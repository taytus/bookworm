<?php

namespace App\MyClasses;

use App\MyClasses\TemplatesInterface;
use App\Partials\Footer;
use App\Events\FooterUpdate;
use App\MyClasses\Cleanup;


class Render {

    private $name;
    public function __construct($section,$name){

        $collection= call_user_func('App\Partials\\'. ucfirst($section).'::all');

        foreach ($collection as $partial){
            $event= 'App\Events\\'.ucfirst($section).'Update';

            $reflect=new \ReflectionClass($event);

            event($reflect->newInstance($partial['id']));

        }

    }



}