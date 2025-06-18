<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Movie;
use App\Models\Keyword;
use App\Models\Genre;
use App\Models\MovieKeyword;
use Illuminate\Support\Facades\Auth;


class MovieController extends defaultController
{
    private $keywords = [];
    protected $data;
    protected $apiKey;
    protected $responseController;
    public function __construct()
    {
        parent::__construct();
        $this->get_session_login();
        $this->set_session_adult();
        $this->responseController = new responseController($this->get_session_adult());
    }


    public function welcome()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $userId = Auth::id();
        $movie = $this->get_movie($id);
        $isLiked = false;
        $isLiked = $this->is_movie_liked($id, $userId);
        //$isWatched = null;
        $isWatched = $this->is_movie_watched($id, $userId);
        $keywords = $this->set_keywords($id);

        return view('movie', [
            'movie' => $movie,
            'keywords' => $keywords,
            'isLiked' => $isLiked,
            'isWatched' => $isWatched,

        ]);
    }

    public function recommendations($movie_id)
    {
        $recommendationResponse = Http::get("http://127.0.0.1:5000/recommend_by_content", [
            'movie_id' => $movie_id
        ]);
        $recommendedMovies = [];

        if ($recommendationResponse->successful()) {
            foreach ($recommendationResponse->json() as $recommendedId) {
                $movieResponse = Http::get("https://api.themoviedb.org/3/movie/{$recommendedId}?api_key={$this->apiKey}");
                if ($movieResponse->successful()) {
                    $recommendedMovies[] = $movieResponse->json();
                }
            }
        }

        return view('recommendations', ['movies' => $recommendedMovies]);
    }

    public function popular()
    {
        $response = $this->responseController->make_request(
            ['link' => 'https://api.themoviedb.org/3/movie/popular'],
            []
        );
        $this->data->set_all($response);
        return view('popular', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
        ]);
    }
    public function upcoming()
    {
        $response =
            $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/movie/upcoming'], []);
        $this->data->set_all($response);
        return view('upcoming', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'isLiked' => false
        ]);
    }
    public function trending()
    {
        $response =
            $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/trending/movie/day'], []);
        $this->data->set_all($response);
        return view('upcoming', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'isLiked' => false
        ]);
    }

    public function byKeyword($keyword)
    {
        $userId = Auth::id();
        $keyword_req = $this->get_keyword($keyword);
        $keywordId = $keyword_req->id_keyword_tmdb;
        $moviesResponse = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
            'with_keywords' => $keywordId,
        ]);
        if ($moviesResponse->successful()) {
            $this->data->prepareMovies($moviesResponse->json()['results'] ?? []);
            $movies = $this->data->getMovies();
            // Return the view with the movies, but you may need to adjust the view to handle the keyword searc
            $existingLike = true;
            $existingLike = $this->is_keyword_liked($keyword_req->id_keyword, $userId);
            //dd($keyword_req);
            //dd($existingLike);
            return view(
                'keyword',
                [
                    'movies' => $movies,
                    'keyword' => $keyword,
                    'id_keyword' => $keywordId,
                    'pageTitle' => $keyword . " keyword",
                    'page' => $this->data->getPage(),
                    'total_pages' => $this->data->getTotalPages(),
                    'total_results' => $this->data->getTotalResults(),
                    'isLiked' => $existingLike,
                ]
            );
        }


        return abort(404);
    }
}
