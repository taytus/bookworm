<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\MyClasses\Seeders;
use App\MyClasses\Server;
use ROBOAMP\DB; as myDB;
use ROBOAMP\MyArray;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run(){
        $server=new Server();

        $now = new Carbon();
        $faker = Faker\Factory::create();

        myDB::truncate('customers');
        $customer= factory(App\Customer::class,10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $seeders= new Seeders();
        $server=new Server();

        $now= Carbon::now();

        $password=bcrypt('secret');
        $lou_id='22d45b49-2fb3-4383-9567-960d484da5ed';
        $lou_password=bcrypt($lou_id);

        $customers=[
            ['id'=>'576c9280-aa06-11e8-9567-eb75f8141c96','name'=>'Kevin Vela','email'=>'kvela@velawoodlaw.com','user_id'=>3,'password'=>$password],
            ['id'=>'576db110-aa06-11e8-a28b-f3947673e28c','name'=>'kreativewebworks','email'=>'customer@roboamp.com','user_id'=>3,'password'=>$password],
            ['id'=>'d99903e7-eb32-4183-845c-23b60a20b5ae','name'=>'treexor','email'=>'diego.v@treexor.com','user_id'=>3,'password'=>$password],
            ['id'=>'0c8944c4-9fb2-4014-833b-4167fa631154','name'=>'Gamestop','email'=>'contact@gamestop.com','user_id'=>3,'password'=>$password],
            ['id'=>'89dd7688-b3d2-415d-8823-b12a2456e2ef','name'=>'American','email'=>'contact@american.com','user_id'=>3,'password'=>$password],
            ['id'=>'bc54ab9a-5cf5-4c7c-bea4-2b40d7a95da7','name'=>'Reap Marketing','email'=>'brice@reapmarketing.com','user_id'=>3,'password'=>$password],

            ['id'=>'822e87a2-2fb1-49d6-94e5-c490d81d6d96','name'=>'Gordon Daugherty','email'=>'gordondaugherty@capitalfactory.com','user_id'=>3,'password'=>$password],
            ['id'=>$lou_id,'name'=>'Lou Garcia','email'=>'lou@lgnetworksinc.com ','user_id'=>3,'password'=>$lou_password],
            ['id'=>'fa4ab750-6209-4755-a3bf-521682a94f51','name'=>'SignUp','email'=>'lou@lgnetworksinc.com ','user_id'=>3,'password'=>$password],
            ['id'=>'4b2e76c5-3e76-4f2e-b79c-128170265e78','name'=>'Testing','email'=>'roberto@roboamp.com ','user_id'=>3,'password'=>$password],

//
        ];



        if($server->testing_server()) {


            MyArray::create_items_from_array('App\Customer', $customers);


            factory(App\User::class, 10)->create()->each(function ($u) {
                $seeders = new Seeders();
            });

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        }

    }
}
