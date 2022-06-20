<?php

namespace customers;
use App\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;



class CustomerSeeder extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()
private $property_id;
private $table="pages";
private $url="https%3A%2F%2Ftiepermanhealth.com";
private $now;


    public function run()
    {
        $this->property_id=Uuid::generate();
        $this->now=new Carbon();

        $customers=[
            ['url'=>'https://www.kreativewebworks.com','seeder'=>1,'steps_id'=>1,'id'=>'c5c30070-ce72-11e7-acde-9b4153c2a21e','customer_id'=>'576db110-aa06-11e8-a28b-f3947673e28c','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://mortalwar.com/2018/10/04/hello-world','seeder'=>1,'steps_id'=>1,'id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','customer_id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'coravana.com','seeder'=>1,'steps_id'=>1,'id'=>'1262c4a8-0441-462b-a036-fe596051898b','customer_id'=>'d99903e7-eb32-4183-845c-23b60a20b5ae','status_id'=>1,'subdomain_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'gamestop.com','seeder'=>1,'steps_id'=>1,'id'=>'b03d9340-b144-4e38-888d-38901a6b6a3a','customer_id'=>'0c8944c4-9fb2-4014-833b-4167fa631154','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://americanreceivable.com/','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'b095d582-1417-45b8-9f96-d761776e9d6a','customer_id'=>'89dd7688-b3d2-415d-8823-b12a2456e2ef','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],


        ];
        $j=0;
        foreach ($customers as $item){
            $customer = new Customer();
            foreach ($item as $obj =>$val){
                $customer->$obj=$val;

            }
            $customer->save();

        };










        //clean up any records with same property_id

        DB::table($this->table)->where('property_id',$this->property_id)->delete();


        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'index',
            'label'=>'HOME',
            'parent_id' => 0,
            'url' => $this->url,
            'created_at' => $this->now,
            'updated_at' => $this->now,]);


        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'about-us',
            'label'=>'ABOUT US',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fabout-us',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);




       $this->insert_conditions_childs();
       $this->insert_treatments_childs();







        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'chiropractor-staff-frisco-tx',
            'label'=>'STAFF',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fchiropractor-staff-frisco-tx',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);

        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'chiropractor-office-forms',
            'label'=>'NEW PATIENTS',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fchiropractor-office-forms',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);

        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'chiropractor-reviews-frisco-tx',
            'label'=>'TESTIMONIALS',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fchiropractor-reviews-frisco-tx"',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);

        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'chiropractic-offices',
            'label'=>'LOCATIONS',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fchiropractic-offices',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);

    }

    private  function insert_conditions_childs(){

        $id=(string)Uuid::generate();

        DB::table($this->table)->insert(['id' => $id,
            'property_id' => $this->property_id,
            'name' => 'chiropractic-conditions-frisco-tx',
            'label'=>'CONDITIONS',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fchiropractic-conditions-frisco-tx',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);

        //////CHILDS FROM CONDITIONS
        ///
        ///

       $arr_childs=[
           ['name'=>'work-accident-chiropractor-frisco-tx','label'=>'WORK RELATED INJURY'],
           ['name'=>'sports-injury-treatment-frisco-tx','label'=>'SPORTS INJURY'],
           ['name'=>'shoulder-pain-treatment-frisco-tx','label'=>'SHOULDER PAIN'],
           ['name'=>'neck-pain-injury-treatment-frisco-tx','label'=>'NECK PAIN'],
           ['name'=>'knee-pain-treatment-frisco-tx','label'=>'KNEE PAIN'],
           ['name'=>'hip-pain-treatment-frisco-tx','label'=>'HIP PAIN'],
           ['name'=>'headache-chiropractor-frisco-tx','label'=>'HEADACHES & MIGRAINE'],
           ['name'=>'disc-injury-treatment-frisco-tx','label'=>'DISC INJURY'],
           ['name'=>'back-pain-chiropractor-frisco-tx','label'=>'BACK PAIN'],
           ['name'=>'auto-accident-injury-chiropractor-frisco-tx','label'=>'AUTO ACCIDENT INJURY'],



       ];
       foreach ($arr_childs as $menu){

           DB::table($this->table)->insert(['id' => $id,
               'property_id' => $this->property_id,
               'name' => $menu['name'],
               'label'=>$menu['label'],
               'parent_id' => 0,
               'url' => $this->url."%2F".$menu['name'],
               'created_at' => $this->now,
               'updated_at' => $this->now,]);
       }


    }
    private  function insert_treatments_childs(){

        $id=(string)Uuid::generate();

        DB::table($this->table)->insert(['id' => $id,
            'property_id' => $this->property_id,
            'name' => 'chiropractor-frisco-medical-treatments',
            'label'=>'TREATMENTS',
            'parent_id' => 0,
            'url' => 'https%3A%2F%2Ftiepermanhealth.com%2Fchiropractor-frisco-medical-treatments',
            'created_at' => $this->now,
            'updated_at' => $this->now,]);



        //////CHILDS FROM CONDITIONS
        ///
        ///

        $arr_childs=[
            ['name'=>'prenatal-massage-frisco-tx','label'=>'PRENATAL MASSAGE'],
            ['name'=>'spinal-decompression-frisco-tx','label'=>'SPINAL DECOMPRESION'],
            ['name'=>'physical-therapy-frisco-tx','label'=>'PHYSIOTHERAPY'],
            ['name'=>'pain-management-treatment-frisco-tx','label'=>'PAIN MANAGEMENT'],
            ['name'=>'nutrition-center-frisco-tx','label'=>'NUTRITION'],
            ['name'=>'massage-center-frisco-tx','label'=>'MASSAGE'],
            ['name'=>'chiropractic-adjustments-frisco-tx','label'=>'CHIROPRACTIC ADJUSTMENTS '],
            ['name'=>'acupuncture-treatment-frisco-tx','label'=>'ACUMPUNTURE'],



        ];
        foreach ($arr_childs as $menu){

            DB::table($this->table)->insert(['id' => $id,
                'property_id' => $this->property_id,
                'name' => $menu['name'],
                'label'=>$menu['label'],
                'parent_id' => 0,
                'url' => $this->url."%2F".$menu['name'],
                'created_at' => $this->now,
                'updated_at' => $this->now,]);
        }


    }

}