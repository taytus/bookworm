<?php

namespace customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;



class StandishSeeder extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()
private $property_id = 'c5c60070-ce72-11e7-bcde-9b4153c2a21e';
private $table="pages";
private $url="https%3A%2F%2Fstandishsalongoods.com";
private $now;


    public function run()
    {

        $this->now = new Carbon();


        //clean up any records with same property_id

        DB::table($this->table)->where('property_id', $this->property_id)->delete();


        DB::table($this->table)->insert(['id' => (string)Uuid::generate(),
            'property_id' => $this->property_id,
            'name' => 'index',
            'label' => 'HOME',
            'parent_id' => 0,
            'url' => $this->url,
            'created_at' => $this->now,
            'updated_at' => $this->now,]);
        //Main menu
        $this->create_main_menu();

    }

    private function create_main_menu(){
        $arr_childs=[
            ['name'=>'standish-salon-equipment-sale','label'=>'Deals'],
            ['name'=>'#','label'=>'Salon'],
            ['name'=>'#','label'=>'Spa'],
            ['name'=>'#','label'=>'Tanning'],
            ['name'=>'#','label'=>'Brands'],
            ['name'=>'salon-equipment-financing','label'=>'Buy Now, Pay Later'],
            ['name'=>'#','label'=>'Why Buy Standish?'],
            ['name'=>'#','label'=>'Freebies'],
            ['name'=>'blog.asp','label'=>'Blog'],



        ];
        $this->generate_links($arr_childs);
        $this->add_extra_pages();
    }
    private function generate_links(array $array_with_links){

        foreach ($array_with_links as $menu){

            DB::table($this->table)->insert([
                'id' => (string)Uuid::generate(),
                'property_id' => $this->property_id,
                'name' => $menu['name'],
                'label'=>$menu['label'],
                'parent_id' => 0,
                'url' => $this->url."%2F".$menu['name'],
                'created_at' => $this->now,
                'updated_at' => $this->now,]);
        }

    }
    private function add_extra_pages(){
        $arr_pages=[
            ['name'=>'hair-salon-chairs','label'=>'Chairs','parent_id'=>'877b56e0-1716-11e8-b707-a3d5bf7909e9'],

        ];

        foreach ($arr_pages as $page){

            DB::table($this->table)->insert([
                'id' => (string)Uuid::generate(),
                'property_id' => $this->property_id,
                'name' => $page['name'],
                'label'=>$page['label'],
                'parent_id' => $page['parent_id'],
                'url' => $this->url."%2F".$page['name'],
                'created_at' => $this->now,
                'updated_at' => $this->now,]);
        }

    }

}