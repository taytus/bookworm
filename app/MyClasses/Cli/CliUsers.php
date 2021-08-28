<?php
namespace App\MyClasses\Cli;

use App\User;



class CliUsers{

    public $users;
    public $options;
    private $output;

    
    public function __construct($output=null){
        
        $this->output=$output;
    
    }
    public  function get_all_users(){

        $this->users=User::select('email','id','name')->where('test','=',false)->get();
        $this->options=[];

        foreach($this->users as $user){


            $this->options[]= $user['name'];
            $this->users[]=$user->toArray();


        };
        return $this->options;

    }




}

