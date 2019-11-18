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

        $array=new Directory_test();

        $this->assertEquals("a","a");

    }
}