<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Seeders;
use Carbon\Carbon;
use ROBOAMP\DB as myDB;
class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        $now=Carbon::now();
        $table='platforms';
        myDB::truncate($table);


        $seeders= new Seeders();

        $platforms=['Select your Platform','HTML','Wordpress', 'Squarespace', 'Tumblr', 'Blogger'];

        $j=1;
        foreach ($platforms as $platform){
            DB::table($table)->insert(['name'=>$platform,'id'=>$j,'created_at'=>$now,'updated_at'=>$now]);
            $j++;
        };



        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
