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





    }

    public function create_directory(){
        $directory_class=new Directory_test();
        $directory_path=base_path('/test');
        dd($directory_path);

    }

}