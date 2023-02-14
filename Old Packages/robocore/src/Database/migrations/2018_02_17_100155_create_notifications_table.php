<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateNotificationsTable extends Migration{

    private $table="notifications";

    public function up(){

        DB::create($this->table, function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id');
            $table->integer('created_by')->nullable();
            $table->string('icon', 50)->nullable();
            $table->text('body');
            $table->string('action_text')->nullable();
            $table->text('action_url')->nullable();
            $table->tinyInteger('read')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
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
