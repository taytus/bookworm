<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestCronJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $my_table='TestCronJob';
    public function up()
    {

        Schema::create($this->my_table, function (Blueprint $table) {
            $table->string('name');
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->my_table);

    }
}
