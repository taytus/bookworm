<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class MansfieldDental extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){
        $now=time();

        $property_id='8fc33172-1b47-4eb3-95b9-92e3d4007912';
        $property_root_url="https://www.mansfield-dentalcare.com";

        $pages=[
            ['id'=>'268dc37b-8daf-450c-9245-69aa102fd442','url'=>urlencode($property_root_url),'name'=>'index','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'a1ec9a06-5e54-4cc0-b2ec-192b8b369427','url'=>urlencode($property_root_url.'/team'),'name'=>'team','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'2ce40351-449e-4fc5-b797-b0bed7899d55','url'=>urlencode($property_root_url.'/services'),'name'=>'services','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'6ef06406-1914-4979-a72c-0f2ef94c9714','url'=>urlencode($property_root_url.'/patient-information/patient-education'),'name'=>'patient-education','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'8a088840-1a5c-437c-8c63-4ed6df542456','url'=>urlencode($property_root_url.'/patient-information/membership'),'name'=>'membership','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'cbb32aa1-f998-42b2-b789-73b8d7d5f65e','url'=>urlencode($property_root_url.'/patient-information/financing'),'name'=>'financing','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'578a3a27-156a-402a-9d6a-021e0e2d0dc8','url'=>urlencode($property_root_url.'/patient-information/online-payment'),'name'=>'online payment','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'117d259c-1850-4587-a55c-d95213f03a33','url'=>urlencode($property_root_url.'/appointments'),'name'=>'appointments','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3bc0ca23-8a8a-495a-8dd9-1615e220b74d','url'=>urlencode($property_root_url.'/patient-information/online-payment'),'name'=>'online payment','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'1b6c086a-0e8c-41c2-89ff-6028343d37b4','url'=>urlencode($property_root_url.'/patient-education/online-patient-forms'),'name'=>'online-patient-forms','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'62ebd78f-6531-43e0-8ef8-44d5f4134f6e','url'=>urlencode($property_root_url.'/patient-information'),'name'=>'patient-information','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
        ];
        return $pages;
    }

}