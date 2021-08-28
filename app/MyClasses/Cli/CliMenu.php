<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 5/20/18
 * Time: 6:30 AM
 */

namespace App\MyClasses\Cli;


use PhpSchool\CliMenu\CliMenu as phps_cliMenu;
use App\MyClasses\Git;
use App\MyClasses\Batman;
use App\MyClasses\MyClasses;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\Action\GoBackAction;
use PhpSchool\CliMenu\Action\ExitAction;
use PhpSchool\CliMenu\MenuStyle;
use App\MyClasses\Cli\CliValidator;
use App\MyClasses\Cli\CLIAlert;
use App\MyClasses\Debug;


class CliMenu extends phps_cliMenu{

    private $menues;
    private $callables;
    private $classes;
    private $main_menu;
    private $output;
    private $server;
    public $cli;
    private $parent_class='';
    private $MyArray;
    private $selectable;
    public $selection;
    public $CLI_alert;

    ///new vars
    //where I'm loading the options from
    public $source=null;
    //if source is !null, it pulls the options from source
    public $menu_options=null;


    public function __construct($cli){

        $this->cli=$cli;
        // list($input,$output)=$cli;

        /*$this->parent_class=debug_backtrace(0);
        $this->parent_class=$this->parent_class[1]['class'];
        $this->server=env('APP_ENV');
        $this->output=$cli->output;
        $this->cli=$cli;
        $this->MyArray=New MyArray();*/
    }

    //renders the menu
    public function render(){
        if (is_null($this->source)){
            if(is_null($this->menu_options)){
                Debug::log("Menu cannot be empty");
            }
        }else{
            $this->menu_options=$this->source;
        }


        $master_menu = new CliMenuBuilder();

        foreach($this->menu_options as $item){
            $option=$this->create_sub_menu($item[1],$item[0]. ' Menu','main_menu',$this->cli);

            $master_menu->addSubMenuFromBuilder($item[0],$option);
        }
        $master_menu->build()->open();
    }







    ///starts from here
    ///
    ///
    ///
    ///


    ///OLD code
    ///
    ///
    public function get_main_menu_options(){
        $class_path='App\MyClasses\Cli\\';
        $parser_main_menu_class=$class_path.'Menu\MainMenuParser';
        $customers_main_menu_class=$class_path.'Customers\CustomersMainMenu';
        $reports_main_menu_class=$class_path.'Reports\MainMenu';
        $main_menu_properties=$class_path.'Menu\MainMenuProperties';
        $main_menu_tools=$class_path.'CliTools';

        $default_method='main_menu_ask';
        //$options=new stdClass();


        return $options=[
            ['Parser',$parser_main_menu_class,$default_method,$this->cli],
            ['Customers',$customers_main_menu_class,$default_method,$this->cli],
            ['Reports',$reports_main_menu_class,$default_method,$this->cli],
            ['Properties',$main_menu_properties,$default_method,$this->cli],
            ['Tools',$main_menu_tools,$default_method,$this->cli]

        ];
    }
    public function display_main_menu(){
        $menu_options=$this->get_main_menu_options();

        $master_menu = new CliMenuBuilder();

        foreach($menu_options as $item){
            dd($item);
            $option=$this->create_sub_menu($item[1],$item[0]. ' Menu','main_menu',$this->cli);

            $master_menu->addSubMenuFromBuilder($item[0],$option);
        }
        $master_menu->build()->open();
    }
    public function create_sub_menu($class,$title,$method='main_menu',$params=null){
        //for each new instance, I need to send the CLI object

        $data=MyClasses::call_method($class,$method,$params);
        $sub_menu=(new CliMenuBuilder)
            ->setTitle($title);
        try{
            foreach($data as $item){
                //check if there is any special event, like "ask"
                switch($class){
                    case "App\\MyClasses\\Cli\\Customers\\CustomersMainMenu":
                        break;
                    case "App\\MyClasses\\Cli\\Reports\\MainMenu";
                    default:
                }

                switch($item[0]){
                    case "ask":
                        $ask_options=$item[2];
                        $item[0]=$ask_options['label'];
                        $callable=$this->ask($ask_options);
                        break;
                    default:
                        $callable=function()use ($item){
                            return MyClasses::call_method($item[1],$item[2],$item[3]);
                        };

                }

                $sub_menu->addItem($item[0],$callable);
            }
        }catch (\Exception $e){
            dd($e);
        }

        $sub_menu->addItem('Return to parent menu', new GoBackAction); //add a go back button
        $sub_menu->disableDefaultItems()->build();
        return $sub_menu;
    }
    public function set_style($menu,$type='default'){
        $styles=[
            'default'=> ['foreground'=>'white','background'=>'blue','border'=>null,'width'=>300],
            'selectable'=>['foreground'=>'green','background'=>'black','border'=>[1,1,'yellow'],'width'=>50]
        ];

        return $menu
            ->setForegroundColour($styles[$type]['foreground'])
            ->setBackgroundColour($styles[$type]['background'])
            ->setBorder($styles[$type]['border'][0],$styles[$type]['border'][1],$styles[$type]['border'][2])
            ->setWidth($styles[$type]['width'])
            ;
    }

    public function get_options($class,$method='main_menu'){
        return MyClasses::call_method($class,$method);
    }

    public function create_menu($title,Array $options,$selectable=false,$selection=null){
        $this->selection=$selection;
        $this->menu_options=$options;
        $this->selectable=$selectable;
        //if($title=='Debug Menu')dd($this->menu_options);

        $menu=new CliMenuBuilder();

        $menu->setTitle($title);
        if($selectable){
            $menu=$this->set_style($menu,'selectable');
        }

        $menu->addItems($this->create_options($options,$selectable));
        $menu->build()->open();

    }
    //some options are strings and some options are an array with the class that contains
    //other options or actions;
    public function create_options($options,$selectable=false,$mycallable=null){

        $new_options=[];
        $callbacks=[];
        $j=0;
        foreach($options as $items){
            if(!is_array($items)){

                $callable=function(){return true;};
                return [$items,$callable];
            }
            switch($items[0]) {
                case "break":
                    break;
                case "ask":
                    dd('asking!');
                    break;
            };


            if($items[0]=="break"){
                if (count($items) == 3) {

                }

            }else {

                if (count($items) == 3) {
                    $new_options[] = $items[0];
                    $tmp_callbacks['class'] = $items[1];
                    if($selectable){
                        $tmp_callbacks['method'][0] = $items[2][0];
                        $tmp_callbacks['method'][1]=$items[2][1];
                    }else{
                        $tmp_callbacks['method'] = $items[2];
                    }
                } else {
                    $new_options[] = $items[0];
                    $tmp_callbacks['class'] = '$this';
                    $tmp_callbacks['method'] = $items[1];

                }
                $callbacks[] = $tmp_callbacks;
                $j++;
            }
        }

        $options=$new_options;



        $this->callables=[];
        $tmp_option=[];
        $tmp_options=[];
        $j=0;
        if(is_array($options)){

            foreach ($options as $item) {
                $this->callables[] = $this->create_callable($callbacks[$j],$selectable);
                $tmp_options[] = [$item, $this->callables[$j]];
                $j++;
            }

        }
        return $tmp_options;
    }
    public function selectable($item){
        return function () use ($item){
            dd($item,'this is sparta');
            return $item;
        };
    }
    public function add_separator($separator='<3',$lines=2){
        $menu = (new CliMenuBuilder)
            ->addLineBreak($separator, $lines)
            ->build();
        return $menu;
    }
    public function create_callable($callback,$selectable=null){

        $callable = function ($menu) use ($callback,$selectable) {
            $index = new Git();
            $selected_text = $menu->getSelectedItem()->getText();
            $index->check_for_string_in_array($selected_text, $this->menu_options, false);
            //HERE

            $params=null;
            //I can send parameters to the method as an array ['method',$params]
            if(is_array($callback['method'])){
                $params=$callback['method'][1];
                $callback['method']=$callback['method'][0];
            }



            if(!method_exists($callback['class'], $callback['method'])){
                //defines the class that is going to be called
                $my_class=new $callback['class']($this->cli);
                $callback['class']=$my_class;
            }else{
                $callback['class'] = ($callback['class'] != '$this' ? new $callback['class']($this->cli) : $this->parent_class);

            }

            if(!is_null($params)){

                call_user_func_array(array($callback['class'], $callback['method']), [$params]);
            }else {
                //                dd($callback,$params);

                // return array($callback['class'], $callback['method']);


                call_user_func_array(array($callback['class'], $callback['method']), [$this->cli]);
            }
        };

        return $callable;

    }
    public function output_to_table($data)
    {
        $headers = [];

        foreach ($data['headers'] as $tmp_header) {
            $headers[] = Batman::uppercase_separator($tmp_header, "_");
        }

        $data = $this->MyArray->replace_null_with_not_available($data);
        $this->cli->output->table($headers, $data);
    }


    /* receives an array and create headers with the keys and
    optionally by default removes the ID field */
    public function headers_from_array($data,$fields_to_exclude=['id']){

        $return=[];
        foreach($data as $obj){
            $return[]=Git::array_exclude_keys($obj,$fields_to_exclude);

        }

        $return['headers']=Git::get_keys_from_array($return);

        return $return;
    }
    public function render_table($data,$fields_to_exclude=['id']){
        //use the same elements in the array, except the ID

        $data_format=$this->headers_from_array($data,$fields_to_exclude);

        $this->output_to_table($data_format);

    }


    public function ask($options){

        /* $style = (new MenuStyle())
             ->setBg('red')
             ->setFg('white');

         $style=$style->setWidth(300);
        */



        return function (phps_cliMenu $menu) use($options){
            $spacer="          ";
            if(!isset($options['validator']))$options['validator']=function(){return true;};
            $result = $menu->askText()
                ->setPromptText($spacer.$options['prompt_text'].$spacer)
                ->setPlaceholderText($options['placeholder_text'])
                ->setValidationFailedText($options['validation_fail_text'])
                ->ask();
            $data['menu']=$menu;
            $data['answer']=$result->fetch();
            //run the validation here;
            $validation=$this->validate($data['answer'],'alphabetic');



//////NOT TESTED





            ////////////////////////










            if($validation['error']===0){
                $data['options']=$options;
                MyClass::call_method($options['class'],$options['method'],$data);
            }else{

                $alert=new CLIAlert($menu);
                $alert->error($validation['error_message']);


            }



        };


    }
    public function validate($data,$validation_type,$error_message=null){
        $validator = new CliValidator();
        //setup validation type
        $validation_type=$validator->get_validation_type($validation_type);
        return $validator->{$validation_type}($data,$error_message);
    }



}