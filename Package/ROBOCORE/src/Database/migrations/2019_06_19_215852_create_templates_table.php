<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateTemplatesTable extends Migration
{
    private $table_name='templates';
    private $pivot_table='ampscript_template';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        return;
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('property_id');
            $table->text('name');
            $table->text('signature');
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties');

        });

        Schema::create($this->pivot_table, function (Blueprint $table) {
            $table->uuid('template_id');
            $table->integer('ampscript_id')->unsigned();
            $table->primary(['template_id','ampscript_id']);

            $table->foreign('template_id')->references('id')->on('templates');
            $table->foreign('ampscript_id')->references('id')->on('ampscripts');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
       DB::drop($this->table_name);
        DB::drop($this->pivot_table);

    }
}
