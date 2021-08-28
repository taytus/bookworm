<?php


namespace App\MyClasses\Cli;
use App\MyClasses\Git;
use App\MyClasses\MyClasses;


class CliDebug {


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
    private $sub_menues;
    private $active_submenu;
    private $output;


    public function __construct($options = null){


        if(!is_null($options))$this->setOptions($options);

    }






    public function add_option($item, $position=null){


        if($item[0]!="") {
            $array=new Git();

            $new_options = $this->getOptions();

            if ($position > count($this->getOptions()) || is_null($position)) {

                $new_item['menu item']=$item[0];
                $new_item['method']=$item[1];
                $new_item['sub menu item']=(isset($item[2])?$item[2]:null);

                $new_options[] = $new_item;

            } else {
                $item = array(['menu item' => $item[0], 'method' => $item[1]]);
                array_splice($new_options, $position, 0, $item);

            }

            $this->setOptions($new_options);
        }
    }
    public function display_sub_menu(){

        $output=$this->getOutput();
        $options=$this->getActiveSubmenu();

        $menu=new Menu('el cerrito',$this->get_labels_for_sub_menu($this->getActiveSubmenu()));

        $menu->open();
        dd();





    }

    public function add_menu($menu){

        $sub_menu_index=0;
        foreach ($menu as $menus){
            $tmp_menu=array($menus['title'],'display_sub_menu',$sub_menu_index);
            $this->add_option($tmp_menu);
            $submenu=$this->getSubMenues();
            $total_options=count($this->getOptions())-1;
            foreach ($menus['menu'] as $options){
                $new_menu[]=$options;
            }
            $submenu[$total_options]=$new_menu;
            $this->setSubMenues($submenu);
            $sub_menu_index++;
        }

    }



    public function get_labels_for_main_menu(){
        $labels=array();
        foreach ($this->getOptions() as $elements){
            $labels[]=$elements['menu item'];
        }

        return $labels;
    }
    public function get_labels_for_sub_menu(){

        $labels=array();
        $sub_menu=$this->getActiveSubmenu();

        foreach ($sub_menu as $elements){
            $labels[]=$elements['menu item'];
        }
        return $labels;
    }



    public function get_options_by_index($index){
        $options = $this->getOptions();

        if ($index <= count($options) - 1) {return $options[$index];}
    }


    public function set_class_and_method_by_index($index){

        if(is_null($index)){
            $this->setExit(true);
            return;
        }


        $option=$this->get_options_by_index($index);
        $option=$option['method'];


        $arr=explode("__",$option);
        if(count($arr)>1){

            $my_class=MyClasses::create_class_from_string($arr[0]);

            $this->setClass($my_class);
            $this->setMethod($arr[1]);

        }else{
            $this->setClass($this);
            $this->setMethod($arr[0]);

        }
        $this->setActiveSubmenu($this->get_sub_menu_by_index($index));



    }

    private function get_sub_menu_by_index($index){


        $sub_menus=$this->getSubMenues();

        if(array_key_exists($index,$sub_menus)) {

            return $sub_menus[$index];
        }else{
            return null;
        }
    }


    public function delete_landing_page(){
        dd('the page has been deleted');
    }



    public function reset_keys(){
        dd('now what!!??');
    }

    //getters and setters
    public function getOptions(){return $this->options;}
    public function getClass(){return $this->class;}
    public function getMethod(){return $this->method;}
    public function getTitle(): string{return $this->title;}
    public function getSubMenues(){return $this->sub_menues;}
    public function getActiveSubmenu(){return $this->active_submenu;}
    public function getOutput(){return $this->output;}


    public function setOptions($options){$this->options = $options;}
    public function setClass($class){$this->class = $class;}
    public function setMethod($method){$this->method = $method;}
    public function setTitle(string $title){$this->title = $title;}
    public function isExit(): bool{return $this->exit;}
    public function setExit(bool $exit){$this->exit = $exit;}
    public function setSubMenues($sub_menues){$this->sub_menues = $sub_menues;}
    public function setActiveSubmenu($active_submenu){$this->active_submenu = $active_submenu;}
    public function setOutput($output){$this->output = $output;}









}