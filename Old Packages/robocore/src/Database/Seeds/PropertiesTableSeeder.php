<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Seeders;
use App\Property;
use ROBOAMP\DB; as myDB;
use App\MyClasses\Directory;
class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $table="properties";
        $now=new \Carbon\Carbon();
        $seeders= new Seeders();
        $property_class=new Directory();

        myDB::truncate('properties');

        $properties=[
            ['url'=>'https://www.kreativewebworks.com','seeder'=>1,'steps_id'=>1,'id'=>'c5c30070-ce72-11e7-acde-9b4153c2a21e','customer_id'=>'576db110-aa06-11e8-a28b-f3947673e28c','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://mortalwar.com/2018/10/04/hello-world','seeder'=>1,'steps_id'=>1,'id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','customer_id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'coravana.com','error_page'=>'https://coravana.com/404','seeder'=>1,'steps_id'=>1,'id'=>'1262c4a8-0441-462b-a036-fe596051898b','customer_id'=>'d99903e7-eb32-4183-845c-23b60a20b5ae','status_id'=>1,'subdomain_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'gamestop.com','seeder'=>1,'steps_id'=>1,'id'=>'b03d9340-b144-4e38-888d-38901a6b6a3a','customer_id'=>'0c8944c4-9fb2-4014-833b-4167fa631154','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://americanreceivable.com','error_page'=>'https://americanreceivable.com/404','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'b095d582-1417-45b8-9f96-d761776e9d6a','customer_id'=>'89dd7688-b3d2-415d-8823-b12a2456e2ef','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://www.mansfield-dentalcare.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'8fc33172-1b47-4eb3-95b9-92e3d4007912','customer_id'=>'bc54ab9a-5cf5-4c7c-bea4-2b40d7a95da7','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://northtarrantdentalcare.com','google_analytics'=>'UA-65207414-4','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'eb7355bf-9684-4d1e-b876-5ddea4765642','customer_id'=>'bc54ab9a-5cf5-4c7c-bea4-2b40d7a95da7','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://northarlingtondentalcare.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'6365b064-fe51-4f17-a2ba-d2c1f4802309','customer_id'=>'bc54ab9a-5cf5-4c7c-bea4-2b40d7a95da7','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://shockwaveinnovations.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'7042e415-e19b-4511-8486-8de569b51ecd','customer_id'=>'bc54ab9a-5cf5-4c7c-bea4-2b40d7a95da7','status_id'=>5,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://www.lgnetworksinc.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'e3bc51a6-2923-4b5f-a4da-30cb5385b232','customer_id'=>'22d45b49-2fb3-4383-9567-960d484da5ed','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://signup.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'075c9bb1-678c-4986-9c64-05b43fa1c00d','customer_id'=>'fa4ab750-6209-4755-a3bf-521682a94f51','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],

            ['url'=>'https://www.redraideroutfitter.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'3a256d94-c27c-46a3-b466-ff90709c0277','max_slugs'=>4,'customer_id'=>'fa4ab750-6209-4755-a3bf-521682a94f51','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['url'=>'https://paynemitchell.com','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'0d578395-fb2f-40b6-9157-be772ba6312b','max_slugs'=>4,'customer_id'=>'fa4ab750-6209-4755-a3bf-521682a94f51','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],

            ['url'=>'http://127.0.0.1:8080/word','white_label'=>1,'seeder'=>1,'steps_id'=>1,'id'=>'3a256d94-4986-46a3-b466-ff90709c0277','customer_id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','status_id'=>1,'created_at'=>$now,'updated_at'=>$now],


        ];
        $j=0;
        foreach ($properties as $item){
            $property = new Property();
            foreach ($item as $obj =>$val){
                $property->$obj=$val;

            }
            $property->save();

            $property_class->create_folders_for_new_property($item['url']);

        };
        //call method to create triggers as when created via CLI
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       // $property= factory(App\Property::class,10)->create();


    }
}
