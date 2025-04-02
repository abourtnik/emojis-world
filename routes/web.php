<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', fn () => 'test'); // For testing queries

Route::fallback(function () {
    return response()->json(['message' => 'Resource not found'], 404);
});
