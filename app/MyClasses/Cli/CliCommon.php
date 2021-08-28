<?php


namespace App\MyClasses\Cli;

use App\MyClasses\Cli\CliStyle;
use Illuminate\Support\Facades\DB;
use Artisan;

class CliCommon {


    protected $option;
    protected $active_class;
    protected $output;
    protected $format;


    private  $arr_main_options=["Tools","Properties","Users","Pages","Cleanup"];
    private  $level_menu_1= [
        "Tools"=>["CURL","Validate","Change from HTTP to HTTPS","Update Property URL","Update Property Domain"],
        "Properties"=>["Create New Property","Pages for Account X"],
        "Users"=>["New User"],
        "Pages"=>["List Pages URLs","Info about Pages"],
        "Cleanup"=>["Directories","Stripe"]

    ];
    //delete
    public function test_batman_function(){
        dd('boom!!');
    }
    private $level_menu_2=["Tools"=>["A","B","C"]];

    public function __construct($output=null){
        system('clear');

        if(!is_null($output)) {
            $this->output=$output;
            $this->format=new CliStyle();
            $this->format->signature();
        }



    }

    //creates the menus based on array passed
    public  function show_menu($options,$question="",$data = null){

        $question=($question==""?"Select an option":$question);
        $j=0;
        //ask if there is a key called ID
        if (array_key_exists('id', $options)) {
            echo "The 'ID' element is in the array\n";
        }

        foreach ($options as $option){
            $j++;
            echo $j." - ".$option."\n";
        }

        $data=$this->ask($question,$data);

        if($data['error']==0){
            $error=$this->process_answer($data);
        }



        return $data;

    }

    public function list_main_menu(){

        CliStyle::header("Main Menu");

        $question="Select an option for Main Menu";

        $this->show_menu($this->arr_main_options,$question);

    }
    private function process_answer($data){

        $data['level']++;

        $function="level_menu_".$data['level'];


        if(!isset($this->$function)){
            //this means there is not another menu level
            CliStyle::my_message("not available operations",'error');

            dd($data,$function);

            return false;
        }


        //if the answer belongs to a menu, I show that menu again
        if(count($this->$function[$data['str_function']])>0) {
            CliStyle::my_message($data['str_function'] . " Menu", "question");

            //show the menu again
            if($data['level']==1) {
                $menu=$this->$function[$this->arr_main_options[$data['index']]];
                $this->show_menu($menu,"",$data);
            }else{
                $menu=["This","is","Spartaaaaaaa!!"];
                $this->show_menu($menu,"",$data);
                dd("this is for third level menues");
            }

        }


    }


    private function ask($question = "Select an option",$data){

        if(!isset($data)){
            $data['level']=0;
        }

        $data['error']=0;

        $data['index']=(int)$this->output->ask($question) -1;

        //check for overflow

        if( $data['index'] > count($this->arr_main_options) || $data['index']==-1){

            CliStyle::my_message("OPTION NOT VALID","error");

             $data['error']=1;

             return $data;
        }


        //get the name of the function I need to call from the array
        $data['active_class']="Cli".$this->arr_main_options[$data['index']];
        $data['str_function']=$this->arr_main_options[$data['index']];

        return $data;
    }

    public function print_message_before_showing_menu($message,$menu,$sleep_time=5){
        $this->print_message($message);
        sleep($sleep_time);
        //Artisan::call($menu);
    }

    private function print_message($message,$break_lines = 1){
        $break_line="";
        for ($j=0;$j<=$break_lines;$j++){
            $break_line.="\n";
        }
        echo $message.$break_line;
    }




}