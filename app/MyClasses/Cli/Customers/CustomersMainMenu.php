<?php

namespace App\MyClasses\Cli\Customers;


use App\MyClasses\Cli\CliMenu;

class CustomersMainMenu{
    /** @var \App\MyClasses\Cli\Cli */
    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;

    public function __construct($cli=null){
        $this->cli=$cli;
    }

    public function main_menu(){

        $CLIProperties='App\MyClasses\Cli\Menu\CLIProperties';
        $local_method='App\MyCLasses\Cli\Menu\MainMenuProperties';
        $asking_info['label']='Create Customer';
        $asking_info['class']=$this;
        $asking_info['method']='create_customer';
        $asking_info['prompt_text']="Enter the Customer's Full Name";
        $asking_info['placeholder_text']='...';
        $asking_info['validation_fail_text']='nah!';
        $asking_info['steps']=5;

        $menu_options=[
            ['ask',$this,$asking_info],
            ['Delete',$CLIProperties,'delete_property_menu'],
            ['Activate Property',$CLIProperties,'activate_property_menu'],
            ['URLs',$local_method,'URL_options'],
            ['Generate Triggers',$CLIProperties,'create_triggers'],

        ];

        return $menu_options;

    }


    public function create_customer ($data){

        $answers[]=$data['answer'];
        $options=[
            ["prompt_text" => "Enter Customer's Email","placeholder_text" => "jon@doe.com","validation_fail_text" => "Email is not Valid",'class'=>$data['options']['class'],'method'=>$data['options']['method']],
        ];

        $max_steps=$data['options']['steps'];
        $current_step=(isset($data['current_step'])?$data['current_step']:0);
        //$options=$options[$current_step];
        $spacer="          ";
        foreach($options as $item){
            $res=$data['menu']->askText()
                ->setPromptText($spacer.$item['prompt_text'].$spacer)
                ->setPlaceholderText($item['placeholder_text'])
                ->setValidationFailedText($item['validation_fail_text'])
                ->ask();
            $answers[]=$res->fetch();
            $current_step=$current_step+1;
        }

        dd($answers);



    }




}