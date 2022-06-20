<?php

namespace App\MyClasses\Templates\Partials;



class Listing   {


    private $listing_type;
    public $table_title=" Available ";

    public function __construct($listing_type,$table_title=null){

        $this->listing_type=$listing_type;

        if(is_null($table_title))$this->set_title();

    }

    public function render(){
        dd($this->table_title);

    }


    public function set_title($title=null){

        if(is_null($title)){
            $this->table_title.=$this->get_plural_label();
        }else{
            $this->table_title=$title;
        }

    }

    private function get_plural_label(){

        switch($this->listing_type){
            case 'amp_error':
                return "Pages with Errors";
        }

    }







}