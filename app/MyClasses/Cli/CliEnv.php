<?php


namespace App\MyClasses\Cli;
use App\MyClasses\Git;
use Artisan;
use App\MyClasses\Cli\CliCommon;
use App\MyClasses\HTML;



class CliEnv {


    //options for the DEBUG MENU
    protected $options=array(
        ['menu item' =>'Delete Landing HTML Page','method'=>'LandingPage__delete_landing_page'],
        ['menu item' =>'Create Landing Page','method'=>'LandingPage__create_landing_page']
        );
    protected $class;
    protected $method;
    private $title="";
    //when the user select close/exit this flags becomes true
    private $exit=false;


    public function __construct(){


    }


    public function reset_keys(){
        Artisan::call('config:clear');

        $cli= new CliCommon();
        $cli->print_message_before_showing_menu("Env Keys has been reset",'debug');
    }






}