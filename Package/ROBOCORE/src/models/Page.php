<?php

namespace ROBOAMP\ROBOCORE;

use Illuminate\Support\Facades\DB;
use ROBOAMP\CLI;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use ROBOAMP\Files;

class Page extends Model{
    //
    protected $table = "pages";

    protected $primaryKey = 'id';
    protected static $domain='https://roboamp.com/amp/';
    protected $keyType = 'string';
    public $incrementing = false;

    public function property(){

        return $this->belongsTo('App\Property','id','property_id');

    }

    /*
     * Receives an ID and returns all the URLs for that property
     */

    public static function get_all_urls(string $property_id){

        $urls=self::where('property_id','=',$property_id)->pluck('url')->all();

        return $urls;
    }

    public static function get_all_roboamp_urls(string $property_id){

        $urls=self::get_all_urls($property_id);

        foreach ($urls as &$url){

            $url = self::$domain.$property_id."/".$url;

        }

        return $urls;

    }
    public static function get_all_amp_urls(string $property_id){

        $urls=self::get_all_urls($property_id);

        foreach ($urls as &$url){

            $url = CLI::make_amp_url($property_id,urldecode($url));

        }

        return $urls;

    }
    public static function update_protocol_to_https(string $property_id){
        $urls=self::get_all_urls($property_id);

        foreach ($urls as $url){
            $tmp_url=str_replace('http%3A%2','https%3A%2',$url);
         //   dd($url);
            //$url = self::$domain.$property_id."/".$url;

            self::where('url',$url)->update(['url'=>$tmp_url]);
        }
    }
    public static function change_property_url(){
        dd("hello from page");
    }
    public static function search_page_by_name($name,$property_id){
        return self::where('name',$name)
            ->where('property_id',$property_id)
            ->first();
    }
    public function create_a_page_from_a_property($property,$create_folder=false){
        $now=Carbon::now();
        $page = new Page();
        $page->id=Uuid::generate(4);
        $page->property_id=$property->id;
        $page->name="index";
        $page->parent_id=0;
        $page->url=urlencode($property->url);
        $page->created_at=$now;
        $page->updated_at=$now;
        $page->save();


        //the folder is where the content is going to be stored

        if($create_folder){
            $file=new Files();

            $url=CLI::get_domain($property->url);

            //I want to save everything under the first website URL for each users

            $customer=new Customer();

            if($customer->demo_customer($property->customer_id)){


            }else{
                dd("this is NOT a demo customer");
            }

            //check if the customer's folder already exist, if not, create it
            if(!$file->folder_exist($property->customer_id,'Customer'))$file->create_folder($property->customer_id,'customer');

            $folder_name=$property->customer_id.'/'.$property->id;

            $file->create_folder($folder_name,'customer');

            $file->copy_template('new_page',$folder_name);

        }

        return $page->id->string;


    }

    public static function pages_from_active_properties(){

        return DB::table('pages')->select('pages.*')->where('pages.id','!=','1')
                ->leftJoin('properties','pages.property_id','properties.id')

        ->leftJoin('property_status','properties.status_id','property_status.id')->get()->toArray();

    }






}

