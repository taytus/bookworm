<?php
namespace App\MyClasses\Cli;

use App\MyClasses\Cleanup;
use App\MyClasses\CliFormat;
use App\MyClasses\Directory;
use App\MyClasses\Files;
use App\MyClasses\Paths;
use App\Page;
use App\Property;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use ROBOAMP\Batman;
use App\MyClasses\Git;
use App\MyClasses\Validate;

class CliParser {

    protected $selected_user=null;
    public $properties;
    public $options;
    private $cli;
    private $property_path;
    private $minified_files=[];

    protected static $callback="create_new_property";


    public function __construct($cli){
        if(is_array($cli)|| is_null($cli))dd(__METHOD__,'wrong CLI');
        $this->cli=$cli;

    }

    public function HTML_to_Blade($res){
        if($res!=$this->cli) {
            //something has been selected
            $cleanup = 1;
            if (is_array($res)) {
               // $this->cli->ask('some question');


                $files_in_folder = $this->get_files($res);
                $files = new Files();
                $files->HTML_to_Blade($files_in_folder);
                //Validate AMP Pages

                $property_data = $this->add_temp_property($files_in_folder);
                //records and folders have been created, so now I copy the files over there
                $files->copy_all_files($res[1], $property_data['path']);
                $cleanup = true;
                echo "\n Starting Validation\n";
                Validate::validate_local_amp_property($property_data['id'], $this->cli->output);
                echo "\n";
                if ($cleanup) Cleanup::delete_temp_properties();
                dd(__METHOD__, "Has been finished");
            }
        }
        return  (new Ask($this->cli))->ask_for_parser_folders();


    }

    private function add_temp_property ($files_in_folder){
        $directory=new Directory();
        $now=Carbon::now();

        //testing user
        $customer_id='4b2e76c5-3e76-4f2e-b79c-128170265e78';
        $property_id= Uuid::generate(4);
        $property_domain="temp_".$property_id.".com";
        $property_url="https://".$property_domain;

        $directory->create_folders_for_new_property($property_url);

        $property_class=new Property();
        $property_class->id=$property_id;
        $property_class->url=$property_url;
        $property_class->status_id=1;
        $property_class->customer_id=$customer_id;
        $property_class->created_at=$now;
        $property_class->updated_at=$now;
        $property_class->save();

        foreach($files_in_folder as $item){
            $page_id=Uuid::generate(4);
            $page_class=new Page();
            $page_class->id=$page_id;
            $page_class->property_id=$property_id;
            $page_class->url=urlencode($property_url."/".$item['filename']);
            $page_class->name=$item['filename'];
            $page_class->created_at=$now;
            $page_class->updated_at=$now;
            $page_class->save();
        }
        $path_to_property=Paths::path_to_folder('properties')."/".$property_domain;

        return ['id'=>$property_id,'path'=>$path_to_property];

    }

    //scan the property's folder and returns an array to help making
    //the page's seeder easier to write.
    public function create_page_seed_inserts_from_pages($res=null){


          if(is_array($res)){
            $files = $this->get_files($res);

            foreach ($files as $item) {
                $str = "['id'=>'" . Uuid::generate(4) . "','url'=>urlencode(\$property_root_url.'/" . $item['filename'] . "'),'property_id'=>\$property_id,'name'=>'" . $item['filename'] . "','created_at'=>\$now,'updated_at'=>\$now],";
                echo $str . "\n";
            }
            dd();
        }
        $res = (new Ask($this->cli))->ask_for_parser_folders();



    }


    public function auto_replace_amp_sidebars($res){
        if($res!=$this->cli) {


            dd('momomomo');

            dd('work on this option again');
            $res[1] = '/Users/taytus/Projects/roboamp/parser/properties/lg_2';


            //$this->cleanup($res[1]);
            if (!is_null($res)) {
                $base_dir = $this->property_path = $res[1];

                //$this->cleanup($base_dir);


                $class_file = new Files();
                $class_array = new Git();
                $class_directory = new Directory();

                $total_files = $class_file->total_php_files_in_directory($base_dir);

                //doing test with only one file to see if it changes it correctly
                $includes_dir = $base_dir . "/includes";
                $includes_dir_array = $class_directory->get_files_in_directories($includes_dir, ["min"]);

                //minify the includes files
                $this->minify_includes($includes_dir_array);

                $includes_files_templates = $class_directory->get_files_in_dir($includes_dir . "/min");
                $blade_files = $class_directory->get_files_in_dir($base_dir);
                $error = null;

                //$includes_dir_array= array with all the folders and files in them

                foreach ($includes_dir_array as $includes_files) {
                    $j = 1;
                    $parsed_files = [];

                    foreach ($includes_files as $item) {
                        $include_file_content = $class_file->get_file_content($includes_dir . "/min/" . $item['basename']);
                        $str = $this->get_replacement($item['filename']);

                        foreach ($blade_files as $blade) {
                            if (!$class_array->check_for_string_in_array($blade['full_path'], $parsed_files)) {
                                $file_path = $base_dir . "/" . $blade['basename'];
                                if (!$class_array->check_for_string_in_array($file_path, $this->minified_files)) {
                                    $minified_file = $this->minify($file_path);
                                    $this->minified_files = $class_array->insert_string_in_array_if_doesnt_exist($file_path, $this->minified_files);
                                } else {
                                    echo "File " . $file_path . " has been ignored\n";
                                    $minified_file = $this->get_minified_file_path($file_path);
                                }
                                $file_content = $class_file->get_file_content($minified_file);

                                $tmp_res = str_replace($include_file_content, $str, $file_content, $count);
                                if ($count) {
                                    echo "File : " . $file_path . " has been updated \n";
                                    $res = $class_file->re_write_file($tmp_res, $file_path);

                                    echo "File " . $j . " of " . $total_files . "\n";
                                    $j++;
                                } else {
                                    $tmp_res = str_replace($str, $str, $file_content, $counter);
                                    if (!$counter) $error[] = "match not found on file " . $file_path . " " . $str;
                                }


                            } else {
                                echo "S K I P " . $j . " -> " . $blade['full_path'] . "\n";
                            }
                            $parsed_files = $class_array->insert_string_in_array_if_doesnt_exist($blade['full_path'], $parsed_files);
                            // dd($item['full_path'],$parsed_files);

                        }
                        if (!is_null($error)) {

                            dd($error, $str, $this->minified_files);

                        };

                        $j++;
                    }

                }
                dd($parsed_files);


                foreach ($includes_files_templates as $item) {
                    $include_file_content = $class_file->get_file_content($includes_dir . "/min/" . $item['basename']);
                    $str = $this->get_replacement($item['filename']);
                    $j = 1;
                    $error = null;
                    echo "\n------------------------------------------\n";
                    echo "-----------NEW INCLUDE FILE-----------------\n";
                    echo "\n------------------------------------------\n";

                    foreach ($blade_files as $blade) {


                        //testing
                        $control_filename = "/Users/taytus/Projects/roboamp/parser/properties/lg_2/active-directory-consulting-firm.blade.php";
                        $control_include = "@include('includes::amp_sidebar')";
                        //end testing
                        /* if($file_path==$control_filename && $str!=$control_include){
                             $minified_file=$this->minify($file_path);

                             $file_content=$class_file->get_file_content($minified_file);

                             $tmp_res=str_replace($include_file_content,$str,$file_content,$count);
                             $this->cleanup($base_dir,0);

                             dd($count,$include_file_content,$file_content,$str);
                             dd("yeah!",$file_content);
                         }*/

                        //check if the file has been minified already


                    }


                }
            } else {

                $res = (new Ask($this->cli))->ask_for_parser_folders();

            }
        }else{
//            $res=$this->cli->ask('something');
            return function(){
                echo "something";
            };
        }



}

    public function get_files($res){
        $directory = new Directory();
        $directory_path = $res[1];
        return $directory->get_files_in_dir($directory_path);
    }
    public function get_replacement($type){

        $str=str_replace(".blade","",$type);
        $str="@include('includes::".$str."')";

        return $str;
    }
    private function get_minified_file_path($file_path){
        $minified_folder_path=(dirname($file_path)."/min/");
        return $minified_folder_path.basename($file_path);
    }
    private function get_minified_directory_path($file_path){
        return dirname($file_path)."/min/";
    }
    public function minify($file_path){
        $minified_folder_path=$this->get_minified_directory_path($file_path);
        $minified_file_path=$this->get_minified_file_path($file_path);
        $string=new Batman();



        Directory::create($minified_folder_path);

        $string->minify($file_path,$minified_file_path);
        $this->minified_files[]=$file_path;


        echo "File ".$file_path." has been minified\n";

        return $minified_file_path;
    }
    //delete all the blade.php files
    public function cleanup($property_path,$die=1){
        $files = glob($property_path.'/*.blade.php'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        //move all the files from the Archive folder;
        $files = glob($property_path.'/Archive/*.blade.php'); // get all file names
        $files_class=new Files();
        foreach($files as $file) {
            $file_info=pathinfo($file);
            $destination=$property_path."/".$file_info['basename'];
            $files_class->copy_file($file,$destination);
        }
        if($die)dd("cleanup has been compleated");


    }
    //receives a directory and minify everything inside that folder
    public function minify_includes($directory_array){
        $string = new Batman();
        $array_class=new Git();
        $j=0;

        foreach ($directory_array as $files) {

           // if (!is_dir($item[$j]['full_path'] . "/min/")) Directory::create($directory . "/min");
            foreach ($files as $item) {
                $minified_file_path = $this->property_path . "/min/" . $item['basename'];
                if(!$array_class->check_for_string_in_array($item['full_path'],$this->minified_files)){
                    $res = $string->minify($item['full_path'], $minified_file_path);
                    echo $minified_file_path . "\n", $res;
                }else{
                    echo "File ".$item['full_path']." has not been minified\n";
                }




            }
            $j++;
            echo "\n--------------------------------\n";
            echo "\n--------------------------------\n";
            echo "\n--------------------------------\n";
        }
    }



}

