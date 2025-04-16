<?php

namespace Tests\Feature;

use App\Models\Emoji;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page(): void
    {
        $this->get(route('pages.index'))->assertStatus(200);
    }

    public function test_api_page(): void
    {
        $this->get(route('pages.api'))->assertStatus(200);
    }
}
