<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;
class CreateReportTable extends Migration
{
    private $table_name='report_amp_errors';
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
            $table->string('url',300);
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();


        });

        Schema::table($this->table_name, function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop('report_amp_errors');
    }
}
