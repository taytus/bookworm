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
        $class=(isset($res[1]['class'])? "| Class: ".$res[1]["class"]:"");
        $triggered_from="Error on Method: ".$res[1]['function']."\t".$class."\t\t\t\t\t\t\t\t\t";
        $called_from= "Called from ".$res[1]['file']." \t | Line: ".$res[1]["line"]."\t\t\t\t\t\t";

        $cliStyle->error_message($error_message);
        $cliStyle->error_message($triggered_from);
        $cliStyle->error_message($called_from);

        die();
    }
    public static function log($message){

        $string_class=new Strings();
        $res=debug_backtrace();
        $cliStyle=new CliStyle();

        //check if messages is multiline
        if($string_class->multi_line($message)){
            $lines=explode("\n",$message);
            $message="";
            dd($lines);
            foreach ($lines as $item){
                $tabs=$string_class->get_total_tabs($item)."\n";
                $message.=$message.$tabs;
            }
        }else{
            $tabs=$string_class->get_total_tabs($message);
            $message=$message.$tabs;
        }




        $tab="     ";
        $class=(isset($res[1]['class'])? "| Class: ".$res[1]["class"]:"");
        $triggered_from="Message triggered on Method: ".$res[1]['function'].$tab.$class;

        $tabs=$string_class->get_total_tabs($triggered_from);
        $triggered_from=$triggered_from.$tabs;

        $cliStyle->log_message($message);
        $cliStyle->log_message($triggered_from);


    }


}