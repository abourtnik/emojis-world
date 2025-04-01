<?php

namespace Feature\Api;

use App\Models\Emoji;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_basic_search(): void
    {
        Emoji::factory()
            ->count(9)
            ->create();

        Emoji::factory()
            ->count(1)
            ->create(['name' => 'green apple']);

        $this->get('/v1/search?q=apple')
            ->assertStatus(200)
            ->assertJsonPath('total', 1)
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->has('results', 1)
                ->has('total')
            );
    }
}
