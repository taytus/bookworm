<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class Seeder_PayneMitchel extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){

        $now=time();
        $property_id='0d578395-fb2f-40b6-9157-be772ba6312b';
        $main_domain='https://paynemitchel.com';
        //class in charge of processing the different blocks
        $process_class= 'App\MyClasses\Customers\Parser_PayneMitchell';

        $nodes=[
            '<div class="row flex">',//case types
            '<div class="container no-top-padding">'//curated articles

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

            ['type'=>'div','class_name'=>'col-md-8','obj'=>false,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_curated_articles']],

            ['type'=>'class','class_name'=>'productlist-page','obj'=>true,'process'=>false],
            ['type'=>'div','div_id'=>'CategoryBreadcrumb','obj'=>true],
            //['type'=>'class','class_name'=>'container','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_counters']],
            ['type'=>'class','class_name'=>'ProductList List','obj'=>true,'process'=>true,'callback'=>['class'=>$process_class,'method'=>'process_items']],




        ];


        $pages=[
                ['id'=>'bcb9b9b2-19dd-4a82-a892-175aaf042a39','url'=>urlencode($main_domain.'/SEXY'),'property_id'=>$property_id,'name'=>'product','created_at'=>$now,'updated_at'=>$now],
                ['id'=>'a24d69fd-c915-4ae9-9640-afa611243ad4','url'=>urlencode($main_domain.'/SEXY'),'property_id'=>$property_id,'name'=>'general','created_at'=>$now,'updated_at'=>$now],
            ];
        //the name of the template is the name of the view where the variables
        //are going to be replaced
        $templates=[
                ['id'=>'1bb72cae-798c-4676-a35e-34e63d0ceccc','property_id'=>$property_id,'name'=>'case types','signature'=>$nodes[0],'created_at'=>$now,'updated_at'=>$now],
                ['id'=>'9b550101-b2cc-4e1e-97d2-a04a36eca2c1','property_id'=>$property_id,'name'=>'curated-articles','signature'=>$nodes[1],'created_at'=>$now,'updated_at'=>$now],

        ];
        $includes=[
            ['id'=>'3a256d94-ce72-11e7-acde-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'title','node'=>$codes[0],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3a256d94-ce72-11e7-ac06-9b4153c2a21e','template_id'=>$templates[0]['id'],'name'=>'canonical','node'=>$codes[1],'created_at'=>$now,'updated_at'=>$now],

            ['id'=>'3b156d94-ce72-11e7-acde-9b4153c2a21e','template_id'=>$templates[1]['id'],'name'=>'title','node'=>$codes[0],'created_at'=>$now,'updated_at'=>$now],
            ['id'=>'4fa22346-1bc3-4d17-ac7b-2481ad044dd9','template_id'=>$templates[1]['id'],'name'=>'content','node'=>$codes[11],'created_at'=>$now,'updated_at'=>$now],



        ];
        return ['pages'=>$pages,'templates'=>$templates,'includes'=>$includes];
    }

}