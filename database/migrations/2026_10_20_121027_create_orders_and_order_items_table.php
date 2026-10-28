<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->decimal('original_price', 8, 2)->nullable()->after('price');
            $table->string('sizes')->default('S,M,L,XL,XXL')->after('color');
            $table->integer('review_count')->default(48)->after('rating');
            $table->boolean('is_featured')->default(true)->after('in_stock');
            $table->boolean('is_bestseller')->default(false)->after('is_featured');
            $table->boolean('is_latest')->default(true)->after('is_bestseller');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('shipping_address');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('delivery_method')->default('Standard');
            $table->string('payment_method')->default('Cash on Delivery');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('shipping_fee', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->string('status')->default('Processing'); // Processing, Shipped, Delivered, Cancelled
            $table->string('tracking_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->string('size')->default('L');
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'original_price', 'sizes', 'review_count',
                'is_featured', 'is_bestseller', 'is_latest'
            ]);
        });
    }
};
