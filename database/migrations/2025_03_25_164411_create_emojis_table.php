<?php

use App\Models\Category;
use App\Models\Emoji;
use App\Models\SubCategory;
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
        Schema::create('emojis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emoji');
            $table->string('unicode')->unique();
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(SubCategory::class)->constrained();
            $table->foreignIdFor(Emoji::class, 'parent_id')->nullable()->constrained('emojis')->cascadeOnDelete();
            $table->smallInteger('count')->default(0);
            $table->double('version')->nullable();
            $table->tinyText('keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emojis');
    }
};
