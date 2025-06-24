<?php

namespace App\Http\Controllers\filter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\defaultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\filter\Interests;
use Illuminate\Support\Env;

class CB extends Controller
{
    private $apiKey;
    private $tmdbBase = 'https://api.themoviedb.org/3/';
    public $interests;

    public function __construct($id_user)
    {
        $this->interests = new Interests($id_user);
        $this->apiKey = env('TMDB_API_KEY');
    }


    public function get_rex_by_genres_alone()
    {
        $genres_extracted = "";
        foreach ($this->interests->liked_genres as $genre) {
            $genres_extracted .= $genre . ",";
        }
        $genres_extracted = substr($genres_extracted, 0, -1);
        //dd($this->interests);
        $results = Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_genres' => $genres_extracted, // Western (37) AND Action (28)
            'sort_by' => 'popularity.desc',
            //'vote_average.gte' => 6,
            'vote_count.gte' => 50,
        ])->json()['results'] ?? [];
        if (!$results)
            return $this->rex_last_liked_genre_alone();
    }


    //GET LAST OF LISTS

    public function rex_last_keyword_alone($id_user)
    {
        $lastkeyword = end($this->interests->liked_keywords);
        //$genres_extracted = substr($genres_extracted, 0, -1);
        //dd($this->interests);
        $json = Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_keywords' => $lastkeyword, // Western (37) AND Action (28)
            'sort_by' => 'popularity.desc',
            //'vote_average.gte' => 6,
            'vote_count.gte' => 50,
        ])->json()['results'] ?? [];

        return [
            'name' => \App\Models\Keyword::where('id_keyword_tmdb', $lastkeyword)->value('name'),
            'results' => $json
        ];
    }
    public function rex_last_liked_movie_alone($id_user)
    {
        $lastmovie = end($this->interests->liked_movies);
        $json = Http::get($this->tmdbBase . "movie/{$lastmovie}/similar", [
            'api_key' => $this->apiKey,
            'sort_by' => 'popularity.desc',
            //'vote_average.gte' => 6,
            //'vote_count.gte' => 50,
        ])->json()['results'] ?? [];
        //dd($json);
        return [
            'name' => \App\Models\Movie::where('id_movie_tmdb', $lastmovie)->value('title'),
            'results' => $json,
            'id' => $lastmovie
        ];
    }

    public function rex_similar_movies($id_user, $id_movie_tmdb)
    {
        //$lastmovie = end($this->interests->liked_movies);
        $json = Http::get($this->tmdbBase . "movie/{$id_movie_tmdb}/similar", [
            'api_key' => $this->apiKey,
            'sort_by' => 'popularity.desc',
            //'vote_average.gte' => 6,
            //'vote_count.gte' => 50,
        ])->json()['results'] ?? [];
        //dd($json);
        return [
            'name' => \App\Models\Movie::where('id_movie_tmdb', $id_movie_tmdb)->value('title'),
            'results' => $json,
            'id' => $id_movie_tmdb
        ];
    }

    public function rex_last_liked_genre_alone()
    {
        $genres_extracted = end($this->interests->liked_genres);
        //dd($this->interests);
        $results = Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_genres' => $genres_extracted, // Western (37) AND Action (28)
            'sort_by' => 'popularity.desc',
            //'vote_average.gte' => 6,
            'vote_count.gte' => 50,
        ])->json()['results'] ?? [];
        return $results;
    }
}
