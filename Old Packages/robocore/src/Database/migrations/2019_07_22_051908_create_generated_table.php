<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateGeneratedTable extends Migration{

    private $table="r_pages_generated";

    public function up(){
        return;
        DB::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('property_id');
            $table->string('url');
            $table->string('view_name')->nullable();
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties');

        });


    }

    public function down(){

        DB::drop($this->table);
    }
}
