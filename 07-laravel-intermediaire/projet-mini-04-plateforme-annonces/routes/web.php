<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php'; // routes générées par Breeze (connexion, inscription...)

Route::redirect('/', '/annonces');

Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');
Route::post('/annonces/{annonce}/messages', [MessageController::class, 'store'])->name('messages.store');

Route::middleware('auth')->group(function () {
    Route::get('/annonces/creer', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/annonces/{annonce}/modifier', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');

    Route::post('/annonces/{annonce}/favori', [FavoriteController::class, 'toggle'])->name('favoris.toggle');
});
