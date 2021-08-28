<?php

namespace App\MyClasses\Cli\Reports;

use App\MyClasses\Cli\CliMenu;


class MainMenu{

    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;

    public function __construct($cli=null){
       $this->cli=$cli;
    }


    public function menu_options(){
        $local_method='App\MyClasses\Cli\Reports\MainMenu';
        return $options=[
                ['B-1',$local_method,['bananas',["bobo"]]],
                ['B-2',$local_method,['bananas',["TAYTUS"]]],
                ['B-3',$local_method,['option_b_menu',["jamaica"]],1]
            ];

    }
    public function option_b_menu($data){
        dd('something else to go deeper');
        $local_method='App\MyClasses\Cli\Reports\MainMenu';
        return $options=[
            ['B-8',$local_method,['bananas',[$this->output]]],

        ];
    }
    public function bananas($data=null){
        dd ($data, "FROM BANANAS");
    }



    public function main_menu(){
        $main_menu='show_main_menu';

        $property_report='App\MyClasses\Cli\Reports\SubMenu\PropertiesCliMenu';
        $customer_report='App\MyClasses\Cli\Reports\SubMenu\CustomersCliMenu';
        return $this->menu_options=[
            ['Properties',$property_report,$main_menu],
            ['Customers',$customer_report,$main_menu]
        ];
    }




    //I have to check if every one of this options are submenues as well and
    //send it over it's parent
    public function show_main_menu($parent_menu=null,$cli=null){
        $property_report='App\MyClasses\Cli\Reports\SubMenu\PropertiesCliMenu';
        $customer_report='App\MyClasses\Cli\Reports\SubMenu\CustomersCliMenu';
        $main_menu='show_main_menu';

       // echo "THIS IS SHOW MAIN MENU!";


        return $this->menu_options=[
            ['Properties',$property_report,$main_menu],
            ['Customers',$customer_report,$main_menu]
        ];

       // $this->master_menu=new CliMenu($this->cli);
        //$this->master_menu->create_menu('Reports',$this->menu_options)->open();


    }


}