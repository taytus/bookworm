<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;
class CreateInvitationsTable extends Migration{

    private $table="invitations";

    public function up(){

        return;
        DB::create($this->table, function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('team_id')->index();
            $table->integer('user_id')->nullable()->index();
            $table->string('email');
            $table->string('token', 40)->unique();
            $table->timestamps();
        });
    }

    public function down(){
        DB::drop($this->table);
    }
}
