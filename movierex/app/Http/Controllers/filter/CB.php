<?php

namespace App\Http\Controllers\filter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\defaultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\filter\Interests;

class CB extends defaultController
{
    private $tmdbBase = 'https://api.themoviedb.org/3/';
    public $interests;

    public function __construct($id_user)
    {
        parent::__construct();
        $this->interests = new Interests($id_user);
    }


    public function get_rex_by_genres_alone($id_user)
    {
        $genres_extracted = "";
        foreach ($this->interests->liked_genres as $genre) {
            $genres_extracted .= $genre . ",";
        }
        $genres_extracted = substr($genres_extracted, 0, -1);
        //dd($this->interests);
        return Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_genres' => $genres_extracted, // Western (37) AND Action (28)
            'sort_by' => 'popularity.desc',
            //'vote_average.gte' => 6,
            'vote_count.gte' => 50,
        ])->json()['results'] ?? [];
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
            'results' => $json
        ];
    }
}
