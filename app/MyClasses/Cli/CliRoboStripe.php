<?php

namespace App\MyClasses\Cli;
use App\Plan;
use Faker\Factory;
use Stripe\{Charge,Customer,Stripe,Product,Subscription};
use App\MyClasses\Seeders;
use DB;
use Faker\Generator;
use App\MyClasses\Stripe\RoboStripe;


class CliRoboStripe extends RoboStripe {

    private $items;
    private $seeder;
    private $type;
    private $data=array();
    private $header=array();
    protected $output;
    protected $menu=array(
        'title'=>'Stripe Operations','items'=>[

            ['menu item' =>'Delete All Records','method'=>'RoboStripe__delete_all_testing_data'],
            ['menu item' =>'Create Base Data','method'=>'RoboStripe__create_base_data'],
            ['menu item' =>'Create 50 Users','method'=>'RoboStripe__create_50_users_for_testing']
        ]
    );






    public function __construct($output=null){

        $this->seeder=new Seeders();

        if(!is_null($output)) {
            $this->output = $output;
        }

        if($this->seeder->testing_server()){
            $key=env('TESTING_STRIPE_SECRET');
        }else{
            $key=env('STRIPE_SECRET');
        }

        Stripe::setApiKey($key);
    }


    public function menu(){
        return $this->menu;
    }

    public function delete_all_testing_data(){
        $this->delete('Plan',1);
        $this->delete('Product',1);
        $this->delete('Customer',1);
        $this->delete('Subscription',1);
    }
    public function create_base_data(){
        $this->create_from_db('Product');
        $this->create_from_db('Plan');

    }

    public function create_from_db($type){
        $class = 'App\\' . ucfirst($type);
        $fields=$this->get_fields_for_item_creation($type);
        $key_field=$this->get_key_field_for_item($type);
        $res=$class::select($fields)->get()->toArray();
        if(empty($res)){
           echo "Seed the Database First\n\n";
           dd();
        }
        $obj=$this->create_obj($res);

        $i=0;
        $this->output->writeln("CREATING ". strtoupper($type)."S\n");
        $bar = $this->output->createProgressBar(count($obj));
        foreach ($obj as $item){

            $stripe_id=$this->create($type,$item);
            if(is_array($stripe_id)){
                dd($stripe_id);
            }
            //update the record with the new stripe_id

            $class::where($key_field,$res[$i][$key_field])
                ->update(['stripe_id'=>$stripe_id]);

            $bar->advance();
            $i++;
        }
        $bar->finish();
        echo "\n\n";

    }

    //this are the fields needed to create X element on Stripe
    private function get_fields_for_item_creation($type){
        $arr_Product=array('name','type');
        $arr_Plan=array('currency','interval','amount','product_stripe_id');
        return ${'arr_'.$type};
    }
    private function get_key_field_for_item($type){
        $key_Product='name';
        $key_Plan='product_stripe_id';
        return ${'key_'.$type};
    }


    public function create_obj($obj){
        foreach ($obj as $key => $value){
            $items[$key]= $value;
        }

        return $items;
    }



    public function create( $type, $obj){

            if($type=='source') return $this->create_source($obj);
            $array = (is_array($obj)) ? $obj : $obj->toArray();

            $ignore_fields = ['created_at', 'updated_at', 'product_stripe_id'];
            $arr = null;

            //rewrite fields to match Stripe API
            if ($type == 'Plan') {
                $array['product'] = $array['product_stripe_id'];
                unset($array['product_stripe_id']);

            }


            $type=$this->setup_type($type);

            foreach ($array as $obj => $value) {
                if (!in_array($obj, $ignore_fields)) {
                    $arr[$obj] = $value;
                }

            }
            try {
                $res = $type::create($arr);
                return $res->id;

            }catch(\Exception $e){
                return (['error'=>1,'error_message'=>$e->getMessage()]);
            }

    }


    public function get_all_items($type){

        $type=$this->setup_type($type);
        $this->setItems($type::all(array("limit" => 100)));
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $tmp=null;
        foreach ($items->data as $obj) {
            $tmp[] = $obj;
        }
        $this->items = $tmp;
    }

    public function delete($type, $echo=0)
    {

        $model = $this->setup_type($type);

        $this->get_all_items($type);
        $total = @count($this->items);
        if (isset($this->output)) {
            $this->output->writeln("DELETING " . strtoupper($type) . "S\n");
        }

        $temp=$total;


        if($total>0){
            $bar = $this->output->createProgressBar($total);
            foreach ($this->items as $obj) {
                $obj = $model::retrieve($obj->id);
                //echo "deleting ". $type."\n".$total ." from ".$temp."\n";
                $obj->delete();
                $bar->advance();

                $total--;
            }
            $bar->finish();
            $this->output->writeln("\n");

        }else{
            $bar = $this->output->createProgressBar(100);
            $bar->advance(100);
            $this->output->writeln("\n");


        }


        $message="";
        if($echo)echo $message;
        //ping again to see if there are still pending records
        $more_records=$this->get_all_items($type);
        $total=@count($this->items);
        $temp=$total;
        if($total>0){
            echo "CALLING AGAIN THE SAME FUNCTION BECAUSE THERE ARE MORE RECORDS TO BE DELETED\n\n";
            $this->delete($type,$echo);
        }

    }

    //creates a payment source for testing. Used during seeding to create credit cards
    private function create_source($obj){
        if(!is_array($obj)) {
            $tmp_user = Customer::retrieve($obj);
            return $tmp_user->sources->create(array("source" => "tok_visa"));
        }else{
            //this creates a source with the real token response from stripe
            $tmp_user=Customer::retrieve($obj['customer_id']);
            return $tmp_user->sources->create(array("source"=>$obj['token']));
        }
    }

    private function setup_type($type){
        $class = 'Stripe\\' . ucfirst($type);
        return new $class();
    }
    public function get_id_from_stripe($type,$item){
        return $this->get_field_from_stripe_collection('id',$type,$item);
    }
    public function get_field_from_stripe_collection($field,$type,$item){
        echo $field ."   ".$type."    \n";
        if(array_key_exists($type,$this->data)){
            $this->header[$type]++;

            $obj=$this->data[$type][$this->header[$type]];

            return $obj->$field;


        }else{

            $this->data[$type]=$this->get_all_items($type);
            //move the header to the first position
            $this->header[$type]=0;
            $obj=$this->data[$type][$this->header[$type]];
            if(@count($obj)==0){
                //since there are no elements of this element type on stripe,
                // I need to create it;
                echo "Element has been created\n";
                $this->create($type,$item);
                $this->data[$type]=$this->get_all_items($type);
                dd($this->data);
            }
            return $obj->$field;

        }

    }
    public function create_50_users_for_testing(){

        $faker=Factory::create();

        for($i=0;$i<50;$i++) {
            $user=Array();
            $user['email'] = $faker->safeEmail();
            $this->create('Customer', $user);
        }
    }


    //setters and getters


    public function setMenu($menu=null){ if (!is_null($menu)){$this->menu = $menu;}}
    public function getMenu(){return $this->menu;}



}