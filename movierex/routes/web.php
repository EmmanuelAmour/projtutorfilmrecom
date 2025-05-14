<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('index');
//Route::get('/home', [HomeController::class, 'index'])->name('home');
//|--------------------------------------------------------------------------
//| Web Routes to get movies and search for movies

Route::get('/movie/{id}', [MovieController::class, 'show_movie_single']);
Route::get('/recommendation/{movie_id}', [MovieController::class, 'recommendations']);
Route::get('/popular', [MovieController::class, 'popular']);
Route::get('/search/keyword/{keyword}', [MovieController::class, 'byKeyword'])->name('search.keyword');
//|--------------------------------------------------------------------------
Route::get('/search/genre/{genre}', [MovieSearchController::class, 'searchByGenre'])->name('search.genre');
Route::get('/search/year/{year}', [MovieSearchController::class, 'searchByYear'])->name('search.year');
Route::get('/search/rating/{rating}', [MovieSearchController::class, 'searchByRating'])->name('search.rating');
Route::get('/search/language/{language}', [MovieSearchController::class, 'searchByLanguage'])->name('search.language');
Route::get('/search/country/{country}', [MovieSearchController::class, 'searchByCountry'])->name('search.country');




//|--------------------------------------------------------------------------
//|
//| Here is where you can register web routes for your application.




//Route::get('/search/{query}', [MovieSearchController::class, 'search']);

//|--------------------------------------------------------------------------
// to get the similar keywords for an input keyword
Route::get('/search/keywords/{keyword}', [MovieSearchController::class, 'searchByKeyword'])->name('get.keywords');
//|--------------------------------------------------------------------------




Route::get('/search/actor', [MovieSearchController::class, 'searchByActor'])->name('search.actor');
Route::get('/search/director', [MovieSearchController::class, 'searchByDirector']);
Route::get('/search/producer', [MovieSearchController::class, 'searchByProducer']);
Route::get('/search/writer', [MovieSearchController::class, 'searchByWriter']);
Route::get('/search/composer', [MovieSearchController::class, 'searchByComposer']);
Route::get('/search/cinematographer', [MovieSearchController::class, 'searchByCinematographer']);
Route::get('/search/editor', [MovieSearchController::class, 'searchByEditor']);
Route::get('/search/production-company', [MovieSearchController::class, 'searchByProductionCompany']);







//-----------------------------------------------------------------
// routes/web.php
Route::get('/movies', [UserController::class, 'fetchMovies']);
Route::get('/movies/horror', [UserController::class, 'getHorrorMovies']);
Route::get('/movies/western', [UserController::class, 'getWesternMovies']);
Route::get('/movies/popular', [UserController::class, 'getPopularMovies']);

