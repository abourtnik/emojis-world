<?php

namespace Database\Seeders;

use App\Models\Emoji;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Emoji::factory()->count(10)->create();
    }
}
