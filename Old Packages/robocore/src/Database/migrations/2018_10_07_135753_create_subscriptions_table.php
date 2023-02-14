<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;

        Schema::create('subscriptions', function ($table) {
            $table->uuid('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->uuid('customer_id')->nullable();
            $table->integer('plan_id')->unsigned();
            $table->uuid('stripe_id');
            $table->uuid('property_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('plan_id')->references('id')->on('plans');

        });

        Schema::table('subscriptions', function (Blueprint $table) {

            $table->foreign('property_id')->references('id')->on('properties');

        });





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop('subscriptions');
    }
}
