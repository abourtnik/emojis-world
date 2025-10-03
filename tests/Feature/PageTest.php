<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_event_page(): void
    {
        $event = Event::factory()->create();

        $this->get(route('pages.event', $event))->assertStatus(200);
    }
}
