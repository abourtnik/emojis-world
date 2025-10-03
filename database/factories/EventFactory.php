<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
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
            'image' => fake()->filePath(),
            'slug' => fake()->slug(),
            'start_date' => fake()->date('m-d'),
            'end_date' => fake()->date('m-d'),
            'is_permanent' => false
        ];
    }
}
