<?php

namespace App\Console\Commands;

use function GuzzleHttp\Psr7\str;
use Illuminate\Console\Command;
use App\MyClasses\Directory;
use ROBOAMP\Files;
use App\Test as test_class;
use ROBOAMP\MyArray;
use ROBOAMP\Strings;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test all the different packages';
    private $testing_file_path;
    private $class_name;
    private $dir_labels;
    private $dirs;
    private $feature_path;
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
        $my_array=new MyArray();
        $file=new Files();



        $this->dirs=Directory::get_dirs_in_dir(base_path('Package'));
        $this->dir_labels=[];

        foreach ($this->dirs as $item) {
            $this->dir_labels[]=$item['basename'];
        }
       // print_r($this->dirs);


        $this->update_arr_positions();


        $option = $this->menu('Select Package',$this->dir_labels)->open();

        $selected_menu=$this->dirs[$option];
        $package_name=$selected_menu['basename'];
        $package_path=$selected_menu['full_path'];

        $this->save_latest_used_option($package_name);

        $this->clone_package_class_into_test($selected_menu);

        $this->update_testing_file();

        $res=$this->run_test();


        if($res)$this->commit($package_path,$package_name);

    }
    private function commit($package_path,$package_name){


        chdir($package_path."/src");
        $res=shell_exec("git add -A;git commit -m 'update'; git push origin; ./tag.sh");

        //$result=Strings::find_string_in_string($res,"nothing to commit, working tree clean");
        return $this->commit_bookworm($package_name);


    }
    private function commit_bookworm($package_name){

        echo "\n------------------------------------------------------------\n";
        echo "|                                                                  |\n";
        echo "|                                                                  |\n";
        echo "|                                                                  | \n";
        echo "|   ____    ___    ___   _  ____        __ ___   ____   __  __ \n";
        echo "|  | __ )  / _ \  / _ \ | |/ /\ \      / // _ \ |  _ \ |  \/  |\n";
        echo "|  |  _ \ | | | || | | || ' /  \ \ /\ / /| | | || |_) || |\/| |\n";
        echo "|  | |_) || |_| || |_| || . \   \ V  V / | |_| ||  _ < | |  | |\n";
        echo "|  |____/  \___/  \___/ |_|\_\   \_/\_/   \___/ |_| \_\|_|  |_|\n";
        echo "|                                                              \n";


        echo "|                                            |\n";
        echo "|                                            |\n";
        echo "|                                            |\n";
        echo "\n------------------------------------------------------------\n";



        chdir(base_path());

        $command="git add -A;git commit -m 'auto update for package ". $package_name."'; git push origin;";

        $res=shell_exec($command);

        return true;
    }

    private function run_test(){

        $result=false;

        $str=new Strings();

        if(!file_exists($this->feature_path."Test.php")){
            echo "\nThere is no testing file for package ".$this->class_name."\n";
            return $result;
        }

        $res=shell_exec('vendor/bin/phpunit Package/'.$this->class_name);
        $str_res=strpos($res,"OK");


        if($str_res==false){
            echo $res;
            echo "\nCommit has been canceled\n";
            return $result;
        }

        return true;
    }
    private function save_latest_used_option($package_name){
        $test=new test_class();
        $test->package=$package_name;
        $test->save();

        $test->deleteUntil($test->id);
    }
    private function clone_package_class_into_test($selected_menu){
        $directory=new Directory();


        $package_full_path=$selected_menu['full_path'];
        $this->class_name=$selected_menu['basename'];
        //grab the file and copy it into the test folder
        $files=new Files();
        $origin_file=$package_full_path."/src/".$this->class_name.".php";
        $this->feature_path=$package_full_path."/tests/Feature/";

        $this->testing_file_path=$this->feature_path.$this->class_name."_test.php";

        //make sure the directory exists
        $directory::create($directory->get_current_directory($this->testing_file_path));

        $files->copy_file($origin_file,$this->testing_file_path);
    }

    //remove stuff from package's main class that has been copied into test/Feature
    private function update_testing_file(){
        $files=new Files();
        $content=$files->get_file_content($this->testing_file_path);

        $str=str_replace("namespace ROBOAMP;","",$content);


        if(strpos($str,"class ".$this->class_name." extends")!=false){
            $str=str_replace("class ".$this->class_name." extends",
                "class ".$this->class_name."_test extends",$str);
        }else{
            $str=str_replace("class ".$this->class_name."{",
                "class ".$this->class_name."_test{",$str);
        }

        $files->re_write_file($str,$this->testing_file_path);
    }

    //makes sure that the latest test I ran is on the first position
    private function update_arr_positions(){

        $test=test_class::all()->last();
        $my_array=new MyArray();

        if($test!=null) {
            $position = $my_array->check_for_string_in_array($test->package, $this->dir_labels, true);

            $this->dir_labels = $my_array->move_to_top_by_index($this->dir_labels, $position);
            $this->dirs = $my_array->move_to_top_by_index($this->dirs, $position);
        }
    }




}
