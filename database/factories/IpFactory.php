<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubCategory>
 */
class IpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => fake()->ipv4(),
            'banned' => false,
            'ignored' => false
        ];
    }

    /**
     * Indicate that the ip is banned.
     *
     * @return Factory
     */
    public function banned() : Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'banned' => true
            ];
        });
    }

    /**
     * Indicate that the ip is ignored for logs.
     *
     * @return Factory
     */
    public function ignored() : Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'ignored' => true
            ];
        });
    }
}
