<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\Product;
use App\Models\Order;

class AdminEcosystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Promotions
        Promotion::truncate();
        Promotion::create([
            'code' => 'THREAD15',
            'description' => '15% Off storewide for new and returning customers',
            'discount_percent' => 15,
            'min_spend' => 30.00,
            'status' => 'Active',
            'uses_count' => 142,
            'expires_at' => now()->addMonths(3),
        ]);
        Promotion::create([
            'code' => 'WELCOME10',
            'description' => '10% Welcome gift on first checkout',
            'discount_percent' => 10,
            'min_spend' => 20.00,
            'status' => 'Active',
            'uses_count' => 88,
            'expires_at' => now()->addMonths(6),
        ]);
        Promotion::create([
            'code' => 'SUMMER25',
            'description' => '25% Seasonal launch promotion',
            'discount_percent' => 25,
            'min_spend' => 60.00,
            'status' => 'Expired',
            'uses_count' => 320,
            'expires_at' => now()->subDays(5),
        ]);

        // 2. Seed Reviews
        Review::truncate();
        $tee = Product::first();
        if ($tee) {
            Review::create([
                'product_id' => $tee->id,
                'reviewer_name' => 'Marcus Kane',
                'reviewer_email' => 'marcus@example.com',
                'rating' => 5,
                'comment' => 'The fabric weight is outstanding. Does not shrink after hot wash.',
                'status' => 'Approved',
            ]);
            Review::create([
                'product_id' => $tee->id,
                'reviewer_name' => 'Elena Rostova',
                'reviewer_email' => 'elena@example.com',
                'rating' => 5,
                'comment' => 'Water-based screen print feels smooth, no plastic stiffness!',
                'status' => 'Approved',
            ]);
            Review::create([
                'product_id' => $tee->id,
                'reviewer_name' => 'Jason Lee',
                'reviewer_email' => 'jason@example.com',
                'rating' => 4,
                'comment' => 'Nice boxy fit. Sizing runs slightly oversized, exactly what I wanted.',
                'status' => 'Pending',
            ]);
        }

        // 3. Seed Payments
        Payment::truncate();
        $order = Order::first();
        if ($order) {
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => 'TXN-98472918',
                'amount' => $order->total,
                'payment_method' => $order->payment_method,
                'status' => 'Successful',
            ]);
        }
        Payment::create([
            'order_id' => null,
            'transaction_id' => 'TXN-98472919',
            'amount' => 74.50,
            'payment_method' => 'Credit Card',
            'status' => 'Successful',
        ]);
        Payment::create([
            'order_id' => null,
            'transaction_id' => 'TXN-98472920',
            'amount' => 45.00,
            'payment_method' => 'PayPal',
            'status' => 'Pending',
        ]);
        Payment::create([
            'order_id' => null,
            'transaction_id' => 'TXN-98472921',
            'amount' => 38.00,
            'payment_method' => 'Credit Card',
            'status' => 'Failed',
        ]);
        Payment::create([
            'order_id' => null,
            'transaction_id' => 'TXN-98472922',
            'amount' => 32.00,
            'payment_method' => 'Credit Card',
            'status' => 'Refunded',
            'refund_reason' => 'Customer requested exchange for size M',
        ]);

        // 4. Seed Site Settings
        SiteSetting::set('store_name', 'THREADCRAFT Store', 'general');
        SiteSetting::set('support_email', 'admin@tshirtstore.com', 'general');
        SiteSetting::set('phone', '+1 (800) 555-TEES', 'general');
        SiteSetting::set('address', '742 Evergreen Blvd, Studio 4A, Los Angeles, CA', 'general');
        SiteSetting::set('currency', 'USD', 'payment');
        SiteSetting::set('free_shipping_threshold', '50.00', 'shipping');
        SiteSetting::set('standard_shipping_rate', '5.00', 'shipping');
        SiteSetting::set('express_shipping_rate', '9.99', 'shipping');
        SiteSetting::set('enable_cod', '1', 'payment');
        SiteSetting::set('enable_stripe', '1', 'payment');
        SiteSetting::set('enable_paypal', '1', 'payment');
        SiteSetting::set('hero_tagline', 'Wear Your Everyday Story. Premium Crafted T-Shirts.', 'content');
        SiteSetting::set('announcement_text', '🔥 FLASH SALE: 15% OFF with code THREAD15 • Free Worldwide Shipping over $50', 'content');
    }
}
