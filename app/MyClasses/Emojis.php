<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 7/27/18
 * Time: 9:40 PM
 */

namespace App\MyClasses;

use App\MyClasses\Git;

//https://www.iemoji.com/
class Emojis {
    private $myArray;
    private $arr_emojis=array(

    [
        'name'=>'robot face','php_src'=>'\xf0\x9f\xa4\x96',
        'HTML_decimal'=>'&#129302;','HTML_hexadecimal'=>'&#129302;'],
    [
        'name'=>'rolling on the floor laughing','php_src'=>'\xf0\x9f\xa4\xa3',
        'HTML_decimal'=>'&#129315;','HTML_hexadecimal'=>'&#x1f923;'],
    [
        'name'=>'Waving Hand: Medium-Light Skin Tone','php_src'=>'\xf0\x9f\x91\x8b\xf0\x9f\x8f\xbc',
        'HTML_decimal'=>'&#128075;','HTML_hexadecimal'=>'&#x1f44b;','shortcut'=>":wave-hand:"],
    [
        'name'=>'Waving Hand','php_src'=>'\xee\x90\x9e',
        'HTML_decimal'=>'&#128075;','HTML_hexadecimal'=>'&#x1f44b;','shortcut'=>""],
    [
        'name'=>'White Heavy Check Mark','php_src'=>'\xe2\x9c\x85',
        'HTML_decimal'=>'&#9989;','HTML_hexadecimal'=>'&#x2705;','shortcut'=>":white_check_mark:"],
    [
        'name'=>'Prohibited','php_src'=>'\xf0\x9f\x9a\xab',
        'HTML_decimal'=>'&#128683;','HTML_hexadecimal'=>'&#x1f6ab;','shortcut'=>":no_entry_sign:"],
    [
        'name'=>'Right Arrow','php_src'=>"\u{27A1}\u{FE0F}",
        'HTML_decimal'=>'&#57908;','HTML_hexadecimal'=>'&#xe234;','shortcut'=>":right_arrow:"]








//Waving Hand: Medium-Light Skin Tone


    );
    private $emoji="";


    public function __construct(){
    }
    public function get_emoji_by_name($name,$format=null){
        $myArray=new Git();
        $index=$myArray->search_for_value_in_key($name,'name',$this->arr_emojis);
        if(!is_null($index)){
            $this->emoji=$this->arr_emojis[$index];
            if(is_null($format)) {
                return $this->emoji;
            }else{
                return  stripcslashes(call_user_func(array($this,"get_".$format)));
            }
        }
    }


    public function get_emoji_by_shortcut($shortcut,$format=null){

        $myArray=new Git();
        $index=$myArray->search_for_value_in_key($shortcut,'shortcut',$this->arr_emojis);
        if(!is_null($index)){
            $this->emoji=$this->arr_emojis[$index];
            if(is_null($format)) {
                return $this->emoji;
            }else{
                return  stripcslashes(call_user_func(array($this,"get_".$format)));
            }
        }
    }





    public function get_emojis_list(){
        $tmp_arr=array();
        foreach($this->arr_emojis as $array=>$item){
            $new_arr['name']=$item['name'];
            $new_arr['php_src']=$item['php_src'];
            $new_arr['emoji']=stripcslashes($item['php_src']);
            $tmp_arr[]=$new_arr;
        }
        return $tmp_arr;
    }




    public function get_php(){
        return $this->emoji['php_src'];
    }
    public function get_HTML_hexadecimal(){
        return  $this->emoji['HTML_hexadecimal'];
    }
    public function get_HTML_decimal(){
        return  $this->emoji['HTML_decimal'];
    }
    public function get_shortcut(){
        return  $this->emoji['shortcut'];
    }


} 