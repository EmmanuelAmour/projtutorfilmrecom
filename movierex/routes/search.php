<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\MovieController;

// All routes will inherit the 'movierex' prefix from web.php
Route::prefix('search')->group(function () {

    // Specific search routes must come before the generic search route
    Route::get('/genre/{genre}', [MovieSearchController::class, 'searchByGenre'])->name('search.genre');
    Route::get('/year/{year}', [MovieSearchController::class, 'searchByYear'])->name('search.year');
    Route::get('/rating/{rating}', [MovieSearchController::class, 'searchByRating'])->name('search.rating');
    Route::get('/language/{language}', [MovieSearchController::class, 'searchByLanguage'])->name('search.language');
    Route::get('/country/{country}', [MovieSearchController::class, 'searchByCountry'])->name('search.country');
    Route::get('/keywords/{keyword}', [MovieSearchController::class, 'searchByKeyword'])->name('get.keywords');
    Route::get('/keyword/{keyword}', [MovieController::class, 'byKeyword'])->name('search.keyword');
    Route::get('/actor/{name}', [MovieSearchController::class, 'searchActor'])->name('actor.search');
    // Fixed the controller method reference
    Route::get('/movie/{query}', [MovieSearchController::class, 'search'])->name('search');
});


// Movie cast route
Route::get('/movie/{movieId}/cast', [MovieSearchController::class, 'getMovieCast']);
