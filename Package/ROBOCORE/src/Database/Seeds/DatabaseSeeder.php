<?php

use Illuminate\Database\Seeder;

use App\MyClasses\Seeders;
use App\MyClasses\Render\RenderFooter;
use App\MyClasses\Server;
use App\MyClasses\Stripe\RoboStripe;
use App\MyClasses\Stripe\RoboStripeCli;
class DatabaseSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $server = new Server();

        $create_stripe_data=false;
        $delete_stripe_data=false;

        $robostripe=new RoboStripe();


        $seeder=new Seeders($create_stripe_data);

        $server_info=$server->server_info();

        if($server_info['testing_server']==true && $delete_stripe_data){
                echo "Deleting Data from Stripe...\n";
                $robostripe->delete_all_testing_data();

        }



        $seeder->call(ProductsTableSeeder::class);
        $seeder->call(PlansTableSeeder::class);
        $seeder->call(UserRolesTableSeeder::class);
        $seeder->call(PropertyStatusTableSeeder::class);
        $seeder->call(NotificationsTypeTableSeeder::class);
        $seeder->call(NotifyTableSeeder::class);


        if($server->testing_server()){
            $seeder->call(UsersTableSeeder::class);
            $seeder->call(CustomersTableSeeder::class);
            $seeder->call(SubDomainsTableSeeder::class);
            $seeder->call(PropertiesTableSeeder::class);
            $seeder->call(PagesTableSeeder::class);

            //$seeder->call(TemplatesTableSeeder::class);
           // $seeder->call( customers\CallBoxStorageSeeder::class);
            //$seeder->call(customers\TiepermanHealthSeeder::class);
            //$seeder->call(customers\StandishSeeder::class);
            $seeder->call(WidgetsTableSeeder::class);
            $seeder->call(CountersTableSeeder::class);

        }else{
            echo "\nTHIS IS NOT A TESTING SERVER\n";
            echo "Users, Customers, Properties and Individual customers have not been seeded\n\n";

        }
        $seeder->call(AMPScriptsTableSeeder ::class);
        $seeder->call(Ampscript_Template::class);
        $seeder->call(\database\seeds\amp4email\Ecommerce::class);
        $seeder->call(SlugFilterTableSeeder::class);

        //demo_old
        //$seeder->call(SubscriptionsTableSeeder::class);
        $seeder->call(PlatformsTableSeeder::class);
        $seeder->call(StepsTableSeeder::class);



        $seeder->call(ReferralProgramTableSeeder::class);
        $seeder->call(CouponsTableSeeder::class);


        //refresh Stripe
        //echo "\n\n Seeding Stripe\n\n";

       // $robostripe=new RoboStripeCli();
        //$robostripe->refresh();


    }

}
