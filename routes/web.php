<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// dashboard route
Route::get('/dashboard',[PostController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // posts routes
    Route::resource('posts', PostController::class)->except(['index']);
    // comments routes
    Route::resource('comments',CommentController::class);
    Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike']);
});

require __DIR__.'/auth.php';
