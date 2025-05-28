<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserController;



Route::post('/genre/{genre}/like', [UserController::class, 'like_genre'])->name('genre.like');
