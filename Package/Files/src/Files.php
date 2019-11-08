<?php
namespace ROBOAMP;


use Illuminate\Filesystem\Filesystem as File;

use ROBOAMP\MyArray;
use ROBOAMP\Seeder;
use Carbon\Carbon;
use ROBOAMP\Directory;
use FilesystemIterator;

class Files{



    public $full_path_to_file="";
    private $file_name="";
    private $file_type="Controller";
    private $array_of_lines=[];
    private $method;
    private $cursor=0;
    private $myFile;

    public function __construct ($file_name=null,$file_type='Controller'){

        $this->file_type=$file_type;
        if(!is_null($file_name)){
            $this->file_name=$file_name;
            $this->full_path_to_file=Paths::full_path_to_file($this->file_name,$this->file_type);

        }
        $this->file_type=$file_type;
        $this->myFile=new File();

    }


    public function delete_file($file_path,$show_message=false){
        if($this->myFile->exists($file_path)){

            $res=$this->myFile->delete($file_path);
            $message="file ".$file_path." has been deleted\n\n".$res."\n\n";
        }else{
            $message= "file ". $file_path." doesn't exist\n\n";
        }

        if($show_message)echo $message;
    }
    public function change_file_extension($file,$extension=".blade.php"){
        $file_info=pathinfo($file);
        $new_extension=$file_info['dirname']."/".$file_info['filename'].$extension;
        //use core function rename;
        rename($file,$new_extension);
        return $new_extension;
    }

    public  function add_line_to_file(String $path_to_file, String $content){
        $content="\n".$content;
        $handle = fopen($path_to_file, 'a') or die('Cannot open file:  '.$path_to_file);
        fwrite($handle, $content);
        fclose($handle);
    }
    public  function add_line_to_method($method_target,$code_to_be_added,$debug=0){
        $myStrings=new Seeder();

        $ignore_debug=1;
        $first_line_of_method=$method_target['first_line_declaration'];
        $method_name=$method_target['name'];
        if($this->method_exist()){


            if($debug==1 && !$ignore_debug){
                $line="*****************************";
                dd($line,$code_to_be_added,$this->method,$this->array_of_lines,$this->method_exist(),$line);
            }
            //position the cursor on top of the //placeholder mark and write the code;
            $new_method=explode("//placeholder",$method_target['code']);

            $new_method=$new_method[0].$code_to_be_added."\n\t\t//placeholder".$new_method[1];

            $file_str=implode("",$this->array_of_lines);




            $content=str_replace($method_target['code'],$new_method,$file_str);

            $this->re_write_file($content);
            $this->method['code']=$new_method;





        }else{
            echo "Method \"".$method_name."\" does not exist\n\n";

        }


    }
    //opens a file, writes the content and close the file
    public function re_write_file($content,$path=null){

        $path_to_file=(is_null($path)?$this->full_path_to_file:$path);

        $handle=fopen($path_to_file,'w') or die('Cannot open file:  '.$path_to_file);
        fwrite($handle,$content);
        fclose($handle);
    }
    private  function extract_method(){

        dd($this->cursor,"HERE COMES THE MAGIC");
        //$search_result=self::check_for_string_in_array($first_line_of_method, $arrayOfLines,$debug


    }


    public function set_method($method_name,$force_creation=0){
        $this->method=$method_name;
    }
    public  function add_method_to_controller($method,$controller_name=null)
    {

        $this->file_name=(is_null($controller_name)?$this->file_name:$controller_name);
        $this->method=$method;
        //if the method doesn't exist, it adds it.
        if(!$this->method_exist()){

            $file_size = count($this->array_of_lines);

            $this->array_of_lines[$file_size - 2] = $this->method['code'];

            file_put_contents($this->full_path_to_file, $this->array_of_lines);

        }


    }

    private  function dump_file_into_array($file_name,$file_type='controller'){
        $path_to_file=Paths::full_path_to_file($file_name,$file_type);
        $arrayOfLines = file($path_to_file);
        return $arrayOfLines;

    }

    //$method is the whole method string, $controller_name is the file without extension
    private  function method_exist($debug=0){
        $myArray=new MyArray();

        //used to compare with the array containing all the file's lines

        try{
            $first_line_of_method = $this->method['first_line_declaration'];
        }catch(\Exception $e){
            dd($this->method);
        }
        $this->array_of_lines=$this->dump_file_into_array($this->file_name);


        if($debug){
            echo "\n()()()()()()()()()()FROM METHOD_EXIST INSIDE FILES()()()()\n";
            echo "\n".$first_line_of_method."\n";
            print_r($this->array_of_lines);
            echo "\n()()()()()()()()()())()()()()\n";
            if ($this->check_for_string_in_array($first_line_of_method, $this->array_of_lines)){
                echo "\n\n YES, The method Exist\n\n";
            }else{
                echo "\n\n THE METHOD DOES NOT EXIST\n\n";

            }
        }

        if ($myArray->check_for_string_in_array($first_line_of_method, $this->array_of_lines,$debug) === false) {

            return false;
        }else{

            return true;
        }


    }
    public function create_folder($folder_name,$type,$delete_if_exist=false){
        $paths=new Paths();

        $path=$paths->path_to_folder($type)."/".$folder_name;

        if($this->myFile->isDirectory($path)){
            if($delete_if_exist){
                $this->myFile->deleteDirectory($path);
                $this->myFile->makeDirectory($path,0777);
            }
        }else{
            $this->myFile->makeDirectory($path,0777);

        }


    }
    public function folder_exist($folder,$type=null,$debug=null){
        $paths=new Paths();

        $path=(!is_null($type)?$paths->path_to_folder($type)."/".$folder:$folder);

        if(!is_null($debug))echo ("\nPath:   ".$path."\n  Type:    ".$type."\n    Folder: ".$folder);

        return  $this->myFile->isDirectory($path);

    }





    private  function get_method_name_from_line($method_declaration){
        $tmp=explode(" ",$method_declaration);
        $function_name=explode("()",$tmp[2]);
        return $function_name[0];
    }

    public function get_method(){
        return $this->method['code'];
    }

    //double underscores is used to separate timestamps from file names
    //I.E. 2019_11_04_10_31_40__filename
    //the destination path only requires the folder's destination because
    // it will copy the file into that folder

    public function copy_file_with_timestamp(string $origin_path,string $destination_path,$placeholder=null,$str=null,$cleanup=1){
        $timestamp=$this->format_time_to_file_name();
        $file_info=pathinfo($origin_path);
        $file_name=$file_info['filename'];
        $file_extension=".".$file_info['extension'];


        $file_name_destination=$file_name."__".$timestamp.$file_extension;
        $destination_path.=$file_name_destination;
        //if $str is "auto" that means it needs to be replaced with timestamp
        if($str=="auto") $str=$placeholder."__".$timestamp;

        $this->copy_file($origin_path,$destination_path,$placeholder,$str,$cleanup);

    }

    public function get_file_name_from_path($file_path,$include_extension=1){
        $res=pathinfo($file_path);
        $extension=($include_extension?".".$res['extension']:"");
        return $res['filename'].$extension;
    }


    public function copy_file($origin_path,$destination_path,$placeholder=null,$str=null,$cleanup=1){
        $path_parts=pathinfo($origin_path);
        //DEBUG THIS
        if(!$cleanup){
            $folders=new Directory();
            $folders->delete_duplicated_files($path_parts['basename'],dirname($origin_path));
        }

        //just copy the file without doing any modifications to it
        if(is_null($placeholder)){
            $this->myFile->copy($origin_path,$destination_path);
        }else{
            $tmp_file_name=$this->get_time_based_name($path_parts['basename']);
            $tmp_path_to_template=$path_parts['dirname']."/".$tmp_file_name;


            $this->myFile->copy($origin_path,$tmp_path_to_template);
            //Now I have a copy of a temporary file I can edit. And then, copy that edited file
            $content=$this->replace_placeholder($placeholder,$str,$tmp_path_to_template);
            //now move it to their final location
            $this->myFile->move($tmp_path_to_template,$destination_path);
        }

    }
    //this only copies files, no folders
    public function copy_all_files($origin_path,$destination_path){
        $files_in_folder=(new Directory())->get_files_in_dir($origin_path);
        foreach ($files_in_folder as $item){
            $this->copy_file($item['full_path'],$destination_path."/".$item['basename']);
        }
    }
    //this is used for autogenerated files
    private function get_time_based_name($filename){
        //get the time to add to the filename
        $now=$this->format_time_to_file_name();
        return $now."___".$filename;

    }
    public function replace_placeholder($placeholder, $str, $tmp_path_to_template, $ignore_missed_files = 0)
    {
        if(is_array($str))$str=MyArray::fully_array_flatten($str);

        if ($this->file_exist($tmp_path_to_template, $ignore_missed_files)) {
            $my_file = new File();
            $file_content = $my_file->get($tmp_path_to_template);

            $content = str_replace($placeholder, $str, $file_content);

            $res=$my_file->put($tmp_path_to_template, $content);
        }else{
            dd("File doesnt exist",__METHOD__);
        }


    }
    public function replace_all_placeholders($array_placeholders,$array_substitutions,$path_to_template,$ignore_missed_files=1){

        if(!$this->file_exist($path_to_template,$ignore_missed_files)) return false;

        $file_content=$this->myFile->get($path_to_template);
        $content='';
        $j=0;
        foreach($array_placeholders as $placeholder){

            $this->replace_placeholder($placeholder,$array_substitutions[$j],$path_to_template);

            $j++;
        }
        $this->full_path_to_file=$path_to_template;
        //$this->re_write_file($content);
    }
    private function file_exist($path_to_file,$ignore_missed_files){
        if(!$this->myFile->exists($path_to_file)) {

            if($ignore_missed_files){
                echo "File doesn't exist, check path:\n";
                echo $path_to_file."\n";
                return false;
            }else{

                echo "File doesn't exist, check path:\n";
                echo $path_to_file."\n";
                dd("operation aborted");
            }
        }else{
            return true;
        }
    }
    public function get_file_content($path_to_template){
        return $this->myFile->get($path_to_template);

    }
    private function format_time_to_file_name($char_replacement="_"){
        $now=  Carbon::now('US/Central');

        $chars_array=[" ","-",":"];

        $time=str_replace($chars_array,$char_replacement,$now);

        return $time;
    }

    public function copy_template($type,$destination_path){
        switch($type){
            case 'new_page':
                $template_name='index.blade.php';
                $placeholder="/**
This file is added to the new pages created automatically when manually activating a property
**/";
                $str="";
                $folder_type='Customer';
                $destination_path.="/".$template_name;
                break;

        }
        $destination_path=Paths::path_to_folder($folder_type)."/".$destination_path;
        $origin_path=Paths::path_to_folder('Templates')."/".$template_name;
        $this->copy_file($origin_path,$destination_path,$placeholder,$str);


    }
    public function copy_folder($origen,$destination){
        $file=new File();
        $res=$file->copyDirectory($origen,$destination);
    }
    public function total_php_files_in_directory($directory){
        return $this->total_files_in_directory($directory,"php");
    }
    public function total_files_in_directory($directory,$extension){
        return count(glob(($directory."/*.".$extension)));

    }

    //receives a directory path and renames all the html files into blade
    public function HTML_to_Blade($directory,$verbose=0){
       $this->change_files_extension($directory,'html','blade.php',$verbose);
    }
    private function change_files_extension($directory,$original_ext,$new_ext,$verbose=0){
        $files= Directory::get_files_in_dir($directory);
        $j=0;
        foreach($files as $item) {
            if ($item['extension'] == $original_ext) {
                $j++;
                $extension = $new_ext;
                $name = $item['filename'];
                $file_name = $name . ".".$extension;
                $destination = $item['dirname'] . "/" . $file_name;
                $origin = $item['dirname'] . "/" . $item['basename'];
                $this->copy_file($origin, $destination);
                if ($verbose)echo "\nFile Copied to " . $destination . "\n";
                $this->delete_file($origin);
            }
        }
        if ($verbose)echo $j . " Files have been renamed\n";

    }


}