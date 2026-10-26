<?php

namespace App\Http\Controllers;

use App\Actions\ShowIndexPage;
use App\Http\Requests\SearchRequest;
use App\Models\Emoji;
use App\Facades\Endpoint;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function index(SearchRequest $request, ShowIndexPage $showIndexPage): View
    {
        return view('pages.index', $showIndexPage->fromRequest($request));
    }

    public function api(): View
    {
        return view('pages.api', [
            'endpoints' => Endpoint::getAll(),
            'emojis_count' => Emoji::count(),
        ]);
    }
}
