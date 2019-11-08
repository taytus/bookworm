<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class LocalWordpress extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){

        $now=time();
        $property_id='3a256d94-4986-46a3-b466-ff90709c0277';
        $main_domain='http://127.0.0.1:8080/wording/';

        $pages=[
                ['id'=>'315cf007-4922-4f4c-b895-f73ab743face','url'=>urlencode($main_domain),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'315cf007-4822-4f4c-b885-f73ab743face','url'=>urlencode($main_domain),'property_id'=>$property_id,'name'=>'index2','created_at'=>$now,'updated_at'=>$now],

        ];
        $templates=[
            ['id'=>'c5c30070-ce72-11e7-acde-9b4153c2a21e','property_id'=>$property_id,'name'=>'index','signature'=>'','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','property_id'=>$property_id,'name'=>'general','signature'=>'<h2 class="comments-title" aria-hidden="true">Leave a comment</h2>','created_at'=>$now,'updated_at'=>$now]

        ];
        $includes=[];
        return array('pages'=>$pages,'templates'=>$templates,'includes'=>$includes);
    }

}