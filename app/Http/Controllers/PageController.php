<?php

namespace App\Http\Controllers;

use App\Models\Emoji;
use App\Facades\Endpoint;
use App\ViewModels\IndexViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request, IndexViewModel $viewModel): View
    {
        return view('pages.index', $viewModel->fromRequest($request));
    }

    public function api(): View
    {
        return view('pages.api', [
            'endpoints' => Endpoint::getAll(),
            'emojis_count' => Emoji::count(),
        ]);
    }
}
