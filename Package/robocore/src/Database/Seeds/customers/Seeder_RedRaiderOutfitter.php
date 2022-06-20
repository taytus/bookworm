<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class Seeder_RedRaiderOutfitter extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){

        $now=time();
        $property_id='3a256d94-c27c-46a3-b466-ff90709c0277';
        $main_domain='https://www.redraideroutfitter.com';
        //class in charge of processing the different blocks
        $process_class= 'App\MyClasses\Customers\Parser_Redraideroutfitter';

        $nodes=[
            '<div class="Label QuantityInput">Quantity:</div>',//product
            '<span class="sort-by-label">Sort by</span>'//general
            //something else

        ];
        $codes=[
            ['type'=>'tag','tag_name'=>'title'],
            ['type'=>'header_link','header_link'=>'canonical'],
            ['type'=>'div','div_id'=>'ProductBreadcrumb','obj'=>true],
            ['type'=>'tag','tag_name'=>'title'],
            ['type'=>'class','class_name'=>'cloudzoom','data'=>'src','obj'=>false,'process'=>false],
            ['type'=>'class','class_name'=>'ProductTinyImageList','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_thumbs_under_product_image']],
            ['type'=>'class','class_name'=>'ProductDescriptionContainer prodAccordionContent','obj'=>true,'process'=>false],
            ['type'=>'class','class_name'=>'ProductPrice VariationProductPrice','obj'=>true],
            ['type'=>'class','class_name'=>'VariationProductSKU','obj'=>true],
            ['type'=>'class','class_name'=>'SideProductRelated','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_related_products']],
            ['type'=>'div','div_id'=>'SimilarProductsByCustomerViews','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'customers_also_viewed']],
            //
            ['type'=>'class','class_name'=>'PageMenu','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_top_menu']],
            ['type'=>'class','class_name'=>'productlist-page','obj'=>true,'process'=>false],
            ['type'=>'div','div_id'=>'CategoryBreadcrumb','obj'=>true],
            //['type'=>'class','class_name'=>'container','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_counters']],
            ['type'=>'class','class_name'=>'ProductList List','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_items']],




        ];


        $pages=[
                ['id'=>'3b15df8e-741a-4818-8599-441050fcf402','url'=>urlencode($main_domain.'/product'),'property_id'=>$property_id,'name'=>'product','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'7ac276e8-0941-42bf-93aa-17270d0a3a3c','url'=>urlencode($main_domain.'/general'),'property_id'=>$property_id,'name'=>'general','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'130e9043-dbc3-4f1e-ac06-618f6e47fddf','url'=>urlencode($main_domain),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'3a256d94-c27c-46a3-b466-ff90709c0277','url'=>urlencode($main_domain."/"),'property_id'=>$property_id,'name'=>'index','created_at'=>$now,'updated_at'=>$now],

        ];
        $templates=[
                ['id'=>'3a256d94-ce72-11e7-acde-9b4153c2a21e','property_id'=>$property_id,'name'=>'product','signature'=>$nodes[0],'created_at'=>$now,'updated_at'=>$now],
                ['id'=>'3b15df8e-ce72-11e7-acde-9b4153c2a21e','property_id'=>$property_id,'name'=>'general','signature'=>$nodes[1],'created_at'=>$now,'updated_at'=>$now],

        ];
        $includes=[
            ['id'=>'3a256d94-ce72-11e7-acde-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'title','node'=>$codes[0],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-ce72-11e7-ac06-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'canonical','node'=>$codes[1],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-ce72-0941-ac06-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'breadcrumbs','node'=>$codes[2],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-ce72-0941-ac06-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'product_header','node'=>$codes[3],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-ce72-0941-ac06-ff90709c0277','template_id'=>$templates[0]['id'],'name'=>'product_image','node'=>$codes[4],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-c27c-0941-ac06-ff90709c0277','template_id'=>$templates[0]['id'],'name'=>'amp_selector','node'=>$codes[5],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-dbc3-0941-ac06-ff90709c0277','template_id'=>$templates[0]['id'],'name'=>'product_description','node'=>$codes[6],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-dbc3-0941-ac06-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'product_price','node'=>$codes[7],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-dbc3-0941-acde-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'product_sku','node'=>$codes[8],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-c27c-0941-acde-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'related_products','node'=>$codes[9],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-c27c-11e7-ac06-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'also_viewed','node'=>$codes[10],'created_at'=>$now,'updated_at'=>$now],

            //
            ['id'=>'b83e6ed6-dbdb-4f32-b63c-de0ee381845b','template_id'=>$templates[1]['id'],'name'=>'top_menu','node'=>$codes[11],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b83e6ed6-dbdb-4f32-b63c-9b4153c2a21e','template_id'=>$templates[1]['id'],'name'=>'top_menu','node'=>$codes[12],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b83e6ed6-ce72-11e7-acde-9b4153c2a21e','template_id'=>$templates[1]['id'],'name'=>'title','node'=>$codes[0],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b83e6ed6-ce72-11e7-ac06-9b4153c2a21e','template_id'=>$templates[1]['id'],'name'=>'canonical','node'=>$codes[1],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b83e6ed6-ce72-0941-ac06-9b4153c2a21e','template_id'=>$templates[1]['id'],'name'=>'breadcrumbs','node'=>$codes[13],'created_at'=>$now,'updated_at'=>$now],
            //['id'=>'b83e6ed6-ce72-0941-ac06-de0ee381845b','template_id'=>$templates[1]['id'],'name'=>'counter','node'=>$codes[14],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b83e6ed6-ce72-0941-ac06-de0ee381845b','template_id'=>$templates[1]['id'],'name'=>'results','node'=>$codes[14],'created_at'=>$now,'updated_at'=>$now],



        ];
        return ['pages'=>$pages,'templates'=>$templates,'includes'=>$includes];
    }

}