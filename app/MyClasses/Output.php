<?php

namespace App\MyClasses;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use File;
use View;



class Output {

    public static $table="pages";
    public static $demo=1;
    public $property_error_page;
    private $testing_server;
    private $data;

    public function __construct($server=false){
        $this->testing_server=$server;
    }

    //receives a Pages element
    public function render($page,$property,$dev=0,$test=0){
        $this->property_404=$property->error_page;
        $data=$this->setup_data($page,$property);
        //returns views with prefix test if /test is send instead of /amp
        $data['page_name']=($test?"test_".$data['page_name']:$data['page_name']);
        return $this->get_view($data,$dev);

    }
    //if we are in a testing server and the view cannot be found,
    //display a message
    public function get_view($data,$dev){
        $view_path=$this->get_view_path($data,$dev);
        if(view()->exists($view_path,$data)) {
            return view($view_path,$this->data);
        }else{

            if($this->testing_server){
                $error_message='Property and Page exist but View couldn\'t be found';
                $error_message.='<br>'.$view_path;
            }else{
                $error_message="Page not found";
            }

            return Errors::abort(404,$error_message,$this->property_error_page);

        }
    }
    public function get_view_path($data,$dev=0,$test=null){
        $view_path=($test?config('view.paths')[3]:config('view.paths')[2]);
        $data['property_url']=URL::get_domain($data['property_url']);
        $folder_to_property=$view_path."/properties/{$data['property_url']}";
        $my_view=View::addNamespace($data['property_url'],$folder_to_property);

        View::addNamespace('includes',$folder_to_property."/includes/");

       //     View::addNamespace($data['property_url'],$folder_to_property."/trigger");
        $hints=$my_view->getFinder()->getHints();

        $true_path_to_view=$hints[$data['property_url']][0];
        $this->data['view']['Folder to Property']=$folder_to_property;
        $this->data['view']['Property Namespace']=$data['property_url'];
        $this->data['view']['Folder to View']=$true_path_to_view;
        $this->data['view']['Paths Matches']=($true_path_to_view==$folder_to_property);
        $this->data['path_to_assets']=asset('/properties/'.$data['property_url']);
        $this->data['property_domain']=$data['property_url'];

        $view="{$data['property_url']}::{$data['page_name']}";
        return $view;
    }
    public static function get_top_menu($property_id){
       return DB::table(self::$table)
            ->where('property_id',$property_id)
            ->where('parent_id',0)
            ->get();
    }


    public static function running_demo($url){

        if(URL::get_domain($url)=="callboxstorage.com") {

            $myfile = base_path('public/Templates/CallboxStorage.amp');

            if (File::exists($myfile) && self::$demo) {
            } else {

                abort(404);
            }
        }
    }

    private function bot_detected() {

        return (
            isset($_SERVER['HTTP_USER_AGENT'])
            && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
        );
    }
    private function setup_data($page,$property){

        $url=new URL();
        $data['property_id']=$property->id;
        $data['includes']='properties/'.$property->id.'/includes/';
        $data['customer_id']=$property->customer_id;
        $data['base_url']=URL('/')."/";
        $data['canonical']=$page->canonical;
        $data['page_name']=$page->name;
        $data['property_url']=$property->url;
        $data['img']=asset('properties/'.$property->id.'/img/');
        $data['amp_url']=$url->make_amp_url($page->property_id,$page->url,null,true,false);
        $data['root_amp_url']=$url->root_amp_url;
        $data['active_page']=array_slice(explode('%2F', $page->url), -1)[0];
        $data['going_live_date']=new Carbon('tomorrow');
        //$data['going_live_date']="December 31, 2017 00:00:00";
        $data['analytics']=$property->google_analytics;
        $this->data=$data;
        return $data;
    }


}