<?php
namespace ROBOAMP;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Strings extends Str{


    public function get_x_last_chars($strings,$limit=null){

        if(!$limit || $limit==1) return substr($strings, -1);

        return substr($strings, $limit);

    }

    public function get_uuid(){
        return (string) self::uuid();
    }

    public function has_special_chars($string, $allow_spaces=true){

        $pattern=($allow_spaces)? '/[^a-zA-Z0-9 ]/':'/[^a-zA-Z0-9]/';

        $clean_string= preg_replace($pattern, '', $string);
        if($string!=$clean_string) return true;

        return false;
    }

    public static function delete_tabs($string){
        if(is_string($string)) {
            return trim(preg_replace('/\t+/', '', $string));
        }
        return $string;
    }

    //returns an object with the file content and a boolean flag
    public static function find_string_in_file($string,$file_path,$case_sensitive=true){
        $obj= new \stdClass();
        if(file_exists($file_path)) {
            $obj->file_content = self::get_file_content($file_path);
            $obj->status = self::find_string_in_string($obj->file_content, $string,$case_sensitive);
        }else{
            $obj->status="error";
            $obj->error="File Not Found";
            $obj->error_message="File not found on path: ".$file_path;
        }
        return $obj;
    }

    public static function remove_non_aphanumeric_chars($string){
        return preg_replace("/[^A-Za-z0-9 ]/", '', $string);
    }

    //replace one of the spaces with the separator or
    //if no separator is passed, remove all the spaces
    public static function remove_multiple_spaces($string,$separator=""){
        return preg_replace('/\s\s+/', $separator, $string);
    }

    // "de*m()()o" will return "demo"
    // "d e       mo" will return "d_e_mo"

    public static function get_method_name($string){
        $string=strtolower(trim($string));
        $string=self::remove_non_aphanumeric_chars($string);
        $string=self::remove_multiple_spaces($string,"_");
        $string=str_replace(" ","_",$string);
        return $string;
    }

    //NON tested Methods


    public static function hex2dec($hex,$format=null){
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        if (is_null($format)){
            return "(".$r.",".$g.",".$b.")";
        }
    }

    public static function get_file_content($file_path){
        $file_content= new Filesystem();
        return $file_content->get($file_path);
    }






    public function minify($input_file,$output_file=null){

        $options =" --remove-tag-whitespace --collapse-whitespace -o ".$output_file;
        $command="html-minifier ".$input_file." ".$options;
        $res=shell_exec($command);
    }


    // returns true if $needle is a substring of $haystack
    public static function find_string_in_string($haystack,$needle,$case_sensitive=true){
        $obj= new \stdClass();

        if($case_sensitive){
            $obj->status=strpos($haystack, $needle) !== false;
        }else{
            $obj->status=stripos($haystack, $needle) !== false;
        }

        return $obj->status;
    }


    public function empty_string($string){
        if (!is_null($string)){
            if(!empty($string)){
                return false;
            }
        }
        return true;
    }

    //take a separator string, breaks the string and make every word uppercase
    //"alpha_charlie_bravo" will return "Alpha Charlie Bravo"
    public static function uppercase_separator($string,$separator){
        $words= str_replace($separator," ",$string);
        return ucwords($words);
    }
    //detects numbers on the strings and returns false if they are founded
    public static function string_without_numbers($string){

        if (preg_match('~[0-9]+~', $string)) return false;

        return true;
    }

    //str_to_method_name("This IS spartA") will return this_is_sparta
    public static function str_to_method_name($str){

    }

    // is_string_between("lol","l","l") ==> true
    // is_string_between("lol","l","a") ==> false
    public static function is_string_between_strings($string,$init_str,$end_str){
        $first=substr($string,0,1);
        $last=substr($string,-1);
        if($first===$init_str && $last===$end_str)return true;
    }

    //get_string_between("thisawesomeday","this","day") will return "awesome"
    public static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public static function roboamp_code_has_been_inserted($url,$property_id){

    }

    public static function insert_string_in_file_after_string($string,$target_string,$file_path){
        $target_string_exist= self::find_string_in_file($target_string,$file_path);

        if(!$target_string_exist->status)dd("Target string:",$target_string,"coudln't be found in file",$file_path);

        $new_string=$target_string." \n".$string;

        $res=str_replace($target_string,$new_string,$target_string_exist->file_content);

        return $res;
    }
    //receives how many words and what's the string to pull the words from
    public static function get_X_first_words_from_string($string,$number_of_words,$second_half=0){
        $pieces = explode(" ", $string);
        $first_part = implode(" ", array_splice($pieces, 0, $number_of_words));
        $second_half = ($second_half?$other_part = implode(" ", array_splice($pieces, 0)):null);
        return (is_null($second_half)?$first_part:[$first_part,$second_half]);

    }


    //depending on how long a string is, returns how many tabs needs
    //to be added to the line. This is used for CLI applications
    public function get_total_tabs( $string, $max_tabs=20, $tabs_size=8){
        $tabs=strlen($string)/$tabs_size;
        $max_tabs=$max_tabs-$tabs;
        $str="";
        for ($i=0;$i<$max_tabs;$i++){
            $str.="\t";
        }
        return $str;
    }




} 