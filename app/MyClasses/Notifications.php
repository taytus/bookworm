<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 8/23/18
 * Time: 9:23 AM
 */

namespace App\MyClasses;


class Notifications {

    public static function Hook($notification){

        $arr_notification_types=array('coupon','property');
        $event=null;

        foreach ($arr_notification_types as $notification_type){
            if(isset($notification->$notification_type)){
                $event=$notification->$notification_type;
                break;
            }
        }

        if(isset($event->notification_type)) {
            return env('SLACK_WEBHOOK_' . strtoupper($event->notification_type));
        }
    }
} 