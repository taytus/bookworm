<?php

namespace App\MyClasses\Stripe;
use App\MyClasses\Server;
use App\Property;
use Stripe\{Charge,Customer,Stripe,Product,Subscription,Coupon};
use App\MyClasses\Seeders;



class RoboStripe   {

    private $items;
    private $server;
    private $type;
    private $data=array();
    private $header=array();
    private $key_type;


    public function __construct(){

        $this->server=new Server();

        Stripe::setApiKey($this->server->get_private_stripe_key());



    }
    public function getKeyType(){
        return $this->key_type;
    }

    public function delete_all_testing_data(){
        $this->delete('Plan',1);
        $this->delete('Product',1);
        $this->delete('Customer',1);
        $this->delete('Subscription',1);
        $this->delete('Coupon',1);
    }

    public function retrieve($type,$id){

        $type=$this->setup_type($type);

        try {
            $res = $type::retrieve($id);
            return $res;

        }catch(\Exception $e){
            return (['error'=>1,'error_message'=>$e->getMessage()]);
        }


    }

    public function create_item_from_array($type,$array){
        foreach ($array as $obj){
            $this->create($type,$obj);
        }

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
        $temp=$total;
        echo "total of records  = " .$total."\n";
        if($total>0){
            foreach ($this->items as $obj) {
                $obj = $model::retrieve($obj->id);
                echo "deleting ". $type."\n".$total ." from ".$temp."\n";
                $obj->delete();

                $total--;
                echo $total." to go!\n";
            }
        }
        $message="";
        if($echo)echo $message;

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

    public function cancel_subscription($subscription_stripe_id){
        $sub=Subscription::retrieve($subscription_stripe_id);
        return $sub->cancel();
    }
    public function cancel_subscription_by_property_id($property_id){
        $subscription_model=\App\Subscription::where('property_id',$property_id)->first();

        if(!is_null($subscription_model)){
             $this->cancel_subscription($subscription_model->stripe_id);
        }
        $res=$subscription_model->delete();
        //update the property status
        $property=Property::where('id',$property_id)->update(['status_id'=>3]);

    }

    public function delete_by_id($type,$id){
        $model=$this->setup_type($type);
        $obj = $model::retrieve($id);
        $res=$obj->delete();
        return $res->deleted;
    }




}