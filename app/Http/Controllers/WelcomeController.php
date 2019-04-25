<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ROBOAMP\MyClass;

use ROBOAMP\URL;

class WelcomeController extends Controller{


    public function main(){

        $class='App\Http\Controllers\WelcomeController';
        $method='bananas';
        $params=['a','b','c'];
        MyClass::call_method($class,$method,$params);



        $res='https://amp.mansfield-dentalcare.com?id=8fc33172-1b47-4eb3-95b9-92e3d4007912&page=https%3A%2F%2Fwww.mansfield-dentalcare.com%2F';

        $res=URL::get_property_info_from_roboamp_install_code($res);

        dd($res);
    }
    public function lol(){
        dd("LOL");
    }

    public static function bananas($params){
        dd("this is bananas",$params);
    }
}
