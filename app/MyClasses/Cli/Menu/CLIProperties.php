<?php
/**
 * create_property_menud by PhpStorm.
 * User: taytus
 * Date: 9/17/18
 * Time: 8:22 PM
 */

namespace App\MyClasses\Cli\Menu;
use App\Customer;
use App\MyClasses\Cli\CliValidator;
use App\MyClasses\Dates;
use App\MyClasses\Errors;
use App\MyClasses\Git;
use App\MyClasses\Paths;
use App\MyClasses\Templates;
use App\Page;
use App\Property;
use Carbon\Carbon;
use App\MyClasses\Directory;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use Webpatser\Uuid\Uuid;
use App\MyClasses\Cli\Ask;
use App\MyClasses\Cli\CliMenu;

use PhpSchool\CliMenu\CliMenu as ClassMenu;


class CLIProperties {
    /** @var \App\MyClasses\Cli\CliMenu */
    private $cliMenu;
    /** @var  \App\MyClasses\Cli\Cli */
    private $cli;
    private $new_property_id;
    private $new_property_url;
    private $property_folder_path;
    private $customer_default_option;
    public $selection;

    private $query;
    //this saves records IDs from multiple selection cases
    private $record_id=null;
    private $error_log=null;
    private $menu_class='App\MyCLasses\Cli\Menu\MainMenuProperties';
    private $menu_title='Properties Menu';

    public function __construct($cli){
        $this->cli=$cli;
        $this->error_log=new Errors($cli);
    }

    public function create_triggers($cli){
        dd("NONONONONONONO77");
        $ask=new Ask($cli);
        $property=new Property();
        $templates=new Templates();
        $pages=$ask->get_pages();
        $white_label=$property->white_label($pages['property_id']);
        if(empty($pages['pages'])){
            $this->cli->show_error('There are no pages for this Property');
        }else{
            foreach($pages['pages'] as $item){
                $templates->create_AMP_triggers($item,$white_label);
            }
        }
    }






    public function delete_property_menu(){
        $local_method='App\MyClasses\Cli\Menu\CLIProperties';
        $this->menu_options=[
            ['Delete All Properties From User',$local_method,'delete_all_properties_from_user'],
            ['Delete A Property from User',$local_method,'delete_a_property_from_user'],
            ['Delete A Property By Property Name',$local_method,'delete_property_by_name'],

        ];
        return $this->menu_options;
        //$this->master_menu=new CliMenu($this->cli);
        //$this->master_menu->create_menu('Reports',$this->menu_options)->open();


    }
    public function delete_a_property_from_user($nothing=null,$customer_default_option=null){
        $directory=new Directory();
        $res=$this->ask_for_customer($customer_default_option,true);
        if($res!='error') {

            if (!isset($res['record_id'])) {
                $this->cli->show_error('User Not Found');
                //recurrent call
               // $this->delete_all_properties_from_user($nothing, $this->customer_default_option);
            } else {
                //I have to ask whats the property that will be deleted
                $this->ask_for_property();
                /*
                 * $this->delete_properties($res);
                $this->cli->show_success('All Properties have been deleted');
                 */
            }
        }
    }


    public function delete_all_properties_from_user($nothing=null,$customer_default_option=null){
        $res = $this->ask_for_customer($customer_default_option, true);
        if($res!='error') {
            if (!isset($res['record_id'])) {
                $this->cli->show_error('User Not Found');
                //recurrent call
                $this->delete_all_properties_from_user($nothing, $this->customer_default_option);
            } else {

                $this->delete_properties($res);
                $this->cli->show_success('All Properties have been deleted');
            }
        }
    }

    public function delete_properties($res){
    $res = $res['record_id'];
    $directory = new Directory();
    $properties = Property::where('customer_id', $this->record_id[$res])->get();
    foreach ($properties as $item) {
        //delete all the pages belonging to this property
        $pages = Page::where('property_id', $item->id)->delete();
        $property = Property::where('id', $item->id)->delete();

        $assets_folders = base_path() . "/public/properties/" . $item->url;
        $renders_folders = base_path() . "/parser/properties/" . $item->url;

        $directory->delete_me($assets_folders);
        $directory->delete_me($renders_folders);
    }
}


    public function create_parser_menu($property_id=null){
        if($property_id!=null){
            dd('property has been selected',$property_id);
        }
        $res= (new Ask($this->cli))->select_property();
    }

    //when a property is activated this way, a new page record is created
    //that doesn't mean the right HTML content is there
    public function create_property_menu($customer_id=null){
        //redraw parent menu


        if($customer_id!=null){
            //$menu=new CliMenu();
            //$menu->display_main_menu();

            //$this->top_menu();
            dd('we have a winner!!!!!!',$customer_id);

            //go to previous screen;


        }
        //$res= (new Ask())->ask_for_property(__METHOD__,__CLASS__);
        $res= (new Ask($this->cli))->select_property();


       // $res= (new Ask($this->cli))->select_customer(__METHOD__,__CLASS__);

        dd('menu exit');
        return true;
        dd($res,'something');
        dd('end from create_property_menu');

        if(!$res['record_id']){
            $customer_id=$this->create_customer($res[1]);
        }else{
            $customer_id=$this->record_id[$res['record_id']];
        }

        if($this->create_property($customer_id))$this->create_default_page();


    }
    public function test(){
        dd('lol from test');
        $itemCallable = function (CliMenu $menu) {
            echo $menu->getSelectedItem()->getText();
        };


    }




    public function asking($data){
        dd ($data);
    }






    //$method is the method we return to after selecting a customer

    public function lilly($option){
        dd('this is the option selected',$option);
    }
    public function create_default_page(){
        $now=new Carbon();
        $id=Uuid::generate(4);

        $page= new Page();
        $page->id=$id;
        $page->property_id=$this->new_property_id;
        $page->name='index';
        $page->url=$this->new_property_url;
        $page->created_at=$now;
        $page->updated_at=$now;
        $page->save();
        $this->cli->show_success("Default page has been created with ID: ". $id);

        $this->generate_default_files();

    }

    public function generate_default_files(){
        $directory=new Directory();
        $templates=new Templates();
        $this->property_folder_path=Paths::path_to_folder('properties')."/".$this->new_property_url;

        $directory->create($this->property_folder_path);

        $this->create_property_folder_assets();
        //the idea of the trigger is to add it to the sitemap.xml so google will
        //index the AMP versions of the websites and make it easier to make demos
        //and speed testing
        $templates->create_default_AMP_trigger($this->new_property_url,$this->property_folder_path,$this->new_property_id);

        $this->cli->show_success('Property Folders has been created');

    }


    public  function create_property_folder_assets(){
        $directory=new Directory();
        $directory_names=["js","img","fonts","css"];

        $directory::create_folders($directory_names,'public/properties/',$this->new_property_url);
    }
    public function create_customer($name){
        $now=new Carbon();
        $validation = $this->cli->set_validation($this->validation_rules['Email'],'Email');

        $email=$this->cli->ask("Please type you Customer's EMAIL:   ",null,$validation);
        $id=Uuid::generate(4);
        $customer=new Customer();
        //defaults to Roberto because I have access to the console so far
        $customer->user_id=3;
        $customer->id=$id;
        $customer->email=$email[1];
        $customer->name=$name;
        $customer->password=bcrypt('secret');
        $customer->created_at=$now;
        $customer->updated_at=$now;
        $customer->testing=0;
        $customer->save();

        echo "\n Customer has been Created\n";
        return (String) $id;


    }

    public function create_property($customer_id){
        $validation = $this->cli->set_validation($this->validation_rules['URL'],'URL');

        $url=$this->cli->ask("please type the URL for this Property:   ",null,$validation);
        if($url[1]) {
            $res=Property::where('url',$url[1])->first();
            if(!$res) {
                $id=Uuid::generate(4);

                //TODO check if that property already exist
                $now = new Carbon();
                $property = new Property();
                $property->customer_id = $customer_id;
                $property->id = $id;
                $property->status_id = 1;
                $property->created_at = $now;
                $property->updated_at = $now;
                $property->plan_id = 2;
                $property->url = $url[1];
                $property->save();
                $str_id=(String) $id;
                $this->cli->show_success("Property has been created with ID:".$str_id);
                $this->new_property_id=$str_id;
                $this->new_property_url=$url[1];
                return true;

            }else{
                $this->cli->show_error("There is a property with that URL");
                $this->create_property($customer_id);
            }
        }else{
            return false;
        }
        return true;

    }
    //when innactive==1 display all properties, otherwise just the active ones
    public function ask_for_property($status=0){

        $res=Property::where('status_id',1)->get();
        dd($res);
    }
    public function activate_property_menu(){
        $res=$this->ask_for_property(1);

        //get the property and change it status to 1
        $property=$this->activate_property($res);


        $page= new Page();
        $page_id=$page->create_a_page_from_a_property($property,true);
        $str="A new Page has been created for PropertyID:  ".$property->id."\n";
        $str.="Page ID: ".$page_id."  \n";
        $str.= "CustomerID: ".$property->customer_id."\n";
        $str.= "You can access it at:\n";
        $str.= url('/amp/'.$property->id."/".$property->url) ." \n";

        $this->cli->show_success($str);

    }
    private function activate_property($res){
        $property=Property::where(strtolower($res[2]),'like','%'.$res[1].'%')->first();
        $property->status_id=1;
        $property->save();

        $this->cli->show_success("Property Status has been updated to ACTIVE");
        return $property;

    }
    private function top_menu(){
       $new_menu=new CliMenu();
        $options=$new_menu->get_options($this->menu_class);
        $new_menu->create_menu($this->menu_title,$options);
       /* $new_menu=new CliMenuBuilder();
        $master_menu = new CliMenu();
        $option=$master_menu->create_sub_menu($this->menu_class,$this->menu_title);
        $new_menu->addSubMenuFromBuilder("NANA",$option);
        $new_menu->build()->open();
       */

    }



    //pending properties who has been confirmed but we haven't run the script on them yet








} 