<?php
namespace ROBOAMP;

use \ReflectionMethod;


class MyClass{


    //create_class_from_string("lol","ROBOAMP") will return "\App\MyClasses\lol\ROBOAMP"
    public static function create_class_from_string($path,$string,$prefix=NULL,$output=NULL){

        $my_class= "\\App\\MyClasses\\".$path."\\".$prefix.ucfirst($string);
        $my_class= new $my_class($output);
        return $my_class;
    }

    //helper to call any class/method without worrying if it is static or not
    public static function call_method($class,$method,$params=null){

        $tmp_params=$params;
        if(!is_array($params)){
            $params=array();
            $params[0]=$tmp_params;
        }

        if(!class_exists($class)){
            dd ("CLASS DOESN'T EXIST","Class: ".$class,"Method:  ".$method);
        }
        if(method_exists($class,$method)){
            $MethodChecker = new ReflectionMethod($class,$method);
            $res = $MethodChecker->invokeArgs(new $class($params), $params);
            return $res;
        }else{
            echo ("METHOD DOESN'T EXIST\nClass\t".$class."\nMethod\t".$method."\n");
        }
    }

}
