<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateAMPScriptsTable extends Migration
{
    private $table_name='ampscripts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',20);
            $table->char('path',200);
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
        DB::drop($this->table_name);
    }
}
