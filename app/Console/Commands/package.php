<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MyClasses\Directory;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class package extends Command
{
    private $package_name,$root_path_to_package,$full_package_path;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package {debug?}';
    private $debug;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This creates a new repo and a new package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->root_path_to_package=base_path('Package');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->debug=$this->argument('debug');

        $this->package_name=$this->ask("What's the name of the package");
        $this->create_package();
    }
    private function create_package(){
        $this->clone_package_directory();
        $this->full_package_path=$this->root_path_to_package.'/'.$this->package_name;
        $this->create_repo();
        $this->create_first_commit();

        dd("done!");
    }
    private function create_first_commit(){
        $this->debug_message('Creating First Commit');
        chdir($this->full_package_path);
        $first_commit_path=$this->full_package_path.'/first_commit.sh';
        dd($first_commit_path);
        shell_exec('chmod 0500 '.$first_commit_path);
        shell_exec($first_commit_path .' '.$this->package_name);

    }
    //this will create a repo on github
    private function create_repo(){
        $this->debug_message('Creating Repo in GITHUB');
        $setup_repo_path=$this->full_package_path.'/setup-repo.sh';
        shell_exec('chmod 0500 '.$setup_repo_path);
        shell_exec($setup_repo_path .' '.$this->package_name. ' '. $this->root_path_to_package.$this->package_name);

    }
    private function clone_package_directory(){
        $this->debug_message('Cloning Package Directory');
        $directory_class=new Directory();
        $template_path=base_path('/templates/packages');
        $package_path=base_path('/package/'.$this->package_name);
        $directory_class->copy_files_recursively($template_path, $package_path);
    }
    private function debug_message($message){
        if($this->debug) $this->info($message);

    }
}
