<?php

namespace App\MyClasses\Cli\Reports\SubMenu;

use App\MyClasses\Cli\CliMenu;


class PropertiesCliMenu{

    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;

    public function __construct($cli=null){
       $this->cli=$cli;
    }


    public function show_main_menu($cli){
        $this->cli=$cli;
        $property_report='App\MyClasses\Cli\Reports\Queries\Properties';
        $this->menu_options=[
            ['Confirmed Properties',$property_report,'confirmed_properties'],
            ['Pending Confirmed Properties',$property_report,'pending_confirmed_properties'],
            ['Unconfirmed Properties',$property_report,'unconfirmed_properties'],
        ];
        $this->master_menu=new CliMenu($this->cli);
        $this->master_menu->create_menu('Reports',$this->menu_options)->open();

    }


}