<?php

namespace Tests\Feature;

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

    public function test_bad_query_search(): void
    {
        $queries = [
            '' ,
            '?q=apple&categories=bad',
            '?q=apple&sub_categories=bad',
            '?q=apple&versions=bad',
            '?q=apple&limit=bad'
        ];

        foreach ($queries as $query) {
            $this->get('/v1/search'.$query)
                ->assertStatus(422)
                ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message', 'string')
                );
        }

    }
}
