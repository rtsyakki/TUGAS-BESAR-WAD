<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\GenreController;

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

// Fitur Top Actor
Route::get('/actors/top', [ActorController::class, 'top'])->name('actors.top');
Route::get('/actors/{id}/movies', [ActorController::class, 'movies'])->name('actors.movies');

// Fitur Top Genre
Route::get('/top-genres', [GenreController::class, 'topGenresPage'])->name('genre.top');
Route::get('/top-genres/filter', [GenreController::class, 'filterTopGenres'])->name('genre.top.filter');

// Fitur Bookmark
Route::get('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'store'])->name('bookmarks.store');
Route::get('/bookmarks/{id}/edit', [App\Http\Controllers\BookmarkController::class, 'edit'])->name('bookmarks.edit');
Route::put('/bookmarks/{id}', [App\Http\Controllers\BookmarkController::class, 'update'])->name('bookmarks.update');
Route::delete('/bookmarks/{id}', [App\Http\Controllers\BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
Route::get('/bookmarks/check/{movieId}', [App\Http\Controllers\BookmarkController::class, 'check'])->name('bookmarks.check');
Route::get('/movies/{slug}', [App\Http\Controllers\MovieController::class, 'show'])->name('movie.detail');
