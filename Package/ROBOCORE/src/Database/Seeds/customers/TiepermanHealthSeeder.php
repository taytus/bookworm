<?php

namespace customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;



class TiepermanHealthSeeder extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()
private $property_id = 'e88d8d9a-77fc-4bef-9568-4a610bd1debf';
private $table="pages";
private $url="https%3A%2F%2Ftiepermanhealth.com";
private $now;


    public function run()
    {

        $this->now=new Carbon();






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



        DB::table($this->table)->insert([
            'id' => (string)Uuid::generate(),
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

           DB::table($this->table)->insert([
               'id' => (string)Uuid::generate(),
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


        DB::table($this->table)->insert([
            'id' =>(string)Uuid::generate(),
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

            DB::table($this->table)->insert([
                'id' => (string)Uuid::generate(),
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