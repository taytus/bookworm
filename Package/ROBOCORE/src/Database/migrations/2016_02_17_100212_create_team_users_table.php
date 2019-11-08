<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateTeamUsersTable extends Migration{

    private $table="team_users";

    public function up(){

        return true;

        DB::create($this->table, function (Blueprint $table) {
            $table->integer('team_id');
            $table->integer('user_id');
            $table->string('role', 20);

            $table->unique(['team_id', 'user_id']);
        });
    }


    public function down(){
        DB::drop('team_users');
    }
}
