<?php

namespace App\Http\Controllers;

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

    protected $liked_movies;
    protected $liked_genres;
    protected $liked_keywords;
    protected $watched_movies;
    public function  __construct($id_user)
    {
        $this->liked_movies = LikeMovie::where('id_user', $id_user)->get();
        $this->liked_genres = LikeGenre::where('id_user', $id_user)->get();
        $this->liked_keywords = LikeKeyword::where('id_user', $id_user)->get();
        $this->watched_movies = Watchlist::where('id_user', $id_user)->get();
    }
}
