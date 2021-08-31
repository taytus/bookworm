<?php

namespace App\Console\Commands;

use App\MyClasses\Files;
use App\MyClasses\Git;
use Illuminate\Console\Command;
use App\MyClasses\Directory;
use ROBOAMP\Strings;
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
    private $debug,$tmp_path;

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
        $this->clone_package_directory_to_tmp_directory();
        $this->update_package_with_new_name();

        dd('end');
        $this->create_repo();
        $this->clone_package_directory_to_package_directory();
        $this->cleanup_tmp_packages_directory();

        dd("done!");
    }

    private function get_all_files(){
        $directory=new Directory();
        $package_path=$this->tmp_path.$this->package_name;
        return $directory->get_all_files_in_directory_recursively($package_path);
    }
    private function update_package_with_new_name()
    {
        $this->debug_message('Updating Template with new Package Name');
        $string_class=new Strings();
        $default_template_name="Directory";
        $new_file_names=[];

        $files=$this->get_all_files();

        //rename every file to the new package name
        foreach ($files as $item){
            $tmp_file_name=$string_class->replaceFirst($default_template_name,ucfirst($this->package_name),$item);
            $new_file_names[]=$tmp_file_name;
            rename($item,$tmp_file_name);
        }


        dd($files,$new_file_names);

    }


    private function cleanup_tmp_packages_directory(){
        $dir=new Directory();
        $path='/Users/taytus/Projects/packages/';
        $dir->delete_everything_inside_dir($path);
        $this->debug_message('Temp packages directories has been reset');
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
        $git=new Git();
        $flags="--private --confirm";
        $this->debug_message('Creating Repo in GITHUB');
        //change directory to the root of the package and init git
        chdir($this->tmp_path.$this->package_name);
        $git->init();

        $this->debug_message('Local Repo has been initialized');

        //create the project in github
        shell_exec('gh repo create '.$this->package_name.' '.$flags);
        shell_exec('git remote add github https://github.com/taytus/'.$this->package_name.'.git');
        shell_exec('git push -u github');
        $this->debug_message('Repo in github has been created');
    }
    //takes the template located in templates/packages and copy it
    //on package/$this->package_name
    private function clone_package_directory_to_tmp_directory(){
        $this->tmp_path='/Users/taytus/Projects/packages/';
        $this->debug_message('Cloning Package Directory');
        $directory_class=new Directory();
        $template_path=base_path('/templates/packages');
        //clone everything in projects/packages/$this->package_name
        $tmp_package_path=$this->tmp_path.$this->package_name;
        //$package_path=base_path('/package/'.$this->package_name);
        $directory_class->copy_files_recursively($template_path, $tmp_package_path);
        $this->full_package_path=$this->root_path_to_package.'/'.$this->package_name;
    }
    private function clone_package_directory_to_package_directory(){
        $this->debug_message('Cloning Package Directory into Package');
        $directory_class=new Directory();
        $template_path=$this->tmp_path.$this->package_name;
        $package_path=base_path('/package/'.$this->package_name);
        $directory_class->copy_files_recursively($template_path, $package_path);
        $this->debug_message('Cloning Package Has been completed');

    }

    private function debug_message($message){
        if($this->debug) $this->info($message);

    }
}
