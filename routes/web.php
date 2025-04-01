<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['message' => 'Resource not found'], 404);
});
