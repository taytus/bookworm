<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateCouponsTable extends Migration{

    private $table="coupons";

    public function up(){

        DB::create($this->table, function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->integer('percent_off')->default(10);
            $table->string('duration',20)->nullable();
            $table->integer('max_redemptions')->default(1)->nullable();
            $table->timestamp('redeem_by');
            $table->integer('duration_in_months')->nullable();
            $table->integer('times_redeemed')->default(0);
            $table->timestamps();
        });
    }

    public function down(){

        DB::drop($this->table);
    }
}
