<?php

/*
 * This controller is the one called from ***EVERY*** client
 *
 */
namespace App\MyClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sunra\PhpSimple\HtmlDomParser;
use simple_html_dom;
use App\MyClasses\URL;


class Faker_js
{
    
    private $params;
    private $testing;
    public function __construct($params=null){
        $this->params = $params;
        $this->testing = true;
    }

    public function get_testing(){
        return $this->testing;
    }


    //--------------------------------------------
    //Start of functions that will generate records for any given model
    public function create($model, $records=1){
        
        $model ="App\\".$model;
        $model2 = new $model;


            factory(get_class($model2),$records)->create();
        

        return;
    }

    public function create_x_random($model, $records){
        
        $model ="App\\".$model;
        $model2 = new $model;

        if(is_array($records)){
            $rand_num = $this->generate_random_number_inbetween($records[0],$records[1]);

        }else{
            $rand_num = $this->generate_random_number_inbetween($records);
        }

            factory(get_class($model2),$rand_num)->create();
        

        return;
    }

    public function generate_random_number_inbetween($y, $z=1){
        return rand($y, $z);
    }
    //End of functions that will generate records for any given model
    //--------------------------------------------

    public function delete_all_until_x_records($table, $records=null){
        
        $model="App\\".$table;
        $count = $model::all()->count();
        if(is_array($records)){
            $records = $this->generate_random_number_inbetween($records[0],$records[1]);
        }
        

        while($count > $records){
            $model::all()->last()->delete();
            $count--;
        }

        return;
    }

    public function delete_x_records_from_table($table, $records){
        
        $model="App\\".$table;
        $count = $records;

        // if(is_array($records)){
        //     $records = $this->generate_random_number_inbetween($records[0],$records[1]);
        // }

        while($count > 0){
            $model::all()->last()->delete();
            $count--;
        }

        return;
    }
    
    public function write_js(){
        $faker = Faker\Factory::create();

        if($this->testing == false){
            return;
        }

        foreach($this->params as $param){
            $value = (string) $param;
            $data[$value] = $faker->$value();
        }


        if(array_key_exists('password', $data)){
            $data['password'] = 'secret';
            $data['password_confirmation'] = 'secret';
        }


        $array = json_encode($data);

        return "<button class='test_data'>AUTO FILL FORM</button>
        <script type='text/javascript'>
            var data = $array;

        document.addEventListener('DOMContentLoaded', function(event) { 
          $('.test_data').on('click', function(){
                for(var x in data){
                    $('input[name='+x+']').val(data[x]);
                    console.log(data[x]);
                }

            });
        });

        </script>";
    }





}
