<?php
namespace App\MyClasses;


use PhpSchool\CliMenu\Action\GoBackAction;
use PhpSchool\CliMenu\CliMenu as phps_cliMenu;
use PhpSchool\CliMenu\MenuItem\SelectableItem;
use App\MyClasses\Server;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use App\MyClasses\Emojis;



class CliMenu2 extends phps_cliMenu{

    private $menues;
    private $callables;
    private $classes;
    private $main_menu;
    private $output;
    private $server;

    public function __construct($output=null){

       /* $this->server=env('APP_ENV');
        $this->output=$output;
        $this->classes=$classes;
        $this->main_menu= new CliMenuBuilder();
        $this->create_menu();

       */
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

    public function create_sub_menu($data,$style)
    {
        list($title, $class, $method) = $data;

        $class = new $class;
        $options = $class->menu_options();

        $subMenuBuilder =(new CliMenuBuilder)
            ->setWidth($style->getWidth());
        $subMenuBuilder->setTitle($title);
        foreach ($options as $item) {
            $myCallback = $this->create_callable($item[1], $item[2]);
            if (is_string($item[1])) {
                //dd($item);
                if (count($item) < 4) {
                    $callable=$this->create_callable($item[1],$item[2]);
                   // $callable=function(){
                   //     echo "hi";
                   // };
                   // dd($item,$callable);
                    $subMenuBuilder->addItem($item[0], $callable);
                    //$subMenuBuilder->addItem("Option", $callable);
                } else {
                    //it's a submenu
                    $second_level_menu = (new CliMenuBuilder)
                        ->setWidth($style->getWidth())
                        ->setMarginAuto();
                    $callable=$this->create_callable($item[1],$item[2]);
                    $second_level_menu->setTitle($item[0]);
                    $second_level_menu->addItem($item[0],$callable);
                    $emojis= new Emojis();
                    $right_arrow=$emojis->get_emoji_by_shortcut(":right_arrow:",'php');

                    $subMenuBuilder->addSubMenuFromBuilder($item[0]."     ".$right_arrow,$second_level_menu);

                }

            }


            // ->addItem("Taytus",function(){
            //        echo "hello!";
            //    });
        }
            return $subMenuBuilder;



            $class = MyClasses::create_class_from_string($class, "Cli", "", $this->output);

            $class_menu = $class->menu();

            $menu_title = $class_menu['title'];
            $menu_items = $class_menu['items'];

            $menu = (new CliMenuBuilder)
                ->setTitle($menu_title);

            $callable = function (phps_cliMenu $menu) {
                $item = $this->callables[$menu->selectedItem];
                $class = MyClasses::create_class_from_string($item['class'], "Cli", "Cli", $this->output);
                call_user_func(array($class, $item['method']));
            };

            foreach ($menu_items as $item) {
                $this->create_callable($item['method']);
                $menu->addItem($item['menu item'], $callable);
            }

            $menu->addLineBreak('-')
                ->setBorder(1, 2, 'yellow')
                ->setPadding(2, 4)
                ->setMarginAuto()
                ->build();
            $tmp_menu['menu'] = $menu;
            $tmp_menu['label'] = $menu_title;
            $this->menues[] = $tmp_menu;


    }

    public function create_callable($class,$method){


        $callable = function ($menu) use ($class,$method) {
            $selected_text = $menu->getSelectedItem()->getText();

            $index = new Git();
            $params=null;
            //I can send parameters to the method as an array ['method',$params]
            if(is_array($method)){
                $params=$method[1][0];
                $method=$method[0];

            }



           /* if(method_exists($class, $method)){
                //defines the class that is going to be called
                $my_class=$class;
            }else{
                dd("dunno");
                //$callback['class'] = ($callback['class'] != '$this' ? new $callback['class']($this->cli) : $this->parent_class);

            }*/

            if(!is_null($params)){
                call_user_func_array(array(new $class, $method), [$params]);
            }else {
                call_user_func(array(new $class, $method));
            }
        };

        return $callable;

    }

    private function create_callablew($string){
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