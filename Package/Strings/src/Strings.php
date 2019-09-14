<?php
namespace ROBOAMP;

use Illuminate\Filesystem\Filesystem;

class Strings {


    public static function hex2dec($hex,$format=null){
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        if (is_null($format)){
            return "(".$r.",".$g.",".$b.")";
        }
    }
    public static function delete_tabs($string){
        if(is_string($string)) {
            return trim(preg_replace('/\t+/', '', $string));
        }
        return $string;
    }

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
        if(file_exists($file_path)) {
            $obj->file_content = self::get_file_content($file_path);
            $obj->status = self::find_string_in_string($obj->file_content, $string);
        }else{
            $obj->status="error";
            $obj->error="File Not Found";
            $obj->error_message="File not found on path: ".$file_path;
        }
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




} 