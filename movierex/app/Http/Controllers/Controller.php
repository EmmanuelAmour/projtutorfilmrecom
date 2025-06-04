<?php

namespace App\Http\Controllers;

abstract class Controller
{
    private $keywords = [];
    protected $data;
    protected $apiKey;
    protected $responseController;
    public function __construct()
    {
        $this->data = new data();
        $this->apiKey = env('TMDB_API_KEY');
        $login = Session::get('login');
        $currentYear = Carbon::now()->year;
        $adult = false;
        if ($currentYear - $login->birth_date->year >= 18) {
            $adult = true;
        }
        $this->responseController = new responseController($adult);
    }
}
