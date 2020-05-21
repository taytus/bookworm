<?php
namespace ROBOAMP\CLI;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleInput;
use ROBOAMP\Strings;



//http://patorjk.com/software/taag/#p=testall&f=Modular&t=Speedy

class CliStyle extends Command {


    const NUMBERS_OF_SPACES_PER_TAB = 4;
    public $input;
    public $output;
    private $break_line="<br>";
    public $helper;
    public $cli=null;

    public function __construct($cli=null){
        parent::__construct();
        $this->output = new ConsoleOutput();
        if(!is_null($cli))$this->cli=$cli;
    }




    public function error_message($message){
        $this->output_text($message,'error');

    }
    public function success_message($message){
        $this->output_text($message,'success');
    }
    public function log_message($message,$extra_padding=false){

        if($extra_padding)return $this->log_message_with_extra_padding($message);

        $this->output_text($message,'log');

    }
    public function log_message_with_extra_padding($message){
        $padding_space=Strings::get_spaces_from_string($message);

        $this->output_text($padding_space,'log');

        $this->output_text($message,'log');

        $this->output_text($padding_space,'log');
    }


    private function output_text($message,$style='success'){
        return $this->output_message($message,$style,'text');
    }
    public function output_message($message,$style,$type){
        if($type=='text'){
            $style_type="style_text_".$style."_message";
            $handler = array( $this, $style_type);
            $params = array($message);
            $message=call_user_func_array($handler , $params);
            $this->output->writeln($message);

        }

    }
    public function style_text_log_message($message=null){
        $message=(is_null($message)?'Log':$message);
        return "<bg=blue;fg=white;options=bold>".$message."</>";
    }
    public function style_text_success_message($message=null){
        $message=(is_null($message)?'Success':$message);
        return "<bg=green;fg=black;options=bold>".$message."</>";
    }
    public function style_text_error_message($message=null){
        $message=(is_null($message)?'Fail':$message);
        return "<bg=red;fg=white;options=bold>".$message."</>";
    }
    public function jump($message){
        $this->my_message($message);
        echo $this->break_line;
    }

    public static function tabs($n){

        $str='';
        for($j=0;$j<=$n;$j++){
            $str.= self::space(self::NUMBERS_OF_SPACES_PER_TAB);
        }
        return $str;

    }

    public static function space($n){
        $str="";
        for($j=0;$j<$n;$j++){
            $str.="&nbsp;";
        }
        return $str;
    }

    public static function style($status){
        $style="color:blue;";

        if($status!="Active"){
            $style="color:red;";
        }
        return $style;
    }

    public  function signature(){

echo "
██████╗  ██████╗ ██████╗  ██████╗  █████╗ ███╗   ███╗██████╗
██╔══██╗██╔═══██╗██╔══██╗██╔═══██╗██╔══██╗████╗ ████║██╔══██╗
██████╔╝██║   ██║██████╔╝██║   ██║███████║██╔████╔██║██████╔╝
██╔══██╗██║   ██║██╔══██╗██║   ██║██╔══██║██║╚██╔╝██║██╔═══╝
██║  ██║╚██████╔╝██████╔╝╚██████╔╝██║  ██║██║ ╚═╝ ██║██║
╚═╝  ╚═╝ ╚═════╝ ╚═════╝  ╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝╚═╝

 \n";

        }


    /**
     * @param $error_message
     * @param $type ERROR |INFO | QUESTION | COMMENT
     */

    public static function header($message){
        $err_msg=strtoupper("   ***   ".$message."   ***   ");
        $line_length= strlen($err_msg);
        $line=str_repeat(" ",$line_length);

        $output = new ConsoleOutput();
        echo "\n";

        $output->writeln("<question>".$line."</question>");
        $output->writeln("<question>".$err_msg."</question>");
        $output->writeln("<question>".$line."</question>");

        echo "\n";

    }


}