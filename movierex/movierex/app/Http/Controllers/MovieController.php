<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    private $keywords = [];
    protected $data;
    protected $apiKey;
    protected $responseController;
    public function __construct()
    {
        $this->data = new data();
        $this->apiKey = env('TMDB_API_KEY');
        $this->responseController = new responseController(false);
    }
    

    public function welcome()
    {
        return view('welcome');
    }
    public function set_keywords($id)
    {
        $response_keywords = Http::get("https://api.themoviedb.org/3/movie/{$id}/keywords?api_key={$this->apiKey}");
        if ($response_keywords->successful()) {
            $keywordsData = $response_keywords->json();
            $this->keywords = $keywordsData['keywords'] ?? [];
        }
        return $this->keywords;
    }
    public function show_movie_single($id)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}?api_key={$this->apiKey}");
        $keywords = $this->set_keywords($id);
        if ($response->successful()) {
            $movie = $response->json();
            return view('movie', compact('movie', 'keywords'));
        }
        return abort(404);
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
        $response =$this->responseController->make_request(
        ['link' => 'https://api.themoviedb.org/3/movie/popular'], []);    
        if ($response->successful()) {
            $this->data->prepareMovies($response->json()['results'] ?? []);   
            $movies = $this->data->getMovies();
            return view('popular', compact('movies'));
        }
        return abort(404);
    }
    public function upcoming()
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/upcoming?api_key={$this->apiKey}");

        if ($response->successful()) {
            $this->data->prepareMovies($response->json()['results'] ?? []);   
            $movies = $this->data->getMovies();
            return view('upcoming', compact('movies'));
        }

        return abort(404);
    }
    public function trending()
    {
        $moviesResponse =$this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
                    'sort_by' => 'popularity.desc'
                ]);
        $response = Http::get("https://api.themoviedb.org/3/movie/trending?api_key={$this->apiKey}");
        if ($response->successful()) {
            $this->data->prepareMovies($response->json()['results'] ?? []);   
            $movies = $this->data->getMovies();
            return view('trending', compact('movies'));
        }
        return abort(404);
    }

    public function byKeyword($keyword)
    {
        // NOTE: The current functionality doesn't filter by keyword, it just shows popular movies.
        // To properly filter by keyword, you would need a different API call.
        
        $response =$this->responseController->make_request(
            ['link' => 'https://api.themoviedb.org/3/search/keyword'], [
            'query' => $keyword,
        ]);
        if ($response->successful()) {
            $keywordData = $response->json();
            $keywordId = $keywordData['results'][0]['id'] ?? null;
            if ($keywordId) {
                $moviesResponse =$this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
                    'with_keywords' => $keywordId,
                ]);
                if ($moviesResponse->successful()) {
                    $this->data->prepareMovies($moviesResponse->json()['results'] ?? []);   
                    $movies = $this->data->getMovies();
                    // Return the view with the movies, but you may need to adjust the view to handle the keyword searc
                    return view('popular', compact('movies'));
                }
            }
        }
        return abort(404);
    }
}
