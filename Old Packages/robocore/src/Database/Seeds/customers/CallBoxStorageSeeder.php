<?php

namespace customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class CallBoxStorageSeeder extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run()
    {

        $table="pages";

        $now=time();

        $property_id = 'f283105c-f439-4bda-9924-6a8cd9ab938f';

        //clean up any records with same property_id

        DB::table($table)->where('property_id',$property_id)->delete();


        DB::table($table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $property_id,
            'name' => 'index',
            'label'=>'HOME',
            'parent_id' => 0,
            'url' => 'http%3A%2F%2Fcallboxstorage.com%2Findex',
            'created_at' => $now,
            'updated_at' => $now,]);


        DB::table($table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $property_id,
            'name' => 'features-and-pricing',
            'label'=>'FEATURES & PRICING',
            'parent_id' => 0,
            'url' => 'http%3A%2F%2Fcallboxstorage.com%2Ffeatures-and-pricing',
            'created_at' => $now,
            'updated_at' => $now,]);

        DB::table($table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $property_id,
            'name' => 'solutions',
            'label'=>'SOLUTIONS',
            'parent_id' => 0,
            'url' => 'http%3A%2F%2Fcallboxstorage.com%2Fsolutions',
            'created_at' => $now,
            'updated_at' => $now,]);

    }

}