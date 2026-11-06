<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contact_messages')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                if (!Schema::hasColumn('contact_messages', 'reply_message')) {
                    $table->text('reply_message')->nullable()->after('message');
                }
                if (!Schema::hasColumn('contact_messages', 'replied_at')) {
                    $table->timestamp('replied_at')->nullable()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contact_messages')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                if (Schema::hasColumn('contact_messages', 'reply_message')) {
                    $table->dropColumn('reply_message');
                }
                if (Schema::hasColumn('contact_messages', 'replied_at')) {
                    $table->dropColumn('replied_at');
                }
            });
        }
    }
};

