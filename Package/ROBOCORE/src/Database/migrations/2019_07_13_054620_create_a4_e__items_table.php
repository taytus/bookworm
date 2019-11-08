<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;


class CreateA4EItemsTable extends Migration
{
    private $table_name='a4e_items';

    public function up()
    {
        return;
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('price');
            $table->string('name',20);
            $table->string('image',150);
            $table->integer('a4e_category_id')->unsigned();
            $table->integer('a4e_template_id')->unsigned();
            $table->timestamps();

            $table->foreign('a4e_category_id')->references('id')->on('a4e_categories');
            $table->foreign('a4e_template_id')->references('id')->on('a4e_templates');

        });
    }


    public function down(){
        DB::drop($this->table_name);
    }
}
