<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\filter\CB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Genre;
use App\Models\Keyword;
use App\Models\LikeKeyword;
use App\Models\LikeMovie;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;



class defaultController extends Controller
{
    private $keywords = [];
    protected $data;
    protected $apiKey;
    protected $login;
    protected $adult;
    protected $cb;
    protected $responseController;
    public function __construct()
    {
        //ini_set('memory_limit', '256M'); // or '512M' if needed
        $this->data = new data();
        $this->apiKey = env('TMDB_API_KEY');
        $this->set_session_login(Session::get('login', null));
        $this->set_session_adult();
        $this->responseController = new responseController($this->set_session_adult());
        $this->cb = new CB(Auth::id());
    }

    //SESSION VARAIBLES 
    //SESSION VARAIBLES : LOGIN
    public function get_session_login()
    {
        return Session::get('login');
    }
    public function set_session_login($login)
    {
        Session::put('login', $login);
        $this->login = $login;
        return $this->login;
    }
    //SESSION VARAIBLES : ADULT
    public function get_session_adult()
    {
        return $this->adult;
    }
    public function set_session_adult()
    {
        $currentYear = Carbon::now()->year;
        $adult = false;
        if ($this->get_session_login() != null) {
            if ($currentYear - $this->get_session_login()->birth_date->year >= 18) {
                $adult = true;
            }
        } else {
            $adult = false;
        }
        Session::put('adult', $adult);
        $this->adult = $adult;
        return $this->adult;
    }
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    //METHODS OF DATABASES
    // METHODS OF DATABASES : KEYWORDS
    public function set_keywords($id)
    {
        $response_keywords = Http::get("https://api.themoviedb.org/3/movie/{$id}/keywords?api_key={$this->apiKey}");
        if ($response_keywords->successful()) {
            $keywordsData = $response_keywords->json();
            $this->keywords = $keywordsData['keywords'] ?? [];
        }
        return $this->keywords;
    }
    // METHODS OF DATABASES : GENRES

    public function add_genre($genreId)
    {
        $genre = Genre::where('id_genre_tmdb', '=', $genreId)->first();
        // If not found, fetch it from the API
        if (!$genre) {
            $genreResponse = $this->responseController->make_request(
                ['link' => 'https://api.themoviedb.org/3/genre/movie/list'],
                []
            );
            if ($genreResponse->successful()) {
                $genreData = $genreResponse->json();
                if (isset($genreData['genres'])) {
                    foreach ($genreData['genres'] as $g) {
                        if ($g['id'] == $genreId) {
                            $genre = Genre::create([
                                'id_genre_tmdb' => $g['id'],
                                'name' => $g['name']
                            ]);
                            break;
                        }
                    }
                }
            } else {
                return response()->json(['error' => 'Failed to fetch genre information'], 500);
            }
        }
    }

    public function prepare_genres()
    {
        $genreResponse = $this->responseController->make_request(
            ['link' => 'https://api.themoviedb.org/3/genre/movie/list'],
            [
                'api_key' => $this->apiKey
            ]
        );
        if ($genreResponse->successful()) {
            $genres = $genreResponse->json()['genres'];
            foreach ($genres as $genre) {
                if (!Genre::where('id_genre_tmdb', '=', $genre['id'])->first())
                    Genre::create([
                        'id_genre_tmdb' => $genre['id'],
                        'name' => $genre['name']
                    ]);
            }
        }
    }

    // METHODS OF DATABASES : MOVIES
    // 
    /*
    
        The method returns the movie from the database if it exists, otherwise it creates it and returns it
        the database doesn't store all of the movie's direct attributes,
        it only stores the id, the title and the published_at date...
        the method also returns the movie from the API if it exists, otherwise it returns null.
    */
    public function get_movie($movieId)
    {
        $movie_database = Movie::where('id_movie_tmdb', '=', $movieId)->first();
        $movieResponse = $this->responseController->make_request(
            ['link' => 'https://api.themoviedb.org/3/movie/' . $movieId],
            []
        );
        $movie = $movieResponse->json();
        if (!$movie_database) {
            if ($movieResponse->successful()) {
                $movie_database = Movie::create([
                    'id_movie_tmdb' => $movie['id'],
                    'title' => $movie['title'],
                    'published_at' => $movie['release_date']
                ]);
            } else {
                return null;
            }
        }
        return $movie;
    }

    public function is_movie_liked($movieId, $userId)
    {
        $movie_database = Movie::where('id_movie_tmdb', '=', $movieId)->first();
        if ($movie_database) {
            $like = LikeMovie::where('id_movie', '=', $movie_database->id_movie)
                ->where('id_user', '=', $userId)->first();
            //dump($like);
            if ($like)
                return true;
            else
                return false;
        }
    }

    //KEYWORDS
    public function get_keyword($keyword)
    {

        $keyword_database = Keyword::where('name', '=', $keyword)->first();
        $keywordResponse  = $this->responseController->make_request(
            ['link' => 'https://api.themoviedb.org/3/search/keyword'],
            [
                'query' => $keyword,
            ]
        );
        $keyword_result = $keywordResponse->json();

        if (!$keyword_database) {
            if ($keywordResponse->successful()) {
                $keyword = $keyword_result['results'][0];
                $keyword_database = Keyword::create([
                    'id_keyword_tmdb' => $keyword['id'],
                    'name' => $keyword['name'],
                ]);
            } else {
                return null;
            }
        }
        return $keyword_database;
    }
    public function is_keyword_liked($id_keyword, $userId)
    {
        $keyword_database = Keyword::where('id_keyword', '=', $id_keyword)->first();
        if ($keyword_database) {
            $like = LikeKeyword::where('id_keyword', '=', $keyword_database->id_keyword)
                ->where('id_user', '=', $userId)->first();
            //dump($like);

            if ($like)
                return true;
            else
                return false;
        }
    }


    public function is_movie_watched($id, $userId)
    {
        $movie_database = Movie::where('id_movie_tmdb', '=', $id)->first();
        if ($movie_database) {
            $isWatched = Watchlist::where('id_movie', '=', $movie_database->id_movie)
                ->where('id_user', '=', $userId)->first();
            //dump($like);
            if ($isWatched)
                return true;
            else
                return false;
        }
    }
}
