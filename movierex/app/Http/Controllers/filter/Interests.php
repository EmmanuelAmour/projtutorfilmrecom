<?php

namespace App\Http\Controllers\filter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LikeKeyword;
use App\Models\LikeGenre;
use App\Models\LikeMovie;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Keyword;
use App\Models\Watchlist;

class Interests extends Controller
{
    public $id_user;
    public $liked_movies;     // Array of TMDb movie IDs
    public $liked_genres;     // Array of TMDb genre IDs
    public $liked_keywords;   // Array of TMDb keyword IDs
    public $watched_movies;   // Array of TMDb movie IDs

    public function __construct($id_user)
    {
        $this->id_user = $id_user;
        $this->get_liked_movies($id_user);
        $this->get_liked_genres();
        $this->get_liked_keywords($id_user);
        $this->get_watched_movies($id_user);
    }

    public function get_liked_movies($id_user)
    {
        $likedMovies = LikeMovie::where('id_user', $id_user)->get();

        $this->liked_movies = [];
        foreach ($likedMovies as $movie) {
            $mo = Movie::find($movie->id_movie);
            if ($mo) {
                $this->liked_movies[] = $mo->id_movie_tmdb;
            }
        }
    }

    public function get_liked_genres()
    {
        $likedGenres = LikeGenre::where('id_user', $this->id_user)->get();

        $this->liked_genres = [];
        foreach ($likedGenres as $g) {
            $genre = Genre::find($g->id_genre);
            if ($genre) {
                $this->liked_genres[] = $genre->id_genre_tmdb;
            }
        }
        return $this->liked_genres; // Return the array her
    }

    public function get_liked_keywords($id_user)
    {
        $likedKeywords = LikeKeyword::where('id_user', $id_user)->get();

        $this->liked_keywords = [];
        foreach ($likedKeywords as $k) {
            $keyword = Keyword::find($k->id_keyword);
            if ($keyword) {
                $this->liked_keywords[] = $keyword->id_keyword_tmdb;
            }
        }
    }

    public function get_watched_movies($id_user)
    {
        $watchedMovies = Watchlist::where('id_user', $id_user)->get();

        $this->watched_movies = [];
        foreach ($watchedMovies as $wm) {
            $movie = Movie::find($wm->id_movie);
            if ($movie) {
                $this->watched_movies[] = $movie->id_movie_tmdb;
            }
        }
    }
}
