<?php

use Illuminate\Database\Seeder;
use ROBOAMP\DB; as myDB;
use App\Page;
use database\seeds\PagesDataSeeder;
use App\Template;
use ROBOAMP\Git;
use App\Includes;


class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $pages_array;
    private $templates_array;
    private $includes_array;
    public function run()
    {

        $table="pages";myDB::truncate($table);
        $table="templates";myDB::truncate($table);
        $table="includes";myDB::truncate($table);


        $now=time();


        //KEVIN
      //  $property_id='c5c30080-ce72-11e7-acde-9b4153c2a21e';
       // $url='http://127.0.0.1:8000/amp/c5c30070-ce72-11e7-acde-9b4153c2a21e/index';
        //$page_id='de4a7958-8d40-4726-99fe-c2b0c24761b2';
       $pages_array=[
                ['id'=>'c5c30070-ce72-11e7-acde-9b4153c2a21e','url'=>'https://www.kreativewebworks.com','property_id'=>'ef3dd872-cb1b-45aa-9aad-75e52f0e2f60','name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','url'=>'https%3A%2F%2Fmortalwar.com%2F2018%2F10%2F04%2Fhello-world','property_id'=>'c3d61bbe-3969-48c4-947a-6fc54dd3dbb8','name'=>'index','created_at'=>$now,'updated_at'=>$now],
                //gamestop
                ['id'=>'189f0be1-cbb1-4bd5-bd27-eb11ce28f652','url'=>'gamestop.com','property_id'=>'b03d9340-b144-4e38-888d-38901a6b6a3a','name'=>'index','created_at'=>$now,'updated_at'=>$now],
        ];
       $templates_array=[];
        

        
        $pages_seeder=PagesDataSeeder::data();
        $this->update_pages_array($pages_array,$pages_seeder);

       // dd($this->pages_array);
        $j=0;

        foreach ($this->pages_array as $item){
            $page = new Page();
            foreach ($item as $obj => $val) {
                $page->$obj = $val;
            }
            $page->save();
            echo "Page ID = ".$page->id."\n";
        };



        foreach ($this->templates_array as $item){
            $page = new Template();
            foreach ($item as $obj => $val) {
                $page->$obj = $val;
            }
            $page->save();
        };

        foreach ($this->includes_array as $item){
            $page = new Includes();
            foreach ($item as $obj => $val) {
                $val=(is_array($val)?json_encode($val):$val);
                $page->$obj = $val;
            }
            $page->save();
        };


       // dd($this->templates_array,$this->includes_array,$this->pages_array);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ;

    }
    //grabs the array content for each class inside seeds/customers
    //and return it so it can be added to the pages table
    public function update_pages_array($pages_array,$pages_seeder){
        $templates_array=[];
        $pages_array=[];
        $includes_array=[];
        foreach($pages_seeder as $property) {
            $new_pages = $property->run();

            //this means the seeder is  returning templates
            if (count($new_pages) == 3) {
                if(isset($new_pages['templates'])) {
                    $templates_array = Git::fill_array_with_array($new_pages['templates'], $templates_array);
                    $includes_array = Git::fill_array_with_array($new_pages['includes'], $includes_array);
                    foreach ($new_pages['pages'] as $item){
                        $pages_array[] = $item;
                    }
                }else{
                    $pages_array=Git::fill_array_with_array($new_pages,$pages_array);

                }
            }else{
                
                $pages_array=Git::fill_array_with_array($new_pages,$pages_array);
            }

        }
        $this->pages_array=$pages_array;
        $this->templates_array=$templates_array;
        $this->includes_array=$includes_array;
    }
}
