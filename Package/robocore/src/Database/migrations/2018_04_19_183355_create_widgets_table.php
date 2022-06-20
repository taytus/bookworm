<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateWidgetsTable extends Migration{

    private $table="widgets";

    public function up(){

        return;

        DB::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('table');
            $table->string('type');
            $table->integer('goal');
            $table->string('label');
            $table->string('color');
            $table->timestamps();
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


