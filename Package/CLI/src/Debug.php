<?php

namespace ROBOAMP\CLI;

use ROBOAMP\CLI\CliStyle;
use ROBOAMP\Strings;

class Debug   {


    public static function error($error_message){
        $res=debug_backtrace();
        $cliStyle=new CliStyle();
        //the [0] position is the one calling this method, the one alarming of an error
        //[1] is the one calling [0]
        $error_message="Error: ".$error_message."\t\t\t\t\t\t\t\t\t\t\t";
        $triggered_from="Error on Method: ".$res[1]['function']."\t | Class: ".$res[1]["class"]."\t\t\t\t\t\t\t\t\t";
        $called_from= "Called from ".$res[1]['file']." \t | Line: ".$res[1]["line"]."\t\t\t\t\t\t";

        $cliStyle->error_message($error_message);
        $cliStyle->error_message($triggered_from);
        $cliStyle->error_message($called_from);

        dd();
    }
    public static function log($message){
        $tabs=strlen($message)/4;
        $max_tabs=13-$tabs;
        $str="";
        for ($i=0;$i<$max_tabs;$i++){
            $str.="\t";
        }
        $res=debug_backtrace();
        $cliStyle=new CliStyle();
        $message=$message.$str;
        $triggered_from="Message triggered on Method: ".$res[1]['function']."\t | Class: ".$res[1]["class"]."\t\t\t\t\t\t\t\t\t";

        $cliStyle->log_message($message);
        $cliStyle->log_message($triggered_from);
    }



}