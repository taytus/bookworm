<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ROBOAMP\DB;

class CreateContactsTable extends Migration{

    private $table='contacts';

    public function up(){
        return;
        DB::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 70);
            $table->uuid('title')->nullable();
            $table->string('phone', 200)->nullable();
            $table->string('avatar', 200);
            $table->timestamps();
        });

    }

    public function down(){

        DB::drop($this->table);
    }
}
