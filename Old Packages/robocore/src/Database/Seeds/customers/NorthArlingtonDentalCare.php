<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class NorthArlingtonDentalCare extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){
        $now=time();
        $property_root_url="https://www.northarlingtondentalcare.com";
        $property_id='6365b064-fe51-4f17-a2ba-d2c1f4802309';
        //https://www.northarlingtondentalcare.com/
        $pages=[


            ['id'=>'31047299-151b-4b28-9691-bfa9eed498f7','url'=>urlencode($property_root_url),'name'=>'index','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],


            //have to update these IDS

            ['id'=>'3db87918-1b2b-4b49-995e-77f5781890b7','url'=>urlencode($property_root_url.'/team'),'name'=>'team','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'21d0d6b8-d625-403d-9baa-4e96d97cec63','url'=>urlencode($property_root_url.'/services'),'name'=>'services','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'34df9cdc-3d1e-452f-822f-a997e1ee4120','url'=>urlencode($property_root_url.'/patient-information/patient-education'),'name'=>'patient-education','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'90518e4e-d6cc-4b2f-abe0-1f9299d0aea6','url'=>urlencode($property_root_url.'/patient-information/membership'),'name'=>'membership','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'14e426ef-6f65-423f-a82b-b27262d89f10','url'=>urlencode($property_root_url.'/patient-information/financing'),'name'=>'financing','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'d71149d3-1512-458a-b352-561d36231381','url'=>urlencode($property_root_url.'/patient-information/online-payment'),'name'=>'payment','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'3b8ca9b5-df55-476b-81da-34c80ccc7cc0','url'=>urlencode($property_root_url.'/appointments'),'name'=>'appointment','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],


            ['id'=>'df1bce3b-26d8-4084-9946-357508c42cdd','url'=>urlencode($property_root_url.'/patient-education/online-patient-forms'),'name'=>'online-patient-forms','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'cf7ed852-e4d1-4e90-b768-b15895079263','url'=>urlencode($property_root_url.'/patient-information'),'name'=>'patient-information','property_id'=>$property_id,'created_at'=>$now,'updated_at'=>$now],




            /*
                         *











            cfccad53-5e91-43dd-898e-be0cdbc75511

            89c0028b-dacd-40d8-b4d4-7db73160ba40

            52726f94-8538-4d47-99a2-8d8765cdf3bf

            ce4b67a6-50a6-4812-8376-3a69ca1abb16

                         */


        ];
        return $pages;
    }

}