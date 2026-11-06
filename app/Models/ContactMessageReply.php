<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ContactMessageReply extends Model
{
    protected $fillable = [
        'contact_message_id',
        'user_id',
        'sender_type',
        'sender_name',
        'message',
    ];

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function ensureTableExists(): bool
    {
        try {
            if (!Schema::hasTable('contact_message_replies')) {
                Schema::create('contact_message_replies', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('contact_message_id');
                    $table->unsignedBigInteger('user_id')->nullable();
                    $table->string('sender_type')->default('admin');
                    $table->string('sender_name')->nullable();
                    $table->text('message');
                    $table->timestamps();
                });
            }
            return true;
        } catch (\Throwable $e) {
            Log::warning("Could not auto-create contact_message_replies table: " . $e->getMessage());
            return false;
        }
    }
}
