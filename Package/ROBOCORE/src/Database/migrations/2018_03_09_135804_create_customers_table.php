<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;
class CreateCustomersTable extends Migration{

    public $incrementing = false;
    private $table="customers";

    public function up(){
        DB::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->string('email')->nullable();
            $table->string('temp_referral')->nullable();
            $table->integer('referral_link_id')->unsigned()->nullable();
            $table->string('password', 60);
            $table->string('coupon_id')->nullable();
            $table->boolean('testing')->default(0);
            $table->integer('notify_id')->unsigned()->nullable();
            $table->date('latest_notification_date')->nullable();

            $table->rememberToken();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->foreign('notify_id')->references('id')->on('notify');



        });





    }


    public function down(){
        DB::drop($this->table);
    }
}
