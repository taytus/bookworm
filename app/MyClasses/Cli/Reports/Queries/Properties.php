<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 9/17/18
 * Time: 8:22 PM
 */

namespace App\MyClasses\Cli\Reports\Queries;

use App\Property;

use App\MyClasses\Cli\CliMenu;
use Carbon\Carbon;

class Properties {

    /** @var  \App\MyClasses\Cli\CliMenu */
    private $cliMenu;
    private $cli;
    private $property;
    private $main_query;

    public function __construct($cli){
        $this->cli=$cli;
        $this->cliMenu=new CliMenu($this->cli);
        $this->property=new Property();
        $this->main_query=$this->property->get_foreign_keys();
    }

    //pending properties who has been confirmed but we haven't run the script on them yet

    public function confirmed_properties($cli=null,$return_query=false){
//

        $res=$this->main_query->where('steps_id',3);


        if($return_query) return $res;

        $data=$res->get()->toArray();


        $this->cliMenu->render_table($data);
    }
    public function unconfirmed_properties(){
        $data=$this->property->get_unconfirmed_properties();
        $this->cliMenu->render_table($data);
    }


    public function pending_confirmed_properties(){
        $main_query=$this->confirmed_properties(null,true);
        $data=$main_query->where('status_id',2)->get()->toArray();
        $this->cliMenu->render_table($data);

    }
    public function confirm_properties(){

    }
    private function setup_headers($headers=null){
        if(is_null($headers)) return [ 'Platform','Name','Email','Status','URL'];

    }



    private function render($data){

        $data['headers']=$this->setup_headers();
        $cliMenu=new CliMenu($this->cli);
        return $cliMenu->output_to_table($data);
    }

    //returns a query matching the field and value passed
    //the var $out_of_6 is used for steps. by default it shows X
    //but if $out_of_6 is true, then it will display x/y
    public function query($field,$value,$operation='=',$out_of_6=false){
        $property=new Property();
        $query= $property->get_foreign_keys();
        $res=$query->where($field,$operation,$value);
        $res=$res->get()->toArray();

        if (!$out_of_6) return $res;

        $j=0;
        foreach($res as $item){
            $res[$j]['steps']=$item['steps']. "/6";
            $res[$j]['confirmed']=($item['steps']>=3?'Yes':'No');
            $j++;
        }

        return $res;

    }





} 