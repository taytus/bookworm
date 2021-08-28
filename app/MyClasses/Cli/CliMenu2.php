<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 5/20/18
 * Time: 6:30 AM
 */

namespace App\MyClasses\Cli;


use PhpSchool\CliMenu\Action\GoBackAction;
use PhpSchool\CliMenu\CliMenu as phps_cliMenu;
use PhpSchool\CliMenu\MenuItem\SelectableItem;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use App\MyClasses\Server;



class CliMenu2 extends phps_cliMenu{

    private $menues;
    private $callables;
    private $classes;
    private $main_menu;
    private $output;
    private $server;

    public function __construct($classes,$output){

        $this->server=env('APP_ENV');
        $this->output=$output;
        $this->classes=$classes;
        $this->main_menu= new CliMenuBuilder();
        $this->create_menu();

    }

    public function create_menu(){
        foreach ($this->classes as $class){
            $this->create_sub_menu($class);
        }

    }
    public function open_menu(){
        $server=new Server();

        if($server->testing_server()){
            $key_type='Using TESTING Stripe Keys';

        }else{
            $key_type='Using LIVE Stripe Keys';
        }

        $this->main_menu
            ->setTitle("You are on ". $this->server. " server.  |"." ".$key_type );

        foreach($this->menues as $menu){

         $this->main_menu->addSubMenuFromBuilder($menu['label'],$menu['menu']);

        }

        $this->main_menu->build()->open();
    }
    public function create_sub_menu($class){

        $class=MyClasses::create_class_from_string($class,"Cli","",$this->output);

        $class_menu= $class->menu();

        $menu_title=$class_menu['title'];
        $menu_items=$class_menu['items'];

        $menu = (new CliMenuBuilder)
            ->setTitle($menu_title);

        $callable=function(phps_cliMenu $menu){
            $item=$this->callables[$menu->selectedItem];
            $class=MyClasses::create_class_from_string($item['class'],"Cli","Cli",$this->output);
            call_user_func(array($class,$item['method']));
        };

        foreach ($menu_items as $item){
            $this->create_callable($item['method']);
            $menu->addItem($item['menu item'],$callable);
        }

       $menu->addLineBreak('-')
            ->setBorder(1, 2, 'yellow')
            ->setPadding(2, 4)
            ->setMarginAuto()
            ->build();
        $tmp_menu['menu']=$menu;
        $tmp_menu['label']=$menu_title;
        $this->menues[]=$tmp_menu;

    }



    private function create_callable($string){
        $arr=explode("__",$string);
        if(count($arr)>1){


            $class=$arr[0];
            $method=$arr[1];

        }else{
            $class=$this;
            $method=$arr[0];

        }
        $this->callables[]=array('class'=>$class,'method'=>$method);

    }


    public function getTitle(){

    }
    public function getMenues(){return $this->menues;}
    public function setMenues($menues){$this->menues = $menues;}




}