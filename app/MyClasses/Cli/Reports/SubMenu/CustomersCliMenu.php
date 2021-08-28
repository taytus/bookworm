<?php

namespace App\MyClasses\Cli\Reports\SubMenu;

use App\MyClasses\Cli\CliMenu;


class CustomersCliMenu{

    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;

    public function __construct($cli=null){
       $this->cli=$cli;
    }

    public function show_main_menu($cli){
        $this->cli=$cli;
        $customer_report='App\MyClasses\Cli\Reports\Queries\Customers';
        $this->menu_options=[
            ['Info about a Customer',$customer_report,'info_about_a_customer'],
           // ['Pending Confirmed Properties',$property_report,'pending_confirmed_properties'],
            //['Info about Users',$customer_report,'hi']
        ];
        $this->master_menu=new CliMenu($this->cli);
        $this->master_menu->create_menu('Customer\'s Reports',$this->menu_options)->open();

    }


}