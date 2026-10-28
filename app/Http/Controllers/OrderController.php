<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function confirmation($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('frontend.order-confirmation', compact('order'));
    }

    public function history()
    {
        $user = Auth::user();

        if ($user) {
            $orders = Order::with('items')->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $orders = collect();
        }

        return view('frontend.order-history', compact('orders'));
    }

    public function track(Request $request)
    {
        $trackingQuery = trim($request->get('code', ''));
        $order = null;

        if ($trackingQuery) {
            $order = Order::with('items')
                ->where('order_number', $trackingQuery)
                ->orWhere('tracking_code', $trackingQuery)
                ->first();
        }

        return view('frontend.order-track', compact('order', 'trackingQuery'));
    }

    public function invoice($orderNumber)
    {
        $order = Order::with(['items', 'user'])->where('order_number', $orderNumber)->firstOrFail();

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
