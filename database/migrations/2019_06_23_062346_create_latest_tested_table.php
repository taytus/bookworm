<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateLatestTestedTable extends Migration{

    private $table='latest_tested';

    public function up(){
        DB::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('package');
        });
    }

    public function down(){
        DB::drop($this->table);
    }
}
