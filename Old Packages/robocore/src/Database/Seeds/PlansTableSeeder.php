<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Plan;
use App\MyClasses\Seeders;
use App\MyClasses\Stripe\RoboStripe;
use App\Product;
use ROBOAMP\DB; as myDB;


class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $create_stripe_data;
    public function run($create_stripe_data){
        $this->create_stripe_data=$create_stripe_data;
        $now = new Carbon();
        $seeders=new Seeders();
        $robostripe= new RoboStripe();

        myDB::truncate('plans');

        $prices=Product::all();

        $products=Product::all();


        $data=array(
            ['coupon_id'=>'beta','nickname'=>'Beta','interval'=>'year','currency'=>'usd','product_stripe_id'=>$prices[0]->stripe_id,'amount'=>0,'sub_title'=>'12 Months Free!!','photo'=>asset('/plans/robo starter.png'), 'label'=>'$0', 'title_caption'=>'Beta Plan', 'learn_more'=>'1 year free ROBOAMP services for your landing page. Open to all of our fellow YC Startup School friends!','link'=>'google.com','color'=>'#05a49a','active'=>1],

            ['nickname'=>'Starter Plan','interval'=>'month','currency'=>'usd','product_stripe_id'=>$prices[1]->stripe_id,'amount'=>500,'active'=>0],
            ['nickname'=>'Starter','interval'=>'month','currency'=>'usd','product_stripe_id'=>$prices[2]->stripe_id,'amount'=>1000,'active'=>0,'sub_title'=>'sub_title_1','photo'=>asset('/plans/robo starter.png')  , 'label'=>'label_1', 'title_caption'=>'title_caption_1', 'learn_more'=>'Great product description will be entered right here','link'=>'google.com','color'=>"#179dc7"],
            ['nickname'=>'Monthly','interval'=>'month','currency'=>'usd','product_stripe_id'=>$prices[3]->stripe_id,'amount'=>1000,'sub_title'=>'Pay as you go','photo'=>asset('/plans/robo business.png'), 'label'=>'$30', 'title_caption'=>'Great Starter Option', 'learn_more'=>'100% Valid AMP Conversion, 100% Satisfaction Guaranteed, Instant Speed, Zero Programming','link'=>'google.com','color'=>'#8a3b8f'],
            ['nickname'=>'Annually','interval'=>'year','currency'=>'usd','product_stripe_id'=>$prices[4]->stripe_id,'amount'=>10000,'sub_title'=>'2 Months Free','photo'=>asset('/plans/robo professional.png'), 'label'=>'$300', 'title_caption'=>'Customer Preferred', 'learn_more'=>'100% Valid AMP Conversion, 100% Satisfaction Guaranteed, Instant Speed, Zero Programming','link'=>'google.com','color'=>'#05a49a']
        );

        foreach ($data as $item){
            $plan = new Plan();
            $counter=0;
            foreach ($item as $obj =>$val){
                $plan->stripe_id='templ_'.rand(1,800);

                $plan->$obj = $val;
                $counter++;

            }
            $plan->save();

        };

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


    }

}
