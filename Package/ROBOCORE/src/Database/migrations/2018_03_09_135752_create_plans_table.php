<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreatePlansTable extends Migration{


    private $table="plans";

    public function up(){

        return;

        DB::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname');
            $table->string('stripe_id')->default('');
            $table->string('currency')->default('usd');
            $table->string('interval')->default('month');
            $table->integer('amount');
            $table->integer('interval_count')->default(1);
            $table->string('product_stripe_id');
            $table->string('sub_title')->default('');
            $table->string('photo')->default('');
            $table->string('title_caption')->default('');
            $table->string('learn_more')->default('');
            $table->string('link')->default('');
            $table->string('color')->default('');
            $table->string('label')->default('');
            $table->boolean('active')->default(1);
            $table->string('coupon_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('product_stripe_id')->references('stripe_id')->on('products')->onUpdate('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onUpdate('cascade');

        });



    }


    public function down(){

        DB::drop($this->table);

    }
}
