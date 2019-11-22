<?php

namespace ROBOAMP;
use Schema;
use DB as LDB;
use PDO;
use PDOException;
use Symfony\Component\Console\Command\Command;
use Eloquent;


class DB extends Command {

    private $error_manager;
    public function __construct(){
        parent::__construct();
    }

    //this is used primarily on migrations. It's a shortcut to get
    //the connection and table name
    public static function get_table_name_from_model($model){
        $model=ucfirst(strtolower($model));
        $class="App\\".$model;
        $model_table=new $class();

        $table_name=$model_table->get_table_name();
        $db_name=$model_table->getConnection()->getDatabaseName();
        return $db_name.'.'.$table_name;
    }

    //this method first check if there is a connection passed to it
    //and if so, uses that connection
    //it also checks if the table exists before trying to create it
    public static function create($table,$callable,$connection=null){

        if(!is_null($connection)) {
            if (!Schema::connection($connection)->hasTable($table)) {
                 Schema::connection($connection)->create($table, $callable);
            }
        }

        if (!Schema::hasTable($table)) {
             Schema::create($table,$callable);
        }


    }
    public function create_table($table_name,$fields,$connection=null){
        $data['error']=0;
        if (!Schema::hasTable($table_name)) {
        }else{
            $data['error']=1;
            $data['message']='Table already exist. Table '.$table_name .' has not been created';

        }
        $this->error_manager->return_error_as_json($data);
    }
    public function create_DB($db_name){


        try {
            $pdo = $this->getPDOConnection(env('DB_HOST_BACKUP'), env('DB_PORT_BACKUP'), env('DB_USERNAME_BACKUP'), env('DB_PASSWORD_BACKUP'));

            $res=$pdo->exec(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $db_name, 'utf8mb4',
                'utf8mb4_unicode_ci'
            ));

            echo (sprintf('Successfully created %s database', $res));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $db_name, $exception->getMessage()));
        }



    }

    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
    public static function truncate($table){

        Eloquent::unguard();

        //disable foreign key check for this connection before running seeders
        self::SET_FOREIGN_KEY(0);

        //truncate the table
        if(Schema::hasTable($table))LDB::table($table)->truncate();


    }
    public static function drop($table){
        self::SET_FOREIGN_KEY(0);
        Schema::dropIfExists($table);
        self::SET_FOREIGN_KEY(1);
    }

    public static function SET_FOREIGN_KEY($foreign_key_checks){
        LDB::statement('SET FOREIGN_KEY_CHECKS='.$foreign_key_checks.';');
    }






}