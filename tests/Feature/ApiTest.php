<?php

namespace Tests\Feature\Api;

use App\Models\Emoji;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;


class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_endpoint(): void
    {
        $this->get('/v1')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->whereType('message', 'string'));;
    }

    public function test_random_endpoint(): void
    {
        Emoji::factory()->count(10)->create();

        $this->assertDatabaseCount('emojis', 10);

        $this->get('/v1/random')
            ->assertStatus(200)
            ->assertJsonPath('total', 10)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('results', 10)
                    ->has('total')
            );
    }

    public function test_popular_endpoint(): void
    {
        Emoji::factory()->count(10)->create();

        $this->assertDatabaseCount('emojis', 10);

        $this->get('/v1/popular')
            ->assertStatus(200)
            ->assertJsonPath('total', 10)
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->has('results', 10)
                ->has('total')
            );
    }

    public function test_emoji_endpoint(): void
    {
        $emoji = Emoji::factory()->create();

        $this->assertDatabaseCount('emojis', 1);

        $this->get('/v1/emojis/'.$emoji->id)
            ->assertStatus(200);
    }

}
