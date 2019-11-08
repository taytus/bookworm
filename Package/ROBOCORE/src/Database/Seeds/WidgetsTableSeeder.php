<?php

use Illuminate\Database\Seeder;
use App\Widget;
use ROBOAMP\DB; as myDB;

class WidgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $table="widgets";
        $now=new \Carbon\Carbon();


        myDB::truncate('widgets');

        $widgets=[
            ['name'=>'widget1','table'=>'property','type'=>'monthly','goal'=>60,'label'=>'Property Goal','color'=>'#FF6C60','created_at'=>$now,'updated_at'=>$now],
            ['name'=>'widget2','table'=>'user','type'=>'monthly','goal'=>30,'label'=>'User Goal','color'=>'#6CCAC9','created_at'=>$now,'updated_at'=>$now],
            ['name'=>'widget3','table'=>'customer','type'=>'monthly','goal'=>40,'label'=>'Customer Goal','color'=>'#3DB0FE','created_at'=>$now,'updated_at'=>$now],

        ];

        $j=0;
        foreach ($widgets as $item){
            $widget = new Widget();
            foreach ($item as $obj =>$val){
                $widget->$obj=$val;

            }
            $widget->save();

        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }
}
