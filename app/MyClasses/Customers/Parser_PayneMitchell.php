<?php
/**
 * Created by ROBOAMP
 * User: taytus
 * Date: 6/28/19
 * Time: 8:49 AM
 */

namespace App\MyClasses\Customers;

use KubAT\PhpSimple\HtmlDomParser;
use App\MyClasses\Errors as e;

class Parser_PayneMitchell{


    public function process_curated_articles($res){
        return $res;
    }
    public function process_items($res){
        $html=new HtmlDomParser();
        $res=$html->str_get_html($res);

        $arr=[];
        $j=0;
        foreach ($res->find('li') as $item){
            $obj=$item->find('[class=ProductImage QuickView] > a',0);
            $image=$obj->find('img',0);
            $arr[$j]['product_url']=$obj->href;
            $arr[$j]['product_image']=$image->src;
            $arr[$j]['product_image_alt']=$image->alt;
            $arr[$j]['product_details']=$image->alt;
            $arr[$j]['product_description']=$item->find('[class=ProductDescription]',0)->innertext;
            $arr[$j]['product_price']=$item->find('[class=p-price]',0)->innertext;

           // dd($arr);
            $j++;
        }

        return $arr;
    }
    public function process_counters($res){
        $html=new HtmlDomParser();



        dd($res);
    }

    public function process_top_menu($res){
        $html=new HtmlDomParser();
        $res=$html->str_get_html($res);
        $res=$res->find('div.container > div > div > div > ul',0);

        foreach ($res->find('li') as $item){

            //echo $item->text()."<br>";
        }
        return true;
       // e::dd($res);
    }

    public function customers_also_viewed($res){
        $html=new HtmlDomParser();
        $res=$html->str_get_html($res);
        $j=0;

        $obj=$res->find( '[class=BlockContent] > div > div');
        foreach($obj as $element) {

            $product_image=$element->find('[class=ProductImage] > a',0);
            if(!is_null($product_image)){


                $product_image_item=$product_image->find('img',0);
                $arr[$j]['product_link']=$product_image->href;
                $arr[$j]['product_image']=$product_image_item->src;
                $arr[$j]['product_image_alt']=html_entity_decode($product_image_item->alt);
                //not used
                $product_details=$element->find('[class=ProductDetails] > a',0);
                $arr[$j]['product_price']=$element->find('[class=ProductPriceRating] > .p-price',0)->text();
                $arr[$j]['product_add_to_cart_link']=html_entity_decode($element->find('[class=WrapperProductAction] > div > div > a',0)->href);


                $j++;


            }

        }
        return $arr;
    }

    public function process_thumbs_under_product_image($res){
        $html=new HtmlDomParser();
        $res=$html->str_get_html($res);
        $j=0;

        foreach($res->find('ul>li>div>div>a') as $element) {
            $arr[$j]=(array)json_decode($element->rel);
            $arr[$j]['tinyimage']=$element->find('img',0)->src;
            unset($arr[$j]['gallery']);
            $j++;
        }
        return $arr;
    }
    public function process_related_products($res){
        $html=new HtmlDomParser();
        $res=$html->str_get_html($res);
        $j=0;

        $obj=$res->find('[class=BlockContent] > div > div');

        foreach($obj as $element) {

            $product_image=$element->find('[class=ProductImage] > a',0);
            if(!is_null($product_image)){
                $product_image_item=$product_image->find('img',0);
                $arr[$j]['product_link']=$product_image->href;
                $arr[$j]['product_image']=$product_image_item->src;
                $arr[$j]['product_image_alt']=html_entity_decode($product_image_item->alt);
                //not used
                $product_details=$element->find('[class=ProductDetails] > a',0);
                $arr[$j]['product_price']=$element->find('[class=ProductPriceRating] > .p-price',0)->text();
                $arr[$j]['product_add_to_cart_link']=html_entity_decode($element->find('[class=WrapperProductAction] > div > div > a',0)->href);


                $j++;


            }

        }
        return $arr;
    }
}