<?php


namespace App\MyClasses\Cli;

use App\MyClasses\Cli\CliStyle;
use App\MyClasses\Directory;
use App\MyClasses\Files;
use App\Property;
use Illuminate\Support\Facades\DB;
use App\MyClasses\Git;

class DevImport {


    protected $option;
    protected $active_class;
    protected $output;
    protected $format;
    private $folders;
    private $directory;
    private $assets=['js','img','css','fonts','json'];
    /** @var  \App\MyClasses\Cli\Cli */
    protected $cli;
    private $property_url;
    private $property_id;
    private $property_path;
    private $pages=[];
    private $log=true;
    /** @var  \App\MyClasses\Files */
    private $filesClass;


    public function __construct($cli=null){
        $this->cli=$cli;
        $this->directory= new Directory();

    }
    public function main($cli=null){
        $this->cli=$cli;
        $this->filesClass=new Files();

        $dev_directory=base_path()."/dev";
        $properties= $this->directory->get_dirs_in_dir($dev_directory);

        $options=$this->get_menu_options($properties);

        $this->property_url=$this->cli->choice_question("Select a property to Import",$options,null);
        $this->property_id=Property::where('url',$this->property_url)->pluck('id')->first();
        //get the main folder and the /assets folder
        $this->property_path=$this->get_property_path();
        $this->move_assets();
        //move the php.blade files to the right /test folder
        $this->move_pages();

        //have to figure it out how to add the page at the end.

        $link=config('app.url')."/dev/".$this->property_id."/".$this->property_url;
        echo "\n".$link."\n";







    }
    private function move_pages(){
        //first replace all the strings with the right paths

        //this is working for coravana only for now;




        //moving everything for now. I should check for pages added to the DB
        //and move those and alert of the missmatch
        $files=$this->directory->get_files_in_dir($this->property_path);
        foreach($files as $item){
            if($item['extension']=='html'){
                $origin=$this->filesClass->change_extension($item['dirname']."/".$item['basename']);
            }else{
                $origin=$item['dirname']."/".$item['basename'];

            }
            $origin_str=['src="images/',['url(images/']];
            $str_path=config('app.url')."/properties/".$this->property_url."/img/";
            $place1='src="'.$str_path;
            $place2='url('.$str_path;
            $final_str=[$place1,$place2];
            $base_destination=base_path('test/properties')."/".$this->property_url;
            $destination=$base_destination."/".$item['basename'];
            $this->directory->create($base_destination,$this->cli);
            $this->filesClass->copy_file($origin,$destination,null,null,0);
            $this->filesClass->replace_all_placeholders($origin_str,$final_str,$destination);

        }
    }
    private function move_assets(){
        $assets_folders=$this->get_assets_folders();
        if(!$assets_folders) return $assets_folders;
        $this->copy_files_to_test_folder($assets_folders);
        //now that I have moved all the assets inside the folders, I move everything outside those folders
        //I assume those are images files
        $this->move_image_files($this->property_path."/assets");
    }
    private function move_image_files($assets_path){
        $files=$this->directory->get_files_in_dir($assets_path);
        $base_destination=base_path('public/properties')."/".$this->property_url."/test/img/";
        $this->directory->create($base_destination,$this->cli);

        foreach($files as $file){
            $origin=$file['dirname']."/".$file['basename'];
            $destination=$base_destination.$file['basename'];
            $this->filesClass->copy_file($origin,$destination,null,null,0);
            if($this->log)echo "\nImage copied to ".$destination;
        }
    }
    private function copy_files_to_test_folder($assets_folders){
        $arr=new Git();


        foreach ($assets_folders as $item) {
            if($arr->check_for_string_in_array($item,$this->assets)){
                $source=$this->property_path."/assets/".$item;
                $dest=base_path()."/public/properties/".$this->property_url."/".$item;
                $this->directory->copy_files_recursively($source,$dest);
                //found the matching folder;
                if($this->log)echo "\n matching folder found: ". $item;
                //check if the destination folder exist. Create it if not
                //search for a list of folder and then check for each files inside the folder

                $this->get_files_inside_folder($item);
            }else{
                echo $this->cli->show_error("\"". $item ."\" doesn't match any assets folder name");
            }
        }
    }
    private function get_files_inside_folder($folder,$subdir=0){

        $files_path=(!$subdir?$this->property_path."/assets/".$folder:$folder);
        //copy over all the items inside the folder. into the
        //public/properties/{property_domain}/test
        $files=$this->directory->get_files_in_dir($files_path);
        foreach($files as $file){
            $origin=$file['dirname']."/".$file['basename'];
            $base_destination=base_path('public/properties')."/".$this->property_url."/test/".$folder;
            $this->directory->create($base_destination,$this->cli);
            $destination=$base_destination."/".$file['basename'];
            $this->filesClass->copy_file ($origin,$destination,null,null,0);
            if($this->log)echo "\nfile copied to ".$destination;

        }
    }
    private function get_assets_folders(){
        $tmp_assets_folders=$this->directory->get_dirs_in_dir($this->property_path."/assets/");
        if(!is_array($tmp_assets_folders)){ $this->cli->show_error($tmp_assets_folders); return false;}

        $assets_folders=[];
        foreach($tmp_assets_folders as $item){
            $assets_folders[]=$item['basename'];
        }
        return $assets_folders;
    }
    private function get_property_path(){

        //search on array folder to get the property path
        foreach($this->folders as $item){
            if($item['basename']==$this->property_url){
                return $item['dirname']."/".$this->property_url;
            }
        }
    }
    private function get_menu_options($properties){
        if(!empty ($properties)){
            $j=0;
            $folder=[];
            foreach($properties as $item){
                $this->folders[]=$item;
                $options[]=$item['basename'];
            }
        }else{
            $this->cli->show_error("Folder is empty");
        }
        return $options;
    }







}