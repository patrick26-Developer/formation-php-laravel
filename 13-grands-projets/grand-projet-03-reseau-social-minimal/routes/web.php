<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/fil-actualite');

    Route::get('/fil-actualite', [PostController::class, 'feed'])->name('posts.feed');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/utilisateurs/{user}/suivre', [FollowController::class, 'basculer'])->name('follow.basculer');
    Route::post('/posts/{post}/aimer', [LikeController::class, 'basculer'])->name('like.basculer');
});
