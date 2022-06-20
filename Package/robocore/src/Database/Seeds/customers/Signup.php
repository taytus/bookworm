<?php
namespace database\seeds\customers;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;



class Signup extends Seeder{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run()
    {

        $now=time();

        $property_id='075c9bb1-678c-4986-9c64-05b43fa1c00d';
        $property_root_url="https://signup.com/";

        $pages=[
            ['id'=>'aeb56fbb-e7b3-447a-b4e1-718146857e6b','url'=>urlencode($property_root_url."/Idea-Center"),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b83e6ed6-dbdb-4f32-b63c-de0ee381845b','url'=>urlencode($property_root_url.'/FamilyCodeNight'),'property_id'=>$property_id,'name'=>'FamilyCodeNight','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'6cc0c122-0c7d-4783-9a7f-642fee703e41','url'=>urlencode($property_root_url.'/Parent-Teacher-Conference'),'property_id'=>$property_id,'name'=>'Parent-Teacher-Conference','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'116a4dc7-36b8-4dfc-97a4-f14520351281','url'=>urlencode($property_root_url.'/classparty'),'property_id'=>$property_id,'name'=>'classparty','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'faa216bb-4bfe-47bc-81f4-81cf5e938110','url'=>urlencode($property_root_url.'/holiday'),'property_id'=>$property_id,'name'=>'holiday','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3f568e3f-9f28-4bb5-bff5-96ce6eae0cd9','url'=>urlencode($property_root_url.'/idea-center'),'property_id'=>$property_id,'name'=>'idea-center','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'d9db42ba-880a-41d5-9ce1-2b4333d9cce7','url'=>urlencode($property_root_url.'/potluck'),'property_id'=>$property_id,'name'=>'potluck','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'341f529b-6398-4fb0-863d-0739aa3cbea5','url'=>urlencode($property_root_url.'/school-activities'),'property_id'=>$property_id,'name'=>'school-activities','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3bd9d068-a75c-4a61-a41a-2e5f0f2a9cf9','url'=>urlencode($property_root_url.'/sign-up-sheet'),'property_id'=>$property_id,'name'=>'sign-up-sheet','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'ebf72d43-9caa-436b-b542-ed73e10110b2','url'=>urlencode($property_root_url.'/teacher-appreciation'),'property_id'=>$property_id,'name'=>'teacher-appreciation','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'663c0236-b720-4d2b-aee0-35ab73883d85','url'=>urlencode($property_root_url.'/volunteer-appreciation'),'property_id'=>$property_id,'name'=>'volunteer-appreciation','created_at'=>$now,'updated_at'=>$now],


        ];
        return $pages;

    }

}