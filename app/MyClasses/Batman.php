<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 7/25/18
 * Time: 9:44 AM
 */

namespace App\MyClasses;

use ROBOAMP\Batman as RoboStrings;


class Batman extends RoboStrings{

    public static function sanitize_string($string){
        $res=str_replace("\t"," ",$string);
        $res=str_replace("\n", " ",$res);
        return $res;
    }

} 