<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ROBOAMP\Batman;
use ROBOAMP\CLI\Debug as CliDebug;
use App\MyClasses\Paths;
use App\MyClasses\Templates;
use ROBOAMP\Files;


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

        $file=new Files();
        $template= new Templates();
        $route_path=Paths::path_to_folder('routes')."/web.php";

        $file->backup_file_with_timestamp($route_path);


    }
}
