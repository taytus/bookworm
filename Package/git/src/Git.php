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

    public function init(){
        shell_exec('git init');
        shell_exec('git add .');
        shell_exec('git commit -m "first commit"');
    }
		
		/**
		 * This method stages and commits changes to the local Git repository.
		 * The Git commands are executed in the context of the project directory,
		 * enabling this method to function correctly whether called from a CLI command or a controller.
		 *
		 * @param string $message The commit message. Defaults to an empty string if not provided.
		 * @param boolean $debug An optional flag that, if true, dumps the commit output for debugging purposes.
		 *
		 * @return void
		 */
		public function commit($message = "", $debug =false) {
				// Define the project directory
				$project_dir = base_path() ; // Replace this with the actual path
				
				// Get the current status of the Git repository
				$status_original = exec('cd ' . $project_dir . ' && git status', $output);
				
				// Stage all changes in the project directory
				$changes = exec('cd ' . $project_dir . ' && git add .', $add);
				
				// Commit the staged changes with the provided message
				$res = exec('cd ' . $project_dir . ' && git commit -m "' . $message . '"', $commit);
				
				// Get the new status of the Git repository after the commit
				$new_status = exec('cd ' . $project_dir . ' && git status', $output);
				
				// If the debug flag is set, dump the output of the commit command
				if ($debug) {
						return "output from commit   = ".$res;
				}
		}
		public function push_to_github($branch){
				$output = shell_exec('git push kakatua ' . escapeshellarg($branch));
				dump($output);
		}
		public function commit_and_push_to_github($message=" ",$branch="roberto"){
				$this->commit($message);
				$this->push_to_github($branch);
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




