<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\MovieController;
/*
|--------------------------------------------------------------------------
| Web Routes
*/

//===============================
//SEARCH
//|--------------------------------------------------------------------------
Route::get('/search/genre/{genre}', [MovieSearchController::class, 'searchByGenre'])->name('search.genre');
Route::get('/search/year/{year}', [MovieSearchController::class, 'searchByYear'])->name('search.year');
Route::get('/search/rating/{rating}', [MovieSearchController::class, 'searchByRating'])->name('search.rating');
Route::get('/search/language/{language}', [MovieSearchController::class, 'searchByLanguage'])->name('search.language');
Route::get('/search/country/{country}', [MovieSearchController::class, 'searchByCountry'])->name('search.country');

//|--------------------------------------------------------------------------
Route::get('/search/keyword/{keyword}', [MovieController::class, 'byKeyword'])->name('search.keyword');
Route::get('/search/genre/{genre}', [MovieSearchController::class, 'searchByGenre'])->name('search.genre');
Route::get('/search/year/{year}', [MovieSearchController::class, 'searchByYear'])->name('search.year');
Route::get('/search/rating/{rating}', [MovieSearchController::class, 'searchByRating'])->name('search.rating');
Route::get('/search/language/{language}', [MovieSearchController::class, 'searchByLanguage'])->name('search.language');
Route::get('/search/country/{country}', [MovieSearchController::class, 'searchByCountry'])->name('search.country');





// to get the similar keywords for an input keyword//

Route::get('/search/keywords/{keyword}', [MovieSearchController::class, 'searchByKeyword'])->name('get.keywords');


Route::get('/search/{query}', [MovieSearchController::class, 'search'])->name('search.default');



Route::get('/movie/{movieId}/cast', [MovieSearchController::class, 'getMovieCast']);
//--------------------------------------------------------------------------




Route::get('/search/actor/{name}', [SearchController::class, 'searchActor'])->name('actor.search');













//Route::get('/search/actor', [MovieSearchController::class, 'searchByActor'])->name('search.actor');
Route::get('/search/director', [MovieSearchController::class, 'searchByDirector']);
Route::get('/search/producer', [MovieSearchController::class, 'searchByProducer']);
Route::get('/search/writer', [MovieSearchController::class, 'searchByWriter']);
Route::get('/search/composer', [MovieSearchController::class, 'searchByComposer']);
Route::get('/search/cinematographer', [MovieSearchController::class, 'searchByCinematographer']);
Route::get('/search/editor', [MovieSearchController::class, 'searchByEditor']);
Route::get('/search/production-company', [MovieSearchController::class, 'searchByProductionCompany']);