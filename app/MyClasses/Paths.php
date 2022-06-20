<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 7/18/18
 * Time: 7:01 AM
 */

namespace App\MyClasses;


class Paths {

    public static function path_to_property($property_domain){
        return self::path_to_folder('Properties')."/".$property_domain;
    }
    public static function path_to_template($file,$folder=null){
        $path=(!is_null($folder)?ucfirst($folder)."/":"");
        return self::path_to_folder('Templates')."/".$path.$file.".blade.php";
    }

    public static function get_property_folder_from_file_path($file_path){
        $str=explode('.com/',$file_path);
        $str=$str[0].".com";
        return $str;
    }
    public static function path_to_folder(String $file_type){
        $file_type=ucfirst($file_type);
        $base_path= base_path();
        switch($file_type){

            case 'Routes':
                return $base_path."/routes/web.php";
                break;
            case 'Controller':
                return $base_path."/app/Http/Controllers";
                break;
            case 'View':
                return $base_path."/resources/views";
                break;
            case 'Dusk':
                return $base_path."/tests/Browser";
                break;
            case 'Test':
                return $base_path."/tests";
                break;
            case 'Parser':
                return $base_path."/parser";
                break;
            case 'Maker':
                return $base_path."/Maker";
                break;
            case 'Commands':
                return $base_path."/app/Console/Commands";
                break;
            case 'Customer':
                return $base_path."/customers";
                break;
            case 'Page':
                return $base_path."/customers/properties";
                break;
            case 'Templates':
                return $base_path."/app/Templates";
                break;
            case 'Robochrome':
                return $base_path."/ROBOChrome";
                break;
            case 'Dropbox';
                return  "/Users/taytus/Dropbox (ROBOAMP)/ROBOAMP Team Folder/";
                break;
            case 'Properties';
                return  $base_path."/parser/properties";
                break;



        }
    }


    public static function full_path_to_file($file_name,$file_type){

        $path=self::path_to_folder($file_type);
        $tmp_path=$path . "/" . $file_name;

        $path_info = pathinfo($tmp_path);

        $path_info['extension']=(!isset($path_info['extension'])?".php":"");

        $full_path_to_file =$tmp_path.$path_info['extension'];

        return $full_path_to_file;
    }

    public static function path_to_dashboard_resource($resource=null){

        if(is_null($resource))$resource='dashboard';

        switch($resource){
            case 'dashboard':
                return app_path('/dashboard');
                break;
        }




    }

} 