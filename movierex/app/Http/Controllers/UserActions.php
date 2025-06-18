<?php

namespace App\Http\Controllers;

use App\Models\LikeKeyword;
use Illuminate\Http\Request;
use App\Models\LikeGenre;
use App\Models\LikeMovie;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Keyword;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserActions extends defaultController
{
    protected $responseController;

    public function __construct()
    {
        parent::__construct();
        $this->set_session_adult();
        $this->responseController = new responseController($this->get_session_adult());
    }
    public function likeGenre($genreId)
    {
        $userId = Auth::id();
        $genre = Genre::where('id_genre_tmdb', '=', $genreId)->first();
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
        if (!$genre) {
            return response()->json(['error' => 'Genre not found after API attempt'], 404);
        }
        $existingLike = LikeGenre::where('id_user', $userId)
            ->where('id_genre', $genre->id_genre)->first();
        if (!$existingLike) {
            LikeGenre::create([
                'id_user' => $userId,
                'id_genre' => $genre->id_genre
            ]);
            return back()->with('success', 'Genre liked successfully');
        }
        return response()->json(['message' => 'Genre already liked']);
    }
    //------------------
    public function unlikeGenre($genreId)
    {
        $genre = Genre::where('id_genre_tmdb', '=', $genreId)->first();
        if (!$genre) {
            return response()->json(['error' => 'Genre not found'], 404);
        }
        $userId = Auth::id();
        $like = LikeGenre::where('id_user', $userId)
            ->where('id_genre', $genre->id_genre)->first();
        if ($like) {
            $like->delete();
            return back()->with('success', 'Genre liked successfully');
        }
        return response()->json(['message' => 'Genre was not liked']);
    }
    //===========================================================================
    //MOVIES
    public function likeMovie($movieId)
    {
        $userId = Auth::id();
        $movie = Movie::where('id_movie_tmdb', '=', $movieId)->first();
        $existingLike = LikeMovie::where('id_user', $userId)
            ->where('id_movie', $movie->id_movie)
            ->first();
        if ($existingLike) {
            return response()->json(['message' => 'Movie already liked'], 409);
        } else {
            LikeMovie::create([
                'id_user' => $userId,
                'id_movie' => $movie->id_movie
            ]);
            return back()->with('success', 'Genre liked successfully');
        }
    }

    public function unlikeMovie($movieId)
    {
        $userId = Auth::id();
        $movie = Movie::where('id_movie_tmdb', '=', $movieId)->first();

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        $like = LikeMovie::where('id_user', $userId)
            ->where('id_movie', $movie->id_movie)
            ->first();

        if (!$like) {
            return response()->json(['error' => 'Like not found'], 404);
        }

        $like->delete();
        return back()->with('success', 'Genre liked successfully');
    }

    public function likeKeyword($keywordId)
    {
        $userId = Auth::id();
        $keyword = Keyword::where('id_keyword_tmdb', '=', $keywordId)->first();
        $existingLike =
            LikeKeyword::where('id_user', $userId)
            ->where('id_keyword', $keyword->id_keyword)
            ->first();
        if ($existingLike) {
            return response()->json(['message' => 'Movie already liked'], 409);
        } else {
            LikeKeyword::create([
                'id_user' => $userId,
                'id_keyword' => $keyword->id_keyword
            ]);
            return back()->with('success', 'Genre liked successfully');
        }
    }

    public function unLikeKeyword($keywordId)
    {
        $userId = Auth::id();
        $keyword = Keyword::where('id_keyword_tmdb', '=', $keywordId)->first();
        $existingLike =
            LikeKeyword::where('id_user', $userId)
            ->where('id_keyword', $keyword->id_keyword)
            ->first();
        if (!$existingLike) {
            return response()->json(['error' => 'Like not found'], 404);
        }
        $existingLike->delete();
        return back()->with('success', 'Genre liked successfully');
    }

    //Watchlist
    public function add_to_watchlist($movieId)
    {
        $userId = Auth::id();
        $movie = Movie::where('id_movie_tmdb', '=', $movieId)->first();
        $existingLike = Watchlist::where('id_user', $userId)
            ->where('id_movie', $movie->id_movie)
            ->first();
        if ($existingLike) {
            return response()->json(['message' => 'Movie already liked'], 409);
        } else {
            Watchlist::create([
                'id_user' => $userId,
                'id_movie' => $movie->id_movie
            ]);
            return back()->with('success', 'Genre liked successfully');
        }
    }
    public function remove_from_watchlist($movieId)
    {
        $userId = Auth::id();
        $movie = Movie::where('id_movie_tmdb', '=', $movieId)->first();

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }
        $watched = Watchlist::where('id_user', $userId)
            ->where('id_movie', $movie->id_movie)
            ->first();

        if (!$watched) {
            return response()->json(['error' => 'Like not found'], 404);
        }

        $watched->delete();
        return back()->with('success', 'Genre liked successfully');
    }
}
