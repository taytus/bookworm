<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\MyClasses\Seeders;
use App\MyClasses\Server;
use App\MyClasses\Stripe\RoboStripeCouponsCli as Coupons;
use ROBOAMP\DB; as myDB;
use ROBOAMP\Git;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run(){

        $server=new Server();
        myDB::truncate('coupons');
        $now= Carbon::now('US/Central');
        $redeem_by=$now->addMonths(12);

        $coupon=new Coupons();
        $coupon->create_random_coupons(10);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $coupons=[
            ['id'=>'beta','duration'=>'forever','max_redemptions'=>'100','percent_off'=>100,'redeem_by'=>$redeem_by]
        ];



        if($server->testing_server()) {
           Git::create_items_from_array('App\Coupon', $coupons);
        }


    }
}
