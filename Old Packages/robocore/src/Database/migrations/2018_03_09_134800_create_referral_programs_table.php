<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\MyClasses\Seeders;
use ROBOAMP\DB;

class CreateReferralProgramsTable extends Migration
{
    const DEFAULT_LIFETIME = 7 * 24 * 60;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create('referral_programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('uri');
            $table->integer('lifetime_minutes')->default(self::DEFAULT_LIFETIME);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop('referral_programs');

    }
}
