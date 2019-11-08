<?php

use Illuminate\Database\Seeder;
use App\Partials\Social;

class SocialFollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($template_id=null)
    {
        $footer = factory(Social::class)->create([
            'template_id'=>$template_id
        ]);


    }

}
