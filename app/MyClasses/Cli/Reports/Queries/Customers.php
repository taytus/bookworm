<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 9/17/18
 * Time: 8:22 PM
 */

namespace App\MyClasses\Cli\Reports\Queries;
use App\Customer;
use App\MyClasses\Git;


use App\Property;

use App\MyClasses\Cli\CliMenu;

class Customers {
    /** @var \App\MyClasses\Cli\CliMenu */
    private $cliMenu;
    /** @var  \App\MyClasses\Cli\Cli */
    private $cli;
    private $query;
    private $validation_rules=['Email'=>'email','Name'=>'alphabetic'];

    public function __construct($cli){
        $this->cli=$cli;
        $this->cliMenu=new CliMenu($this->cli);
        $this->query=new Property();
    }

    //pending properties who has been confirmed but we haven't run the script on them yet

   public function info_about_a_customer(){

       $question=$this->cli->choice_question('Search customer by:(defaults to Email)',
           array('Email', 'Name'),
           0);
       $validation = $this->cli->set_validation($this->validation_rules[$question],$question);

       $autocomplete= $this->cli->set_autocomplete('Customer',$question);

       $res=$this->cli->ask("please type Customer's " . $question.":  ",null,$validation,$autocomplete);

       $this->show_info(array_map('strtolower',$res));
   }







    //$data contains the field and the value to search for
    private function show_info($info){
        $customers=new Customer();
        $properties= new Properties($this->cli);

        $customers_data=array('id','name','email','coupon_id','created_at');
        $data=$customers->where($info[2],'=',$info[1])->select($customers_data)->get()->toArray();
        $this->cliMenu->render_table($data);

        //property info
        $customer_id=$data[0]['id'];
        $data=$properties->query('customers.id',$customer_id,'=',true);
        //a customer might not have any property
        if(!empty($data)){
            $this->cliMenu->render_table($data,$fields_to_exclude=['id']);
        }else{
            echo "This customer doesn't have Properties\n\n";
        }

    }










} 