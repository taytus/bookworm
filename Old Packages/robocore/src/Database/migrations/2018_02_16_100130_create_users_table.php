<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateUsersTable extends Migration{

    private $table="users";

    public function up(){

        DB::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('test')->default(0);
            $table->boolean('admin')->default(false);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->text('photo_url')->nullable();
            $table->tinyInteger('uses_two_factor_auth')->default(0);
            $table->string('authy_id')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('two_factor_reset_code', 100)->nullable();
            $table->integer('current_team_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('current_billing_plan')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->string('card_country')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip', 25)->nullable();
            $table->string('billing_country', 2)->nullable();
            $table->string('vat_id', 50)->nullable();
            $table->text('extra_billing_information')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('last_read_announcements_at')->nullable();
            $table->timestamps();
            $table->integer('referral_link_id')->unsigned()->nullable();
            $table->integer('user_role_id')->unsigned()->default(1);

            $table->foreign('user_role_id')->references('id')->on('user_roles');

        });

    }


    public function down(){

        DB::drop($this->table);
    }
}
