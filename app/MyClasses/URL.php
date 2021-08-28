<?php


namespace App\MyClasses;
use App\Property;
use ROBOAMP\URL as ROBOAMP_URL;
use App\Page;


/**
 * Class URL
 * @package App\MyClasses
 */
class URL extends ROBOAMP_URL {

    public static function decode_current_url(String $property_id=null){
        $full_url=parent::current();
        if(!is_null($property_id)){
            $str=$property_id."/";
            $url_pieces=explode($str,$full_url);

        }else{
            $server_url=config('app.url')."/";
            $url_pieces=explode($server_url,$full_url);
            if(!isset($url_pieces[1])){
                dd('app.url var has not been set');
            }
            $url_pieces=explode("/",$url_pieces[1]);
        }
        $url=$url_pieces[1]."//";
        for($j=3;$j<count($url_pieces);$j++){
            $url.=$url_pieces[$j]."/";
        }
        $url=trim($url,"//");

        return urldecode($url);

    }
    public function check_if_domain_exist_in_db($domain,$https=0){

        $property= new Property();
        $data=null;

        $full_url=$this->get_full_domain_with_scheme($domain,$https);

        $property_info=$property::where('url',$full_url)->first();

        $record_found=(!is_null($property_info)?count($property_info):0);



        $domain_info=new \stdClass();

        if(!$record_found && !$https){
            $data= $this->check_if_domain_exist_in_db($domain,1);
            return $data;
        }else{
            //second loop
            echo "Record found   = ". $record_found."\n\n";
            if($record_found){
                $domain_info->customer_id=$property_info->customer_id;
                $domain_info->property_id=$property_info->id;
                $domain_info->folder_name=$property_info->full_path_to_property_folder();
                $domain_info->schema=($https==0?'http://':'https://');

            }else{
                $domain_info->customer_id=null;
                $domain_info->schema='http://';

            }
            $domain_info->domain=$domain;
            $domain_info->full_url=$domain_info->schema.$domain_info->domain;





        }

        return $domain_info;
    }

    //TEST this method to see if is local
    public static function get_slug_by_number($segment_number){
       return request()->segment($segment_number);

    }
    public static function get_last_slug(){
        return self::get_slug_by_number(count(request()->segments()));
    }

    public static function get_first_slug(){
        return self::get_slug_by_number(1);
    }

    public static function get_slug_count(){
        return count(request()->segments());
    }
    public static function get_slugs($after_url=true){
        //remove the first too because
        // #1 is the property ID
        //#2 is the protocol
        //#3 is the URL
        $res=request()->segments();
        if(!$after_url) return $res;

        unset ($res[0]);
        unset ($res[1]);
        unset ($res[2]);


        return array_values ($res);


    }
    //////DEPENDENCIES ////
    //THESE ARE METHODS THAT NEEDS EXTRA PARAMS TO WORK

    public function make_amp_url_from_property($property_id,$url,$white_label=null){

        $property_url=Property::where('id',$property_id)->pluck('url')->first();
        $property_domain=parent::get_domain($property_url);

        return parent::make_amp_url($url,$property_domain,$property_id,$white_label);

    }

    public function make_amp_url_from_url($url,$force_roboamp=true){
        return parent::make_amp_url($url,null,null,false,$force_roboamp);
    }
    //local->dependency on page;
    public static function get_domain_from_property_id($property_id){
        $page=Page::where('property_id',$property_id)->first();
        return self::get_domain($page->url);
    }



}