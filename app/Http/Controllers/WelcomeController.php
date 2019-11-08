<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ROBOAMP\URL;
use ROBOAMP\Validator;
use ROBOAMP\Seeder as myStrings;

class WelcomeController extends Controller{


    public function main(){
     /*   //$res=$str::get_string_between("<hola lola>","<",">");
        $file_path=base_path('taytus.txt');
        //$res=myStrings::string_in_file("hello",$file_path);
        $res=myStrings::find_string_in_file('haha',$file_path);
        dd($res);


        dd();

        $val=new Validator();

        $str=['aa44aa','aa44','44aa',44,'44','aa'];

        foreach($str as $item){
            $res=$val->validation_rules_alphabetic($item);
            echo $item."    ".$res['error']."<br>";
        }

        dd();












        $class='App\Http\Controllers\WelcomeController';
        $method='bananas';
        $params=['a','b','c'];
        MyClass::call_method($class,$method,$params);



        $res='https://amp.mansfield-dentalcare.com?id=8fc33172-1b47-4eb3-95b9-92e3d4007912&page=https%3A%2F%2Fwww.mansfield-dentalcare.com%2F';

        $res=URL::get_property_info_from_roboamp_install_code($res);

        dd($res);*/
    }
    public function lol(){
        dd("LOL");
    }

    public static function bananas($params){
        dd("this is bananas",$params);
    }
}
