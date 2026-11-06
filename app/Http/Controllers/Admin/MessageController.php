<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        ContactMessage::ensureTableExists();

        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $query = ContactMessage::orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(12)->withQueryString();

        $counts = [
            'all' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'unread')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
        ];

        return view('admin.messages.index', compact('messages', 'status', 'search', 'counts'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Auto mark as read on view if unread
        if ($message->status === 'unread') {
            $message->status = 'read';
            $message->save();
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'created_at_formatted' => $message->created_at->format('M d, Y • h:i A'),
                'replied_at_formatted' => $message->replied_at ? $message->replied_at->format('M d, Y • h:i A') : null,
                'unread_count' => ContactMessage::where('status', 'unread')->count(),
            ]);
        }

        return redirect()->route('admin.messages.index');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        $message = ContactMessage::findOrFail($id);
        $replyText = trim($request->input('reply_message'));
        $storeName = SiteSetting::get('store_name', 'T-Shirt Online Store');

        $emailSent = false;

        // Dispatch branded HTML email to customer
        try {
            Mail::send([], [], function ($m) use ($message, $replyText, $storeName) {
                $m->to($message->email, $message->name)
                  ->subject("Re: " . ($message->subject ?: "Your inquiry at {$storeName}"))
                  ->html("
                    <div style='font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica,Arial,sans-serif; max-width:600px; margin:0 auto; padding:28px 24px; border:1px solid #e2e8f0; border-radius:16px; background:#ffffff; color:#0f172a;'>
                        <div style='display:flex; align-items:center; gap:12px; border-bottom:2px solid #4f46e5; padding-bottom:18px; margin-bottom:24px;'>
                            <div>
                                <h2 style='margin:0; color:#4f46e5; font-size:22px; font-weight:800;'>{$storeName}</h2>
                                <p style='margin:3px 0 0; color:#64748b; font-size:13px; font-weight:600;'>Customer Concierge & Support Service</p>
                            </div>
                        </div>

                        <p style='font-size:15px; margin-bottom:16px;'>Dear <strong>" . htmlspecialchars($message->name) . "</strong>,</p>

                        <div style='font-size:15px; line-height:1.7; color:#1e293b; white-space:pre-wrap; background:#f8fafc; border-left:4px solid #4f46e5; padding:16px 20px; border-radius:0 12px 12px 0; margin-bottom:24px;'>
" . htmlspecialchars($replyText) . "
                        </div>

                        <div style='background:#f1f5f9; border-radius:12px; padding:14px 18px; margin-bottom:24px;'>
                            <div style='font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;'>Your Original Message:</div>
                            <div style='font-size:13px; color:#475569; font-style:italic;'>\"" . htmlspecialchars($message->message) . "\"</div>
                        </div>

                        <div style='border-top:1px solid #e2e8f0; padding-top:18px; font-size:12px; color:#94a3b8; text-align:center;'>
                            Thank you for contacting <strong>{$storeName}</strong>.<br>
                            If you have additional questions, simply reply directly to this email.
                        </div>
                    </div>
                  ");
            });
            $emailSent = true;
        } catch (\Throwable $e) {
            Log::error("Failed to send customer inquiry reply email: " . $e->getMessage());
            $emailSent = false;
        }

        // Save reply in database and mark status as 'replied'
        $message->reply_message = $replyText;
        $message->replied_at = now();
        $message->status = 'replied';
        $message->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'email_sent' => $emailSent,
                'message' => $emailSent ? 'Reply sent successfully to customer email!' : 'Reply recorded, but SMTP failed to dispatch email.',
                'replied_at' => $message->replied_at->format('M d, Y • h:i A'),
                'status' => 'replied',
            ]);
        }

        $flashText = $emailSent
            ? "Your reply has been sent successfully to {$message->email}!"
            : "Reply saved in database. Note: Email could not be dispatched via SMTP (check settings).";

        return redirect()->back()->with('success', $flashText);
    }

    public function toggleStatus(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->status = $message->status === 'unread' ? 'read' : 'unread';
        $message->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $message->status,
                'unread_count' => ContactMessage::where('status', 'unread')->count(),
            ]);
        }

        return redirect()->back()->with('success', 'Message status updated.');
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Customer inquiry deleted successfully.');
    }
}
