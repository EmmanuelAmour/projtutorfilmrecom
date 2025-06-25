<?php

namespace App\Http\Controllers\filter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\defaultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LikeGenre;
use App\Http\Controllers\filter\CB;
use App\Http\Controllers\filter\Interests;
use Illuminate\Support\Facades\Http;

class Collab extends defaultController
{
    private $tmdbBase = 'https://api.themoviedb.org/3/';
    //private $cb;

    public function __construct($id_user)
    {
        parent::__construct();
        $this->cb = new CB($id_user);
    }

    public function get_other_interests($their_id)
    {
        return new Interests($their_id);
    }

    public function rex_by_their_liked_genres()
    {
        //$this->cb = new CB(Auth::id()); // assuming CB needs to be instantiated
        $user_liked_genres = $this->cb->interests->liked_genres;

        if (empty($user_liked_genres)) {
            return [];
        }

        // Get all other users who liked the same genres (except current user)
        $other_users = LikeGenre::whereIn('id_genre', $user_liked_genres)
            ->where('id_user', '!=', Auth::id())
            ->pluck('id_user')
            ->unique();

        if ($other_users->isEmpty()) {
            return [];
        }

        $all_their_genres = [];

        foreach ($other_users as $id_user) {
            $their_interests = $this->get_other_interests($id_user);
            $their_liked_genres = $their_interests->liked_genres ?? [];

            foreach ($their_liked_genres as $genre_id) {
                $all_their_genres[] = $genre_id;
            }
        }
        //dd($all_their_genres);

        // Remove duplicates
        //$unique_genres = array_unique($all_their_genres);

        //dd($all_their_genres);

        // Prepare genres as comma-separated string for TMDB
        $genres_extracted = implode(',', $all_their_genres);
        $results = Http::get($this->tmdbBase . 'discover/movie', [
            'api_key' => $this->apiKey,
            'with_genres' => $genres_extracted, // e.g. "28,37"
            'sort_by' => 'popularity.desc',
            'vote_count.gte' => 50,
        ])->json()['results'] ?? [];
        if (empty($results)) {
            $genres_extracted = implode(',', array_slice($all_their_genres, 0, (int)(count($all_their_genres) / 2)));

            $results = Http::get($this->tmdbBase . 'discover/movie', [
                'api_key' => $this->apiKey,
                'with_genres' => $genres_extracted, // e.g. "28,37"
                'sort_by' => 'popularity.desc',
                'vote_count.gte' => 50,
            ])->json()['results'] ?? [];
        }

        return $results;
    }
}
