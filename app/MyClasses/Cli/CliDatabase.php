<?php

namespace App\MyClasses\Cli;

use App\MyClasses\DB;


class CliDatabase extends DB{

    private $items;
    private $seeder;
    private $type;
    private $data=array();
    private $header=array();
    protected $output;
    protected $menu=array(
        'title'=>'Backup Options','items'=>[

            ['menu item' =>'Export User Records','method'=>'Database__export_user_record'],

        ]
    );






    public function __construct($output=null){

        parent::__construct();

        if(!is_null($output)) {
            $this->output = $output;
        }


    }


    public function menu(){
        return $this->menu;
    }

    public function export_user_record(){
        $users=(new CliUsers)->get_all_users();
        $db=$this->create_DB(env('DB_DATABASE_BACKUP','BACKUP_ROBOAMP'));


       // Artisan::call('migrate', array('database' => $databaseConnection, 'path' => 'app/database/tenants'));
        //$db= $this->create_table('tmp_users');

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




}