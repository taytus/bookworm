<?php

namespace roboamp;

use ROBOAMP\Strings;
use ROBOAMP\Git;

class Git{

    public function current_git_branch(){
        $shellOutput = [];
        exec('git branch | ' . "grep ' * '", $shellOutput);
        foreach ($shellOutput as $line) {
            if (strpos($line, '* ') !== false) {
                return trim(strtolower(str_replace('* ', '', $line)));
            }
        }
        return null;
    }

    public function checkout($branch){
        $res=exec('git checkout '.$branch. ' 2>&1');
        $this->output($res);
    }
    public function branches(){
        $res=shell_exec('git branch  2>&1');

        return $this->process_list_as_array($res);

    }

    public function process_list_as_array($array){
        $arr= new Git();
        $str=explode("\n",$array);
        array_pop($str);
        //removes active branch
        $index=0;
        foreach ($str as $item){
            $str[$index]=str_replace(' ','',$item);
            if (Strings::find_string_in_string($item,"*")){
                $str[$index]=str_replace("* ","",$item);
            }

            $index++;
        }

        return $str;
    }
    public function create_branch($branch){

    }

    private function output($string){
        echo "\n".$string."\n";

        echo "OK";
    }
}
