<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MyClasses\Directory;


class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the com command for each Package';

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
        //get all the packages
        $directory_class=new Directory();
        $packages=$directory_class->get_dirs_in_dir(base_path('Package'));
        foreach ($packages as $item){
            echo "Starting process for package: ".$item."\n";
            chdir($item);

            $com="cd src;git add .; git commit -m 'update'; git push origin; ./tag.sh;";
            $message = shell_exec($com . " 2>&1");
            echo $message ."\n\n";
            dd('ended');
        }
        //chdir('/Users/Taytus/projects/bookworm');



    }
}
