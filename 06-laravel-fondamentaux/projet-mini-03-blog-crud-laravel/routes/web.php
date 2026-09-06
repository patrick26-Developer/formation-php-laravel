<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/articles');

Route::resource('articles', ArticleController::class);
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
