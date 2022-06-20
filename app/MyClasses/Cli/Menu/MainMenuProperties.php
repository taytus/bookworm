<?php

namespace App\MyClasses\Cli\Menu;

use App\MyClasses\Cli\CliMenu;
use App\MyClasses\Cli\Ask;
use App\Property;
use DemeterChain\C;
use App\Page;


class MainMenuProperties{
    /** @var \App\MyClasses\Cli\Cli */
    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;
    public  $property_id;

    public function __construct(){
    }

    public function main_menu(){


        //$parent_menu->open()->redraw();
        //ignore everything

        $CLIProperties='App\MyClasses\Cli\Menu\CLIProperties';
        $local_method='App\MyCLasses\Cli\Menu\MainMenuProperties';

        $menu_options=[
            ['Parser',$CLIProperties,'create_parser_menu',$this->cli],
            ['Create Property',$CLIProperties,'create_property_menu',$this->cli],
            ['Delete super',$CLIProperties,'delete_property_menu',$this->cli],
            ['Activate Property',$CLIProperties,'activate_property_menu',$this->cli],
            ['URLs',$local_method,'URL_options',$this->cli],
            ['Generate Triggers',$CLIProperties,'create_triggers',$this->cli],

        ];


        return $menu_options;

    }

    public function URL_options($property_id){


        if($property_id!=null && is_array($property_id)){
            $this->property_id=$property_id[1];
            $pages['pages']=Page::where('property_id',$property_id[1])->get()->toArray();
            $pages['property_id']=$property_id;



            ////////////
            ///
            $propertiesURL='App\MyClasses\Cli\Properties\PropertiesURL';
            $property=new Property();

            $white_label=$property->white_label($this->property_id);


            $pages['white_label']=$white_label;


            if(!empty($pages['pages'])) {
                $this->menu_options = [
                    ['Display Local Pages URLs', $propertiesURL, ['display_local_pages_urls', [$pages,$this->cli]]],
                    ['Display ROBOAMP Pages URLs', $propertiesURL, ['display_ROBOAMP_pages_links', [$pages,$this->cli]]],
                    ['Display AMP URLs', $propertiesURL, ['display_amp_links', [$pages,$this->cli]]],
                    ['Display White Listed Pages', $propertiesURL, ['display_white_listed_pages', [$pages,$this->cli]]],
                    ['Generate URLs Report', $propertiesURL, ['create_urls_report', [$pages,$this->cli]]],


                ];
                //only displays the option to show White Labels URLs if the property is white label
                if ($white_label) {
                    $white_label_option = ['Display White Labels URLs', $propertiesURL, ['display_white_label_urls', [$pages]]];
                    array_splice($this->menu_options, 1, 0, [$white_label_option]);
                }

                $this->master_menu = new CliMenu($this->cli);
                $this->master_menu->create_menu('Properties ---- URLs', $this->menu_options)->open();
            }else{
                dd($this->cli);
                $this->cli->show_error("There are no pages for this Property");
            }
            ///////////////
            dd();
            $local_method='App\MyClasses\Cli\Menu\CLIProperties';
            $this->menu_options=[
                ['Delete All Properties From User',$local_method,'delete_all_properties_from_user'],
                ['Delete A Property from User',$local_method,'delete_a_property_from_user'],
                ['Delete A Property By Property Name',$local_method,'delete_property_by_name'],

            ];
            $this->master_menu=new CliMenu($this->cli);
            $this->master_menu->create_menu('Reports',$this->menu_options)->open();


            dd();

            //////////







            $propertiesURL='App\MyClasses\Cli\Properties\PropertiesURL';
            $property=new Property();
            /** @var \App\MyClasses\Cli\CliMenu */
            $this->cli=$cli;
            $property_id=$pages['property_id'];
            $white_label=$property->white_label($property_id);
            $pages['white_label']=$white_label;
            if(!empty($pages['pages'])) {
                $this->menu_options = [
                    ['Display ROBOAMP Pages Links', $propertiesURL, ['display_ROBOAMP_pages_links', [$pages]]],
                    ['Display AMP Links', $propertiesURL, ['display_amp_links', [$pages]]],
                    ['Generate URLs Report', $propertiesURL, ['create_urls_report', [$pages]]],


                ];
                //only displays the option to show White Labels URLs if the property is white label
                if ($white_label) {
                    $white_label_option = ['Display White Labels URLs', $propertiesURL, ['display_white_label_urls', [$pages]]];
                    array_splice($this->menu_options, 1, 0, [$white_label_option]);
                }

                $this->master_menu = new CliMenu($this->cli);
                $this->master_menu->create_menu('Properties ---- URLs', $this->menu_options)->open();
            }else{
                $this->cli->show_error("There are no pages for this Property");
            }


        }
        $res= (new Ask($this->cli))->select_property();



    }
    public function activate_property_menu(){
        $property_report='App\Property';

        $this->menu_options=[
            ['something',$this,'something'],
        ];

        $this->master_menu=new CliMenu($this->cli);
        $this->master_menu->create_menu('Reports',$this->menu_options)->open();
    }




}