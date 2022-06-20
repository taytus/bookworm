<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;
class CreatePerformanceIndicatorsTable extends Migration{

    private $table="performance_indicators";

    public function up(){

        return;

        DB::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monthly_recurring_revenue');
            $table->decimal('yearly_recurring_revenue');
            $table->decimal('daily_volume');
            $table->integer('new_users');
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(){

        DB::drop($this->table);
    }
}
