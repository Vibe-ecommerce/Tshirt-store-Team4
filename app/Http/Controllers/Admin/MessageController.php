<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

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
        ];

        return view('admin.messages.index', compact('messages', 'status', 'search', 'counts'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Auto mark as read on view
        if ($message->status === 'unread') {
            $message->status = 'read';
            $message->save();
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'created_at_formatted' => $message->created_at->format('M d, Y • h:i A'),
                'unread_count' => ContactMessage::where('status', 'unread')->count(),
            ]);
        }

        return redirect()->route('admin.messages.index');
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

