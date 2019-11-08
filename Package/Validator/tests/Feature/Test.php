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

        $this->validate_email();
        $this->validate_strings();
    }

    private function validate_strings(){
        $validator = new Validator_test();

        $strings_equals_no_numbers_no_special_chars=[
            "hell o",
            "hell     o",
        ];

        $strings_equals_no_numbers_special_chars=[
            "hell o",
            "hell,     o",
            "hel,l,o"
        ];

        $strings_equals_numbers_no_special_chars=[
            "hell1o",
            "he2l2l     o",
        ];

        $strings_equals_numbers_special_chars=[
            "hell1o",
            "he2l2l    , o",
            "hell,1,0"
        ];

        //////////NOT EQUALS/////
        $strings_not_equals_no_numbers_no_special_chars=[
            "hell 1o",
            "hell  #   o",
            "hell1  #   o",
        ];

        $strings_not_equals_no_numbers_special_chars=[
            "hell 1o",
            "hell#10"
        ];
        $strings_not_equals_numbers_special_chars=[
            "",
        ];


        foreach ($strings_equals_no_numbers_no_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings);
            $this->assertEquals($strings, $res);
        };
        foreach ($strings_equals_no_numbers_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings,false,true);
            $this->assertEquals($strings, $res);
        };
        foreach ($strings_equals_numbers_no_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings,true);
            $this->assertEquals($strings, $res);
        };
        foreach ($strings_equals_numbers_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings,true,true);
            $this->assertEquals($strings, $res);
        };

        //NOT EQUALS
        foreach ($strings_not_equals_no_numbers_no_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings);
            $this->assertNotEquals($strings, $res);
        };
        foreach ($strings_not_equals_no_numbers_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings,false,true);
            $this->assertNotEquals($strings, $res);
        };
        foreach ($strings_not_equals_numbers_special_chars as $strings) {
            $res = $validator->validation_rules_alphabetic($strings,true,true);
            $this->assertNotEquals($strings, $res);
        };

    }

    private function validate_email(){
        $validator = new Validator_test();

        $emails_equals = [
            "roberto@roboamp.com",
            "roberto@lol.co",
            "a@a.com",
            "z.s.z@lol.za",
            "z-z-z.a@kk.com",
            "john.doe43@domainsample.co.uk"
        ];
        $emails_not_equals=[
            "@tat",
            "@tay.com",
            "asdsadasdsad",
            "aaa.@",
            "dsadsad@dadasd",
            "sasas@.a",
            "asada.o.o",
            "asas.a",
        ];

        foreach ($emails_equals as $email) {
            $res = $validator->validation_rules_valid_email($email);
            $this->assertEquals($email, $res);
        }

        foreach ($emails_not_equals as $email) {
            $res = $validator->validation_rules_valid_email($email);
            $this->assertNotEquals($email, $res);
        }

    }
}