<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreatePropertyTable extends Migration{

    private $table='properties';

    public function up(){
        return;

        $now=\Carbon\Carbon::now();
        $last_pinged=$now->subHours(8);

        DB::create($this->table, function (Blueprint $table) use($last_pinged) {


            $table->string('id',36)->primary();
            $table->string('url');
            $table->string('error_page')->nullable()->default(null);


            $table->uuid('customer_id');
            $table->integer('plan_id')->unsigned()->default(1);
            $table->integer('status_id')->unsigned();
            $table->boolean('main_website')->default(0);
            $table->boolean('seeder')->unsigned()->default(0);
            $table->boolean('roboamp_analytics')->default(0);
            $table->string('google_analytics')->nullable()->default(null);
            $table->integer('max_slugs')->nullable()->default(4);

            $table->integer('steps_id')->unsigned()->default(1);
            $table->boolean('white_label')->default(0);

            $table->integer('platform_id')->nullable();
            $table->integer('subdomain_id')->nullable();

            $table->char('coupon_id',255)->nullable();
            $table->smallInteger('pinger')->default(8);
            $table->dateTime('last_ping')->default($last_pinged);

            $table->timestamps();

            $table->foreign('steps_id')->references('id')->on('steps');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('status_id')->references('id')->on('property_status');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('coupon_id')->references('id')->on('coupons');

            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('subdomain_id')->references('id')->on('subdomains');


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
