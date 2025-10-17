<?php

use App\Http\Middleware\Logger;
use App\Http\Middleware\StripEmptyParams;
use App\Http\Middleware\CheckIp;
use App\Http\Middleware\AssignVisitorId;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use App\Http\Controllers\PageController;
use App\Http\Controllers\EmojiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HistoryController;

Route::domain(config('app.url'))
    ->group(function () {
        Route::name('pages.')->group(function () {
            Route::get('/', [PageController::class, 'index'])->middleware([AssignVisitorId::class, StripEmptyParams::class, CheckIp::class, Logger::class])->name('index');
            Route::get('/api', [PageController::class, 'api'])->name('api');
            Route::get('events/{event:slug}', [EventController::class, 'show'])->name('event');
        });
        Route::post('emojis/{emoji:id}/increment', [EmojiController::class, 'increment'])->name('emojis.increment');
        Route::post('history/clear', [HistoryController::class, 'clear'])->name('history.clear');
    }
);

// Global 404 Page
Route::fallback(function () {
    if (Str::startsWith(request()->fullUrl(), config('app.api_url'))) {
        return response()->json(['message' => 'Resource not found'], 404);
    }
    abort(404);
});
