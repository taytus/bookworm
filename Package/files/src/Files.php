<?php
namespace ROBOAMP;


use Illuminate\Filesystem\Filesystem as File;

use Carbon\Carbon;


class Files{



    public $full_path_to_file="";
    private $file_name="";
    private $file_type="Controller";
    private $array_of_lines=[];
    private $method;
    private $cursor=0;


    public function __construct ($file_name=null,$file_type='Controller'){

        $this->file_type=$file_type;
        if(!is_null($file_name)){
            $this->file_name=$file_name;
            $this->full_path_to_file=Paths::full_path_to_file($this->file_name,$this->file_type);

        }
        $this->file_type=$file_type;

    }

    public function save_file($path,$content){
        $fs=new File();
        return $fs->put($path,$content);
    }

    public function delete_all_backups($file_path){
        $dirname=$this->get_folder_from_file_path($file_path);
        $prefix=$this->get_prefix_for_backup_files($file_path);

        foreach (glob($dirname."/".$prefix."__*.php") as $filename) {
            $this->delete_file($filename);
        }
    }

    public function get_prefix_for_backup_files($file_path){
        $filename=$this->get_file_name_from_path($file_path);
        $filename_array=explode("__",$filename);

        if(count($filename_array)==1){
            $filename_array=explode(".php",$filename);
        }

        return $filename_array[0];
    }

    public function backup_file_with_timestamp($file_path){
        $dirname=$this->get_folder_from_file_path($file_path);
        return $this->copy_file_and_add_timestamp_to_its_name($file_path,$dirname);
    }

    public function get_folder_from_file_path($file_path){
        $file_info=pathinfo($file_path);
        return $file_info['dirname'];
    }


    public function delete_file($file_path,$show_message=false){
        $myFile= new File();
        if($myFile->exists($file_path)){

            $res=$myFile->delete($file_path);
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
        $myStrings=new Git();

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
        //demo
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
        $myArray=new Git();

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






    private  function get_method_name_from_line($method_declaration){
        $tmp=explode(" ",$method_declaration);
        $function_name=explode("()",$tmp[2]);
        return $function_name[0];
    }

    public function get_method(){
        return $this->method['code'];
    }

    //copy origin/filename.extension to demo/prefix_filename__timestamp.extension
    //$prefix is optional


    public function copy_file_and_add_timestamp_to_its_name(string $origin_path,string $destination_path,$prefix=null,$cleanup=0){
        $prefix=(is_null($prefix)?"":$prefix."_");
        $timestamp=str_replace(".","",microtime(true));
        $file_info=pathinfo($origin_path);
        $file_name=$file_info['filename'];
        $file_extension=".".$file_info['extension'];


        $file_name_destination=$prefix.$file_name."__".$timestamp.$file_extension;
        $destination_path.="/".$file_name_destination;

        $this->copy_file($origin_path,$destination_path,null,null,$cleanup);

        return $destination_path;
    }

    public function get_file_name_from_path($file_path,$include_extension=1){
        $res=pathinfo($file_path);
        $extension=($include_extension?".".$res['extension']:"");
        return $res['filename'].$extension;
    }


    public function copy_file($origin_path,$destination_path,$placeholder=null,$replacement=null,$cleanup=0){
        $path_parts=pathinfo($origin_path);
        //DEBUG THIS
        if($cleanup){
            $folders=new Directory();
            $folders->delete_duplicated_files($path_parts['basename'],dirname($origin_path));
        }

        $myFile=new File();
        //just copy the file without doing any modifications to it
        if(is_null($placeholder)){
            $myFile=new File();
            $myFile->copy($origin_path,$destination_path);
        }else{
            $tmp_file_name=$this->get_time_based_name($path_parts['basename']);
            $tmp_path_to_template=$path_parts['dirname']."/".$tmp_file_name;


            $myFile->copy($origin_path,$tmp_path_to_template);
            //Now I have a copy of a temporary file I can edit. And then, copy that edited file
            $content=$this->replace_placeholder($placeholder,$replacement,$tmp_path_to_template);
            //now move it to their final location
            $myFile->move($tmp_path_to_template,$destination_path);
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
        if(is_array($str))$str=Git::fully_array_flatten($str);

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
        $myFile=new File();
        if(!$this->file_exist($path_to_template,$ignore_missed_files)) return false;

        $file_content=$myFile->get($path_to_template);
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
        $myFile=new File();
        if(!$myFile->exists($path_to_file)) {

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
        $myFile=new File();
        return $myFile->get($path_to_template);

    }

    //grabs the current time and returns a string to be used as filename
    public function format_time_to_file_name($char_replacement="_"){
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
