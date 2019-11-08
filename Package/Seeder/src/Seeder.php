<?php

namespace ROBOAMP;

use Illuminate\Database\Seeder as Laravel_seeder;
use Symfony\Component\Console\Output\ConsoleOutput;


class Seeder extends Laravel_seeder  {



    private $create_stripe_data;

    public function __construct($create_stripe_data=false){

        $this->create_stripe_data=$create_stripe_data;
    }

    public function call($class,$extra=null){

        $this->resolve($class)->run($this->create_stripe_data);

        $output =  new ConsoleOutput();
        $output->writeln("<info>Seeded:</info>". $class);

    }

    public function random_record_from_table($table){
        $model="App\\". $table;
        echo "table is ".$table ."\n";
        $obj=$model::all()->random(1);
        return $obj[0];
    }

    public function field_from_random_record_from_table($table,$field){
        $record=$this->random_record_from_table($table);
        return ($record->$field);
    }
    public function update_default_properties(){
        $customers= Customer::all();

        foreach ($customers as $customer) {

            $properties = $customer->properties;


            foreach ($properties as $property) {
                $property->main_website = 0;
                $property->save();
            };
            $property =Property::where('customer_id',$customer->id)->first();

            // dd($property);
            //if(count($property)>0) {
            if(!is_null($property)){
                $property->main_website = 1;
                $property->save();
            }
        }
    }








}


