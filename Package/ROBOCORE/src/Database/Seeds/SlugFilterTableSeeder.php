<?php

use Illuminate\Database\Seeder;
use ROBOAMP\DB; as myDB;
use App\Page;
use database\seeds\PagesDataSeeder;
use App\Template;
use ROBOAMP\Git;
use App\Includes;


class SlugFilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $pages_array;
    private $templates_array;
    private $includes_array;
    public function run(){

        $table="slug_filters";myDB::truncate($table);
        $slug_model="App\SlugFilter";
        $now=time();


        $slugs_array=[
            ['property_id'=>'3a256d94-c27c-46a3-b466-ff90709c0277','slug'=>'blog','position'=>1],
        ];


        Git::create_items_from_array($slug_model,$slugs_array);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ;

    }
}
