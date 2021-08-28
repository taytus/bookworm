<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 5/16/18
 * Time: 9:01 AM
 */

namespace App\MyClasses;


use ROBOAMP\Git as Robo_Array;

class Git extends Robo_Array
{
    public static function remove_prefix(array $array, string $prefix=""){

        $new_arr = array();
        foreach($array as $key => $value) {

            $newkey = explode($prefix, $key);

            if(count($newkey)>=2){
                $new_arr[$newkey[1]] = $value ;
            }else{
                $new_arr[$key] = $value ;
            }

        }
         return $new_arr;
    }

    public static function array_element_in_other_array($needle,$hay){
        //dd($needle,$hay);
        return (count(array_intersect($needle, $hay))) ? true : false;
    }

//one dimension arrays only
    public function remove_tabs_from_array($array){
        foreach ($array as $item){
            $item=trim(preg_replace('/\t+/', '', $item));

        }
        return $array;
    }
    public function check_for_string_in_array($string,$array,$boolean=false){
        $i=0;
        foreach ($array as $element) {

            if ($string=== $element)  {

                $this->cursor=$i;
                if($boolean)return $i;
                return true;
            }
            $i++;
        }

        return null;
    }

    private static function insert_items_from_array($model,$item){
        $class =  ucfirst($model);
        $model = new $class();
        foreach ($item as $obj => $val) {
            $model->$obj = $val;
        }
        $model->save();
    }



}

