<?php

namespace App\Http\Controllers;

use App\Models\Emoji;
use App\Models\History;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class EmojiController extends Controller
{
    public function increment(Emoji $emoji): Response
    {
        $emoji->newQuery()->increment('count');

        $visitorId = Cookie::get('visitor_id');

        History::query()->updateOrCreate(
            ['visitor_id' => $visitorId, 'emoji_id' => $emoji->id],
            ['date' => now()]
        );

        Cache::forget('visitor-' .$visitorId. '-history');

        return response()->noContent();
    }
}
