<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Seeders;
use Carbon\Carbon;
use App\User;
use App\MyClasses\Server;
use ROBOAMP\DB; as myDB;
use ROBOAMP\MyArray;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run($stripe_debug)
    {
        $seeders= new Seeders();
        myDB::truncate('users');

        $lou_id='$2y$10$OEXDIJoXw.yp/5pvSCr6.uttfwYnrEiB016b4MKVWZsGB3eE7FF9q';
        $lou_password=bcrypt($lou_id);

        $tiffany_password=bcrypt('$2y$10$ZgGbIVoQxDjtBOo/.1zCjej9gAvg9H8MKoPZTzUuE6bYI45uaLQ0C');






        $password=bcrypt('seeding_it');

        $users=[
            ['name'=>'Admin','email'=>'admin@roboamp.com','user_role_id'=>1,'password'=>$password],
            ['name'=>'Roberto','email'=>'roberto@roboamp.com','user_role_id'=>3,'password'=>$password],

            ['name'=>'Lou Garcia','email'=>'lou@lgnetworksinc.com','user_role_id'=>2,'password'=>$lou_password],

            ['name'=>'Tiffany Boyle','email'=>'tiffany@reapmarketing.com','user_role_id'=>2,'password'=>$tiffany_password],


            ['name'=>'Kevin Vela','email'=>'kvela@velawoodlaw.com','user_role_id'=>1,'password'=>$password],

            ['name'=>'TGMA','email'=>'tgma@tgma.com','user_role_id'=>1,'password'=>$password],
            ['name'=>'Kim Langston','email'=>'kim@oskyblue.com','user_role_id'=>1,'password'=>$password],
            ['name'=>'Kyle Bainter','email'=>'kbainter@callboxstorage.com','user_role_id'=>1,'password'=>$password]
        ];


        $server=new Server();

        $now= Carbon::now();

        if($server->testing_server()) {


            MyArray::create_items_from_array('App\User', $users);


            factory(App\User::class, 10)->create()->each(function ($u) {
                $seeders = new Seeders();
            });

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }




    }
}
