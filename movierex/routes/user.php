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
    Route::delete('/genre/{id}/unlike', [UserActions::class, 'unlikeGenre'])->name('user.unlike.genre');

    // Movie management
    Route::post('/movie/{movieId}/like', [UserActions::class, 'likeMovie'])->name('user.like.movie');
    Route::delete('/movie/{movieId}/unlike', [UserActions::class, 'unlikeMovie'])->name('user.unlike.movie');
    Route::post('/movie/{movie}/rate', [UserActions::class, 'rate_movie'])->name('movie.rate');
    Route::delete('/movie/{movie}/unrate', [UserActions::class, 'unrate_movie'])->name('movie.unrate');

    // Keyword management
    Route::post('/keyword/{id}/like', [UserActions::class, 'likeKeyword'])->name('user.like.keyword');
    Route::delete('/keyword/{id}/unlike', [UserActions::class, 'unLikeKeyword'])->name('user.unlike.keyword');

    // Watchlist management
    Route::get('/watchlist', [UserController::class, 'watchlist'])->name('watchlist.index');
    Route::post('/watchlist/movie/{movie}/add', [UserController::class, 'add_to_watchlist'])->name('watchlist.add');
    Route::delete('/watchlist/movie/{movie}/remove', [UserController::class, 'remove_from_watchlist'])->name('watchlist.remove');

    // Comments
    Route::post('/movie/{movie}/comment', [UserController::class, 'comment'])->name('movie.comment');
    Route::put('/comment/{comment}', [UserController::class, 'update_comment'])->name('comment.update');
    Route::delete('/comment/{comment}', [UserController::class, 'delete_comment'])->name('comment.delete');
});
