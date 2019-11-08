<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class Coravana extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){
        $now=time();

        $property_id='1262c4a8-0441-462b-a036-fe596051898b';
        $main_domain="https://coravana.com";

        $pages=[
                //coravana
                ['id'=>'fa90b13f-23b8-4110-89ed-688a636dcdfc','url'=>$main_domain,'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'41aba0c2-7e5f-460a-9a6d-c530d354191c','url'=>urldecode($main_domain.'/products'),'property_id'=>$property_id,'name'=>'products','created_at'=>$now,'updated_at'=>$now],
                //forcing product page for testing
                ['id'=>'271bc021-2dec-461a-bf6c-db918ea87ace','url'=>urlencode($main_domain.'/collections/bracelets/products/daydream-leather-bracelet-black-gold?variant=19365921751104'),'property_id'=>$property_id,'name'=>'products','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'271bc021-2ced-461a-bf6c-db918ea87ace','url'=>urlencode($main_domain.'/form'),'property_id'=>$property_id,'name'=>'products','created_at'=>$now,'updated_at'=>$now],


        ];
        return $pages;
    }

}