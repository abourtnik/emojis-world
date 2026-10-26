<?php

use App\Models\Emoji;
use Rappasoft\LaravelPatches\Patch;
use Illuminate\Support\Str;

class AddSlugAndDescriptionToEmojis extends Patch
{
    /**
     * Run the patch.
     *
     * @return void
     */
    public function up(): void
    {
        Emoji::query()->whereNull('slug')->chunkById(1000, function ($emojis) {
            $rows = $emojis->map(fn (Emoji $emoji) => array_merge(
                $emoji->getAttributes(),
                ['slug' => Str::slug($emoji->name)],
            ))->all();

            Emoji::upsert($rows, ['id'], ['slug']);
        });
    }

    /**
     * Reverse the patch.
     *
     * @return void
     */
    public function down(): void
    {
        Emoji::query()->update(['slug' => null, 'description' => null]);
    }
}
