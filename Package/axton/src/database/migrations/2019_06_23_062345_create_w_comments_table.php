<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateWCommentsTable extends Migration
{
    private $table='w_comments';

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
            $table->integer('user_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('w_status');


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
