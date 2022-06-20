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
        $directory_class= new Directory_test();
        dd('OK');

        $this->assertDirectoryNotExists($directory_path);
        $directory_class->create_folder($directory_path);
        $this->assertDirectoryExists($directory_path);
        $this->delete_directory($directory_path);

    }
    public function delete_directory($directory_path){

        $directory_class=new Directory_test();
        $directory_class->delete_directory($directory_path);
        $this->assertDirectoryNotExists($directory_path);

    }

}
