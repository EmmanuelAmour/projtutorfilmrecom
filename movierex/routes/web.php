<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetLinkController;

// If your Laravel app is in a subdirectory, wrap all routes in a group with a prefix
Route::group(['prefix' => ''], function () {
    // Main routes
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/popular', [MovieController::class, 'popular']);
    Route::get('/trending', [MovieController::class, 'trending']);
    Route::get('/upcoming', [MovieController::class, 'upcoming']);


    include __DIR__ . '/search.php';

    // Routes d'authentification
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);


    //Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');


    // Movie routes group
    Route::prefix('movie')->group(function () {
        Route::get('/{id}', [MovieController::class, 'show_movie_single']);
        Route::get('/{movie_id}/recommendations', [MovieController::class, 'recommendations']);
    });

    // User movie routes group
    Route::prefix('movies')->group(function () {
        Route::get('/', [UserController::class, 'fetchMovies']);
        Route::get('/horror', [UserController::class, 'getHorrorMovies']);
        Route::get('/western', [UserController::class, 'getWesternMovies']);
        Route::get('/popular', [UserController::class, 'getPopularMovies']);
    });

    // Include other route files within the main group
    include __DIR__ . '/search.php';
    include __DIR__ . '/user.php';
});
