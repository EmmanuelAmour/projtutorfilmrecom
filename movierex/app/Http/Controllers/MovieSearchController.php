<?php

namespace App\Http\Controllers;

use App\Http\Controllers\data;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieSearchController extends Controller
{
    protected $data;
    protected $apiKey;


    public function __construct()
    {
        $this->data = new data();
        $this->apiKey = env('TMDB_API_KEY');
    }

    public function search($query)
    {
        $response = Http::get("https://api.themoviedb.org/3/search/movie?api_key={$this->apiKey}&query={$query}");

        if ($response->successful()) {
            $movies = $response->json()['results'];
            return view('movies', [
                'movies' => $movies,
                'pageTitle' => 'Search Results for "' . $query . '"'
            ]);
        }

        return abort(404);
    }

    public function searchByKeyword($keyword)
    {
        $response = Http::get(
            "https://api.themoviedb.org/3/search/keyword",
            [
                'api_key' => $this->apiKey,
                'query' => $keyword
            ]
        );
        if ($response->successful()) {
            $movies = $response->json()['results'];
            dd($movies);
            return view('movies', [
                'movies' => $movies, // No movies directly here!
                'pageTitle' => 'Keywords Found for "' . $keyword . '"'
            ]);
        }
        return abort(404);
    }

    public function searchByGenre($genre)
    {

        $genreResponse = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
            'api_key' => $this->apiKey
        ]);
        if ($genreResponse->successful()) {
            $genres = $genreResponse->json()['genres'];

            // Find genre ID by name
            $genreId = collect($genres)->firstWhere('name', ucfirst(strtolower($genre)))['id'] ?? null;

            if ($genreId) {
                $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
                    'api_key' => $this->apiKey,
                    'with_genres' => $genreId
                ]);

                if ($response->successful()) {
                    $movies = $response->json()['results'];
                    return view('movies', [
                        'movies' => $movies,
                        'pageTitle' => 'Movies in Genre: ' . ucfirst($genre)
                    ]);
                }
            }
        }

        return abort(404);
    }

    public function searchByYear($year)
    {
        if (empty($this->apiKey)) {
            return abort(500, 'API key not set.');
        }
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
            'api_key' => $this->apiKey,
            'primary_release_year' => $year
        ]);
        if ($response->successful()) {
            $this->data->setMovies($response->json()['results'] ?? []);
            $this->data->sortMoviesBy('vote_average', 'desc');
            return view('movies', [
                'movies' => $this->data->getMovies(),
                'pageTitle' => 'Movies Released in ' . $year . ' (Sorted by Rating) || total_results  ' . $response->json()['total_results'] . ' movies'
            ]);
        }

        return view('error', ['message' => 'Could not fetch movie data.']);
    }


    public function searchByRating($rating)
    {
        //$rating = $request->input('rating');
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
            'api_key' => $this->apiKey,
            'vote_average.gte' => $rating
        ]);

        if ($response->successful()) {
            $this->data->setMovies($response->json()['results'] ?? []);
            $this->data->sortMoviesBy('vote_average', 'desc');
            return view('movies', [
                'movies' => $this->data->getMovies(),
                'pageTitle' => 'Movies Rated Above ' . $rating . '★'
            ]);
        }

        return abort(404);
    }

    public function searchByLanguage($language)
    {
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
            'api_key' => $this->apiKey,
            'with_original_language' => $language
        ]);

        if ($response->successful()) {
            $movies = $response->json()['results'];
            return view('movies', [
                'movies' => $movies,
                'pageTitle' => 'Movies in Language: ' . strtoupper($language)
            ]);
        }

        return abort(404);
    }

    public function searchByCountry($country)
    {
        $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
            'api_key' => $this->apiKey,
            'country' => $country
        ]);

        if ($response->successful()) {
            $movies = $response->json()['results'];
            return view('movies', [
                'movies' => $movies,
                'pageTitle' => 'Movies Released in ' . strtoupper($country)
            ]);
        }

        return abort(404);
    }

    public function searchByActor(Request $request)
    {
        $actor = $request->input('actor');
        $personResponse = Http::get("https://api.themoviedb.org/3/search/person", [
            'api_key' => $this->apiKey,
            'query' => $actor
        ]);

        if ($personResponse->successful()) {
            $actorData = $personResponse->json()['results'][0] ?? null;

            if ($actorData) {
                $actorId = $actorData['id'];

                $movieCredits = Http::get("https://api.themoviedb.org/3/person/{$actorId}/movie_credits", [
                    'api_key' => $this->apiKey
                ]);

                if ($movieCredits->successful()) {
                    $movies = $movieCredits->json()['cast'];
                    return view('movies', [
                        'movies' => $movies,
                        'pageTitle' => 'Movies Starring ' . $actor
                    ]);
                }
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
                    $movies = $moviesResponse->json()['results'];
                    return view('movies', [
                        'movies' => $movies,
                        'pageTitle' => 'Movies by ' . $company
                    ]);
                }
            }
        }

        return abort(404);
    }
}
