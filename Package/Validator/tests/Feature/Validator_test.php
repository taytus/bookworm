<?php


use ROBOAMP\Strings;

class Validator_test{

    private $type=null;
    private $error_messages=[
        "email"=>"Please enter a valid Email",
        "between"=>"some error message here",
        "required"=>"This field is REQUIRED and cannot be empty or Numeric",
        "alphabetic"=>"Numeric values are not accepted.",
        "alphabetic_only"=>"Numeric values are not accepted.",
        "url"=>"Please enter a valid URL",
        "error"=>"something goes here"

    ];

    public function __construct(){
    }


    public function between($min,$max,$val,$error_message=null){
        $answer=(int)$val;

        if ($answer<$min || $answer>$max) {
            $this->display_error_message('between',$error_message);
        }
        return (string)$answer;
    }

    public function validation_rules_valid_email($email,$error_message=null){


        if(!$this->valid_email($email)){
            return $this->display_error_message('email',$error_message);
        }else{
            return $email;
        }

    }
    public function validation_rules_required_field($string,$error_message=null){
        $strings=new Strings();

        if($strings->empty_string($string)){
            $this->display_error_message('required',$error_message);
        }else{
            return $string;

        }
    }
    //conditions:
    //can't be an empty string and can't have numbers
    public function validation_rules_alphabetic($string,$allow_numbers=false,$allow_special_chars=false,$error_message=null){
        $strings=new Strings();
        $error="error";

        if($strings->has_special_chars($string) && !$allow_special_chars) return $error;


        if($strings->empty_string($string)){
            return $this->display_error_message('required',$error_message);
        }

        $error_type="alphabetic";

        if(!$allow_numbers){
            if ($strings->string_without_numbers($string)){
                return $string;
            }else{

                if(is_null($error_message)) return $error;

                return $this->display_error_message($error_type);
            }
        }

        return $string;


    }
    public function display_error_message($type,$error_message=null){
        //if no error message is passed, then searches in the error_messages array and displays that.

        $error_message= (is_null($error_message)?$this->error_messages[$type]:$error_message);
        $obj= new \stdClass();
        $obj->error=1;
        $obj->error_message=$error_message;

        return $obj;
    }
    public function validation_rules_valid_url($string,$error_message=null){
        $strings=new Strings();

        if($strings->empty_string($string)){
            $this->display_error_message('required',$error_message);
        }else{

            return (URL::is_valid_url($string)?$string:$this->display_error_message('url',$error_message));

        }
    }
    //depending on the validation type, call a function with the returned name
    public function get_validation_type($key){
        $key=ucfirst($key);
        switch($key){
            case 'Email':
                return 'validation_rules_valid_email';
                break;
            case 'Required':
                return 'validation_rules_required_field';
                break;
            case 'Alphabetic':
                return 'validation_rules_alphabetic';
                break;
            case 'URL':
                return 'validation_rules_valid_url';
        }

    }

    private function valid_email($email){
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }





}