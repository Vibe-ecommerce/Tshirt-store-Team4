<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $query = Order::with('items')->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        $statusCounts = [
            'All' => Order::count(),
            'Pending' => Order::where('status', 'Pending')->count(),
            'Processing' => Order::where('status', 'Processing')->count(),
            'Shipped' => Order::where('status', 'Shipped')->count(),
            'Delivered' => Order::where('status', 'Delivered')->count(),
            'Cancelled' => Order::where('status', 'Cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'status', 'statusCounts'));
    }

    public function show($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        $statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
            'tracking_code' => 'nullable|string|max:100',
        ]);

        $order->status = $validated['status'];
        if ($request->filled('tracking_code')) {
            $order->tracking_code = $validated['tracking_code'];
        }
        $order->save();

        return redirect()->back()->with('success', "Order #{$order->order_number} status updated to {$order->status}.");
    }

    public function invoice($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        $savedTax = \App\Models\SiteSetting::get('tax_rate');
        $taxRate = ($savedTax !== null && $savedTax !== '' && floatval($savedTax) > 0) ? floatval($savedTax) : 10.00;

        $storeInfo = [
            'name' => \App\Models\SiteSetting::get('store_name', 'THREADCRAFT Store'),
            'tagline' => \App\Models\SiteSetting::get('store_tagline', 'Premium Streetwear & Graphic T-Shirts'),
            'email' => \App\Models\SiteSetting::get('support_email', 'admin@tshirtstore.com'),
            'phone' => \App\Models\SiteSetting::get('phone', '+1 (800) 555-TEES'),
            'currency' => \App\Models\SiteSetting::get('currency', 'USD'),
            'address' => 'Studio 4A, Street 123, Sangkat Boeung Keng Kang 1, Phnom Penh, Cambodia',
            'tax_id' => \App\Models\SiteSetting::get('tax_id', 'VAT-K008-902188442'),
            'tax_rate' => $taxRate,
        ];

        return view('frontend.order-invoice', compact('order', 'storeInfo', 'taxRate'));
    }
}
