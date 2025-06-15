<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Fitur Movie Picker
Route::get('/movie-picker', [App\Http\Controllers\MoviePickerController::class, 'showStart'])->name('movie-picker.start');
Route::get('/movie-picker/quiz', [App\Http\Controllers\MoviePickerController::class, 'showQuiz'])->name('movie-picker.quiz.form');
Route::post('/movie-picker/quiz', [App\Http\Controllers\MoviePickerController::class, 'processQuiz'])->name('movie-picker.quiz');
Route::get('/movie-picker/result', [App\Http\Controllers\MoviePickerController::class, 'showResult'])->name('movie-picker.result');
Route::post('/movie-picker/another', [App\Http\Controllers\MoviePickerController::class, 'getAnother'])->name('movie-picker.another');
Route::get('/movie-picker/retake', [App\Http\Controllers\MoviePickerController::class, 'retakeQuiz'])->name('movie-picker.retake');
Route::post('/movie-picker/random', [App\Http\Controllers\MoviePickerController::class, 'showRandom'])->name('movie-picker.random');

// Bookmark routes
Route::get('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'store'])->name('bookmarks.store');
Route::get('/bookmarks/{id}/edit', [App\Http\Controllers\BookmarkController::class, 'edit'])->name('bookmarks.edit');
Route::put('/bookmarks/{id}', [App\Http\Controllers\BookmarkController::class, 'update'])->name('bookmarks.update');
Route::delete('/bookmarks/{id}', [App\Http\Controllers\BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
Route::get('/bookmarks/check/{movieId}', [App\Http\Controllers\BookmarkController::class, 'check'])->name('bookmarks.check');
