<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $group = $request->get('group', 'website');

        $settings = [
            // Website Settings
            'store_name' => SiteSetting::get('store_name', 'THREADCRAFT Store'),
            'store_tagline' => SiteSetting::get('store_tagline', 'Premium Streetwear & Graphic T-Shirts'),
            'support_email' => SiteSetting::get('support_email', 'admin@tshirtstore.com'),
            'phone' => SiteSetting::get('phone', '+1 (800) 555-TEES'),
            'currency' => SiteSetting::get('currency', 'USD'),
            'address' => SiteSetting::get('address', 'Studio 4A, Street 123, Sangkat Boeung Keng Kang 1, Phnom Penh, Cambodia'),
            'tax_id' => SiteSetting::get('tax_id', 'VAT-K008-902188442'),

            // Payment Settings
            'enable_stripe' => SiteSetting::get('enable_stripe', '1'),
            'enable_paypal' => SiteSetting::get('enable_paypal', '1'),
            'enable_cod' => SiteSetting::get('enable_cod', '1'),
            'enable_qr' => SiteSetting::get('enable_qr', '1'),
            'qr_bank_name' => SiteSetting::get('qr_bank_name', 'ABA Bank / KHQR'),
            'qr_account_name' => SiteSetting::get('qr_account_name', 'THREADCRAFT CO., LTD'),
            'qr_account_number' => SiteSetting::get('qr_account_number', '001 888 999 (USD)'),
            'qr_instructions' => SiteSetting::get('qr_instructions', 'Scan this QR code using any banking app (ABA Mobile, Bakong, ACLEDA, Wing) to complete payment. Upload your payment slip / receipt screenshot below for prompt verification.'),
            'qr_code_image' => SiteSetting::get('qr_code_image', '/images/payments/default_khqr.svg'),
            'tax_rate' => SiteSetting::get('tax_rate', '0.00'),

            // Shipping Settings
            'free_shipping_threshold' => SiteSetting::get('free_shipping_threshold', '50.00'),
            'standard_shipping_rate' => SiteSetting::get('standard_shipping_rate', '5.00'),
            'express_shipping_rate' => SiteSetting::get('express_shipping_rate', '9.99'),
            'shipping_origin' => SiteSetting::get('shipping_origin', 'Los Angeles Fulfillment Center'),

            // Notification Settings
            'notify_on_order' => SiteSetting::get('notify_on_order', '1'),
            'notify_on_low_stock' => SiteSetting::get('notify_on_low_stock', '1'),
            'admin_notify_email' => SiteSetting::get('admin_notify_email', 'admin@tshirtstore.com'),

            // Security Settings
            'two_factor_auth' => SiteSetting::get('two_factor_auth', '0'),
            'session_timeout' => SiteSetting::get('session_timeout', '120'),
            'login_attempt_limit' => SiteSetting::get('login_attempt_limit', '5'),
        ];

        return view('admin.settings.index', compact('group', 'settings'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'website');

        // Handle QR Code Image Upload if in payment group
        if ($group === 'payment') {
            if ($request->hasFile('qr_code_image_file')) {
                $request->validate([
                    'qr_code_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
                ]);
                $file = $request->file('qr_code_image_file');
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $fileName = 'qr_code_' . time() . '.' . $extension;
                $destination = public_path('uploads/payments');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
                $file->move($destination, $fileName);
                SiteSetting::set('qr_code_image', '/uploads/payments/' . $fileName, 'payment');
            } elseif ($request->filled('remove_qr_code') && $request->input('remove_qr_code') == '1') {
                SiteSetting::set('qr_code_image', '/images/payments/default_khqr.svg', 'payment');
            }
        }

        foreach ($request->except(['_token', 'group', 'qr_code_image_file', 'remove_qr_code']) as $key => $value) {
            SiteSetting::set($key, $value, $group);
        }

        return redirect()->route('admin.settings.index', ['group' => $group])->with('success', ucfirst($group) . ' settings updated successfully.');
    }
}
