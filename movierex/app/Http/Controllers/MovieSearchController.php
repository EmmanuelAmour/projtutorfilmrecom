<?php

namespace App\Http\Controllers;

use App\Http\Controllers\data;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;



class MovieSearchController extends MovieController
{
    protected $data;
    protected $apiKey;
    protected $responseController;
    public function __construct()
    {
        parent::__construct();
    }

    public function search($query, $page = 1)
    {
        $response = $this->responseController->make_request([
            'link' => 'https://api.themoviedb.org/3/search/movie'
        ], [
            'api_key' => $this->apiKey,
            'query' => $query,
            'page' => $page // Ajout du paramètre de pagination
        ]);

        $this->data->set_all($response);
        return view('movies', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'query' => $query,
            'pageTitle' => 'Search Results for "' . $query . '"',
            'isLiked' => false
        ]);
    }
    public function searchByGenre($genre, $page = 1)
    {
        $genreResponse = $this->responseController->make_request(
            ['link' => 'https://api.themoviedb.org/3/genre/movie/list'],
            [
                'api_key' => $this->apiKey
            ]
        );
        if ($genreResponse->successful()) {
            $genres = $genreResponse->json()['genres'];
            $genreId = collect($genres)->firstWhere('name', ucfirst(strtolower($genre)))['id'] ?? null;

            if ($genreId) {
                $response = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
                    'api_key' => $this->apiKey,
                    'with_genres' => $genreId,
                    'page' => $page // Ajout du paramètre de pagination
                ]);
                $this->data->set_all($response);
                return view('genre', [
                    'movies' => $this->data->getMovies(),
                    'page' => $this->data->getPage(),
                    'total_pages' => $this->data->getTotalPages(),
                    'total_results' => $this->data->getTotalResults(),
                    'genre' => $genre,
                    'id_genre' => $genreId,
                    'isLiked' => false
                ]);
            }
        }

        return abort(404);
    }

    public function searchByKeyword($keyword)
    {
        $response = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/search/keyword'], [
            'api_key' => $this->apiKey,
            'query' => $keyword
        ]);
        $this->data->set_all($response);
        return view('movies', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'isLiked' => false
        ]);
    }

    public function searchByYear($year)
    {
        if (empty($this->apiKey)) {
            return abort(500, 'API key not set.');
        }
        $response = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
            'api_key' => $this->apiKey,
            'primary_release_year' => $year
        ]);
        $this->data->set_all($response);
        return view('movies', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'pageTitle' => 'Movies Released in ' . $year . ' (Sorted by Rating)',
            'isLiked' => false
        ]);
    }

    public function searchByRating($rating)
    {
        $response = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
            'api_key' => $this->apiKey,
            'vote_average.gte' => $rating
        ]);
        $this->data->set_all($response);
        return view('movies', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'pageTitle' => 'Movies Rated Above ' . $rating . '★',
            'isLiked' => false
        ]);
    }

    public function searchByLanguage($language)
    {
        $response = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
            'api_key' => $this->apiKey,
            'with_original_language' => $language
        ]);
        $this->data->set_all($response);
        return view('movies', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'pageTitle' => 'Movies in Language: ' . strtoupper($language),
            'isLiked' => false
        ]);
    }

    public function searchByCountry($country)
    {
        $response = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/discover/movie'], [
            'api_key' => $this->apiKey,
            'country' => $country
        ]);
        $this->data->set_all($response);
        return view('movies', [
            'movies' => $this->data->getMovies(),
            'page' => $this->data->getPage(),
            'total_pages' => $this->data->getTotalPages(),
            'total_results' => $this->data->getTotalResults(),
            'pageTitle' => 'Movies Released in ' . strtoupper($country),
            'isLiked' => false
        ]);
    }

    public function searchByActor(Request $request)
    {
        $actor = $request->input('actor');
        $personResponse = $this->responseController->make_request(['link' => 'https://api.themoviedb.org/3/search/person'], [
            'api_key' => $this->apiKey,
            'query' => $actor
        ]);

        if ($personResponse->successful()) {
            $actorData = $personResponse->json()['results'][0] ?? null;
            if ($actorData) {
                $actorId = $actorData['id'];
                $response = $this->responseController->make_request(
                    ['link' => "https://api.themoviedb.org/3/person/{$actorId}/movie_credits"],
                    ['api_key' => $this->apiKey]
                );
                $this->data->set_all($response);
                return view('movies', [
                    'movies' => $this->data->getMovies(),
                    'page' => $this->data->getPage(),
                    'total_pages' => $this->data->getTotalPages(),
                    'total_results' => $this->data->getTotalResults(),
                    'pageTitle' => 'Movies Starring ' . $actor,
                    'isLiked' => false
                ]);
            }
        }
        return abort(404);
    }


    // For Director, Producer, Writer, Composer, Cinematographer, Editor:
    // (Similar to Actor but you filter by job)

    public function searchByDirector(Request $request)
    {
        return $this->searchByCrewJob($request, 'Director');
    }

    public function searchByProducer(Request $request)
    {
        return $this->searchByCrewJob($request, 'Producer');
    }

    public function searchByWriter(Request $request)
    {
        return $this->searchByCrewJob($request, 'Writer');
    }

    public function searchByComposer(Request $request)
    {
        return $this->searchByCrewJob($request, 'Original Music Composer');
    }

    public function searchByCinematographer(Request $request)
    {
        return $this->searchByCrewJob($request, 'Director of Photography');
    }

    public function searchByEditor(Request $request)
    {
        return $this->searchByCrewJob($request, 'Editor');
    }

    private function searchByCrewJob(Request $request, $job)
    {
        $name = $request->input(strtolower(str_replace(' ', '_', $job)));
        $personResponse = Http::get("https://api.themoviedb.org/3/search/person", [
            'api_key' => $this->apiKey,
            'query' => $name
        ]);

        if ($personResponse->successful()) {
            $personData = $personResponse->json()['results'][0] ?? null;

            if ($personData) {
                $personId = $personData['id'];

                $credits = Http::get("https://api.themoviedb.org/3/person/{$personId}/movie_credits", [
                    'api_key' => $this->apiKey
                ]);

                if ($credits->successful()) {
                    $crewMovies = collect($credits->json()['crew'])->where('job', $job)->values();
                    return view('movies', [
                        'movies' => $crewMovies,
                        'pageTitle' => 'Movies by ' . $job . ' ' . $name
                    ]);
                }
            }
        }

        return abort(404);
    }

    public function searchByProductionCompany(Request $request)
    {
        $company = $request->input('production_company');

        $companySearch = Http::get("https://api.themoviedb.org/3/search/company", [
            'api_key' => $this->apiKey,
            'query' => $company
        ]);

        if ($companySearch->successful()) {
            $companyData = $companySearch->json()['results'][0] ?? null;

            if ($companyData) {
                $companyId = $companyData['id'];

                $moviesResponse = Http::get("https://api.themoviedb.org/3/discover/movie", [
                    'api_key' => $this->apiKey,
                    'with_companies' => $companyId
                ]);

                if ($moviesResponse->successful()) {
                    $this->data->prepareMovies(movies: $moviesResponse->json()['results'] ?? []);
                    return view('movies', [
                        'movies' => $this->data->getMovies(),
                        'pageTitle' => 'Movies by ' . $company
                    ]);
                }
            }
        }

        return abort(404);
    }

    public function getMovieCast($movieId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/credits", [
            'api_key' => $this->apiKey
        ]);

        if ($response->successful()) {
            $cast = $response->json()['cast'] ?? [];
            return view('cast', [
                'cast' => $cast,
                'pageTitle' => 'Movie Cast'
            ]);
        }

        return abort(404);
    }
}
