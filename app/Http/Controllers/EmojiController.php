<?php

namespace App\Http\Controllers;
use App\Models\Emoji;
use Illuminate\Http\Response;

class EmojiController extends Controller
{
    public function increment(Emoji $emoji): Response
    {
        $emoji->increment('count');

        return response()->noContent();
    }
}
