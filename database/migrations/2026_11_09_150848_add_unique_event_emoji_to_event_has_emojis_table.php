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
        Schema::table('event_has_emojis', function (Blueprint $table) {
            $table->unique(['event_id', 'emoji_id'], 'event_has_emojis_event_emoji_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_has_emojis', function (Blueprint $table) {
            $table->dropUnique('event_has_emojis_event_emoji_unique');
        });
    }
};
