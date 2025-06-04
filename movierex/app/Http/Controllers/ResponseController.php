<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;



class ResponseController extends Controller
{
    protected $apiKey;
    protected $response;
    protected $link;
    protected $certification;
    protected $certification_country;
    protected $include_adult;
    public function __construct($adult)
    {
        $this->apiKey = env('TMDB_API_KEY');
        $this->set_audience($adult);
    }
    public function set_audience($adult)
    {
        if ($adult == true) {
            $this->include_adult = true;
            $this->certification = 'R';
        } else {
            $this->include_adult = false;
            $this->certification = 'PG-13';
        }
        $this->certification_country = 'US';
    }
    public function make_request($array, array $query)
    {

        //$this->set_audience(false);
        $baseParams = [
            'api_key' => $this->apiKey,
            'include_adult' => $this->include_adult,
            'certification_country' => $this->certification_country,
            'certification' => $this->certification
        ];
        // Merge the base parameters with any additional query parameters
        $params = array_merge($baseParams, $query);
        return $this->response = Http::get($array['link'], $params);
    }
}
