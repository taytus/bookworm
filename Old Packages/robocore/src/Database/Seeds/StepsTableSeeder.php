<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use ROBOAMP\DB; as myDB;

class StepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table='steps';
        myDB::truncate($table);
        $confirm_btn='&nbsp &nbsp;<button  class="btn confirm" disabled >Confirm Step</button>';
        $data=array(
            ['copy'=>'Add a new Website','platform_id'=>2],
            ['copy'=>'Select your Platform','platform_id'=>2],
            ['copy'=>'Copy code in &lt;HEADER&gt; section '.$confirm_btn,'platform_id'=>2],
            ['copy'=>'ROBOAMP will generate AMP Code','platform_id'=>2],
            ['copy'=>'Everything is Ready','platform_id'=>2],

            ['copy'=>'Add a new Website','platform_id'=>3],
            ['copy'=>'Select your Platform','platform_id'=>3],
            ['copy'=>'Copy code in &lt;HEADER&gt; section '.$confirm_btn,'platform_id'=>3],
            ['copy'=>'ROBOAMP will generate AMP Code','platform_id'=>3],
            ['copy'=>'Everything is Ready','platform_id'=>3],

            ['copy'=>'Add a new Website','platform_id'=>4],
            ['copy'=>'Select your Platform','platform_id'=>4],
            ['copy'=>'Copy code in &lt;HEADER&gt; section '.$confirm_btn,'platform_id'=>4],
            ['copy'=>'ROBOAMP will generate AMP Code','platform_id'=>4],
            ['copy'=>'Everything is Ready','platform_id'=>4],

            ['copy'=>'Add a new Website','platform_id'=>5],
            ['copy'=>'Select your Platform','platform_id'=>5],
            ['copy'=>'Copy code in &lt;HEADER&gt; section '.$confirm_btn,'platform_id'=>5],
            ['copy'=>'ROBOAMP will generate AMP Code','platform_id'=>5],
            ['copy'=>'Everything is Ready','platform_id'=>5],

            ['copy'=>'Add a new Website','platform_id'=>6],
            ['copy'=>'Select your Platform','platform_id'=>6],
            ['copy'=>'Copy code in &lt;HEADER&gt; section '.$confirm_btn,'platform_id'=>6],
            ['copy'=>'ROBOAMP will generate AMP Code','platform_id'=>6],
            ['copy'=>'Everything is Ready','platform_id'=>6],

            ['id'=>99,'copy'=>'ROBOAMP Professional5','platform_id'=>null]

        );

        foreach ($data as $item){
            DB::table($table)->insert($item);
        };

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



    }
}
