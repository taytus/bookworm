<?php

use Illuminate\Database\Seeder;
use App\Counter;
use ROBOAMP\DB; as myDB;

class CountersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $table="counters";
        $now=new \Carbon\Carbon();


        myDB::truncate('counters');

        $counters=[
            ['name'=>'counter1', 'user_id'=>'1', 'table'=>'property','type'=>'monthly','icon'=>'tags','label'=>'Properties','color'=>'#FF6C60','created_at'=>$now,'updated_at'=>$now],
            ['name'=>'counter2', 'user_id'=>'1', 'table'=>'customer','type'=>'monthly','icon'=>'shopping-cart','label'=>'Customers','color'=>'#3DB0FE','created_at'=>$now,'updated_at'=>$now]
        ];

        $j=0;
        foreach ($counters as $item){
            $counter = new Counter();
            foreach ($item as $obj =>$val){
                $counter->$obj=$val;

            }
            $counter->save();

        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }
}
