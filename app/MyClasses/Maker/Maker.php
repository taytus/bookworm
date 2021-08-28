<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 9/14/18
 * Time: 9:09 PM
 */

namespace App\MyClasses\Maker;

use App\MyClasses\Paths;
use App\MyClasses\Git;
use App\MyClasses\Files;
use App\MyClasses\Batman;


class Maker {

    public static $file_type=['CliTool','Sabina','OLOLO'];
    public static $template_path="";
    public $file_prefix="";
    public $file_extension=".php";

    public function __construct(){

    }
    public static function make($file_type,$file_name){
        $array=new Git();
        if($array->check_for_string_in_array($file_type,self::$file_type)){
            call_user_func(array(__CLASS__,"make_".$file_type),ucfirst($file_name));
        }else{
            echo "\File type is not valid. These are valid file types:\n";
            echo self::get_file_types();
        }

    }

    public static function get_file_types(){
        $str="";
        foreach (self::$file_type as $file_type){
            $str.="--->".$file_type."\n";
        }
        return $str;
    }
    public static function make_CliTool($file_name){
        $placeholders=['{{tool_name}}'];
        $subs=[$file_name];
        $path_to_template_folder=Paths::path_to_folder('Maker');
        $path_to_command_folder=Paths::path_to_folder('Commands');

        $template_path=$path_to_template_folder.'/CliTool.php';
        $template_destination=$path_to_command_folder."/".$file_name.".php";
        $file=new Files();
        $file->copy_file($template_path,$template_destination,null,null,0);
        $file->replace_all_placeholders($placeholders,$subs,$template_destination);

        //now register the tool

        self::register_tool($file_name);


    }
    public static function register_tool($file_name){
        $file=new Files();
        $path_to_template= base_path()."/app/Console/Kernel.php";
        $placeholder=['//{{new_command}}'];
        $sub=["Commands\\".$file_name."::class,\n\t\t//{{new_command}}"];
        $file_content=$file->get_file_content($path_to_template);

        if(!Batman::string_in_string($file_content,"Commands\\".$file_name."::class")){
            $file->replace_all_placeholders($placeholder,$sub,$path_to_template);
        }





    }


} 