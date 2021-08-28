<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 5/9/19
 * Time: 8:28 PM
 */

namespace App\MyClasses;
use App\Property;
use App\MyClasses\Paths;
use App\MyClasses\Templates;
use App\MyClasses\Batman;
use App\MyClasses\Files;


class Analytics{

    private $top_async_script="<script async src=\"https://cdn.ampproject.org/v0.js\"></script>";
    private $script_line="<script async custom-element=\"amp-analytics\" src=\"https://cdn.ampproject.org/v0/amp-analytics-0.1.js\"></script>";
    private $include_tag="@include('includes::google_analytics')";

    private $property_folder;
    private $property_domain;
    private $analytics_include_file_path;
    private $async_scripts_blade_path;



    public function run($property_domain){
        $this->setup($property_domain);
        $files = Directory::get_files_in_property($this->property_domain);

        $analytics=$this->copy_template();


        if($analytics) {

            foreach ($files as $item) {
                $file_path = $item['full_path'];
                $this->insert_async_script_tag($file_path);
                $this->insert_include_analytics_tag($file_path);
            }
        }else{
            $this->remove_analytics($files[0]['full_path']);
        }

    }
    private function remove_analytics($files){
        //remove script on html if found
        $res=$this->delete_line($this->script_line,$files);
        if(!$res){
            $this->delete_line($this->script_line,$this->async_scripts_blade_path);
        }
        $files_class=new Files();
        $files_class->delete_file($this->analytics_include_file_path);

        $this->delete_line($this->include_tag,$files);
        //remove reference to the google_analytics include and delete the file
    }


    private function delete_line($line,$file_path){

        $res=Batman::find_string_in_file($line,$file_path);
        if($res->status) {
            if($res->status=="error") {
            }
            $content = str_replace($line, "", $res->file_content);
            $this->update_file($content, $file_path);
            return true;
        }
        return false;
    }
    public  function copy_template(){
        $data['google_id']=$this->get_analytics_from_domain($this->property_domain);
        //only copy the template if there is a google analytics
        if($data['google_id']!="") {

            $template = new Templates();
            $template_destination = $this->analytics_include_file_path;
            $template_source = Paths::path_to_template('google_analytics', 'includes');
            $template->move_template($template_source, $template_destination, $data);
            echo "Analytics Template has been moved to: \t" . $template_destination . "\n";

        }
        return ($data['google_id']!=""?true:false);
    }
    public function insert_include_analytics_tag($file_path){
        $res=Batman::find_string_in_file($this->include_tag,$file_path);

        if(!$res->status){
            $content=Batman::insert_string_in_file_after_string($this->include_tag,'<body>',$file_path);
            $this->update_file($content,$file_path);

        }
    }
    public function get_analytics_from_domain($domain){
        return Property::where('url',$domain)->pluck('google_analytics')->first();

    }
    public function insert_async_script_tag($file_path){
        $res=Batman::find_string_in_file($this->script_line,$file_path);
        if(!$res->status){
            //if the line doesn't exist,
            // I have to search for a an include with all the async scripts
            $async_include_tag_exist=$this->search_for_async_scripts_include($res->file_content);

            if(!$async_include_tag_exist){
                $content=Batman::insert_string_in_file_after_string($this->script_line,'</title>',$file_path);
                $this->update_file($content,$file_path);

            }else{
                $this->property_folder=Paths::get_property_folder_from_file_path($file_path);

                $this->update_async_scripts_file();
            }

        }
    }
    private function search_for_async_scripts_include($file_content){
        $async_scripts_include_line="@include('includes::async_scripts')";
        $find_str=Batman::find_string_in_string($file_content,$async_scripts_include_line);
        return $find_str;
    }
    private function update_async_scripts_file(){
        $res=Batman::find_string_in_file($this->script_line,$this->async_scripts_blade_path);
        if($res->status=="error"){
            if($res->error=="File Not Found"){
                $this->create_basic_script_include_file();
                return true;
            }

        }
        if(!$res->status){
            $file_content=$res->file_content;
            $content=Batman::insert_string_in_file_after_string($this->script_line,$this->top_async_script,$this->async_scripts_blade_path);
            $this->update_file($content,$this->async_scripts_blade_path);
        }
    }
    private function create_basic_script_include_file(){
        $template = new Templates();
        $template_destination = $this->property_folder."/includes/async_scripts.blade.php";
        $template_source = Paths::path_to_template('async_scripts', 'includes');
        $template->move_template($template_source, $template_destination);
        $this->update_async_scripts_file();
        echo "Analytics Template has been created\n";

    }
    private function update_file($content,$file_path){
        $file=new Files();
        $file->re_write_file($content,$file_path);
    }
    private function setup($property_domain){
        $this->property_domain=$property_domain;
        $this->property_folder = Paths::path_to_property($this->property_domain);
        $this->analytics_include_file_path = $this->property_folder . "/includes/google_analytics.blade.php";
        $this->async_scripts_blade_path=$this->property_folder."/includes/async_scripts.blade.php";

    }

}