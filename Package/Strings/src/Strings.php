<?php
namespace ROBOAMP;



class Strings{



    public static function create_class_from_string($string,$path="Cli",$prefix="Cli",$output){

        $my_class= "\\App\\MyClasses\\".$path."\\".$prefix.ucfirst($string);

        $my_class= new $my_class($output);

        return $my_class;
    }

    //helper to call any class/method withuot worrying if it is static or not
    //TODO: Update it to accept parameters
    public static function call_method($class,$method){
        if(method_exists($class,$method)){
            $MethodChecker = new ReflectionMethod($class,$method);
            if($MethodChecker->isStatic()){
                return $class::$method();
            }else{
                $instance = new $class();
                $instanceMethod = $method;
                return $instance->$instanceMethod();
            }
        }else{
            echo ("METHOD DOESN'T EXIST\nClass\t".$class."\nMethod\t".$method."\n");
        }

    }


}