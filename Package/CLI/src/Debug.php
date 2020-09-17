<?php

namespace ROBOAMP\CLI;

use ROBOAMP\cli\clistyle;
use ROBOAMP\Batman;

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
    public static function log($message,$extra_padding=false){

        $string_class=new Batman();
        $res=debug_backtrace();
        $cliStyle=new CliStyle();
        //check if messages is multiline
        if($string_class->multi_line($message)){

            $lines=explode("\n",$message);
            $tmp_message="";
            foreach ($lines as $item){
                if($item!="") {
                    $tabs = $string_class->get_total_tabs($item);
                    $tmp_message .= $tmp_message . $tabs;
                    $cliStyle->log_message($item.$tabs);
                }
            }

        }else{
            $tabs=$string_class->get_total_tabs($message);
            $tmp_message=$message.$tabs;
            $cliStyle->log_message($tmp_message);

        }

        $starting_index=2;

        $tab="     ";
        $class=(isset($res[$starting_index]['class'])? "| Class: ".$res[$starting_index]["class"]:"");
        $triggered_from="Message triggered on Method: ".$res[$starting_index]['function'].$tab.$class;

        $tabs=$string_class->get_total_tabs($triggered_from);
        $triggered_from=$triggered_from.$tabs;

        $cliStyle->log_message($triggered_from,$extra_padding);


    }


}