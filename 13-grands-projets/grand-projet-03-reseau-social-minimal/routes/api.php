<?php

use App\Http\Controllers\Api\FeedController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->prefix('v1')->group(function () {
    Route::get('/fil-actualite', [FeedController::class, 'index']);
    Route::post('/posts', [FeedController::class, 'store']);
});
