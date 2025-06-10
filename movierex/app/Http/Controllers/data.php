<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use App\Models\Movie;

class Data extends Controller
{
    //CLASS TO DEAL WITH THE RESULTING DATA FROM THE API

    protected $movies = [];
    protected $page;
    protected $total_results;
    protected $total_pages;
    //SETTERS AND GETTERS====================================================================
    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    public function setTotalPages($total_pages)
    {
        $this->total_pages = $total_pages;
        return $this;
    }
    public function getTotalResults()
    {
        return $this->total_results;
    }

    public function setTotalResults($total_results)
    {
        $this->total_results = $total_results;
        return $this;
    }
    public function setMovies(array $movies)
    {
        $this->movies = $movies;
    }

    public function getMovies()
    {
        return $this->movies;
    }
    //==================================================================

    // Sort movies by a given key and order
    public function sortMoviesBy($key, $order = 'asc')
    {
        if (empty($this->movies)) {
            return false;
        }
        usort($this->movies, function ($a, $b) use ($key, $order) {
            if (!isset($a[$key]) || !isset($b[$key])) {
                return 0;
            }

            return ($order === 'asc')
                ? $a[$key] <=> $b[$key]
                : $b[$key] <=> $a[$key];
        });
        return true; // success
    }
    // Remove adult movies
    public function removeAdultMovies()
    {
        if (empty($this->movies)) {
            return false;
        }
        $this->movies = array_filter($this->movies, function ($movie) {
            // Check if adult flag exists and is false, or if it doesn't exist
            return !isset($movie['adult']) || $movie['adult'] === false;
        });

        return true;
    }

    public function prepareMovies(array $movies)
    {
        $this->setMovies($movies);
        $this->removeAdultMovies();
        $this->sortMoviesBy('popularity', 'desc');
        $this->sortMoviesBy('vote_average', 'desc');
        return $this->getMovies();
    }
    public function set_all(Response $result)
    {
        if ($result->successful()) {
            $this->setMovies($result->json()['results'] ?? []);
            $this->setPage($result->json()['page'] ?? 1);
            $this->setTotalPages($result->json()['total_pages'] ?? 1);
            $this->setTotalResults($result->json()['total_results'] ?? 1);
        } else {
            return abort(500, 'Something went wrong');
        }
        $this->removeAdultMovies();
        $this->sortMoviesBy('popularity', 'desc');
        $this->sortMoviesBy('vote_average', 'desc');
        return $this->getMovies();
    }
}
