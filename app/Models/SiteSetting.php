<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Auto-ensure site_settings table exists in production databases (e.g. TiDB Cloud / Render)
     */
    protected static function ensureTableExists(): bool
    {
        try {
            if (!Schema::hasTable('site_settings')) {
                Schema::create('site_settings', function ($table) {
                    $table->id();
                    $table->string('key')->unique();
                    $table->text('value')->nullable();
                    $table->string('group')->default('general');
                    $table->timestamps();
                });
            }
            return true;
        } catch (\Throwable $e) {
            Log::warning("Could not auto-create site_settings table: " . $e->getMessage());
            return false;
        }
    }

    public static function get($key, $default = null)
    {
        try {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (\Throwable $e) {
            // If table doesn't exist, auto-create it once and retry
            if (str_contains($e->getMessage(), "doesn't exist") || str_contains($e->getMessage(), 'Base table')) {
                if (self::ensureTableExists()) {
                    try {
                        $setting = self::where('key', $key)->first();
                        return $setting ? $setting->value : $default;
                    } catch (\Throwable $e2) {}
                }
            }
            return $default;
        }
    }

    public static function set($key, $value, $group = 'general')
    {
        try {
            return self::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), "doesn't exist") || str_contains($e->getMessage(), 'Base table')) {
                if (self::ensureTableExists()) {
                    try {
                        return self::updateOrCreate(
                            ['key' => $key],
                            ['value' => $value, 'group' => $group]
                        );
                    } catch (\Throwable $e2) {}
                }
            }
            Log::error("Failed to save SiteSetting {$key}: " . $e->getMessage());
            return null;
        }
    }
}

