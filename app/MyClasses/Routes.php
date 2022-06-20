<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 7/18/18
 * Time: 6:46 AM
 */

namespace App\MyClasses;
use App\MyClasses\Paths;
use App\MyClasses\Files;
use Route;


class Routes {

    //creates a route in the routes.php file
    public  function add_route(String $name = null,String $path,String $method,String $controller, String $middleware = null){
        $str="Route::get('".$path."', '".$controller."@".$method."')";

        $route_name=(!is_null($name)?$route_name="->name('".$name."');":";");

        $str.=$route_name;


        $path_to_file = Paths::path_to_file('routes');


        Files::add_line_to_file($path_to_file,$str);


    }
    public function has($route){
        return Route::has(($route));

    }



} 