<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class AmericanReceivable extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){

        $now=time();
        $property_id='b095d582-1417-45b8-9f96-d761776e9d6a';
        $main_domain='https://americanreceivable.com';

        $pages=[
                ['id'=>'315cf007-fafa-4f4c-b895-f73ab743face','url'=>urlencode($main_domain),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'b095d582-1417-45b8-9f96-d761776e9d6a','url'=>urlencode($main_domain.'/index'),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'2497c3bd-c45d-485d-b69e-b494ff0001ef','url'=>urlencode($main_domain.'/application-for-factoring'),'property_id'=>$property_id,'name'=>'application-for-factoring','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'7f0aa930-8d65-4e5c-b732-63f1dcd08b58','url'=>urlencode($main_domain.'/how-does-factoring-work'),'property_id'=>$property_id,'name'=>'how-does-factoring-work','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'9d3b7b36-4163-4a72-94c5-eed9e1430f30','url'=>urlencode($main_domain.'/about-us'),'property_id'=>$property_id,'name'=>'about-us','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'516b16ca-2df4-47e6-8e50-435c4af2ea67','url'=>urlencode($main_domain.'/what-makes-us-stand-out'),'property_id'=>$property_id,'name'=>'what-makes-us-stand-out','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'bd229a7-487b-4faa-ada5-724add17cca31','url'=>urlencode($main_domain.'/testimonials'),'property_id'=>$property_id,'name'=>'testimonials','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'cce5f6f8-2721-4922-bfe8-6d873c98974e','url'=>urlencode($main_domain.'/what-is-invoice-factoring'),'property_id'=>$property_id,'name'=>'what-is-invoice-factoring','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'4525e8d5-4a8f-421b-9ef1-606029eeed1e','url'=>urlencode($main_domain.'/about-factoring-terminology'),'property_id'=>$property_id,'name'=>'about-factoring-terminology','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'00d8b906-7b3c-4ddc-a7f2-b3df22177f4d','url'=>urlencode($main_domain.'/quick-quote-for-factoring-2'),'property_id'=>$property_id,'name'=>'quick-quote-for-factoring-2','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'0c55d95a-d8a3-4983-84f8-a53d0cb782a6','url'=>urlencode($main_domain.'/blog-page-10-2-2'),'property_id'=>$property_id,'name'=>'blog-page-10-2-2','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'fea13a87-f430-4a92-a0f6-c6627b91ca27','url'=>urlencode($main_domain.'/faq'),'property_id'=>$property_id,'name'=>'faq','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'5d3dff8f-562a-45b5-a3a7-46b2344f1243','url'=>urlencode($main_domain.'/contact-us'),'property_id'=>$property_id,'name'=>'contact-us','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'c650a21c-7935-40ee-9687-ac8bcf88cb5a','url'=>urlencode($main_domain.'/brokers'),'property_id'=>$property_id,'name'=>'brokers','created_at'=>$now,'updated_at'=>$now],

        ];
        return $pages;
    }

}