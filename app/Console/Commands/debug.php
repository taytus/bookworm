<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ROBOAMP\Strings;
use ROBOAMP\CLI\Debug as CliDebug;

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

        $log=new CliDebug();

        $str_class = new Strings();
        $strs = ["1","22","333","4444","55555","666666","7777777","88888888","999999999","1000000000"];
        foreach($strs as $item) {
            $log::log($item,"Taytus");
        }



        die('bye');


    }
}
