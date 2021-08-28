<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 3/8/18
 * Time: 5:20 PM
 */

namespace App\MyClasses;


class Form
{

    public function match_dropdown($name,$caption,$array,$id,$index=0){
        $str="<label for=\"".$name."\">".$caption."</label>";
        $str.="<select name=\"".$name."\" id=\"".$name."\">";

            if($index){
                $str.=$this->process_array_withuot_ids($array,$id);
            }else{
                $str.=$this->process_array_with_ids($array,$id);
            }


        $str.="</select>";

        return $str;
    }
    private  function process_array_withuot_ids($array,$id){
        $j=0;
        $str="";
        foreach ($array as $item){
            if($j==$id){
                $str.="<option value=\"".$j."\" selected>".$array[$j]."</option>";

            }else{
                $str.="<option value=\"".$j."\">".$array[$j]."</option>";
            }
            $j++;
        }
        return $str;
    }
    private  function process_array_with_ids($array,$id){
        $j=0;
        $str="";
        foreach ($array as $item){
            if($item->id==$id){
                $str.="<option value=\"".$item->id."\" selected>".$item->name."</option>";

            }else{
                $str.="<option value=\"".$item->id."\">".$item->name."</option>";
            }
            $j++;
        }
        return $str;
    }
}
