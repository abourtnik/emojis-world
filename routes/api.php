<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmojiController;
use App\Http\Middleware\ApiResponse;
use App\Http\Middleware\CheckIp;
use App\Http\Middleware\IsBannedIp;
use App\Http\Middleware\Logger;
use Illuminate\Support\Facades\Route;

Route::prefix('v'.config('app.version'))
    ->middleware([ApiResponse::class, 'throttle:api', CheckIp::class, IsBannedIp::class, Logger::class])
    ->group(function () {
        Route::controller(EmojiController::class)
            ->name('emojis.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/search', 'search')->name('search');
                Route::get('/random', 'random')->name('random');
                Route::get('/popular', 'popular')->name('popular');
                Route::get('/emojis/{emoji:id}', 'emoji')->name('emoji');
            });

        // CATEGORIES
        Route::controller(CategoryController::class)
            ->prefix('categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
        });
});

