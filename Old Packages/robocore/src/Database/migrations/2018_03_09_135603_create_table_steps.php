<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateTableSteps extends Migration{

    private $table="steps";

    public function up(){

        return;

        DB::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('platform_id')->nullable();
            $table->string('copy');

            $table->foreign('platform_id')->references('id')->on('platforms');

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
