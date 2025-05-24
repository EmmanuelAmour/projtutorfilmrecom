<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Data extends Controller
{
    protected $movies = [];

    


    // Set movies array
    public function setMovies(array $movies)
    {
        $this->movies = $movies;
    }

    // Get movies array
    public function getMovies()
    {
        return $this->movies;
    }

    // Sort movies by a given key and order
    public function sortMoviesBy($key, $order = 'asc')
    {
        if (empty($this->movies)) {
            return false; // or throw an exception if preferred
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


    public function removeAdultMovies()
    {
        if (empty($this->movies)) {
            return false;
        }
        $this->movies = array_filter($this->movies, function($movie) {
            // Check if adult flag exists and is false, or if it doesn't exist
            return !isset($movie['adult']) || $movie['adult'] === false;
        });

        return true;
    }

    public function prepareMovies(array $movies){
        $this->setMovies($movies);
        $this->removeAdultMovies();
        $this->sortMoviesBy('popularity', 'desc');
        $this->sortMoviesBy('vote_average', 'desc');
        return $this->getMovies();
    }

}
