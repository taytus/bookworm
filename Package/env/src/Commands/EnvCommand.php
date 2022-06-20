<?php

namespace ROBOAMP\Commands;

use Illuminate\Console\Command;
use ROBOAMP\Server;
use ROBOAMP\Strings;

class EnvCommand extends Command
{

    protected $signature = 'env_info';
    private $server_env='';
    private $env_file_content="";
    private $debug_message="";

    protected $description = 'Prints out ENV vars to check if everything is OK';

    public function __construct(){
        $server= new Server();
        $this->server_env= strtoupper($server->current_environment);
        parent::__construct();
    }


    public function handle(){
        $this->env_file_content=Strings::get_file_content(base_path('.env'));
        parent::__construct();
        $this->print_db_info();
    }

    private function print_db_info(){
        $keys=['DB_CONNECTION','DB_HOST','DB_PORT','DB_DATABASE','DB_USERNAME','DB_PASSWORD'];

        $results=$this->get_results($keys);
        $j=0;
        $this->table([$results['keys']],[$results['values']]);
        echo $this->debug_message;

    }

    //based on the keys and prefix, creates an array with keys and the values and returns both arrays
    private function get_results($keys){
        $values=[];
        $j=0;
        // dd($keys);
        foreach ($keys as $item){
            $key=$this->server_env."_".$item;
            if(env($key)!==null){
                $values[$j]=env($key);
            }else{
                $values[$j]="NULL";
                //we know we have null values, but we don't know why,
                //so we have to check if the keys have a different prefix
                $this->debug_info($item);
            }
            $j++;
        }

        $results['keys']=$keys;
        $results['values']=$values;
        return $results;
    }
    private function debug_info($key){
        $res=Strings::find_string_in_string($this->env_file_content,$key);
        if($res){
            $this->get_prefix($key);
        }else{
            $this->debug_message.= "\nKey ".$key." has not been defined\n";
        }
    }
    private function get_prefix($key){
        $prefix=Strings::get_string_between($this->env_file_content,"\n",$key);
        $arr_prefix=explode("\n",$prefix);
        $new_prefix=str_replace("_","",end($arr_prefix));
        $this->debug_message.= "\nKey ".$key." has the prefix ". $new_prefix.". Prefix ".$this->server_env." was expected \n";

    }
}
