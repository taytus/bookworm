<?php


use ROBOAMP\MyArray;


class Server   {

    public $current_environment;
    public $info;
    public $local_server;
    //qa is when is ready to be pushed to production
    public $qa_server=false;
    //demo is for demo purposes, still needs more development
    // but we want to share progress
    public $demo_server=false;
    //for internal testing purposes only
    private $testing_server;
    public $enable_route=false;
    public $current_branch="";


    public function __construct($availabe_environments=null){

        $availabe_environments[]="local";

        $my_array=new MyArray();
        //all the branches this route will be available too
        $dev_branches=["testing","payne_mitchel","wp_engine"];
        $this->current_environment=env('APP_ENV');
        $this->current_branch=$this->get_git_branch();

        if($my_array->check_for_string_in_array($this->current_environment,$availabe_environments)){
            if($my_array->check_for_string_in_array($this->current_branch,$dev_branches)) {
                $this->enable_route=true;
            }
        }
        //dd($this->current_environment,$current_branch,$my_array->check_for_string_in_array($current_branch,$dev_branches));
        //dd('popo');



        // dd($this->current_environment);

        $this->testing_server=($this->current_environment=='live'?false:true);
        $this->info=$this->server_info();
        $this->local_server=$this->info['local_server'];
    }
    //anything that isn't "live" is a testing server
    public function testing_server(){

        return $this->testing_server;

    }

    public function get_private_stripe_key(){

        return ($this->testing_server()?env('TESTING_STRIPE_SECRET'):env('STRIPE_SECRET'));

    }
    public function get_public_stripe_key(){

        return ($this->testing_server()?env('TESTING_STRIPE_KEY'):env('STRIPE_KEY'));

    }
    public function get_prefix(){

        return ($this->testing_server()?'TEST_':'');
    }
    public function get_server_expected_environment(){
        $path=base_path();
        $home=explode("/",$path);
        switch($home[1]){
            case 'home':
                return $this->get_live_servers($home[3]);
                break;
            case 'Users':
                return 'local';
                break;

        }
    }

    public function correct_environment(){

        return ($this->current_environment==$this->get_server_expected_environment()?true:false);

    }
    private function get_live_servers($folder){
        switch($folder){
            case 'demo.speedy.com':
                return 'demo';
                break;
            case 'kanuca.com':
                return 'qa';
                break;
            case 'parser.roboamp.com':
                return 'parser';
            default:
                return 'live';
        }
    }




    public function server_info(){
        $data['correct_environment']=$this->correct_environment();
        $data['current_environment']=$this->current_environment;
        $data['testing_server']=$this->testing_server();
        $data['expected_environment']=$this->get_server_expected_environment();
        $data['app_url']=config('app.url');
        $data['local_server']=$this->is_local_server();

        return $data;
    }

    public function is_local_server(){
        // dd($this->current_environment);
        return ($this->current_environment=='local' && $this->get_server_expected_environment()=='local'?true:false);
    }

    public function get_git_branch(){
        $shellOutput = [];
        exec('git branch | ' . "grep ' * '", $shellOutput);
        foreach ($shellOutput as $line) {
            if (strpos($line, '* ') !== false) {
                return trim(strtolower(str_replace('* ', '', $line)));
            }
        }
        return null;
    }



}



