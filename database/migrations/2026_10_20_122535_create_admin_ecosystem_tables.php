<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->integer('discount_percent');
            $table->decimal('min_spend', 8, 2)->default(0);
            $table->string('status')->default('Active'); // Active, Expired, Disabled
            $table->integer('uses_count')->default(0);
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('reviewer_name');
            $table->string('reviewer_email');
            $table->integer('rating')->default(5);
            $table->text('comment');
            $table->string('status')->default('Approved'); // Approved, Pending, Hidden
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 8, 2);
            $table->string('payment_method')->default('Credit Card');
            $table->string('status')->default('Successful'); // Successful, Pending, Failed, Refunded
            $table->string('refund_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('promotions');
    }
};
