<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollabFiltering extends Controller
{
    protected $Interests;


    public function __construct($id_user)
    {
        $this->Interests = new Interests($id_user);
    }
    public function get_recommedation($id_user) {}
}
