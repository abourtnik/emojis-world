<?php

namespace App\Http\Controllers;

use App\Models\Emoji;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function emojis(): Response
    {
        return $this->renderSitemap('emojis', function () {
            return Emoji::query()->select(['id', 'slug'])->orderBy('id')->get();
        });
    }

    public function events(): Response
    {
        return $this->renderSitemap('events', function () {
            return Event::query()->select(['id', 'slug'])->orderBy('id')->get();
        });
    }

    private function renderSitemap(string $key, callable $dataResolver, int $ttlHours = 1): Response
    {
        $cacheKey = "sitemap-{$key}";
        $view = "sitemaps.{$key}";

        $content = Cache::remember($cacheKey, now()->addHours($ttlHours), function () use ($view, $dataResolver, $key) {
            return view($view, [$key => $dataResolver()])->render();
        });

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
