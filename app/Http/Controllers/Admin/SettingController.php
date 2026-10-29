<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            'social_telegram' => SiteSetting::get('social_telegram', 'https://t.me/Tdelivery4_bot'),
            'social_facebook' => SiteSetting::get('social_facebook', 'https://facebook.com/tshirtonline.cambodia'),
            'social_tiktok' => SiteSetting::get('social_tiktok', 'https://tiktok.com/@tshirtonline.cambodia'),
            'social_instagram' => SiteSetting::get('social_instagram', 'https://instagram.com/tshirtonline.cambodia'),

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
            'telegram_bot_token' => SiteSetting::get('telegram_bot_token', env('TELEGRAM_BOT_TOKEN', '')),
            'telegram_chat_id' => SiteSetting::get('telegram_chat_id', env('TELEGRAM_CHAT_ID', '')),
            'enable_telegram_notifications' => SiteSetting::get('enable_telegram_notifications', '1'),

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

        // Auto-fix if user mistakenly entered a bot username (ending in _bot) for chat_id
        if ($group === 'notification') {
            $botToken = SiteSetting::get('telegram_bot_token');
            $chatId = SiteSetting::get('telegram_chat_id');
            if (!empty($botToken) && !empty($chatId) && str_ends_with(strtolower(trim($chatId)), '_bot')) {
                try {
                    $res = Http::timeout(5)->get("https://api.telegram.org/bot{$botToken}/getUpdates")->json();
                    if (!empty($res['result'])) {
                        $lastMsg = end($res['result']);
                        if (isset($lastMsg['message']['chat']['id'])) {
                            $realChatId = (string) $lastMsg['message']['chat']['id'];
                            SiteSetting::set('telegram_chat_id', $realChatId, 'notification');
                        }
                    }
                } catch (\Exception $e) {}
            }
        }

        return redirect()->route('admin.settings.index', ['group' => $group])->with('success', ucfirst($group) . ' settings updated successfully.');
    }

    /**
     * Send test notification to verify Telegram Bot & Chat ID connection
     */
    public function testTelegram(Request $request)
    {
        $botToken = SiteSetting::get('telegram_bot_token', $request->input('telegram_bot_token'));
        $chatId = SiteSetting::get('telegram_chat_id', $request->input('telegram_chat_id'));

        if (empty($botToken)) {
            return redirect()->back()->with('error', 'Please configure your Telegram Bot Token first.');
        }

        // If chat ID is bot username, attempt auto-resolution
        if (empty($chatId) || str_ends_with(strtolower(trim($chatId)), '_bot')) {
            try {
                $updates = Http::timeout(5)->get("https://api.telegram.org/bot{$botToken}/getUpdates")->json();
                if (!empty($updates['result'])) {
                    $last = end($updates['result']);
                    if (isset($last['message']['chat']['id'])) {
                        $chatId = (string) $last['message']['chat']['id'];
                        SiteSetting::set('telegram_chat_id', $chatId, 'notification');
                    }
                }
            } catch (\Exception $e) {}
        }

        if (empty($chatId)) {
            return redirect()->back()->with('error', 'Chat ID is missing. Please type /start to your bot in Telegram first, then try again.');
        }

        try {
            $storeName = SiteSetting::get('store_name', 'THREADCRAFT Store');
            $message = "🎉 <b>TELEGRAM NOTIFICATION TEST SUCCESSFUL!</b>\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "🏪 <b>Store:</b> {$storeName}\n";
            $message .= "⏰ <b>Timestamp:</b> " . now()->format('Y-m-d H:i:s') . "\n";
            $message .= "⚡ <b>Status:</b> Active & Listening for live customer orders.\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "✅ Your Bot is successfully configured! Whenever a customer places an order, you will receive full receipt slips and order details here in real-time.";

            $response = Http::timeout(10)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', '✓ Telegram test message sent successfully to Chat ID: ' . $chatId . '! Check your Telegram app.');
            } else {
                $desc = $response->json('description') ?? 'Unknown error';
                return redirect()->back()->with('error', 'Telegram API Error: ' . $desc . ' (Hint: Make sure you opened the bot and clicked /start)');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reach Telegram API: ' . $e->getMessage());
        }
    }

    /**
     * Auto-detect Telegram Chat ID from /start messages
     */
    public function detectTelegramChat(Request $request)
    {
        $botToken = SiteSetting::get('telegram_bot_token', $request->input('telegram_bot_token'));

        if (empty($botToken)) {
            return redirect()->back()->with('error', 'Please configure your Telegram Bot Token first.');
        }

        try {
            $updates = Http::timeout(8)->get("https://api.telegram.org/bot{$botToken}/getUpdates")->json();

            if (!empty($updates['result'])) {
                $last = end($updates['result']);
                if (isset($last['message']['chat']['id'])) {
                    $chat = $last['message']['chat'];
                    $chatId = (string) $chat['id'];
                    $name = trim(($chat['first_name'] ?? '') . ' ' . ($chat['last_name'] ?? ''));
                    $username = !empty($chat['username']) ? ('@' . $chat['username']) : '';

                    SiteSetting::set('telegram_chat_id', $chatId, 'notification');

                    return redirect()->back()->with('success', "✓ Successfully detected Telegram Chat ID: {$chatId} ({$name} {$username})! Settings updated.");
                }
            }

            return redirect()->back()->with('error', 'No messages found yet. Please open your Telegram app, search for your bot, and send /start first, then click Auto-Detect again.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to detect Chat ID: ' . $e->getMessage());
        }
    }
}
