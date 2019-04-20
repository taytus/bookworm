<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ROBOAMP\URL;
use ROBOAMP\MyClass;


class WelcomeController extends Controller{


    public function main(){
        $class='App\Http\Controllers\WelcomeController';

        MyClass::call_method($class,'bananas');



    }
    public function lol(){
        dd("LOL");
    }

    public static function bananas(){
        dd("this is bananas");
    }
}
