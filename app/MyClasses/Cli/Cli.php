<?php


namespace App\MyClasses\Cli;
use FontLib\Table\Type\loca;
use Illuminate\Console\Command;
use phpDocumentor\Reflection\Types\Callable_;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use App\MyClasses\Cli\CliValidator;
use Symfony\Component\Console\Helper\Table;
use App\MyClasses\Git;


class Cli  {

        private $live;
        public $output;
        public $colors;
        public $input;
        public $helper;
    //$data= main cli terminal
    public function __construct($data){

        $this->output=$data->data['output'];
        $this->live=$data->data['live'];
        $this->colors=$data->data['colors'];
        $this->input=$data->data['input'];
        $this->helper=$data->data['helpers'];

    }




    public function ask($question,$default=null){
        return $this->output->ask($question,$default);
    }

    public function choice_question($question,$options,$default){
        $question=new ChoiceQuestion($question,$options,$default);
        $val=$this->helper['question']->ask($this->input, $this->output, $question);
        return $val;
    }
    public function show_error($error_message){
        $cli_format=new CliStyle();
        $format=$cli_format->format_error_message($error_message);
        $this->output->writeln($format);

    }
    public function show_success($success_message){
        $cli_format=new CliStyle();
        $format=$cli_format->format_success_message($success_message);
        $this->output->writeln($format);
    }
    public function table($data,$fields=null){

        $headers=Git::get_keys_from_array($data);
        $data=Git::ignore_timestamps($data);


        if(array_key_exists('error_message',$headers)) dd($headers['error_message']);


        $table = new Table($this->output);
        //if $fields is null, then list all the fields, if not, then $fields is an array
        if(is_null($fields)){

        }else{
            $subset = $data->map(function ($info,$fields) {
                return $info->only($fields);
            });

        }


        $table
            ->setHeaders($headers)
            ->setRows($data)
        ;
        $table->render();
    }

    public function my_message($message,$type="info",$options=""){

        switch ($type) {
            case "custom":
                $this->output->writeln("<fg=" . $options[0] . ";bg=" . $options[1] . ";options=bold>" . $message . "</>");

                break;
            case "pass":
                $this->output->writeln("<fg=black;bg=green;options=bold>" . $message . "</>");

                break;
            default:
                $this->output->writeln("<" . $type . ">" . $message . "</" . $type . ">");

                break;
        }

    }

    public function set_validation($res,$field,$key=null,$error_message=null){

       // dd($res,$field,$key,$error_message);

        $validation=function ($answer) use ($res,$field,$key,$error_message) {
                $validator = new CliValidator();
                //setup validation type
                $validation_type=$validator->get_validation_type($res);

                return [$res, $validator->{$validation_type}($answer,$error_message),$field];


        };
        return $validation;

    }


    public function getInput(){
        return $this->input;
    }
    public function getHelper($helper){

        return $this->helper[$helper];
    }
    public function set_autocomplete($class,$field,Callable $map=null){
        $field=strtolower($field);
        $new_class='\App\\'.$class;
        $class=new $new_class;
        $res=$class->all();
        $data=null;
        foreach($res as $results){
            $results=(!is_null($map)?$map($results,$field):$results->$field);
            if(!is_null($results))$data[]=strtolower($results);

        }
        return $data;
    }






}