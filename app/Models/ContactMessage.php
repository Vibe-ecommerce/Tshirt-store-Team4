<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'reply_message',
        'status',
        'replied_at',
        'ip_address',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ContactMessageReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * Auto-ensure table exists in production databases (e.g. TiDB Cloud / Render)
     */
    public static function ensureTableExists(): bool
    {
        try {
            ContactMessageReply::ensureTableExists();
            if (!Schema::hasTable('contact_messages')) {
                Schema::create('contact_messages', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id')->nullable();
                    $table->string('name');
                    $table->string('email');
                    $table->string('subject');
                    $table->text('message');
                    $table->text('reply_message')->nullable();
                    $table->string('status')->default('unread');
                    $table->timestamp('replied_at')->nullable();
                    $table->string('ip_address')->nullable();
                    $table->timestamps();
                });
            } else {
                if (!Schema::hasColumn('contact_messages', 'user_id')) {
                    Schema::table('contact_messages', function (Blueprint $table) {
                        $table->unsignedBigInteger('user_id')->nullable()->after('id');
                    });
                }
                if (!Schema::hasColumn('contact_messages', 'reply_message')) {
                    Schema::table('contact_messages', function (Blueprint $table) {
                        $table->text('reply_message')->nullable();
                    });
                }
                if (!Schema::hasColumn('contact_messages', 'replied_at')) {
                    Schema::table('contact_messages', function (Blueprint $table) {
                        $table->timestamp('replied_at')->nullable();
                    });
                }
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

