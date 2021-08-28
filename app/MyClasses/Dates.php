<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 8/15/18
 * Time: 5:53 AM
 */

namespace App\MyClasses;

use Carbon\Carbon;

class Dates {

    /**
     * Method to generate random date between two dates
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return bool|string
     */
    public static function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s')
    {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);
        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);
        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }
    public static function timestamp_to_date($timestamp){
        return Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
    public static function date_to_timestamp($date){
        return Carbon::createFromFormat('Y-m-d H:i:s',$date)->timestamp;
    }
    public static function carbon_to_mysql_date($date){
        return $date->toDateTimeString();
    }
    public static function mysql_date_to_carbon($mysql_date){
        return new Carbon($mysql_date);
    }
    public static function time_to_local_time(Carbon $time){
        return $time->config('app.timezone');
    }

    public static function days_since($start_time,$end_time=null){

        if(!$start_time instanceof Carbon)$start_time=self::mysql_date_to_carbon($start_time);

        if(is_null($end_time))$end_time=Carbon::now(config('app.timezone'));
        return $start_time->diffInDays($end_time);
    }




} 