<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\MyClasses\Seeders;
use ROBOAMP\DB;

class UpdateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;

        Schema::table('subscriptions', function ($table) {


            if (!Schema::hasColumn('subscriptions', 'customer_id')) {
                $table->uuid('customer_id')->nullable();
                $table->foreign('customer_id')->references('id')->on('customers');
            }

            $table->integer('user_id')->unsigned()->nullable()->change();

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
