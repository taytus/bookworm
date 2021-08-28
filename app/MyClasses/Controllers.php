<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 7/18/18
 * Time: 7:58 AM
 */
namespace App\MyClasses;
use App\MyClasses\Files;
use App\MyClasses\Git;
use App\MyClasses\Errors;


class Controllers {
    public $controller_name=null;
    private $files;
    private $method;
    private $arr_methods=[];
    private $method_name;
    private $errors;

    public function __construct($controller_name=null)
    {
        if (!is_null($controller_name)) {
            $this->controller_name = $this->format_controller_name($controller_name);
        }
        $this->files=new Files($this->controller_name);
        $this->errors=new Errors();


    }

    public function add_method_to_controller($method_name,$method_type = 'public'){
        $this->setup_method($method_name,$method_type);
        $myArray= new Git();

        $this->arr_methods=$myArray->insert_by_key_if_key_doesnt_exist($this->method,'name',$this->arr_methods,0);


        $this->files=new Files($this->controller_name);

        $res=$this->files->add_method_to_controller($this->method);

        dd($res,$this->arr_methods,__METHOD__);


    }
    public function delete_controller($controller_name=null){

        $controller_name=$this->format_controller_name($controller_name);

        $this->controller_name=(is_null($controller_name)?$this->controller_name:$controller_name);

        $controller_file_path=Paths::full_path_to_file($this->controller_name,'controller');

        $this->files->delete_file($controller_file_path);

        $this->controller_name=null;
    }



    //creates a series of variables for the new method
    public function setup_method($method_name,$method_type){
        $method_name=ucfirst(strtolower($method_name));
        $method_declaration=$this->create_method_declaration($method_type,$method_name);
        $this->method['name']=$method_name;
        $this->method['code']=$method_declaration;
        $this->method['first_line_declaration']=$this->format_method_declaration($method_declaration);

    }


    public function insert_code_into_method($code,$method_name=null,$debug=0){
        $ignore_debug=0;

        if(is_null($method_name)){


        }else{
            $this->method=$this->arr_methods[$method_name];
        }

        if($debug===1 & !$ignore_debug){
            $this->box($code);
            $this->box($this->method['name']);


        }
        //I need to know what's the active method
        $this->method['code']=$this->sanitize_method($this->method['code']);
        $this->files->add_line_to_method($this->method,$code,$debug);


        $this->method['code']=$this->files->get_method();
        $this->method['code']=$this->sanitize_method($this->method['code']);
        $this->arr_methods[$this->method['name']]['code']=$this->method['code'];

    }

    public function create_controller($name=null){

        if(is_null($name)){
            if(is_null($this->controller_name) ){
                $error_msg=["$"."this->controller_name cannot be null","Operation aborted"];
                $this->errors->log_error_and_die(__METHOD__,$error_msg);
            }
        }else{
            $this->controller_name=$this->format_controller_name($name);
        }

        \Artisan::call('make:controller', array('name' => $this->controller_name));

    }
    public function set_method($method_name){
        $method_name=ucfirst(strtolower($method_name));
        $res=array_key_exists($method_name,$this->arr_methods);
        if(!$res){
            $this->box('Key doesn\'t exist');
        }else{
            $this->method=$this->arr_methods[$method_name];
        }


    }

    public function box($message){
        echo "\n\n";
        echo "\n\t*****************************************\n";
        echo "\t\t".$message;
        echo "\n\t*****************************************\n";
        echo "\n\n";
    }
    public function get_method(){
        return $this->method;
    }
    public function get_methods(){

        return $this->arr_methods;
    }
    private  function format_method_declaration($method_declaration,$number_of_tabs=1){
        //remove all the \t and \n, and add them later
        $method_declaration=str_replace("\t","",$method_declaration);
        $method_declaration=str_replace("\n","",$method_declaration);
        $method_declaration=str_replace("}","",$method_declaration);
        $method_declaration=explode("{",$method_declaration);

        $method_declaration=$method_declaration[0]."{";

        $t="";
        for($number_of_tabs;$number_of_tabs>0;$number_of_tabs--){
            $t.="\t";
        }

        $method_declaration=$t.$method_declaration."\n";

        return $method_declaration;


    }
    public function create_method_declaration($method_type,$method_name){
        return "\t".$method_type." function ". $method_name."() {\n\n\t\t//placeholder\n\t}\n\n\n";
    }
    private function sanitize_method($method){
        //removes \n\n
        return str_replace("\n\n\n","\n\n",$method);
    }
    private function format_controller_name($controller_name){

        if(is_null($controller_name))return $controller_name;

        $controller_name=str_replace('controller','Controller',$controller_name);

        if( strpos($controller_name,'Controller') !== false){
            $tmp_name="";
        }else{

            $tmp_name="Controller";
        }

        return ucfirst($controller_name).$tmp_name;


    }
} 