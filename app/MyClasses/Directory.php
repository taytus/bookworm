<?php

namespace App\MyClasses;
use Illuminate\Support\Facades\File;
use App\Property;
use App\MyClasses\Files;



class Directory   {


    private $type;
    private $short_path;
    private $template_name;

    public function __construct(){
       /* $this->type=$type;
        $this->short_path=$short_path;
        $this->template_name=$template_name;

        call_user_func(array($this,$type));
       */


    }

    //receives the root path to the folder
    //prefix are exploded using _ I.E. temp_timestamp_
    public function delete_folders_with_prefix($path_to_folders,$prefix){

        $mask = $path_to_folders."/".$prefix."*";
        array_map( array($this,'delete_directory'), glob( $mask ) );

    }
    public function create_folders_for_new_property($url){

        $assets=['js','img','css','fonts','json'];

        if($url=='http://127.0.0.1:8080/word'){
            $domain='localwordpress.com';
        }else{
            $domain=URL::get_domain($url);
        }


        $assets_path=base_path()."/public/properties/".$domain;
        $test_assets_path=base_path()."/public/properties/".$domain."/test";
        $view_path=Paths::path_to_folder('properties')."/".$domain;

        $this->create_folders($assets,$assets_path);
        $this->create_folders($assets,$test_assets_path);



        if(!$this->dir_is_empty($view_path)){
            echo "\nDirectory ".$view_path." is not empty.\n";
            echo "\tOperation CANCELED\n";
        }else{
            $this->create($view_path);
            $this->create($view_path."/includes");
            $this->create($view_path."/reports");
            $this->create($view_path."/generated");

        }
    }

    public static function create($folder_path,$cli=null){
        $result=false;
        if(!is_dir($folder_path)) {
            if($cli) $cli->show_error("\nFolder ".$folder_path." has been created");
            $res=File::makeDirectory($folder_path, 0775, true);
            echo "RES ".$res."\n\n";
        }
        return $result;
    }
    public function delete_directory($path){
        File::deleteDirectory($path, false);
    }

    /*
     * gets the path for the directory from the short_path given
     * deletes all the folders and files except itself
     */

    public function delete(){
        $path=$this->get_path();
        File::deleteDirectory($path, true);
    }

    public function get_path(){

        switch($this->short_path){
            case 'footer':

                $path=base_path('resources/views/templates/'.$this->template_name.'/render/footer');
            break;
            case 'render':
                $path=base_path('resources/views/templates/'.$this->template_name.'/render');

                break;
        }

        return $path;

    }

    //copy all the files from one folder to another
    public function copy_files_recursively($source,$dest){
        if(!is_dir($dest)) {
            mkdir($dest, 0755);
        }
        foreach (
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                $dir=$dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
               if(!is_dir($dir))
                mkdir($dir);
            } else {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
    }



    public static function create_folders(array $directory_names, string $path){

        foreach ($directory_names as $directory){

            $new_path=$path."/".$directory;
            echo "............FOLDER =    ".$new_path."\n";
            if(!is_dir($new_path)) {
                $result = File::makeDirectory($new_path, 0775, true);
            }
        }

    }

    /*
     * Recives a list of folder and a list of records, delete orphan folders
     */

    public static function delete_orphan_folders(string $path){

        $properties=Property::where('name','!=','')->pluck('id')->all();

        $directory_names = File::directories(base_path($path));
        $total_directories=0;
        foreach ($directory_names as $directory){
            $basename=basename($directory);
            if(!in_array($basename,$properties)){

                File::deleteDirectory($directory);
                $total_directories++;
            }
        }

        CliFormat::my_message("A total of ".$total_directories." directories has been deleted in ".$path);


    }
    public static function get_files_in_dir($directory){
        if(!is_dir($directory)) dd('Error from '.__METHOD__,'Directory '.$directory.' doesn\'t exist');
        $manuals = [];
        $filesInFolder = \File::files($directory);

        $j=0;
        foreach($filesInFolder as $path) {
            $manuals[] = pathinfo($path);
            $manuals[$j]['full_path']=$manuals[$j]['dirname']."/".$manuals[$j]['basename'];
            $manuals[$j]['filename']=str_replace('.blade',"",$manuals[$j]['filename']);

            $j++;
        }
        return $manuals;
    }
    public function get_dirs_in_dir($directory){
        if(!is_dir($directory)) return $directory .' is not a valid Directory';
        $manuals = [];

        $filesInFolder = \File::directories($directory);
        $j=0;
        foreach($filesInFolder as $path) {
            $manuals[] = pathinfo($path);
            $manuals[$j]['full_path']=$manuals[$j]['dirname']."/".$manuals[$j]['basename'];
            $j++;
        }
        return $manuals;
    }

    //this is used to delete all the duplicated files except the file provider
    //sadasda_file.txt, asdasasd_file.txt, will be deleted and file.txt will remain
    public function delete_duplicated_files($filename,$directory,$str_separator="_"){

        $files=new Files();
        $all_files=[];
        $filesInFolder=\File::files($this->path_to_app_directory($directory));

        foreach($filesInFolder as $path) {
            $path_to_file=$path->getRealPath();
            if (strpos($path_to_file, $str_separator.$filename) !== false) {
                //delete the file
                $files->delete_file($path_to_file);
                echo $path_to_file."\n\n";
            }
        }
    }
    //transforms
    ///Users/taytus/Projects/roboamp/app/MyClasses/AMP/Includes/Demo"
    //into app/MyClasses/AMP/Includes/Demo"
    public function path_to_app_directory($full_path_to_resource){

        $resource=pathinfo($full_path_to_resource);
        if(isset($resource['extension'])){
            dd('file',$resource);
        }else{
            $arr_path=explode("app/",$full_path_to_resource);
            if(count($arr_path)>1) {
                $path = "app/" . $arr_path[1];
            }else{
                $path=null;
            }
        }

        return $path;
    }
    public function dir_is_empty($dir){
        if (is_dir($dir)) {
            $handle = opendir($dir);
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    closedir($handle);
                    return FALSE;
                }
            }
            closedir($handle);
            return TRUE;
        }else{
            return TRUE;
        }
    }
    //returns an array with all the folders and files in them
    public function get_files_in_directories($directory,Array $exclude_folders){
        $folder=$this->get_dirs_in_dir($directory);
        $arr=null;
        $j=0;

        $array_class=new MyArray();
        foreach ($folder as $item){
            $valid_folder=!$array_class->check_for_string_in_array($item['filename'],$exclude_folders);
            if($valid_folder){
                $arr[$j]=$this::get_files_in_dir($item['full_path']);
                $j++;
            }


        }
        return $arr;

    }
    public static function get_files_in_property($property_domain){
        $property_folder=Paths::path_to_property($property_domain);
        return self::get_files_in_dir($property_folder);
    }
    function get_all_files_in_folder_recursively($dir, &$results = array()){
        $files = scandir($dir);

        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }
}