<?php
namespace App\MyClasses;
use App\MyClasses\Cli\CliStyle;
use Illuminate\Support\Facades\Redirect;
use App\MyClasses\Server;


class Errors extends CliStyle {



    public function __construct(){
    }

    public function return_error_as_json($error){
        return json_encode($error);
    }
    public static function dd(...$message){
        $server=new Server();
        if($server->local_server){
            dd($message);
        }
    }

    public function log_error($method_name){
        $backtrace = debug_backtrace();
        echo "\n# Method ".$method_name."  called from " . $backtrace[0]['file'] . " at line " . $backtrace[0]['line']."\n\n";

    }
    public function log_error_and_die($method_name,$error_message){
        $backtrace = debug_backtrace();
        dd("Method ".$method_name,"called from " . $backtrace[0]['file'] , "at line " . $backtrace[0]['line'],$error_message);
    }
    public static function abort($error_number,$message,$property_error_page){

        if($error_number==404){
            if(!is_null($property_error_page)){
               return redirect()->away($property_error_page);
                exit();
            }else{
                return abort(404,$message);

            }
        }
    }



}