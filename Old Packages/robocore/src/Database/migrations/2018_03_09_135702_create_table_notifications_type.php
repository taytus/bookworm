<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateTableNotificationsType extends Migration{

    private $table='notifications_type';


    public function up(){
        //this table keeps records of notifications sent to users via email
        DB::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('name',50);


        });

    }


    public function down()
    {
        DB::drop($this->table);
    }
}
