<?php
namespace database\seeds\amp4email;

use ROBOAMP\Git;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use ROBOAMP\DB as myDB;
use App\MyClasses\AMP4Email\Items;



class Ecommerce extends Seeder{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run()
    {
        myDB::truncate('a4e_items');
        myDB::truncate('a4e_categories');
        myDB::truncate('a4e_templates');


        $now=time();

        $items_model= 'App\Models\AMP44Email\A4E_Item';
        $category_model='App\Models\AMP4Email\A4E_Category';
        $template_model='App\Models\AMP4Email\A4E_Template';

        $image_path='/img/amp4email/templates/e-commerce/product/';
        $templates=[['name'=>'ecommerce']];
        $categories=[['name'=>'accessories'],['name'=>'bikes'],['name'=>'components']];

        $items=[
                ['name' => 'Leather Saddle', 'description' => 'Firm, yet comfortable for long leisurely rides.', 'price' => 476, 'image' => $image_path.'product-4.jpg', 'a4e_category_id' => 1,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => '16-Speed', 'description' => 'Smooth shifting through all gears for city riding.', 'price' => 524, 'image' => $image_path.'product-5.jpg', 'a4e_category_id' => 1,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Sprocket Set', 'description' => 'Steel, designed for long lasting stability.', 'price' => 581, 'image' => $image_path.'product-1.jpg', 'a4e_category_id' => 2,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Wheel Set', 'description' => 'Ride Sally, ride.', 'price' => 603, 'image' => $image_path.'product-10.jpg', 'a4e_category_id' => 3,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Fixie Blue', 'description' => 'Designed to get you there.', 'price' => 643, 'image' => $image_path.'product-2.jpg', 'a4e_category_id' => 1,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Road Bike', 'description' => 'Built with lightweight aluminum for speed.', 'price' => 644, 'image' => $image_path.'product-9.jpg', 'a4e_category_id' => 1,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Red Cruiser', 'description' => 'Smooth ride for enjoyable cruising.', 'price' => 688, 'image' => $image_path.'product-6.jpg', 'a4e_category_id' => 1,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Caliper Brakes', 'description' => 'Fits most wheel sizes and designed to last long.', 'price' => 776, 'image' => $image_path.'product-8.jpg', 'a4e_category_id' => 3,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Horn Handles', 'description' => 'Grippingly durable and stylish.', 'price' => 838, 'image' => $image_path.'product-7.jpg', 'a4e_category_id' => 3,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
                ['name' => 'Chain set', 'description' => 'Silver alloy construction for durability.', 'price' => 867, 'image' => $image_path.'product-3.jpg', 'a4e_category_id' => 1,'a4e_template_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ];
        Git::create_items_from_array($template_model,$templates);
        Git::create_items_from_array($category_model,$categories);
        Git::create_items_from_array($items_model,$items);

        //now create the JSON files;
        $items=new Items();
        $res=$items->items_to_json(1,'all','price');
    }

}