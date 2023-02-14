<?php

use Illuminate\Database\Seeder;
use DB as lDB;
use Carbon\Carbon;
use App\Product;
use ROBOAMP\DB; as myDB;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $create_stripe_data;
    public function run($create_stripe_data=false){

        $this->create_stripe_data=$create_stripe_data;
        myDB::truncate('products');
        $now = new Carbon();

        $data=array(
                    ['name'=>'ROBOAMP Beta','type'=>'service'],

                    ['name'=>'ROBOAMP Starter','type'=>'service'],
                    ['name'=>'ROBOAMP Simple','type'=>'service'],
                    ['name'=>'ROBOAMP Business','type'=>'service'],
                    ['name'=>'ROBOAMP Professional','type'=>'service']);





        foreach ($data as $obj){
            $product=new Product();
            $product->name=$obj['name'];
            $product->type=$obj['type'];
            $product->stripe_id ='temp_'.rand(1,800);
            $product->created_at=$now;
            $product->updated_at=$now;
            $product->save();
        }

        lDB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }



}
