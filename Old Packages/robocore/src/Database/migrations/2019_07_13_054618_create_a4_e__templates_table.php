<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;


class CreateA4ETemplatesTable extends Migration
{
    private $table_name='a4e_templates';

    public function up()
    {
        return;

        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop($this->table_name);
    }
}
