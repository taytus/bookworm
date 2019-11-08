<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateIncludesTable extends Migration
{
    private $table_name='includes';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('template_id');
            $table->string('name',30);
            $table->string('node',250);
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop($this->table_name);
    }
}
