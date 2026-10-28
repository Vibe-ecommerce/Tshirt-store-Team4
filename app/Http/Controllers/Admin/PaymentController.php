<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $query = Payment::with('order')->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $payments = $query->paginate(10)->withQueryString();

        $counts = [
            'All' => Payment::count(),
            'Successful' => Payment::where('status', 'Successful')->count(),
            'Pending' => Payment::where('status', 'Pending')->count(),
            'Failed' => Payment::where('status', 'Failed')->count(),
            'Refunded' => Payment::where('status', 'Refunded')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'status', 'counts'));
    }

    public function refund(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $reason = $request->input('reason', 'Customer requested return');

        $payment->status = 'Refunded';
        $payment->refund_reason = $reason;
        $payment->save();

        if ($payment->order) {
            $payment->order->status = 'Cancelled';
            $payment->order->save();
        }

        return redirect()->back()->with('success', "Payment {$payment->transaction_id} refunded successfully.");
    }

    public function confirm($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'Successful';
        $payment->save();

        return redirect()->back()->with('success', "Payment {$payment->transaction_id} verified and marked as Successful.");
    }
}
