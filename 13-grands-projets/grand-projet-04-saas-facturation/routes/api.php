<?php

use App\Http\Controllers\Api\BillingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->prefix('v1')->group(function () {
    Route::get('/abonnement', [BillingController::class, 'abonnement']);
    Route::get('/factures', [BillingController::class, 'factures']);
});
