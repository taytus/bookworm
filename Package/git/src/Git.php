<?php
namespace ROBOAMP;

class Git{
    public $verbose=false;

    public function current_git_branch(){
        $shellOutput = [];
        exec('git branch | ' . "grep ' * '", $shellOutput);
        foreach ($shellOutput as $line) {
            if (strpos($line, '* ') !== false) {
                $current_branch=trim(strtolower(str_replace('* ', '', $line)));

                $this->output("The current branch is ". $current_branch);

                return $current_branch;
            }
        }
        return null;
    }

    public function checkout($branch,$create=""){
        $res=exec('git checkout '.$create .' '.$branch. ' 2>&1');


        $this->output($res);
    }
    public function branches(){
        $res=shell_exec('git branch  2>&1');

        return $this->process_list_as_array($res);

    }

    public function process_list_as_array($array){
        $arr= new MyArray();
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
        $res=$this->checkout($branch,"-b");

        dd($res,__METHOD__);
        $this->output("Branch ".$branch." has been created");
        return true;
    }
    public function clone_remote_branch($branch_origin,$repo_url){
        $res=exec('git clone --branch '.$branch_origin .' '.$repo_url. ' 2>&1');
        $this->output($res);
        return true;
    }
    public function clone_local_branch($branch_origin, $branch_destination){
        $res=exec('git checkout -b '.$branch_destination .' '.$branch_origin. ' 2>&1');
        $this->output($res);
        return true;
    }
    public function push_to_repo($repo,$branch){
        $res=exec('git push '.$repo .' '.$branch. ' 2>&1');
        $this->output($res);
        return true;
    }
    private function output($string){

        if($this->verbose) {
            echo "\n" . $string . "\n";
        }
    }
}




