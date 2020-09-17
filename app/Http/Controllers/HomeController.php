<?php

namespace App\Http\Controllers;
use roboamp\DB;
use Illuminate\Http\Request;

use ROBOAMP\Batman;

class HomeController extends Controller{

    public function index(){

        dd(Batman::random());

    }
}
