<?php

namespace App\MyClasses;
use App\MyClasses\Directory;
use App\Partials\PartialTemplate;
use App\Template;
use App\Property;
use App\Page;


class Cleanup   {




    public function __construct($type){



    }
    public static function delete_temp_dirs_in_properties(){
        $myDir=new Directory();
        $path_to_properties=Paths::path_to_folder('properties');
        $myDir->delete_folders_with_prefix($path_to_properties,"temp_");
    }
    public static function clean($directory){

        $templates=PartialTemplate::all();

        foreach ($templates as $template) {
            $update_folders=new Directory('delete',$directory, $template->path);
            echo $template->path."\n";
        }

    }
    public static function reset_render(){
        $templates=Template::all();

        foreach ($templates as $template) {
            $update_folders=new Directory('delete','render', $template->path);
        }
    }

    //these are properties created during the validation process
    public static function delete_temp_properties(){
        $directory= new Directory();
        $res=Property::where('url','like','%temp_%')->pluck('id')->toArray();
        foreach ($res as $item){
            Page::where('property_id',$item)->delete();
            Property::where('id',$item)->delete();
            $directory_path=Paths::path_to_folder('properties')."/temp_".$item.".com";
            $directory->delete_directory($directory_path);
        }
        self::delete_temp_dirs_in_properties();
    }



}