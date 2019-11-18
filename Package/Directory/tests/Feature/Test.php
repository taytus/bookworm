<?php
use Tests\TestCase;

class Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest(){

        $this->create_directory();



    }

    public function create_directory(){
        $directory_path=base_path('testing_directory_package');
        $directory_class=new Directory_test();

        $this->assertDirectoryNotExists($directory_path);
        $directory_class->create_folder($directory_path);
        $this->assertDirectoryExists($directory_path);

    }

}