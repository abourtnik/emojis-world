<?php

namespace App\Http\Controllers;

use App\Actions\ShowEmojiPage;
use App\Models\Emoji;
use App\Models\History;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class EmojiController extends Controller
{
    public function show(Emoji $emoji): View
    {
        return view('pages.emoji', ShowEmojiPage::for($emoji));
    }

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
