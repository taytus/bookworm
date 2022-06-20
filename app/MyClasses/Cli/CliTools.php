<?php
namespace App\MyClasses\Cli;

use App\MyClasses\Batman;
use App\MyClasses\Templates;
use App\Page;
use App\MyClasses\Cli\CliCommon;
use App\MyClasses\Cli\CliProperties;
use App\MyClasses\URL;
use App\MyClasses\Files;
use App\MyClasses\Directory;
use App\Property;
use App\Template;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use App\MyClasses\Cli\Ask;
use App\MyClasses\Paths;
use App\MyClasses\RoboCode;

class CliTools extends CliCommon{

    public $users;
    private $options;
    private $cli;


    public $local_method='App\MyCLasses\Cli\CliTools';
    /*
             * ['Add Google Analytics Code',$local_method,'add_analytics_code_to_property'],

                ['HTML to Blade',$local_method,'HTML_to_Blade'],
                ['ENV',$local_method,'show_env_vars'],

                ['Stripe',$local_method,'Stripe_menu'],
                ['Database',$local_method,'show_database_menu'],
                ['break']
             */
    public function  __construct(){

    }
    public function main_menu(){
        $menu_options=[
            ['ROBOAMP Code Generator',$this->local_method,'roboamp_code_generator',$this->cli],

            ['Make AMP Mailable',$this->local_method,'make_amp_mailable',$this->cli],
            ['Check for ROBOAMP Code',$this->local_method,'check_for_roboamp_code',$this->cli],

            ['Add Google Analytics Code',$this->local_method,'add_analytics_code_to_property',$this->cli],
            ['HTML to Blade',$this->local_method,'HTML_to_blade',$this->cli],
            ['ENV',$this->local_method,'activate_property_menu',$this->cli],
            ['Stripe',$this->local_method,'URL_options',$this->cli],
            ['Database',$this->local_method,'create_triggers',$this->cli],
            ['break']

        ];

        return $menu_options;
    }

    public function make_amp_mailable($res=null){
        dd($res,'from make amp mailable');
        $this->setupCli($res);
        dd($this->cli->output->ask('something'));

        $email=$this->cli->ask("Please type you Customer's EMAIL:   ",null,null);

        dd($email);
        /*if($res==instanceof('App\MyClasses\Cli\Cli')){
            dd("instance");
        }dd('no instance');
        */


dd($res);
        dd(isset($res[1]));
       $tmp_cli=(isset($res[1])?$res[0]:$res);
        dd($tmp_cli);
        $this->cli=$res;
    }
    private function setupCli($res){
       // dd($res);

        if(($res instanceof Cli)){
            $this->cli=$res;
        }else{

            $output=$res[0]->output;
            $input=$res[0]->input;

            $helper = $res[0]->helper;
            //$question = new ConfirmationQuestion('Continue with this action?', false);
            $res[0]->ask('bananas','no');
            $output->ask('something');
            /*
            if (!$helper->ask($input, $output, $question)) {
                return;
            }
            */
            dd('done');



            dd($output);
            $output->ask('ouppies?');
        }
        dd($res);

        dd('end');
       // $this->cli=?$res:$res[0];


        $this->cli->output=$res[0]->output;
        $this->cli->ask('nono','OK');
        dd($this->cli);

    }

    public static function change_from_http_to_https_options(){
        //get a list of all the available properties

        Page::update_protocol_to_https('e88d8d9a-77fc-4bef-9568-4a610bd1debf');
    }

    public static function update_property_url_options(){

        $cliProperty=new CliProperties();

        $callback="update_property_url";

        return self::setup_property_menu($callback);
    }
    public static function update_property_domain_options(){


        $callback="update_property_domain";
        return self::setup_property_menu($callback);
    }


    private static function setup_property_menu($callback){

        $cliProperty=new CliProperties();

        $data['question']="Select a property";
        $data['callback']=$callback;

        $data['menu']=true;
        $data['menu_options']=$cliProperty->list_active_properties();
        $data['properties']=$cliProperty->properties;
        return $data;
    }
    public function curl_options(){


        //*TODO

        $this->options=["a","b","c","d"];

        $this->show_menu($this->options);

        $d=$this->output->ask("select an option");


        dd($d);

        /*
         * 1-select property - it will only list active properties
         * 2-select page to scrap info from
         * 3-select div where to scrap info from
         * 4-create a new div target
         *
         */

    }

    public function roboamp_code_generator($res=null){
        if(($res instanceof Cli)){
            $this->cli=$res;
        }else{
            $property=Property::where('id',$res[1])->first();
            $data=RoboCode::all($property);

            $property_domain=$data['property_domain'];

            $template= new Templates();
            $template_source= $template->get_template('ROBOAMP_Code',1);
            $template_destination=Paths::path_to_folder('properties')."/".$property_domain."/reports/ROBOAMP_code.html";




            $template->move_template($template_source,$template_destination,$data);

            dd('file://'.$template_destination);
        }
        $ask=new Ask($this->cli);
        $ask->select_property('roboamp_code_generator',$this);


    }

    //$property is a Property record, if not $property is passed,
    //returns info about the ROBOAMP code, if found.

    public function check_for_roboamp_code(){

        $url='https://www.mansfield-dentalcare.com/';
        $url=(new URL())->check_for_roboamp_code($url);
        dd($url);
    }
    public function generate_ROBOAMP_code($property_id){
        dd('generating code for ',$property_id,__METHOD__);
    }


}

