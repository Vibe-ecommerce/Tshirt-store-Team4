<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('contact_message_replies')) {
            Schema::create('contact_message_replies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('contact_message_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('sender_type')->default('admin'); // 'admin' or 'customer'
                $table->string('sender_name')->nullable();
                $table->text('message');
                $table->timestamps();

                $table->foreign('contact_message_id')
                      ->references('id')
                      ->on('contact_messages')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_message_replies');
    }
};
