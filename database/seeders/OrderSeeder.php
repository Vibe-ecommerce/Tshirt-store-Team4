<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@gmail.com')->first();
        $tee = Product::first();

        if ($customer && $tee) {
            $order = Order::create([
                'order_number' => 'TC-DEMO2026',
                'user_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => '+1 (555) 234-5678',
                'shipping_address' => '742 Evergreen Blvd, Apt 4B',
                'city' => 'Los Angeles',
                'postal_code' => '90014',
                'delivery_method' => 'Express',
                'payment_method' => 'Credit Card',
                'subtotal' => 69.00,
                'discount' => 10.35,
                'shipping_fee' => 0.00,
                'total' => 58.65,
                'status' => 'Shipped',
                'tracking_code' => 'TRK-2026-8849',
                'notes' => 'Please leave at front door.',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $tee->id,
                'product_name' => $tee->name,
                'price' => $tee->price,
                'quantity' => 2,
                'size' => 'L',
                'color' => $tee->color,
                'image' => $tee->image,
            ]);
        }
    }
}
