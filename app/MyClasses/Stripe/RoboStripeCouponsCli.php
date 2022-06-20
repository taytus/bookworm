<?php

namespace App\MyClasses\Stripe;
use App\MyClasses\Seeders;
use Faker\Factory;
use Illuminate\Support\Carbon;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Faker;
use App\MyClasses\Cli\CliValidator;
use App\Coupon;
use NunoMaduro\LaravelConsoleMenu\Menu;
use App\MyClasses\Dates;




class RoboStripeCouponsCli extends RoboStripe   {

   private $cli;

    public function __construct($cli=null){
       $this->cli=$cli;
    }

    public function sync_coupons_menu(){
        $menu=new Menu('Sync Menu Options', [
            'Stripe to Local','Local to Stripe']);
        $option=$menu->open();


        $arr_menu_options=['sync_stripe_to_local','sync_local_to_stripe'];
        call_user_func(array($this,$arr_menu_options[$option]));
    }
    public function create_coupon_menu(){
        $menu=new Menu('Create Menu Options', [
            'Create New Coupon','Create random Coupons']);
        $option=$menu->open();


        $arr_menu_options=['create_coupon','create_x_random_coupons'];
        call_user_func(array($this,$arr_menu_options[$option]));
    }


    public function sync_stripe_to_local(){
        $stripe_coupons=$this->get_all_items('Coupon');
        if(is_null($stripe_coupons)) dd('No Coupons are available on Stripe. Create Base Data');
        $added_records=0;
        $updated_records=0;

        //delete everything on the table coupons;
        $seeder=new Seeders();
        $seeder->delete('coupons');



        //adds all the elements to the DB, Ignore if ID exist
        foreach($stripe_coupons as $coupons){
            $res=Coupon::find($coupons->id);

            $redeem_by=date("Y-m-d H:i:s", $coupons->redeem_by);

            if(is_null($res)) {
                $coupon = Coupon::create(
                    [
                        'id' => $coupons->id,
                        'percent_off' => $coupons->percent_off,
                        'redeem_by' => $redeem_by,
                        'duration' => $coupons->duration,
                        'times_redeemed' => $coupons->times_redeemed,
                        'max_redemptions' => $coupons->max_redemptions,
                        'duration_in_months'=>$coupons->duration_in_months,


                    ]);
                $added_records++;
            }else{
                $res->percent_off = $coupons->percent_off;
                $res->redeem_by = $redeem_by;
                $res->duration = $coupons->duration;
                $res->times_redeemed = $coupons->times_redeemed;
                $res->max_redemptions = $coupons->max_redemptions;
                $res->save();
                $updated_records++;

            }
        }

        $this->cli->my_message($added_records ." coupons has been added");
        $this->cli->my_message($updated_records ." coupons has been updated");






    }
    public function sync_local_to_stripe(){

        $res=Coupon::get();
        dd($res);


    }

    public function list_coupons(){
        $data=Coupon::get();
        $this->cli->table($data->toArray());

    }


    public function create_coupon(){
        //coupon name;
        $data['id']=$this->ask_coupon_id();
        $data['duration']=$this->ask_coupon_duration();
        $data['percent_off']=$this->ask_coupon_percent_off();
        $data['max_redemptions']=$this->ask_coupon_max_redemptions();
        $data['redeem_by']=$this->ask_coupon_redeem_by(30);

        $res=$this->create('Coupon',$data);

        if($res==$data['id']){
            $info['error']=0;
            $info['message']='Coupon Has been Created';
            //save it to the DB
            $data['redeem_by']=Carbon::createFromTimestamp($data['redeem_by'])->toDateTimeString();
            $this->create_local_coupon_from_array($data);
        }else{
            $info['error']=$res['error'];
            $info['message']=$res['error_message'];
        }

        print_r($info);
        echo "\n-----------------------\n";


        $data['info']=$info;
        return $data;


    }

    private function generate_coupon_id(){
        $faker=Factory::create();
        $tmp_coupon_id=strtolower("coupon_".$faker->name('female'));
        return $this->clean_coupon_id($tmp_coupon_id);

    }
    public  function clean_coupon_id($coupon_id){
        $tmp_id=str_replace(" ","_",$coupon_id);
        $tmp_id=str_replace(".","",$tmp_id);
        $tmp_id=str_replace("'","",$tmp_id);
        return $tmp_id;


    }

    private function ask_coupon_id(){
        $default_coupon_name='Auto';

        $data['id']=$this->cli->ask('Please enter a name for the Coupon   ',$default_coupon_name);

        if($data['id']==$default_coupon_name){
            $tmp_id=$this->generate_coupon_id();
            $data['id']=$tmp_id;
        }

        return str_replace(" ","_",$data['id']);

    }
    private function ask_coupon_duration(){
        $question= new ChoiceQuestion(
            'Please select Coupon Duration (defaults to once)',
            array('once', 'forever'),
            0
        );
        return $this->cli->choice_question($question);
    }
    private function ask_coupon_percent_off(){
        $other_value='Other';
            $question= new ChoiceQuestion(
                'Please select a Percent Off (defaults to 30%)',
                array('30%', '50%','100%',$other_value),'0'
            );
            $question->setAutocompleterValues(null);

            $data['percent_off'] = $this->cli->choice_question($question);
            if($data['percent_off']===$other_value){
                $validation=function($answer) {
                    $validator = new CliValidator();
                    $error_validation = "The discount has to be a Number between 1 and 100";
                    return $validator->between(1, 100, $answer, $error_validation);
                };

                return $this->cli->ask('Please enter a Percent Off Value for the Coupon. Defaults to 30   ', '30', $validation);
            }else{
                return $data['percent_off'];
            }
    }

    private function ask_coupon_max_redemptions(){
        $other_value = 'Other';
        $question = new ChoiceQuestion(
            'Please select Max Redemptions for this Coupon (defaults to 10)',
            array('10', '50', '100', $other_value),'10'
        );
        $question->setAutocompleterValues(null);

        $data['max_redemptions'] = $this->cli->choice_question($question);

        if ($data['max_redemptions'] == $other_value) {
            $validation = function ($answer) {
                $validator = new CliValidator();
                $error_validation = "The Value for Max Redemptions has to be a Number smaller than 500";
                return $validator->between(1, 500, $answer, $error_validation);
            };

            return $this->cli->ask('Please enter a value for Max Redemptions for the Coupon (defaults to 20)  ', '20', $validation);
        }else{
            return $data['max_redemptions'];
        }
    }

    private function ask_coupon_redeem_by($days){
        $now =  Carbon::now("US/Central");
        return $now->addDays($days)->timestamp;
    }

    //
    private function create_x_random_coupons(){
        $validation=function($answer) {
            $validator = new CliValidator();
            $error_validation = "Please enter a number between 1 and 100";
            return $validator->between(1, 100, $answer, $error_validation);
        };

        $res= $this->cli->ask('Please enter a number between 1 and 100. Defaults to 30   ', '30', $validation);

        $this->create_random_coupons($res,'both');
    }
    public function create_random_coupons($total_coupons,$remote='local'){

        $faker= Factory::create();
        $tmp_coupon=array();
        $now=Carbon::now('US/Central');
        $arr_duration=['once','forever','repeating'];
        for($i=0;$i<$total_coupons;$i++){
            $coupon['id']=$this->generate_coupon_id();
            $coupon['duration']=$arr_duration[array_rand($arr_duration)];
            $coupon['duration_in_months']=null;
            if($coupon['duration']=='repeating')$coupon['duration_in_months']=rand(1,12);

            $coupon['percent_off']=rand(10,100);
            $coupon['max_redemptions']=rand(1,100);
            $date=$faker->dateTimeBetween('now','2 years')->format('Y-m-d H:i:s');

            $coupon['redeem_by']=Carbon::createFromFormat('Y-m-d H:i:s',$date)->toDateTimeString();

            $coupons[]=$coupon;
        }

        switch($remote){
            case 'local':
                foreach($coupons as $element){
                    $this->create_local_coupon_from_array($element);
                }
                break;
            case 'remote':
                foreach($coupons as $element){
                    $element['redeem_by']=Carbon::createFromFormat('Y-m-d H:i:s',$element['redeem_by'])->timestamp;
                    $res=$this->create('Coupon',$element);
                }


                echo "\n-----------------------\n";
                break;
            case 'both':
                foreach($coupons as $element){
                    $element['redeem_by']=Carbon::createFromFormat('Y-m-d H:i:s',$element['redeem_by'])->timestamp;
                    $res=$this->create('Coupon',$element);
                    $element['redeem_by']=Carbon::createFromTimestamp($element['redeem_by'])->toDateTimeString();
                    $this->create_local_coupon_from_array($element);
                }

        }



    }
    private function create_local_coupon_from_array($data){
        $coupons= new Coupon();
        $coupons->id=$data['id'];
        $coupons->duration=$data['duration'];
        $coupons->percent_off=str_replace('%','',$data['percent_off']);
        $coupons->max_redemptions=$data['max_redemptions'];
        $coupons->duration_in_months=$data['duration_in_months'];
        $coupons->redeem_by=$data['redeem_by'];
        $coupons->save();
    }
    public function delete_coupon_menu(){
        dd("hello!! from delete_coupon class RoboStripeCouponsCli");
    }




}