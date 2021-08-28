<?php

namespace App\MyClasses\Cli\Menu;

use App\MyClasses\Cli\CliMenu;
use App\MyClasses\Git;
use DB;
use Webpatser\Uuid\Uuid;

class Debug{

    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;
    private $apply_to_all=true;

    public function __construct($cli=null){
       $this->cli=$cli;
    }

    public function show_main_menu($cli){
        $this->cli=$cli;
        $localMethod='App\MyClasses\Cli\Menu\Debug';
        $main_menu='show_main_menu';

        $testing_debug_array=[true,false,'nana'];
        $this->menu_options=[
            ['Generate IDs',$this,['generate_id_debug_menu',[$testing_debug_array]]],
            ['All Properties',$this,['debug_property_menu',true]],
            ['One Property',$this,['debug_property_menu',false]],

        ];

        $this->master_menu=new CliMenu($this->cli);
        $this->master_menu->create_menu('Debug Menu',$this->menu_options)->open();
    }
    public function generate_id_debug_menu($options){
        $arr=new Git();
        $options=$arr->array_flatten($options);

        list($a,$b,$c)=$options;



        for($i=0;$i<10;$i++){
            echo "\n".Uuid::generate(4)."\n";
        }

    }
    //buffer function that is in charge to passing $this->apply_to_all var all across the child methods
    public function debug_property_menu($apply_to_all){
        $this->apply_to_all = $apply_to_all;
        $this->debug_property_options();
    }

    public function debug_property_options(){

        $plural_properties=($this->apply_to_all?"Properties":"Property");

        $this->menu_options=[
            ['Change ACTIVE status to PENDING',$this,['change_status_to_pending',$this->apply_to_all]],
            ['Delete '.$plural_properties.' Folders',$this,['delete_folders',$this->apply_to_all]]

        ];

        $this->master_menu=new CliMenu($this->cli);
        $res=$this->master_menu->create_menu('Reports',$this->menu_options)->open();
    }
    //if $property_id is null apply the changes to every property

    public function change_status_to_pending($apply_to_all){

        if($apply_to_all) {
            $res = DB::table('properties')->where('status_id', 1)->update(['status_id' => 2]);
            echo "\nProperties status have been updated to PENDING\n\n";
        }else{
            dd('not ready yet man!!!');
        }
    }





}