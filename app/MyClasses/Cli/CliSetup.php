<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 8/31/18
 * Time: 7:24 AM
 */

namespace App\MyClasses\Cli;

use App\MyClasses\Server;

class CliSetup {

    private $live;
    public $data;

    public $colors;

    public function __construct($input, $output,$helpers,$live=null){


        $server=new Server();
        $this->live=(is_null($live)?!$server->testing_server():$live);

        $this->data['colors']=$this->setup_colors();
        $this->data['output']=$output;
        $this->data['input']=$input;

        foreach ($helpers as $helper=>$value){
            $this->data['helpers'][$helper]=$value;
        }

        //$this->data['helper']['question']=$question_helper;

        $this->data['live']=true;//$this->live;
        return $this->data;


    }

    public function setup_colors(){
        $colors['menuForegroundColour']='white';
        $colors['menuBackgroundColour']='blue';

        if($this->live){
            $colors['menuForegroundColour']='white';
            $colors['menuBackgroundColour']='red';
        }
        return $colors;
    }

} 