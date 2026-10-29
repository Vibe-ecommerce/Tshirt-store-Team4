<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'))->with('info', 'សូមចូលគណនី (Login) របស់អ្នកដើម្បីបន្តការទិញទំនិញ (Please sign in to proceed with your checkout).');
        }

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('info', 'Your cart is empty. Add some shirts before checking out!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = Session::get('coupon', null);
        if ($coupon) {
            $activeCoupon = \App\Models\Promotion::where('code', $coupon['code'])->where('status', 'Active')->first();
            if (!$activeCoupon || ($activeCoupon->expires_at && $activeCoupon->expires_at->isPast())) {
                Session::forget('coupon');
                $coupon = null;
            }
        }
        $discount = $coupon ? ($subtotal * $coupon['percent']) / 100 : 0;
        $shipping = $subtotal >= 50 ? 0 : 5.00;
        $total = max(0, $subtotal - $discount + $shipping);

        $user = Auth::user();

        $qrSettings = [
            'enabled' => SiteSetting::get('enable_qr', '1') == '1',
            'image' => SiteSetting::get('qr_code_image', '/images/payments/default_khqr.svg'),
            'bank_name' => SiteSetting::get('qr_bank_name', 'ABA Bank / KHQR'),
            'account_name' => SiteSetting::get('qr_account_name', 'THREADCRAFT CO., LTD'),
            'account_number' => SiteSetting::get('qr_account_number', '001 888 999 (USD)'),
            'instructions' => SiteSetting::get('qr_instructions', 'Scan this QR code using any banking app (ABA Mobile, Bakong, ACLEDA, Wing) to complete payment. Upload your payment slip / receipt screenshot below for prompt verification.'),
        ];

        // Estimated delivery dates calculation
        $estStandardStart = now()->addDays(2)->format('D, M d');
        $estStandardEnd = now()->addDays(4)->format('D, M d');
        $estExpress = now()->addDays(1)->format('D, M d');

        return view('frontend.checkout', compact(
            'cart', 'subtotal', 'discount', 'shipping', 'total', 'coupon', 'user', 'qrSettings',
            'estStandardStart', 'estStandardEnd', 'estExpress'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'))->with('error', 'សូមចូលគណនី (Login) របស់អ្នកដើម្បីបន្តការទិញទំនិញ (Please sign in to proceed with your checkout).');
        }

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cannot checkout with an empty cart.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'delivery_method' => 'required|string|in:Standard,Express',
            'payment_method' => 'required|string|in:Credit Card,Cash on Delivery,PayPal,QR Code',
            'payment_slip' => 'nullable|image|mimes:jpeg,png,jpg,webp,pdf|max:6144',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
            'notify_telegram' => 'nullable',
            'notify_whatsapp' => 'nullable',
        ]);

        // Process payment receipt slip upload if present
        $paymentSlipPath = null;
        if ($request->hasFile('payment_slip')) {
            $slipFile = $request->file('payment_slip');
            $extension = $slipFile->getClientOriginalExtension() ?: 'jpg';
            $slipName = 'slip_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
            $destPath = public_path('uploads/receipts');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $slipFile->move($destPath, $slipName);
            $paymentSlipPath = '/uploads/receipts/' . $slipName;
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = Session::get('coupon', null);
        if ($coupon) {
            $activeCoupon = \App\Models\Promotion::where('code', $coupon['code'])->where('status', 'Active')->first();
            if (!$activeCoupon || ($activeCoupon->expires_at && $activeCoupon->expires_at->isPast())) {
                Session::forget('coupon');
                $coupon = null;
            }
        }
        $discount = $coupon ? ($subtotal * $coupon['percent']) / 100 : 0;
        $shippingFee = $validated['delivery_method'] === 'Express' ? 9.99 : ($subtotal >= 50 ? 0 : 5.00);
        $total = max(0, $subtotal - $discount + $shippingFee);

        $orderNumber = 'TC-' . strtoupper(Str::random(8));
        $trackingCode = 'TRK-' . date('Ymd') . '-' . rand(1000, 9999);

        // Channels note
        $channels = [];
        if ($request->filled('notify_telegram')) $channels[] = 'Telegram';
        if ($request->filled('notify_whatsapp')) $channels[] = 'WhatsApp';
        $channelNote = !empty($channels) ? ('[Updates via: ' . implode(', ', $channels) . ']') : '';
        $finalNotes = trim(($validated['notes'] ?? '') . ' ' . $channelNote);

        DB::beginTransaction();
        try {
            // 1. Verify stock availability for all products in cart
            foreach ($cart as $item) {
                if (!empty($item['id'])) {
                    $product = Product::find($item['id']);
                    if ($product) {
                        if ($product->isOutOfStock()) {
                            throw new \Exception("Sorry, '{$product->name}' is out of stock (Stockout). Please remove it from your cart before proceeding.");
                        }
                        if ($item['quantity'] > $product->stock) {
                            throw new \Exception("Only {$product->stock} units left for '{$product->name}'. Please adjust your cart quantity.");
                        }
                    }
                }
            }

            // 2. Create Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'] ?? null,
                'delivery_method' => $validated['delivery_method'],
                'payment_method' => $validated['payment_method'],
                'payment_slip' => $paymentSlipPath,
                'payment_reference' => $validated['payment_reference'] ?? null,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'status' => 'Processing',
                'tracking_code' => $trackingCode,
                'notes' => $finalNotes ?: null,
            ]);

            // 3. Create items and automatically decrement stock
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] ?? null,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? 'L',
                    'color' => $item['color'] ?? null,
                    'image' => $item['image'] ?? null,
                ]);

                // Decrement stock and auto-mark stockout if 0
                if (!empty($item['id'])) {
                    $product = Product::find($item['id']);
                    if ($product) {
                        $product->stock = max(0, $product->stock - $item['quantity']);
                        if ($product->stock <= 0) {
                            $product->in_stock = false;
                        }
                        $product->save();
                    }
                }
            }

            // 4. Record transaction in Payment Management
            $isQr = $validated['payment_method'] === 'QR Code';
            $isCod = $validated['payment_method'] === 'Cash on Delivery';
            $txnId = ($isQr && !empty($validated['payment_reference'])) 
                ? 'REF-' . strtoupper(trim($validated['payment_reference'])) 
                : 'TXN-' . rand(10000000, 99999999);

            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $txnId,
                'amount' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_slip' => $paymentSlipPath,
                'payment_reference' => $validated['payment_reference'] ?? null,
                'status' => ($isCod || $isQr) ? 'Pending' : 'Successful',
            ]);

            DB::commit();

            // Increment promotion uses count if coupon was applied
            if ($coupon) {
                if (!empty($coupon['id'])) {
                    \App\Models\Promotion::where('id', $coupon['id'])->increment('uses_count');
                } elseif (!empty($coupon['code'])) {
                    \App\Models\Promotion::where('code', $coupon['code'])->increment('uses_count');
                }
            }

            // 5. Send Automated Telegram Notification
            $this->sendTelegramNotification($order, $cart, $paymentSlipPath, $channels);

            // Clear session cart and coupon
            Session::forget('cart');
            Session::forget('coupon');

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', 'Thank you! Your order has been placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Checkout error: ' . $e->getMessage());
        }
    }

    /**
     * Send instant Telegram Bot order alert to Store Managers / Telegram Group
     */
    protected function sendTelegramNotification($order, array $cart, ?string $slipPath, array $channels = [])
    {
        try {
            $enabled = SiteSetting::get('enable_telegram_notifications', '1') == '1';
            if (!$enabled) {
                return;
            }

            $botToken = SiteSetting::get('telegram_bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId = SiteSetting::get('telegram_chat_id', env('TELEGRAM_CHAT_ID'));

            // Format items list
            $itemsText = "";
            foreach ($cart as $item) {
                $size = $item['size'] ?? 'L';
                $lineTotal = number_format($item['price'] * $item['quantity'], 2);
                $itemsText .= "• {$item['quantity']}x <b>" . htmlspecialchars($item['name']) . "</b> ({$size}) — \${$lineTotal}\n";
            }

            $prefChannels = !empty($channels) ? implode(', ', $channels) : 'Standard SMS';
            $refText = !empty($order->payment_reference) ? " (Ref: " . htmlspecialchars($order->payment_reference) . ")" : "";
            $slipStatus = !empty($slipPath) ? " Attached & Ready to Verify" : "No receipt attached";

            $message = "🛍️ <b>NEW ORDER RECEIVED! #{$order->order_number}</b>\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "👤 <b>Customer:</b> " . htmlspecialchars($order->customer_name) . "\n";
            $message .= "📞 <b>Phone:</b> " . htmlspecialchars($order->customer_phone) . " <i>({$prefChannels})</i>\n";
            $message .= "✉️ <b>Email:</b> " . htmlspecialchars($order->customer_email) . "\n";
            $message .= "📍 <b>Delivery:</b> " . htmlspecialchars($order->shipping_address) . ", " . htmlspecialchars($order->city) . "\n";
            $message .= "🚚 <b>Method:</b> " . htmlspecialchars($order->delivery_method) . " Delivery\n";
            $message .= "💳 <b>Payment:</b> " . htmlspecialchars($order->payment_method) . "{$refText}\n";
            $message .= "🧾 <b>Slip Status:</b> {$slipStatus}\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "📦 <b>ORDER ITEMS:</b>\n{$itemsText}";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "💰 <b>Subtotal:</b> \$" . number_format($order->subtotal, 2) . "\n";
            if ($order->discount > 0) {
                $message .= "🎟️ <b>Discount:</b> -\$" . number_format($order->discount, 2) . "\n";
            }
            $message .= "🚚 <b>Shipping:</b> " . ($order->shipping_fee == 0 ? "FREE" : "\$" . number_format($order->shipping_fee, 2)) . "\n";
            $message .= "💵 <b>TOTAL AMOUNT:</b> <b>\$" . number_format($order->total, 2) . " USD</b>\n";
            if (!empty($order->notes)) {
                $message .= "📝 <b>Notes:</b> " . htmlspecialchars($order->notes) . "\n";
            }
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "🔗 <a href=\"" . url('/admin/orders') . "\">Open Admin Dashboard</a>";

            // If token and chat ID are configured, call Telegram Bot API
            if (!empty($botToken) && !empty($chatId)) {
                $fullSlipPath = $slipPath ? public_path($slipPath) : null;

                if ($fullSlipPath && file_exists($fullSlipPath)) {
                    Http::timeout(10)
                        ->attach('photo', file_get_contents($fullSlipPath), basename($fullSlipPath))
                        ->post("https://api.telegram.org/bot{$botToken}/sendPhoto", [
                            'chat_id' => $chatId,
                            'caption' => $message,
                            'parse_mode' => 'HTML',
                        ]);
                } else {
                    Http::timeout(10)
                        ->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                            'chat_id' => $chatId,
                            'text' => $message,
                            'parse_mode' => 'HTML',
                            'disable_web_page_preview' => true,
                        ]);
                }
            }

            Log::info("Telegram order notification processed for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Telegram order notification failed: " . $e->getMessage());
        }
    }
}
