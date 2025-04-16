<?php

use App\Http\Middleware\Logger;
use App\Http\Middleware\StripEmptyParams;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\EmojiController;

Route::domain(config('app.url'))
    ->name('pages.')
    ->group(function () {
        Route::get('/', [PageController::class, 'index'])->middleware([StripEmptyParams::class, Logger::class])->name('index');
        Route::get('/api', [PageController::class, 'api'])->name('api');
        Route::post('emojis/{emoji:id}/increment', [EmojiController::class, 'increment'])->name('increment');
});

// Global 404 Page
Route::fallback(function () {
    if (request()->fullUrlIs(config('app.api_url'))) {
        return response()->json(['message' => 'Resource not found'], 404);
    }
    abort(404);
});
