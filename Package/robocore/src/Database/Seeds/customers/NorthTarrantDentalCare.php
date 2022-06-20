<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class NorthTarrantDentalCare extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){
        $now=time();
        $property_root_url="https://www.northtarrantdentalcare.com";
        $property_id='eb7355bf-9684-4d1e-b876-5ddea4765642';
        $pages=[


            ['id'=>'10be93f0-55f5-4b90-a371-11a54063d7f6','url'=>urlencode($property_root_url),'name'=>'index','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],


            //have to update these IDS

            ['id'=>'0d8af8dd-1b10-4c20-a3b9-1b95e2feb187','url'=>urlencode($property_root_url.'/team'),'name'=>'team','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'bfa26ba2-4076-4e96-9dee-969ac664ae2b','url'=>urlencode($property_root_url.'/services'),'name'=>'services','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'469344cb-5591-4392-82b7-2596681bf74b','url'=>urlencode($property_root_url.'/patient-information/patient-education'),'name'=>'patient-education','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'9e98e0ad-b1ca-4f4f-b586-0261c4294013','url'=>urlencode($property_root_url.'/patient-information/membership'),'name'=>'membership','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'2df58525-84c8-4299-885d-eae937c6e516','url'=>urlencode($property_root_url.'/patient-information/financing'),'name'=>'financing','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3ae5c368-da8b-4980-85ed-50e26d6fe2ad','url'=>urlencode($property_root_url.'/patient-information/online-payment'),'name'=>'payment','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'d97d6883-bdb9-4546-b4ad-a018b919a44d','url'=>urlencode($property_root_url.'/appointments'),'name'=>'appointment','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],


            ['id'=>'81dbe4c1-7272-43d9-a1b4-79b6651f3c77','url'=>urlencode($property_root_url.'/patient-education/online-patient-forms'),'name'=>'online-patient-forms','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'e5b0361d-b2b2-4393-bbb4-0fe077fc9da2','url'=>urlencode($property_root_url.'/patient-information'),'name'=>'patient-information','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],



        ];
        return $pages;
    }

}