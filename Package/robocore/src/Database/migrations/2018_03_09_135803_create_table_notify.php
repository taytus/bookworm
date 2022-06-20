<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateTableNotify extends Migration{

    private $table="notify";

    public function up(){

        //this table keeps records of notifications sent to users via email
        DB::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('name',50);
            $table->string('copy');
            $table->char('interval',50);
            $table->integer('notifications_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('notifications_type_id')->references('id')->on('notifications_type');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        DB::drop($this->table);
    }
}
