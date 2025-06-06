<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

abstract class Controller
{
    private $keywords = [];
    protected $data;
    protected $apiKey;
    protected $login;
    protected $responseController;
    public function __construct()
    {
        $this->data = new data();
        $this->apiKey = env('TMDB_API_KEY');
        $this->login = Session::get('login');
        $currentYear = Carbon::now()->year;
        $adult = false;
        if ($currentYear - $this->login->birth_date->year >= 18) {
            $adult = true;
        }
        $this->responseController = new responseController($adult);
    }

    //SESSION VARAIBLES 
    // LOGIN
    public function get_session_login()
    {
        return Session::get('login');
    }
    public function set_session_login($login)
    {
        Session::put('login', $login);
        $this->login = $login;
    }

    //adult
    public function get_session_adult() {}
    public function set_session_adult() {}
}
