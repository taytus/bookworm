<?php

namespace App\Console\Commands;

use App\MyClasses\Directory;
use Illuminate\Console\Command;
use ROBOAMP\Batman;
use ROBOAMP\CLI\Debug as CliDebug;
use App\MyClasses\Paths;
use App\MyClasses\Templates;
use ROBOAMP\Files;
use ROBOAMP\Git;
use ROBOAMP\MyArray;
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

		$arr_class= new MyArray();
		$demo=["hi","Bye"];
		$arr_class->check_for_string_in_array("hello",$demo);
		dd($arr_class);


        $dir_class=new Directory();
        $res=$dir_class->get_dirs_in_dir(base_path('app'));
        dd($res);


        $git_class=new Git();
        $git_class->verbose=true;
        $new_branch="nono";

        $current_branch=$git_class->current_git_branch();
        $branches=$git_class->branches();

        $res=$git_class->create_branch($new_branch);
        $res2=$git_class->checkout($new_branch);


        dd($current_branch,$branches,$res,$res2);

        dd("exit");

        //

        $file=new Files();
        $template= new Templates();
        $route_path=Paths::path_to_folder('routes')."/web.php";

        $file->backup_file_with_timestamp($route_path);


    }
}
