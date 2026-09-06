<?php

use App\Http\Controllers\Api\V1\AnnonceController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MessageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Authentification (module 09.3), limitée strictement contre le brute-force (module 09.6)
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:connexion');

    // Lecture publique, sans authentification (module 09.1 : stateless)
    Route::get('/annonces', [AnnonceController::class, 'index'])->middleware('throttle:lecture-publique');
    Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->middleware('throttle:lecture-publique');
    Route::post('/annonces/{annonce}/messages', [MessageController::class, 'store'])->middleware('throttle:lecture-publique');

    // Écriture, réservée aux utilisateurs authentifiés (module 09.3)
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::post('/annonces', [AnnonceController::class, 'store']);
        Route::put('/annonces/{annonce}', [AnnonceController::class, 'update']);
        Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy']);
    });
});
