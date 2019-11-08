<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\MyClasses\Seeders;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $seeders= new Seeders();
        $seeders->delete('subscriptions');
        $now= Carbon::now();


        $subscription= factory(App\Subscription::class,10)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



    }
}
