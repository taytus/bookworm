<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ROBOAMP\Strings;

class debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ROBOAMP:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){



        $str_class = new Strings();
        $strs = ["0"];
        for ($i = 0; $i < 20; $i++) {
            $strs[] = strval((intval($strs[$i]))+($i+1));
        }

        foreach ($strs as $item) {
            echo "\n" . $str_class->get_total_tabs($item).$item."\n";

        }


        die('bye');


    }
}
