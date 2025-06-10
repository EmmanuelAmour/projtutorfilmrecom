<?php


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\defaultController;
use App\Http\Controllers\data;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SearchController extends defaultController
{


    public function __construct()
    {
        parent::__construct();
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $response = Http::get('https://api.themoviedb.org/3/search/person', [
            'api_key' => $this->apiKey,
            'query' => $query,
            'language' => app()->getLocale(),
            'page' => $request->input('page', 1)
        ]);

        if (!$response->successful()) {
            abort($response->status(), 'Erreur lors de la recherche');
        }

        $data = $response->json();

        return view('actor.search', [
            'results' => $data['results'],
            'total_pages' => $data['total_pages'],
            'current_page' => $data['page'],
            'query' => $query
        ]);
    }

    //
    // SearchController.php
    public function searchActor($name)
    {


        $response = Http::get('https://api.themoviedb.org/3/search/person', [
            'api_key' => $this->apiKey,
            'query' => $name,
            'page' =>  1,
            'language' => app()->getLocale()
        ]);

        if (!$response->successful()) {
            return back()->withError('API error: ' . $response->status());
        }

        $data = $response->json();

        return view('actor-search', [
            'results' => $data['results'],
            'total_pages' => $data['total_pages'],
            'current_page' => $data['page'],
            'search_term' => $name
        ]);
    }
}
