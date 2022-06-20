<?php

namespace App\MyClasses\Stripe;
use Carbon\Carbon;
use Faker\Factory;
use Stripe\{Charge,Customer,Stripe,Product,Subscription,Coupon};
use NunoMaduro\LaravelConsoleMenu\Menu;
use App\MyClasses\Stripe\RoboStripeCouponsCli as RoboMenu;


class RoboStripeCli   {

    private $items;
    private $seeder;
    private $type;
    private $data=array();
    private $header=array();
    //used for menu/options background
    private $colors;
    private $live;
    protected $output;
    protected $input;
    protected $helper;
    private $cli;



    public function __construct($cli=null){

        $this->cli=$cli;

        $key=($this->live?env('STRIPE_SECRET'):env('TESTING_STRIPE_SECRET'));


        Stripe::setApiKey($key);

    }

    public function coupons_menu(){

        $menu=new Menu('MENU Options', [
            'Create','Delete','Update Coupon','List Coupons','Sync Coupons',

        ]);
        $option=$menu->open();


        $arr_menu_options=['create_coupon_menu','delete_coupon_menu','update_coupon','list_coupons','sync_coupons_menu'];


        $robo_menu=new RoboMenu($this->cli);


        $res=call_user_func(array($robo_menu,$arr_menu_options[$option]));

        if($res['info']['error']==0){

        }
    }


    public function delete_all_testing_data(){

        $this->delete('Plan',1);
        $this->delete('Product',1);
        $this->delete('Customer',1);
        $this->delete('Subscription',1);
        $this->delete('Coupon',1);
    }
    public function create_base_data(){
        $this->create_from_db('Product');
        $this->create_from_db('Plan');
        $this->create_from_db('Coupon');

    }

    public function create_from_db($type){
        $type=ucfirst($type);
        $class = 'App\\' . $type;
        $fields=$this->get_fields_for_item_creation($type);
        $key_field=$this->get_key_field_for_item($type);
        $res=$class::select($fields)->get()->toArray();


        if(empty($res)){
           echo "Seed the Database First\n\n";
           dd();
        }
        $j=0;
        if($type=='Coupon'){
            foreach($res as $item){
                $now = new Carbon();
                $redeem_by = Carbon::createFromFormat('Y-m-d H:i:s', $item['redeem_by'])->timestamp;
                $res[$j]['redeem_by']=$redeem_by;
                $j++;
            }
        }

        $obj=$this->create_obj($res);

        $i=0;
        //$this->cli->output->writeln("CREATING ". strtoupper($type)."S\n");
        $this->display_message("CREATING ". strtoupper($type)."S");
        if(!is_null($this->cli))$bar = $this->cli->output->createProgressBar(count($obj));
        foreach ($obj as $item){

            $stripe_id=$this->create($type,$item);


            if(is_array($stripe_id)){
                dd($stripe_id);
            }
            //update the record with the new stripe_id
            if($type!='Coupon') {
                $class::where($key_field, $res[$i][$key_field])
                    ->update(['stripe_id' => $stripe_id]);
            }
            if(!is_null($this->cli))$bar->advance();
            $i++;
        }
        if(!is_null($this->cli))$bar->finish();
        echo "\n\n";

    }

    //this are the fields needed to create X element on Stripe
    private function get_fields_for_item_creation($type){
        $arr_Product=array('name','type');
        $arr_Plan=array('currency','interval','amount','product_stripe_id');
        $arr_Coupon=array('id','percent_off','duration','redeem_by','max_redemptions','duration_in_months');
        return ${'arr_'.$type};
    }
    private function get_key_field_for_item($type){
        $key_Product='name';
        $key_Plan='product_stripe_id';
        $key_Coupon='id';
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

    public function delete($type, $echo=0){

        $model=$this->setup_type($type);

        $this->get_all_items($type);
        $total=@count($this->items);

        $this->display_message("DELETING " . strtoupper($type) . "S\n");

        $temp=$total;
        if($total>0){
            if(!is_null($this->cli)) {
                $bar = $this->cli->output->createProgressBar($total);
            }
            foreach ($this->items as $obj) {
                $obj = $model::retrieve($obj->id);
                //echo "deleting ". $type."\n".$total ." from ".$temp."\n";
                $obj->delete();
                if(!is_null($this->cli))$bar->advance();

                $total--;
            }
            if(!is_null($this->cli)) {
                $bar->finish();
                $this->cli->output->writeln("\n");
            }

        }else{
            if(!is_null($this->cli)) {
                $bar = $this->cli->output->createProgressBar(100);
                $bar->advance(100);
                $this->cli->output->writeln("\n");
            }

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
    public function refresh(){
        $this->delete_all_testing_data();
        $this->create_base_data();
    }

    public function display_message($message){
        if(!is_null($this->cli)){
            $this->cli->output->writeln($message);
        }else{
            echo $message;
        }

    }





}