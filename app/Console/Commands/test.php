<?php

namespace App\Console\Commands;

use function GuzzleHttp\Psr7\str;
use Illuminate\Console\Command;
use App\MyClasses\Directory;
use ROBOAMP\Files;
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

        $dirs=Directory::get_dirs_in_dir(base_path('Package'));
        $dir_labels=[];

        foreach ($dirs as $item) {
            $dir_labels[]=$item['basename'];
        }

        $option = $this->menu('Select Package',$dir_labels)->open();

        $selected_menu=$dirs[$option];

        $this->clone_package_class_into_test($selected_menu);

        $this->update_testing_file();


        $test_path=$selected_menu['full_path']."/tests/Feature/Test.php";

        //$res=exec('vendor/bin/phpunit --filter '.$test_path);

        $res=exec('vendor/bin/phpunit Package/'.$this->class_name);

        //vendor/bin/phpunit --filter testBasicTest /Users/taytus/Projects/bookworm/Package/Validator/tests/Feature/Test.php
       dd($res);


    }
    private function clone_package_class_into_test($selected_menu){

        $package_full_path=$selected_menu['full_path'];
        $this->class_name=$selected_menu['basename'];
        //grab the file and copy it into the test folder
        $files=new Files();
        $origin_file=$package_full_path."/src/".$this->class_name.".php";
        $this->testing_file_path=$package_full_path."/tests/Feature/".$this->class_name."_test.php";

        ///Users/taytus/Projects/bookworm/Package/Validator
        $files->copy_file($origin_file,$this->testing_file_path);
    }
    private function update_testing_file(){
        $files=new Files();
        $content=$files->get_file_content($this->testing_file_path);

        $str=str_replace("namespace ROBOAMP;","",$content);
        $str=str_replace("class ".$this->class_name."{","class ".$this->class_name."_test{",$str);

        $files->re_write_file($str,$this->testing_file_path);
    }



}
