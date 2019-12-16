<?php
namespace ROBOAMP;

use ROBOAMP\Seeder;

class MyArray{

    private $marray;
    private $deleted_indexes=array();
    private $arr_tmp=array();

    public function __construct($array = null){

        $this->setArray($array);
    }

    public function move_to_top_by_index($array, $index) {
        array_unshift($array,$array[$index]);
        unset($array[$index+1]);

        return $array;
    }

    //this works with one and two levels array
    public static function add_prefix_to_array_elements($array,$prefix){
        $new_array=[];
        if(is_array($array[0])){
            foreach ($array as $item){
                $tmp_array=[];
                foreach ($item as $obj){
                    $tmp_array[]=$prefix.$obj;
                }
                $new_array[]=$tmp_array;
            }
        }else{
            foreach ($array as $item){
                $new_array[]=$prefix.$item;
            }

        }
        return $new_array;
    }


    //simplified way to write foreachs
    public static function fill_array_with_array($array,$destination){
        foreach ($array as $item){
            $destination[]=$item;
        }
        return $destination;
    }
    //takes a two dimension array and makes it one dimension
    //@doc https://robowiki.kanuca.com/books/myarray/page/array_flatten
    public static function array_flatten($data){
        foreach ($data as $i => $items) {
            if(is_array($items)) {
                foreach ($items as $key => $value) {
                    if(is_numeric($key)){
                        $data[] = $value;
                    }else{
                        $data[$key]=$value;
                    }
                }
                $data[$i]=null;
            }
        }

        return array_filter($data);

    }
    public function flatten_array_with_one_key($array){
        $key=array_keys($array);
        foreach ($array as $item){
            $this->arr_tmp[]=$key[0];
        }
        return $this->arr_tmp;
    }
    public static function fully_array_flatten($array) {
        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){
                $return = array_merge($return, self::array_flatten($value));
            } else {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    //accept an array and a value, then assigns 1 or 0 the default key when that value is matched
    public function setup_default_option($array,$value){
        foreach ($array as $item){
            if($item->stripe_id==$value){
                $item->default=1;
            }else{
                $item->default=0;
            }
        }
        return $array;
    }



    //setters and getters
    public function getArray(){return $this->marray;}

    public function setArray($array){$this->array = $array;}

    public function array_insert_assoc($array,$values,$offset) {
        return array_slice($array, 0, $offset, true) + $values + array_slice($array, $offset, NULL, true);
    }
    public function array_swap_assoc($key1, $key2, $array) {
        $newArray = array ();
        foreach ($array as $key => $value) {
            if ($key == $key1) {
                $newArray[$key2] = $array[$key2];
            } elseif ($key == $key2) {
                $newArray[$key1] = $array[$key1];
            } else {
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }
    public function array_swap (&$array,$element1,$element2){
        $local_array=$array;
        $temp=$array[$element1];
        $array[$element1]=$array[$element2];
        $array[$element2]=$temp;
        return $array;
    }

    //this is used for two level arrays. $arr['a'=>'A'] will be added if key 'a' is not found
    //
    public function insert_by_key_if_key_doesnt_exist(Array $array,$key,$array_to_compare_against,$debug=0){
        //extract the key and checks if exist
        $res=array_key_exists($key,$array_to_compare_against);

        if(!$res){$array_to_compare_against[$array[$key]]=$array;}

        if($debug){echo "\n Nothing has been changed\n";}

        return $array_to_compare_against;
    }
    public function insert_string_in_array_if_doesnt_exist($string,$array){

        if(!$this->check_for_string_in_array($string,$array)){
            $array[]=$string;
        }
        return $array;


    }
    //if $index is false, returns true/false
    //otherwise returns the position on the array
    //$arr=["house"=>"banana","human"=>["blue","green"]];
    //"banana" and "green" will return 0 and 1;
    public function check_for_string_in_array($string,$array,$index=false){
        $i=0;
        foreach ($array as $element) {
            if(is_array($element)){
                //if the element is an array, transverse the array.
                foreach ($element as $item){
                    if($item===$string){
                        $this->cursor = $i;
                        if ($index) return $i;
                        return true;
                    }
                }
            }else {
                if ($element === $string) {
                    $this->cursor = $i;
                    if ($index) return $i;
                    return true;
                }
            }
            $i++;
        }

        return null;
    }

    //search for $key = $string for an array inside an array

    public function search_for_value_in_key($string,$key,$array,$two_level_array=1){
        $j=0;
        $found=null;
        // dd($string,$key);
        if($two_level_array){
            foreach ($array as $item =>$content){
                if(array_key_exists($key,$content)) {
                    if ($content[$key] == $string) {
                        $found = $j;
                    }
                }
                $j++;
            }
        }
        return $found;

    }

    public static function get_keys_from_array($array,$array_format=true){

        $keys=[];
        if (is_null($array)) return ['error' => 1, 'error_message' => 'Array cannot be null'];
        //check if the array is a two levels array
        if (isset($array[0])) {
            if (is_array($array[0])) {
                $keys = array_keys($array[0]);

            }
        }else{
            $keys = array_keys($array);

        }

        return $keys;


    }
    public static function get_key_names_from_array($array){
        $keys=self::get_keys_from_array($array);
        $new_array=[];
        foreach($keys as $item){
            $new_array[]=ucwords(str_replace(["_","-"], " ", $item));
        }
        return $new_array;
    }

    public static function ignore_timestamps($data){
        $tmp_data=array();

        foreach($data as $ellement){
            $tmp_data[]=array_slice($ellement,0,-2);
        };

        return  $tmp_data;
    }

    public static function replace_null_with_not_available($data){
        return self::replace_null_with_X($data,'Not Available');
    }
    public static function replace_null_with_X($data,$replacement){
        $content=[];
        foreach($data as $item){
            if(is_array($item)){
                if (!array_key_exists(0,$item)) {
                    foreach(array_keys($item) as $keys){
                        if($item[$keys]==null)$item[$keys]=$replacement;
                    }
                    $content[]=$item;
                }
            }else{
                return $data;
            }
        }
        return $content;
    }
    //works for single level arrays.
    //replaces 1 and 0 with emojis or CLI success/error messages
    //custom messages are not being implemented yet
    public function replace_booleans_with_x($array,$emojis=false,$custom=null){
        $myEmoji= new \App\MyClasses\Emojis();
        $cliformat= new \App\MyClasses\Cli\CliFormat();
        $tmp_array=[];
        $passes= $myEmoji->get_emoji_by_shortcut(':white_check_mark:','php');
        $fails=$myEmoji->get_emoji_by_shortcut(':no_entry_sign:','php');
        foreach($array as $item=>$key){

            if($key===false){
                if($emojis){
                    $key=$fails;
                }else{
                    $key=$cliformat->format_error_message();
                }
            }elseif ($key===true){
                //if key is true
                if($emojis){
                    $key=$passes;
                }else{
                    $key=$cliformat->format_success_message();
                }
            }
            $tmp_array[$item]=$key;
        }

        return $tmp_array;
    }

    function arrayOrderBy(array &$arr, $field,$order = 'asc') {
        if (is_null($order))return $arr;

        usort($arr, function($a, $b) use($arr,$field,$order) {
            $result = array();
            foreach ($arr as $value) {
                //list($field, $sort) = array_map('trim', explode(' ', trim($value)));
                //dd($field,$sort,__METHOD__);
                if (!(isset($a[$field]) && isset($b[$field]))) {
                    continue;
                }
                if (strcasecmp($field, 'desc') === 0) {
                    $tmp = $a;
                    $a = $b;
                    $b = $tmp;
                }
                if (is_numeric($a[$field]) && is_numeric($b[$field]) ) {
                    $result[] = $a[$field] - $b[$field];
                } else {
                    $result[] = strcmp($a[$field], $b[$field]);
                }
            }
            return implode('', $result);
        });
        return $arr;
    }

    public static function array_exclude_keys($array, Array $exclude_keys,$reset = null){

        // array_diff_key() expected an associative array.
        $assocKeys = array();
        foreach($exclude_keys as $key) {
            $assocKeys[$key] = true;
        }

        return array_diff_key($array, $assocKeys);

    }

    //take a string and returns it as an array


    public function get_values_from_array($array){
        foreach ($array as $item){
            $arr[]= $item;
        }
        return $arr;
    }

    public static function rename_key($old_key_name,$new_key_name,$array){
        foreach($array as &$val){
            $val[$old_key_name] = $val[$new_key_name];
            unset($val[$old_key_name]);
        }
        return $array;
    }
    public static function rename_key_from_db($old_key_name,$new_key_name,$array){
        foreach($array as &$val){
            $val->$new_key_name=$val->$old_key_name;
            unset($val->$old_key_name);
        }
        return $array;
    }

    //takes a model and an array and create new records for every array entry
    //@doc https://robowiki.kanuca.com/books/myarray/page/create_items_from_array
    //if the arrays is one level only, it assumes the value passes is the "name" field
    public static function create_items_from_array($model,$array,$default_field='name'){
        $class =  ucfirst($model);
        foreach ($array as $item){
            $model= new $class();
            if(is_array($item)) {
                foreach ($item as $obj => $val) {
                    $model->$obj = $val;
                }
            }else{
                $model->$default_field = $item;
            }
            $model->save();
        };
    }



}