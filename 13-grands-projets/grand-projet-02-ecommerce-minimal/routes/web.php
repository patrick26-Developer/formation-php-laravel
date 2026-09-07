<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::redirect('/', '/produits');

Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/{product}', [CartController::class, 'ajouter'])->name('cart.ajouter');
Route::delete('/panier/{product}', [CartController::class, 'retirer'])->name('cart.retirer');

Route::middleware('auth')->group(function () {
    Route::post('/commande', [OrderController::class, 'valider'])->name('orders.valider');
    Route::get('/commande/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');
    Route::get('/mes-commandes', [OrderController::class, 'historique'])->name('orders.historique');
});

Route::middleware(['auth', 'can:acceder-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class)->except(['show']);
});
