<?php

namespace Database\Seeders;

use App\Models\Emoji;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $category = Category::factory()
            ->create();

        $subCategory = SubCategory::factory()
            ->for($category)
            ->create();

        Emoji::factory()
            ->for($category, 'category')
            ->for($subCategory, 'subCategory')
            ->count(10)
            ->create();
    }
}
