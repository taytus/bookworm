<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Seeders;
use App\Partials\PartialTemplate;

class HTMLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $partials=['FootersTableSeeder','SocialFollowersTableSeeder'];
    public function run($extra = null)
    {
        // get the sections for each template and only call the TableSeeders
        //associated with those sections

        //make a method to be executed only if needed
        $template=PartialTemplate::find($extra);
        $sections=json_decode($template->master->sections_id,true);

        $seeder=new Seeders();

        foreach ($sections as $section ){
            $seeder->call($this->partials[$section -1],$extra);
        }


    }


}
