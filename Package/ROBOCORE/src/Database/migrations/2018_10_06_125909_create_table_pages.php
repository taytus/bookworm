<?php

use ROBOAMP\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $my_table='pages';
    public function up()
    {
        return;
        DB::create($this->my_table, function (Blueprint $table) {

            $table->string('id',36);
            $table->string('property_id',36);
            $table->string('name',100);
            $table->string('label',100)->default('');
            $table->string('parent_id',36)->default(0)->nullable();
            $table->string('url')->default('');
            $table->integer('demo_old')->default(0);
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

        });


    }


    public function down(){

        DB::drop($this->my_table);

    }
}
