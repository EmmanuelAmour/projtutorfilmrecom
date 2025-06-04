<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikeGenre;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserActions extends Controller
{
    protected $responseController;

    public function __construct()
    {
        //$this->data = new data();
        //$this->apiKey = env('TMDB_API_KEY');
        //$login = Session::get('login');

        $this->responseController = new responseController($adult);
    }
    public function likeGenre($genreId)
    {
        $userId = Auth::id();

        $genre = Genre::find($genreId);
        if (!$genre) {
            $genreResponse = $this->responseController->make_request(
                ['link' => 'https://api.themoviedb.org/3/genre/movie/list'],
                [
                    'api_key' => $this->apiKey
                ]
            );
            Genre::create([
                'id_genre' => $genreId,
                'name' => ''
            ]);
        }
        // Check if the user has already liked this genre
        $existingLike = LikeGenre::where('id_user', $userId)
            ->where('id_genre', $genreId)
            ->first();
        if (!$existingLike) {
            // Create new like
            LikeGenre::create([
                'id_user' => $userId,
                'id_genre' => $genreId
            ]);
            dd($userId);
            return back()->with('success', 'Genre liked successfully');
        }

        return response()->json(['message' => 'Genre already liked']);
    }

    public function unlikeGenre($genreId)
    {
        $userId = Auth::id();

        // Find and delete the like
        $like = LikeGenre::where('id_user', $userId)
            ->where('genre_id', $genreId)
            ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Genre unliked successfully']);
        }

        return response()->json(['message' => 'Genre was not liked']);
    }
}
