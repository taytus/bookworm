<?php

use Illuminate\Database\Seeder;
use ROBOAMP\DB; as myDB;
use ROBOAMP\Git;


class Ampscript_Template extends Seeder{

    public function run(){

        $table = "ampscript_template";
        myDB::truncate($table);
        $now = time();




        $scripts_array = [
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 1],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 2],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 3],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 4],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 5],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 6],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 7],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 8],
            ['template_id' => '3a256d94-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 9],

            //

            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 1],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 2],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 3],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 4],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 5],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 6],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 7],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 8],
            ['template_id' => '3b15df8e-ce72-11e7-acde-9b4153c2a21e', 'ampscript_id' => 9],



            /////payne mitchell
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 1],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 2],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 3],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 4],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 5],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 6],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 7],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 8],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 9],
            ['template_id' => '1bb72cae-798c-4676-a35e-34e63d0ceccc', 'ampscript_id' => 10],


            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 1],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 2],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 3],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 4],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 5],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 6],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 7],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 8],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 9],
            ['template_id' => '9b550101-b2cc-4e1e-97d2-a04a36eca2c1', 'ampscript_id' => 10],

        ];

        Git::create_items_from_array("App\Models\Pivots\Ampscript_Template", $scripts_array);
    }
}
