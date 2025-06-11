<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActorController;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/movie-picker', [App\Http\Controllers\MoviePickerController::class, 'showStart'])->name('movie-picker.start');
Route::get('/movie-picker/quiz', [App\Http\Controllers\MoviePickerController::class, 'showQuiz'])->name('movie-picker.quiz.form');
Route::post('/movie-picker/quiz', [App\Http\Controllers\MoviePickerController::class, 'processQuiz'])->name('movie-picker.quiz');
Route::get('/movie-picker/result', [App\Http\Controllers\MoviePickerController::class, 'showResult'])->name('movie-picker.result');
Route::post('/movie-picker/another', [App\Http\Controllers\MoviePickerController::class, 'getAnother'])->name('movie-picker.another');
Route::get('/movie-picker/retake', [App\Http\Controllers\MoviePickerController::class, 'retakeQuiz'])->name('movie-picker.retake');
Route::post('/movie-picker/random', [App\Http\Controllers\MoviePickerController::class, 'showRandom'])->name('movie-picker.random');
Route::get('/actors/top', [ActorController::class, 'top'])->name('actors.top');
Route::get('/actors/{id}/movies', [ActorController::class, 'movies'])->name('actors.movies');