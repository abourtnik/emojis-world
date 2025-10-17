<?php

namespace Database\Factories;

use App\Http\Requests\SearchRequest;
use App\Models\Category;
use App\Models\Emoji;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Emoji>
 */
class EmojiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'emoji' => fake()->emoji(),
            'unicode' => fake()->unique()->numerify('1F###'),
            'category_id' => Category::factory()->create()->id,
            'sub_category_id' => SubCategory::factory()->create()->id,
            'parent_id' => null,
            'count' => 0,
            'version' => fake()->randomElement(SearchRequest::AVAILABLE_VERSIONS),
            'keywords' => fake()->words()
        ];
    }
}
