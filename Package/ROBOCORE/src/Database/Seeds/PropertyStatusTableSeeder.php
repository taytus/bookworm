<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use ROBOAMP\DB; as myDB;

class PropertyStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        $now=Carbon::now();
        $table='property_status';
        myDB::truncate('property_status');

        $statuses=['Active','Pending','Suspended','Canceled','Beta',];

        foreach ($statuses as $status){
            DB::table($table)->insert(['status'=>$status,'created_at'=>$now,'updated_at'=>$now]);
        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
