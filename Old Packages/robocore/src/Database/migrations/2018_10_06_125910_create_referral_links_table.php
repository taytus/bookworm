<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\MyClasses\Seeders;
use ROBOAMP\DB;

class CreateReferralLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;

        Schema::create('referral_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('referral_program_id')->unsigned();
            $table->string('code', 36)->index();
            $table->unique(['referral_program_id', 'user_id']);
            $table->timestamps();
        });

        Schema::table('referral_links', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('referral_links', function (Blueprint $table) {

            $table->foreign('referral_program_id')->references('id')->on('referral_programs');

        });

        Schema::table('users', function (Blueprint $table) {

            $table->foreign('referral_link_id')->references('id')->on('referral_links');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::drop('referral_links');

    }
}
