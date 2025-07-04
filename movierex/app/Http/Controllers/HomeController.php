<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HomeController extends defaultController
{
    public $userController;
    protected $apiKey;


    public function __construct()
    {
        parent::__construct();
        $this->userController = new UserController();
    }

    public function index()
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/popular?api_key={$this->apiKey}");

        if ($response->successful()) {
            $popularMovies = $this->userController->getPopularMovies();
            $featuredMovie = $popularMovies[0] ?? null;

            // Removed calls to get*Movies as they are not defined in the User model.
            //$movies = $response->json()['results'];
            return view('home', [
                'popular_movies' => $this->userController->getPopularMovies(),
                'keyword_movies' => $this->userController->getPopularMovies(),
                'horror_movies' => $this->userController->getPopularMovies(),
                'top_rated' => $this->userController->getTopRatedMovies(),
                'rex' => $this->userController->rex(),
                'pageTitle' => 'Welcome to MovieRex',
                'featured_movie' => $featuredMovie,
            ]);
        }

        return abort(404);
    }
}
