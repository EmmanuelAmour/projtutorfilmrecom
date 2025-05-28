<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('index');
//|--------------------------------------------------------------------------
//| Web Routes to get movies and search for movies
Route::get('/movie/{id}', [MovieController::class, 'show_movie_single']);
Route::get('/recommendation/{movie_id}', [MovieController::class, 'recommendations']);
Route::get('/popular', [MovieController::class, 'popular']);
Route::get('/upcoming', [MovieController::class, 'upcoming']);
Route::get('/trending', [MovieController::class, 'trending']);
//|--------------------------------------------------------------------------

//-----------------------------------------------------------------
// routes/web.php
Route::get('/movies', [UserController::class, 'fetchMovies']);
Route::get('/movies/horror', [UserController::class, 'getHorrorMovies']);
Route::get('/movies/western', [UserController::class, 'getWesternMovies']);
Route::get('/movies/popular', [UserController::class, 'getPopularMovies']);

include __DIR__ . '/search.php';

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');
