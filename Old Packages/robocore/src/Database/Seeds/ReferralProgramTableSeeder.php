<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Seeders;
use Carbon\Carbon;
use ROBOAMP\DB; as myDB;
class ReferralProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        $now=Carbon::now();
        $table='referral_programs';
        $seeders= new Seeders();
        myDB::truncate('referral_programs');

        $names=['partners','customers'];

        foreach ($names as $name){
            DB::table($table)->insert(['name'=>$name, 'uri'=>'register/'.$name, 'lifetime_minutes'=> 10080, 'created_at'=>$now,'updated_at'=>$now]);
        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
