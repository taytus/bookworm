<?php
use Tests\TestCase;


class Test extends TestCase
{
    /** @test Strings Class*/
    function testDeleteTabs(){
        $strings= new Strings_test();
        $str="this\t is sparta\t";
        $res=$strings::delete_tabs($str);

        $this->assertEquals("this is sparta",$res);
    }

    function test_find_string_in_file(){
        $content="This is Sparta!!";
        $strings=new Strings_test();
        $file_path=storage_path("/app/testing.txt");
        //create a new file for testing purposes
        Storage::disk('local')->put('testing.txt', $content);

        $res1=$strings::find_string_in_file("this",$file_path,false);
        $this->assertTrue($res1->status);

        $res1=$strings::find_string_in_file("This",$file_path,false);
        $this->assertTrue($res1->status);

        $res1=$strings::find_string_in_file("This",$file_path);
        $this->assertTrue($res1->status);

        $res1=$strings::find_string_in_file("this",$file_path);
        $this->assertFalse($res1->status);

        $res1=$strings::find_string_in_file("blue",$file_path,false);
        $this->assertFalse($res1->status);
    }

    function test_remove_non_aphanumeric_chars(){
        $strings=new Strings_test();
        $str="--P*ea^c..e";
        $res=$strings::remove_non_aphanumeric_chars($str);

        $this->assertEquals("Peace",$res);
    }

    function test_remove_multiple_spaces(){
        $strings=new Strings_test();

        $str="Peac       e";
        $res=$strings::remove_multiple_spaces($str);
        $this->assertEquals("Peace",$res);

        $str="Peac       e";
        $res=$strings::remove_multiple_spaces($str,"_");
        $this->assertEquals("Peac_e",$res);

        $str="Peac       _e";
        $res=$strings::remove_multiple_spaces($str);
        $this->assertEquals("Peac_e",$res);

        $str="Peac       _e";
        $res=$strings::remove_multiple_spaces($str,"_");
        $this->assertEquals("Peac__e",$res);

        $str="Pe  ac       e";
        $res=$strings::remove_multiple_spaces($str,"_");
        $this->assertEquals("Pe_ac_e",$res);

        $str="Pe ac       e";
        $res=$strings::remove_multiple_spaces($str,"_");
        $this->assertEquals("Pe ac_e",$res);

        $str="Pe ac e";
        $res=$strings::remove_multiple_spaces($str,"_");
        $this->assertEquals("Pe ac e",$res);

    }

    function test_get_method_name(){
        $strings=new Strings_test();

        $str="Peac       e";
        $res=$strings::get_method_name($str);
        $this->assertEquals("peac_e",$res);

        $str="Peac       _e";
        $res=$strings::get_method_name($str);
        $this->assertEquals("peac_e",$res);

        $str="Pe  ac       e";
        $res=$strings::get_method_name($str);
        $this->assertEquals("pe_ac_e",$res);

        $str="Pe ac       e";
        $res=$strings::get_method_name($str);
        $this->assertEquals("pe_ac_e",$res);

        $str="Pe ac e";
        $res=$strings::get_method_name($str);
        $this->assertEquals("pe_ac_e",$res);

    }

    ///lines
    ///
    function test_get_line_number_x(){
        $strings=new Strings_test();
        $str="this \n is\na\nnice\nday";
        $res=$strings->get_line_number_x($str,1);

        $this->assertEquals($res,"this ");
        $this->assertNotEquals($res,"this");
    }
    function test_get_last_line(){
        $strings=new Strings_test();
        $str="this \n is\na\nnice\nday ";
        $res=$strings->get_last_line($str);

        $this->assertEquals($res,"day ");
        $this->assertNotEquals($res,"day");
    }



}