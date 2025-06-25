<?php

namespace App\Http\Controllers;

use App\Http\Controllers\filter\Collab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Rex extends defaultController
{
    private $collab;
    private $userController;

    public function __construct()
    {
        parent::__construct();
        $this->collab = new Collab(Auth::id());
        $this->userController = new UserController();
    }

    public function matches()
    {
        // Get collaborative filtering recommendations
        $collab_movies = $this->collab->rex_by_their_liked_genres() ?? [];

        // Get content-based recommendations
        $user_rex = $this->userController->rex();
        $genre_movies = $user_rex['rex_genres_alone'] ?? [];
        $keyword_movies = $user_rex['rex_last_keyword_alone'] ?? [];
        $similar_movies = $user_rex['rex_last_liked_movie_alone'] ?? [];

        // Merge all recommendations
        $all_movies = array_merge(
            $collab_movies,
            $genre_movies,
            $keyword_movies,
            $similar_movies
        );

        // Remove duplicate movies based on id
        $unique_movies = [];
        $seen_ids = [];

        foreach ($all_movies as $movie) {
            if (!isset($movie['id']) || in_array($movie['id'], $seen_ids)) {
                continue;
            }
            $seen_ids[] = $movie['id'];
            $unique_movies[] = $movie;
        }

        // Sort by popularity
        usort($unique_movies, function ($a, $b) {
            return ($b['popularity'] ?? 0) <=> ($a['popularity'] ?? 0);
        });

        return view('movies', [
            'movies' => $unique_movies,
            'page' => 1,
            'total_pages' => 1,
            'pageTitle' => 'Best Matches for you'
        ]);
    }
}
