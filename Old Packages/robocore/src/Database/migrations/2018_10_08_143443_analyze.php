<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class Analyze extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;

        Schema::create('analyze', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->uuid('customer_id')->nullable();
            $table->string('url');
            $table->string('status');
            $table->string('public_url');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop('analyze');
    }
}
