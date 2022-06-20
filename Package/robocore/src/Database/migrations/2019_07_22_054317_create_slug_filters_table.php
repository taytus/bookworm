<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;


class CreateSlugFiltersTable extends Migration{

    private $table="slug_filters";

    public function up(){

        return;

        DB::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('property_id');
            $table->string('slug');
            $table->tinyInteger('position');

            $table->foreign('property_id')->references('id')->on('properties');

        });
    }


    public function down(){
        DB::drop($this->table);
    }
}
