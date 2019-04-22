<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use ROBOAMP\Strings;
class WelcomeController extends Controller{


    public function main(){

        $str=new Strings();

        dd($str::get_string_between('<nothing>','<','>'));


    }
    public function lol(){
        dd("LOL");
    }

    public static function bananas(){
        dd("this is bananas");
    }
}
