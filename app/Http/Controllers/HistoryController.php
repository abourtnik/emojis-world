<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class HistoryController extends Controller
{
    public function clear(): RedirectResponse
    {
        $visitorId = Cookie::get('visitor_id');

        History::query()->where('visitor_id', $visitorId)->delete();

        Cache::forget('visitor-' .$visitorId. '-history');

        return redirect()->route('pages.index');
    }
}
