<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 3/28/19
 * Time: 9:49 PM
 */

namespace App\MyClasses\Cli;

use App\MyClasses\Directory;
use App\MyClasses\Git;
use App\MyClasses\URL;
use App\Page;
use App\Customer;
use App\Property;

//



class Ask {


    private $cli;
    private $validation_rules=['URL'=>'URL','ID'=>'required','Name'=>'required','Email'=>'Email'];


    public function __construct(){

    }

    public function general_ask2($label,$content,$method,$class){
        $menu= new CliMenu();
        foreach($content as $item){
            //I can keep adding as many fields as needed
            //those that are null will be deleted
            $data=[$item->label,$item->id,'lmao'];
           // $data=array_filter($data);
            $menu_options=[$item->label,$class,[$method,$data]];
        }
        //dd($menu_options);
        $menu->create_menu($label,$menu_options,1);

    }
    public function general_ask($label,$content,$method,$class){
        $menu= new CliMenu($this->cli);
        $arr=[];
        foreach($content as $item){
            $data=[$item->label,$item->full_path,$item->id];
            $data=array_values(array_filter($data));
            $menu_options[]=[$item->label,$class,[$method,$data]];
        }
        $menu->create_menu($label,$menu_options,1);
        dd('menu has been created');
    }

    public function ask_for_parser_folders($method=null,$class=null){
        $data=$this->get_class_and_method($method,$class);
        $dirs= new Directory();
        $content=$dirs->get_dirs_in_dir(base_path('parser/properties'));
        //before listing the dirs, check if they are associated with a property
        //if not, display *** before and after it's name
        //these are testing folders.
        $obj_arr=[];
        foreach ($content as $item){
            $directory_name=$item['basename'];
            $property_id=$this->get_property_id_from_parser_path($directory_name);
            $obj=new \stdClass;
            $obj->label=(is_null($property_id)?"*** ".$directory_name." ***":$directory_name);
            $obj->full_path=$item['full_path'];
            $obj->id=$property_id;
            $obj_arr[]=$obj;
        }
        $this->general_ask('Select a folder',$obj_arr,$data['method'],$data['class']);
    }
    //$path is a folder's name. Most of the time will be a domain but it doesn't have to
    //$path is not necesary tied to the property, in such case this method will return null
    private function get_property_id_from_parser_path($path){
        $url='https://'.$path;
        $property=Property::where('url',$url)->pluck('id')->first();
        if(is_null($property))$property=Property::where('url',$path)->pluck('id')->first();
        if(is_null($property))$property=Property::where('url','https://www.'.$path)->pluck('id')->first();
        return $property;
    }

    public function select_property($method=null,$class=null){
        $data=$this->get_class_and_method($method,$class);
        $content=$properties=Property::where('seeder',1)->get();
        $res=Git::rename_key_from_db('url','label',$content);
        $this->general_ask("Select a property",$content,$data['method'],$data['class']);
    }
    private function get_class_and_method($method,$class){
        if(is_null($method)&& is_null($class)) {
            $res = debug_backtrace();
            $res = $res[2];
            $class=$res['class'];
            $method=$class."::".$res['function'];
        }
        $data['class']=$class;
        $data['method']=$method;
        return $data;
    }




    public function select_customer($method=null,$class=null,$has_property=false){
        $data=$this->get_class_and_method($method,$class);

        if($has_property)$this->check_for_properties();


        $content=$properties=Property::all();
        $this->general_ask("Select a property",$content,$data['method'],$data['class']);




        /* review following code */

        $menu= new CliMenu();

        $customers=Customer::all();
        $arr=[];
        foreach($customers as $item){
            $data=[$item->name,$item->id];
            $menu_options[]=[$item->name,$class,[$method,$data]];
        }

        $ll=$menu->create_menu('Select a Customer',$menu_options,1);
        dd('OK');
        $this->top_menu();

        return true;

        $res=$ll->build()->open();
        //this is excecuted when exiting the menu;
        dd('now Im gone');

        dd($method,$has_property);
        dd('something has to happen here');




        $menu_options=(is_null($default)?['Name','ID']:array($default));

        $this->record_id=[];
        if(is_null($default)) {
            $question = $this->cli->choice_question('Select Customer by:(defaults to ' . $menu_options[0] . ')',
                $menu_options,
                0);
        }else{
            $question=$default;
        }
        $this->customer_default_option=$question;

        $validation = $this->cli->set_validation($this->validation_rules[$question],$question);


        $callable=function($param,$field) use ($has_property){
            //return only real customers
            if($param->testing==1) return null;
            if($has_property){
                if(!$param->at_least_one_property()) return null;
            }
            $this->record_id[]=$param->id;
            return $param->{$field} ." - ".$param->email;

        };

        $autocomplete= $this->cli->set_autocomplete('Customer',$question,$callable);
        //this is the name selected or typed by the user
        return $this->cli->ask("please type Customer's " . $question.":  ",null,$validation,$autocomplete);

    }
    private function check_for_properties(){
        //check first if I have customers with properties
        $res=new Customer();
        if(count($res->with_properties())<1){
            $this->cli->show_error("Couldn't find Customers with Properties");
            return "error";
        }
    }

} 