<?php

namespace Tests\Feature;

use App\Models\Ip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_banned_ip(): void
    {
        Ip::factory()->banned()->create(['ip' => '127.0.0.1']);

        $this->get(route('emojis.index'))->assertStatus(403);

        $this->assertDatabaseCount('logs', 0);
    }

    public function test_ignored_ip(): void
    {
        Ip::factory()->ignored()->create(['ip' => '127.0.0.1']);

        $this->get(route('emojis.index'))->assertStatus(200);

        $this->assertDatabaseCount('logs', 0);
    }

    public function test_ok_ip(): void
    {
        $this->get(route('emojis.index'))->assertStatus(200);

        $this->assertDatabaseCount('logs', 1);
    }

    public function test_rate_limit(): void
    {
        $limit = config('limit.value');

        $this->get(route('emojis.index'))
            ->assertStatus(200)
            ->assertHeader('X-Ratelimit-Limit', $limit)
            ->assertHeader('X-Ratelimit-Remaining', $limit - 1);;
    }

    public function test_rate_limit_decreases_remaining(): void
    {
        $limit = config('limit.value');

        foreach(range(1, $limit) as $i) {
            $this->get(route('emojis.index'))
                ->assertOk()
                ->assertHeader('X-Ratelimit-Remaining', $limit - $i);
        }

       $this->get(route('emojis.index'))
           ->assertStatus(429)
           ->assertHeader('Retry-After', 60 * 60 * 24);
    }

    public function test_crawler(): void
    {
        $this
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/100.0.4896.127 Safari/537.36',])
            ->get(route('emojis.index'))
            ->assertStatus(200);

        $this->assertDatabaseCount('logs', 0);
    }
}
