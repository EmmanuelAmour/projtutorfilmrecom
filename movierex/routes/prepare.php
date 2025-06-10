<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\defaultController;
use App\Http\Controllers\AuthController;




Route::get('/prepare/genres', [defaultController::class, 'prepare_genres'])->name('prepare.genres');
