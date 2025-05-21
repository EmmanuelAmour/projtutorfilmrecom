<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\MovieController;
/*
|--------------------------------------------------------------------------
| Web Routes
*/


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





// to get the similar keywords for an input keyword//
Route::get('/search/keywords/{keyword}', [MovieSearchController::class, 'searchByKeyword'])->name('get.keywords');
//--------------------------------------------------------------------------




Route::get('/search/actor/{name}', [SearchController::class, 'searchActor'])->name('actor.search');