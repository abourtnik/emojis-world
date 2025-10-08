<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Emoji;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCategoriesCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-categories-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update count field for categories and sub categories';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $categories = Category::all();

        foreach ($categories as $category) {

            $count = Emoji::query()->where('category_id', $category->id)->count();

            $category->update(['count' => $count]);

            foreach ($category->subCategories as $subCategory) {

                $count = Emoji::query()->where('sub_category_id', $subCategory->id)->count();

                $subCategory->update(['count' => $count]);
            }

        }

        Cache::forget('api_categories');

        return Command::SUCCESS;
    }
}
