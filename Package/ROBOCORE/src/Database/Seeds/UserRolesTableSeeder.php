<?php

namespace roboamp\robocore\Database\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use roboamp\DB as myDB;
use Illuminate\Support\Facades\DB;
class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        $now=Carbon::now();
        $table='user_roles';
        myDB::truncate($table);

        $statuses=['user','partner','admin'];

        foreach ($statuses as $status){
            DB::table($table)->insert(['name'=>$status,'created_at'=>$now,'updated_at'=>$now]);
        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
