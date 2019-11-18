<?php
namespace ROBOAMP;


use Illuminate\Support\Facades\File;


class Directory{


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

    //receives the root path to the directory
    //prefix are exploded using _ I.E. temp_timestamp_
    public function delete_directories_with_prefix($path_to_directories,$prefix){

        $mask = $path_to_directories."/".$prefix."*";
        array_map( array($this,'delete_directory'), glob( $mask ) );

    }
    //receives the path to a file and return it's parent folder

    public function get_parent_directory($file_path){
        $res=pathinfo($file_path);


        $path=explode("/",$res['dirname']);
        $str="/";
        for($j=1;$j<count($path)-1;$j++){
            $str.=$path[$j]."/";
        }
        return $str;
    }
    public function create_directories_for_new_property($url){

        $assets=['js','img','css','fonts','json'];

        $domain=URL::get_domain($url);

        $assets_path=base_path()."/public/properties/".$domain;
        $test_assets_path=base_path()."/public/properties/".$domain."/test";
        $view_path=Paths::path_to_directory('properties')."/".$domain;

        $this->create_directories($assets,$assets_path);
        $this->create_directories($assets,$test_assets_path);



        if(!$this->dir_is_empty($view_path)){
            echo "\nDirectory ".$view_path." is not empty.\n";
            echo "\tOperation CANCELED\n";
        }else{
            $this->create($view_path);
            $this->create($view_path."/includes");
            $this->create($view_path."/reports");
        }
    }


    public function delete_directory($path){
        File::deleteDirectory($path, false);
    }

    /*
     * gets the path for the directory from the short_path given
     * deletes all the directories and files except itself
     */

    public function delete(){
        $path=$this->get_path();
        File::deleteDirectory($path, true);
    }

    public function get_path_to_folder($folder_name,$type){
        if(!is_null($type)){
            $paths=new Paths();
            $path=$paths->path_to_folder($type)."/".$folder_name;
        }else{
            $path=$folder_name;
        }

        return $path;
    }

    /*public function get_path(){

        switch($this->short_path){
            case 'footer':

                $path=base_path('resources/views/templates/'.$this->template_name.'/render/footer');
                break;
            case 'render':
                $path=base_path('resources/views/templates/'.$this->template_name.'/render');

                break;
        }

        return $path;

    }*/

    public function get_current_directory($file_path){
        $res=pathinfo($file_path);
        return $res['dirname'];
    }

    //copy all the files from one directory to another
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



    public static function create_directories(array $directory_names, string $path){

        foreach ($directory_names as $directory){

            $new_path=$path."/".$directory;
            echo "............FOLDER =    ".$new_path."\n";
            if(!is_dir($new_path)) {
                $result = File::makeDirectory($new_path, 0775, true);
            }
        }

    }


    public function create_folder($folder_name,$type=null,$mode=0775,$delete_if_exist=false){

        /*
         * public static function create($directory_path,$cli=null){
        $result=false;
        if(!is_dir($directory_path)) {
            $res=File::makeDirectory($directory_path, 0775, true);
        }
        return $result;
    }
         */

        dd(php_sapi_name(),"Taytus");
        $path=$this->get_path_to_folder($folder_name,$type);


        if(is_dir($folder_name)){
            if($delete_if_exist){
                File::deleteDirectory($path);
                File::makeDirectory($path,$mode,true);
            }
        }else{
            File::makeDirectory($path,$mode,true);

        }

        if($cli) $cli->show_error("\nFolder ".$directory_path." has been created");

    }
    public function folder_exist($folder,$type=null,$debug=null){
        $paths=new Paths();

        $path=(!is_null($type)?$paths->path_to_folder($type)."/".$folder:$folder);

        if(!is_null($debug))echo ("\nPath:   ".$path."\n  Type:    ".$type."\n    Folder: ".$folder);

        return  $this->myFile->isDirectory($path);

    }


    /*
     * Recives a list of directory and a list of records, delete orphan directories
     */

    public static function delete_orphan_directories(string $path){

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
    public static function get_files_in_dirrectory($directory){
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
    public static function get_dirs_in_dir($directory){
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
    //returns an array with all the directories and files in them
    public function get_files_in_directories(string $directory,array $exclude_directories=[]){

        $dirs_in_dirs=$this->get_dirs_in_dir($directory);
        $valid_directory=true;

        if(count($dirs_in_dirs)>0) {
            $directory=$dirs_in_dirs;
        }else{
            $tmp=array();
            $tmp[0]=$directory;
            $directory=$tmp;
        }
        $arr=null;
        $j=0;

        $array_class=new MyArray();
        foreach ($directory as $item){
            if(count($exclude_directories)>0) {
                $valid_directory = !$array_class->check_for_string_in_array($item['filename'], $exclude_directories);
            }
            if($valid_directory){

                $path=(isset($item['full_path'])?$item['full_path']:$item);

                $arr[$j]=$this::get_files_in_dirrectory($path);

                $j++;
            }


        }

        return $arr;

    }
    public static function get_files_in_property($property_domain){
        $property_directory=Paths::path_to_property($property_domain);
        return self::get_files_in_directory($property_directory);
    }
    function get_all_files_in_directory_recursively($dir, &$results = array()){
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
    public static  function copy_directory($origin,$destination){
        $res=File::copyDirectory($origin,$destination);
    }

}