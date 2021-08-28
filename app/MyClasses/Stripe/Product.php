<?php

namespace App\MyClasses\Stripe;
use App\MyClasses\RoboStripe;


class Product   {

    private $customers;
    private $products;


    public function __construct(){
    }


    public function get_all_products_from_stripe(){
        $this->setProducts(Product::all());
    }

    public function delete_all_products(){
        if(count($this->products)>0){
            foreach ($this->products as $product) {
                $obj = Customer::retrieve($product->id);
                $obj->delete();
            }
        }
    }
    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $tmp=null;
        foreach ($products->data as $obj) {
            $tmp[] = $obj;
        }
        $this->products = $tmp;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }



    public function create_stripe_customer($email=null){
        Customer::create([
            'description'=>'testing user created during seeding step',
            'email'=>$email
        ]);
        echo "Stripe User has been Created\n";
    }



    public function get_all_customers_from_stripe(){
        $this->setCustomers(Customer::all());
    }

    public function delete_all_customers(){

        $this->get_all_customers_from_stripe();

        if(count($this->customers)>0){
            foreach ($this->customers as $customer) {
                $obj = Customer::retrieve($customer->id);
                $obj->delete();
            }
        }
    }

    /**
     * @param mixed $customers
     */
    public function setCustomers($customers){
        $tmp=null;
        foreach ($customers->data as $obj) {
            $tmp[] = $obj;
        }
        $this->customers = $tmp;
    }

    /**
     * @return mixed
     */
    public function getCustomers()
    {
        return $this->customers;
    }






}