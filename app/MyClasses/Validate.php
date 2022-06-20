<?php


namespace App\MyClasses;

use App\MyClasses\Cli\CliEnv;
use Symfony\Component\Process\Process;
use App\MyClasses\CliFormat;
use App\Property;
use App\Page;

class Validate{

    public static function validate_amp_url(string $url,$verbose=0){

        $process = new Process('amphtml-validator '.$url);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {

            return [$url,self::process_errors($process->getErrorOutput(),$url)];
           // throw new ProcessFailedException($process);
       }
       $res=$process->getOutput();

        if($verbose)echo $process->getOutput();
        return [$url,"VALID"];

    }
    private static function parse_errors($errors,$verbose){
        dd($errors,'boom');
        if($verbose)echo $errors;

    }
    private static function check_for_critical_errors($error){
        $myArray=new Git();
        $critical_errors_arr=['Unable to fetch'];
        $critical_errors_messages=["+-+-+-+-+-+-+ +-+-+ +-+-+-+-+\n|S|E|R|V|E|R| |I|S| |D|O|W|N|\n+-+-+-+-+-+-+ +-+-+ +-+-+-+-+\n"];
        $error_message=Batman::get_X_first_words_from_string($error,3);
        $res=$myArray->check_for_string_in_array($error_message,$critical_errors_arr,1);
        if($res!==false){
            //cleanup temp folders created
            Cleanup::delete_temp_dirs_in_properties();
            echo "\n";
            echo $critical_errors_messages[$res];
            dd();


        }
    }
    private static  function process_errors($error,$url){

        self::check_for_critical_errors($error);

        $url_class=new URL();
        $error_message=[];
        $page_name=$url_class->get_page_name_from_local_url($url);
        $tmp_error=str_replace($url,$page_name,$error);
        $tmp_error=str_replace("\n","",$tmp_error);

        $err_array=explode($page_name.":",$tmp_error);
        array_shift($err_array);
        $error_message['page_name']=$page_name;
        foreach ($err_array as $item){
            $error_message['errors'][]=$item;
        }
         return $error_message;
    }

    public static function validate_local_amp_property($property_id,$output=null){



        $url=new Property();
        $urls=$url->get_all_urls_for_property($property_id,'local');
        $total=count($urls);
        $temp_count=1;
        $progressBar=(!is_null($output)?$output->createProgressBar($total):null);
        $errors=[];
        foreach ($urls as $item){
           if($progressBar)$progressBar->advance();
            $res=self::validate_amp_url($item,0);
            if($res[1]!="VALID"){
                $res=$res[1];

                foreach ($res['errors'] as $item) {
                    $errors['page_name'][]= $item;
                }

            }else{
                $temp_count++;
            }
        }
        echo ("\nValidation has been completed");

    }

    public static function validate_property(string $property_id){

        $urls=Page::get_all_amp_urls($property_id);
        if(empty($urls))dd('No AMP pages found for property '.$property_id);
        $success=false;
        foreach ($urls as $url){
                $success = self::validate_amp_url($url);
                if($success=="VALID"){

                    CliFormat::my_message("PASS","pass");
                }else{

                    CliFormat::my_message("ERROR","error");
                    $error=self::list_errors($success);
                    CliFormat::my_message($error,"error");

                }
        }
        //get all the urls for this property
        return ($success);

    }
    public static function list_errors($success){

        $tmp_errors=explode("\n",$success);
        $str_error="";

        foreach ($tmp_errors as &$error){
            $break=explode(" ",$error);
            $j=1;
            for( $j=1;$j<count($break);$j++){
                $str_error .= " ".$break [$j];
            }
            $str_error.="\n";
        }
        return $str_error;
    }
}

