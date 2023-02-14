<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;
class CreateWStatusTable extends Migration
{
    private $table='w_status';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('style',20);
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
