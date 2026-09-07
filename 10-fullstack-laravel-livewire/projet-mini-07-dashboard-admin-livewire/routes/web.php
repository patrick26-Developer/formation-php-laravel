<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

// À ajouter dans AppServiceProvider::boot() (module 07.5) :
// Gate::define('acceder-admin', fn ($user) => $user->est_admin);

Route::middleware(['auth', 'can:acceder-admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
});
