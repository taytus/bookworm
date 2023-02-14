<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Cleanup;
use App\Events\FooterUpdate;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncate the table


        $table=DB::table('sections')->truncate();

        $dataset=[];
        $now=\Carbon\Carbon::now();

        $dataset[]=['name'=>'footer','options'=>json_encode([]),'created_at'=>$now,'updated_at'=>$now];
        $dataset[]=['name'=>'social_follow','options'=>json_encode([]),'created_at'=>$now,'updated_at'=>$now];

        DB::table('sections')->insert($dataset);


    }

}
