<?php

use Illuminate\Database\Seeder;
use ROBOAMP\DB; as myDB;

use App\Template;


class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){

        $table="templates";
        $now=new \Carbon\Carbon();

        myDB::truncate($table);

        $property_id='3a256d94-4986-46a3-b466-ff90709c0277';
       // $url='http://127.0.0.1:8000/amp/c5c30070-ce72-11e7-acde-9b4153c2a21e/index';
        //$page_id='de4a7958-8d40-4726-99fe-c2b0c24761b2';
       $templates=[
                ['id'=>'c5c30070-ce72-11e7-acde-9b4153c2a21e','property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','property_id'=>$property_id,'name'=>'general','created_at'=>$now,'updated_at'=>$now]

        ];

        $j=0;
        foreach ($templates as $item){
            $template = new Template();
            foreach ($item as $obj =>$val){
                $template->$obj=$val;
            }
            $template->save();
        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ;

    }

}
