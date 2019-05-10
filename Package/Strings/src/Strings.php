<?php
namespace ROBOAMP;

use Illuminate\Filesystem\Filesystem;

class Strings {

    public function diff_between_two_strings($string1,$string2,$separator="\t",$debug=0){
        $first_array = explode($separator, $string1);
        $second_array = explode($separator, $string2);
        $result_array = array_merge(array_diff($first_array, $second_array), array_diff($second_array, $first_array));
        if($debug===89) {
            dd($string1,$string2);

        }

        return  implode($separator, $result_array);
    }

    public static function get_file_content($file_path){
        $file_content= new Filesystem();
        return $file_content->get($file_path);
    }

    //returns an object with the file content and a boolean flag
    public static function find_string_in_file($string,$file_path){
        $obj= new \stdClass();
        $obj->file_content=self::get_file_content($file_path);
        $obj->status=self::find_string_in_string($obj->file_content,$string);
        return $obj;
    }


    public function minify($input_file,$output_file=null){

        $options =" --remove-tag-whitespace --collapse-whitespace -o ".$output_file;
        $command="html-minifier ".$input_file." ".$options;
        $res=shell_exec($command);
    }


    // returns true if $needle is a substring of $haystack
    public static function find_string_in_string($haystack,$needle){
        $obj= new \stdClass();
        $obj->status=strpos($haystack, $needle) !== false;
        return $obj->status;
    }
    public function valid_email($email){
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
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
    public static function uppercase_separator($string,$separator){
        $words= str_replace($separator," ",$string);
        return ucwords($words);
    }
    //detects numbers on the strings and returns false if they are founded
    public static function string_without_numbers($string){

        if (preg_match('~[0-9]+~', $string)) return false;

        return true;
    }
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




} 