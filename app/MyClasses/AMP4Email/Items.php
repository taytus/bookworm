<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 8/15/18
 * Time: 5:53 AM
 */

namespace App\MyClasses\AMP4Email;
use App\Models\AMP44Email\A4E_Item;
use App\MyClasses\Git;
class Items {

    private $filter;
    private $categories=array();

    public  function items_to_json($model_id,$condition,$filter){
       $this->filter=$filter;
       $MyArray=new Git();
        switch ($condition){
           case 'all':
               //get all the products
               $products=A4E_Item::where('a4e_template_id',$model_id)->get();
               break;
       }

       $records=array();
       $this->setup_categories($products);
        foreach ($this->categories as $categories){
            $records[]=$products->filter(function($value,$key) use ($categories){
                return $value->a4e_category_id==$categories;
            })->values();
        }
        //records is holding all the products grouped by category
        $j=1;
        //dd($records);
        foreach ($records as $item){
            $category=$item[0]->category->name;
            $obj[$category]['asc']=$this->sort_items($item);
            $obj[$category]['desc']=$this->sort_items($item,true);
            $j++;
        }


        $obj['all']['asc']= $this->sort_items($products);
        $obj['all']['desc']= $this->sort_items($products,true);

        return $obj;
    }
    private function sort_items($collection,$direction=false){
        return $collection->sortBy($this->filter,SORT_REGULAR,$direction)->values()->toJson();
    }
    private function setup_categories($products){
        foreach ($products as $item){
            $found=false;
            $category=$item->a4e_category_id;
            foreach ($this->categories as $cat){
                //dd($cat,$category);
                if($cat===$category){
                    $found=true;// dd("FOUND IT!",$cat,$this->categories);
                    continue;
                }
            }
            if(!$found)$this->categories[]=$category;
        }
    }


} 