<?php

namespace App\MyClasses;
use App\MyClasses\Cli\CliStyle;


class Debug   {




    public function __construct(){


    }
    public static function log($error_message){
        $res=debug_backtrace();
        $cli=$res[1]["object"]->cli;
        $cliStyle=new CliStyle($cli);
        //the [0] position is the one calling this method, the one alarming of an error
        //[1] is the one calling [0]
        $error_message="Error: ".$error_message."\t\t\t\t\t\t\t\t\t\t";
        $triggered_from="Error on Method: ".$res[1]['function']."\t | Class: ".$res[1]["class"]."\t\t\t\t\t\t\t\t\t";
        $called_from= "Called from ".$res[1]['file']." \t | Line: ".$res[1]["line"]."\t\t\t\t\t\t";

        echo

        $cliStyle->error_message($error_message);
        $cliStyle->error_message($triggered_from);
        $cliStyle->error_message($called_from);

        dd();

    }



}