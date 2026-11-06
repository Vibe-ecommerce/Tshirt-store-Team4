<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'ip_address',
    ];

    /**
     * Auto-ensure table exists in production databases (e.g. TiDB Cloud / Render)
     */
    public static function ensureTableExists(): bool
    {
        try {
            if (!Schema::hasTable('contact_messages')) {
                Schema::create('contact_messages', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email');
                    $table->string('subject');
                    $table->text('message');
                    $table->string('status')->default('unread');
                    $table->string('ip_address')->nullable();
                    $table->timestamps();
                });
            }
            return true;
        } catch (\Throwable $e) {
            Log::warning("Could not auto-create contact_messages table: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Safe query wrapper that auto-creates table if missing
     */
    public static function safeCountUnread(): int
    {
        try {
            return self::where('status', 'unread')->count();
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), "doesn't exist") || str_contains($e->getMessage(), 'Base table')) {
                self::ensureTableExists();
                try {
                    return self::where('status', 'unread')->count();
                } catch (\Throwable $e2) {}
            }
            return 0;
        }
    }
}
