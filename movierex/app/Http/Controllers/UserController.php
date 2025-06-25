<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\CB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\LikeKeyword;
use App\Models\LikeGenre;
use Illuminate\Support\Facades\Auth;


class UserController extends defaultController
{
    private $tmdbBase = 'https://api.themoviedb.org/3/';
    protected $cb;


    public function __construct()
    {
        parent::__construct();
    }

    public function fetchMovies(Request $request)
    {
        return response()->json([
            'horror' => $this->getHorrorMovies(),
            'western' => $this->getWesternMovies(),
            'popular' => $this->getPopularMovies(),

        ]);
    }

    public function getHorrorMovies()
    {
        return Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_genres' => 27,
            'sort_by' => 'popularity.desc',
            'language' => 'fr-FR'
        ])->json()['results'] ?? [];
    }

    public function getWesternMovies()
    {
        $keywordId = Http::get($this->tmdbBase . 'search/keyword', [
            'api_key' => $this->apiKey,
            'query' => 'western'
        ])->json()['results'][0]['id'] ?? null;

        return $keywordId ? Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_keywords' => $keywordId,
            'sort_by' => 'release_date.desc',
            'language' => 'fr-FR'
        ])->json()['results'] ?? [] : [];
    }

    public function getPopularMovies()
    {
        return Http::get($this->tmdbBase . 'movie/popular', [
            'api_key' => $this->apiKey,
            //'region' => 'FR',
            //'language' => 'fr-FR',
            'page' => 1
        ])->json()['results'] ?? [];
    }



    public function rex()
    {
        //dump($this->cb->rex_last_keyword_alone(Auth::id()));
        //dump($this->cb->rex_last_liked_movie_alone(Auth::id()));

        return [
            'rex_genres_alone' => $this->cb->rex_by_genres_alone(Auth::id()),
            'rex_last_keyword_alone' => $this->cb->rex_last_keyword_alone(Auth::id()),
            'rex_last_liked_movie_alone' => $this->cb->rex_last_liked_movie_alone(Auth::id()),
        ];
    }
}
