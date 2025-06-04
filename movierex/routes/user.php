<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\UserActions;
use App\Http\Controllers\UserController;

// Genre management
Route::prefix('user')->group(function () {
    // Specific search routes must come before the generic search route
    Route::post('/genre/{id}/like', [UserActions::class, 'likeGenre'])->name('user.like.genre');
    Route::delete('/genre/{id}/unlike', [UserController::class, 'unlike_genre'])->name('user.unlike.genre');

    // Movie management
    Route::post('/movie/{movie}/like', [UserController::class, 'like_movie'])->name('user.like.movie');
    Route::delete('/movie/{movie}/unlike', [UserController::class, 'unlike_movie'])->name('user.unlike.movie');
    Route::post('/movie/{movie}/rate', [UserController::class, 'rate_movie'])->name('movie.rate');
    Route::delete('/movie/{movie}/unrate', [UserController::class, 'unrate_movie'])->name('movie.unrate');

    // Keyword management
    Route::post('/keyword/{keyword}/like', [UserController::class, 'like_keyword'])->name('user.like.keyword');
    Route::delete('/keyword/{keyword}/unlike', [UserController::class, 'unlike_keyword'])->name('user.unlike.keyword');

    // Watchlist management
    Route::get('/watchlist', [UserController::class, 'watchlist'])->name('watchlist.index');
    Route::post('/watchlist/movie/{movie}/add', [UserController::class, 'add_to_watchlist'])->name('watchlist.add');
    Route::delete('/watchlist/movie/{movie}/remove', [UserController::class, 'remove_from_watchlist'])->name('watchlist.remove');

    // Comments
    Route::post('/movie/{movie}/comment', [UserController::class, 'comment'])->name('movie.comment');
    Route::put('/comment/{comment}', [UserController::class, 'update_comment'])->name('comment.update');
    Route::delete('/comment/{comment}', [UserController::class, 'delete_comment'])->name('comment.delete');
});
