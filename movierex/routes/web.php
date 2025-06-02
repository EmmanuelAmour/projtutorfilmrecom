<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// If your Laravel app is in a subdirectory, wrap all routes in a group with a prefix
Route::group(['prefix' => ''], function () {
    // Main routes
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/popular', [MovieController::class, 'popular']);
    Route::get('/trending', [MovieController::class, 'trending']);
    Route::get('/upcoming', [MovieController::class, 'upcoming']);
    // Movie routes
    Route::get('/movie/{id}', [MovieController::class, 'show']);
    Route::get('/movie/{id}/similar', [MovieController::class, 'similar']);
    Route::get('/movie/{id}/credits', [MovieController::class, 'credits']);
    Route::get('/movie/{id}/reviews', [MovieController::class, 'reviews']);
    Route::get('/movie/{id}/recommendations', [MovieController::class, 'recommendations']);
    Route::get('/movie/{id}/keywords', [MovieController::class, 'keywords']);
    Route::get('/movie/{id}/videos', [MovieController::class, 'videos']);
    Route::get('/movie/{id}/images', [MovieController::class, 'images']);
    Route::get('/movie/{id}/lists', [MovieController::class, 'lists']);
    Route::get('/movie/{id}/watch/providers', [MovieController::class, 'watchProviders']);
    Route::get('/movie/{id}/account/states', [MovieController::class, 'accountStates']);


    include __DIR__ . '/search.php';

    aaaaa

    // Routes d'authentification
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    //Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
});
