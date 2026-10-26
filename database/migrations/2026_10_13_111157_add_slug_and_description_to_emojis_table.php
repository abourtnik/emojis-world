<?php

use App\Enums\Direction;
use App\Enums\Gender;
use App\Enums\SkinTone;
use App\Models\Emoji;
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
        Schema::table('emojis', function (Blueprint $table) {
            $table->after('unicode', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique();
                $table->text('description')->nullable();
                $table->foreignIdFor(Emoji::class, 'group_id')->nullable()->constrained('emojis')->nullOnDelete();
                $table->unsignedTinyInteger('skin_tone')->default(SkinTone::None);
                $table->unsignedTinyInteger('skin_tone_2')->nullable();
                $table->unsignedTinyInteger('gender')->default(Gender::Neutral);
                $table->unsignedTinyInteger('direction')->default(Direction::Default);
            });

            $table->unique(
                ['group_id', 'skin_tone', 'skin_tone_2', 'gender', 'direction'],
                'emojis_variant_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emojis', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropUnique('emojis_variant_unique');
            $table->dropColumn(['slug', 'description', 'group_id', 'skin_tone', 'skin_tone_2', 'gender', 'direction']);
        });
    }
};
