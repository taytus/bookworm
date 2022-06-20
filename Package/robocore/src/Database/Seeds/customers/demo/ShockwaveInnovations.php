<?php

namespace database\seeds\customers\demo;
use Illuminate\Database\Seeder;



class ShockwaveInnovations extends Seeder{


    public function run(){
        $now=time();

        $property_id='7042e415-e19b-4511-8486-8de569b51ecd';
        $main_domain='https://shockwaveinnovations.com';
        $pages=[
                ['id'=>'5e93ea16-7a5d-42ee-92bf-04eb7f69b864','url'=>urlencode($main_domain),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'6bd9b7aa-7630-47bd-9f32-a09be9f20c4b','url'=>urlencode($main_domain."/index"),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'49379ae7-44b3-4193-b07e-1070a468d5b8','url'=>urlencode($main_domain."/blog"),'property_id'=>$property_id,'name'=>'blog','created_at'=>$now,'updated_at'=>$now],


        ];
        return $pages;
    }

}