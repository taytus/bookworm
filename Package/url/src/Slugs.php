<?php


namespace ROBOAMP;


class Slugs
{
    public static function get_last_slug($url){
        return basename($url);
    }
    public static function get_slug_by_number($segment_number){
        return  request()->segment($segment_number);

    }
    public static function get_slugs($after_url=true){
        //remove the first two because
        //#1 is the property ID
        //#2 is the protocol
        //#3 is the URL
        $res=request()->segments();
        if(!$after_url) return $res;

        unset ($res[0]);
        unset ($res[1]);
        unset ($res[2]);

        return array_values ($res);

    }
    public static function get_first_slug(){
        return self::get_slug_by_number(1);
    }
    public static function get_slug_count(){
        return count(request()->segments());
    }
}
