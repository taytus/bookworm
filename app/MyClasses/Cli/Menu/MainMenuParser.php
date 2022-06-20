<?php

namespace App\MyClasses\Cli\Menu;

use App\MyClasses\Cli\CliMenu;
use App\MyClasses\Cli\Ask;
use App\Property;
use DemeterChain\C;


class MainMenuParser{
    /** @var \App\MyClasses\Cli\Cli */
    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;

    public function __construct($cli=null){
       // if(is_array($cli)|| is_null($cli))//dd(__METHOD__,'wrong CLI');
        $this->cli=$cli;
    }



    public function main_menu(){
        $CliParser = 'App\MyClasses\Cli\CliParser';
        $menu_options = [

            ['Replace AMP Sidebar', $CliParser, 'auto_replace_amp_sidebars',$this->cli],
            ['HTML to Blade', $CliParser, 'HTML_to_Blade',$this->cli],
            ['Output Pages Seeder', $CliParser, 'create_page_seed_inserts_from_pages',$this->cli],


        ];
        $parent=debug_backtrace();
        echo $parent[0]['class']."|".$parent[0]['function']."\n";
        echo $parent[1]['class']."|".$parent[1]['function']."\n";
        echo $parent[2]['class']."|".$parent[2]['function']."\n";
        echo "------------------------------------------\n";
        echo "------------------------------------------\n";
        echo "------------------------------------------\n";


        return $menu_options;
    }

}

