<?php
namespace ROBOAMP;

use \ReflectionMethod;


class Dusk{


    public function clear_text_box($browser,$txt_where,$number_of_keystrokes=50){

        for($i=0;$i<50;$i++){
            $browser->clear($txt_where)->keys($txt_where,  '{backspace}');
            $i++;
        }

    }

}
