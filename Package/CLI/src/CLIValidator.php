<?php
namespace ROBOAMP;

use ROBOAMP\URL;
use ROBOAMP\Validator;
use ROBOAMP\Strings;
class CLIValidator extends Validator {

    public $input,$output;
    private $type=null;
    private $error_messages=[
        "email"=>"Please enter a valid Email",
        "between"=>"some error message here",
        "required"=>"This field is REQUIRED and cannot be empty",
        "alphabetic"=>"Numeric values are not accepted.",
        "alphabetic_only"=>"Numeric values are not accepted.",
        "url"=>"Please enter a valid URL",
        "error"=>"something goes here"
    ];

    public function __construct($output,$input){
        $this->input=$input;
        $this->output=$output;
    }

    public function check_for_null($original_question,$alternative_question){
        $domain=$this->output->ask($original_question);
        if(is_null($domain)) {
            $domain=$this->check_for_null($alternative_question,$alternative_question);
        }
        return $domain;
    }







}
