<?php

namespace ROBOAMP\;

use App\MyClasses\Paths;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PropertyNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Notifications\Notifiable;
use App\MyClasses\Notifications;
use App\Platform;
use DB;
use App\Customer;
use roboamp\Git;
use roboamp\URL;

//////
///
use roboamp\CLI;

 class Property extends Model
{
    use Notifiable;
    //
    protected $table = "properties";
    protected $guarded=[];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

//returns a boolean and checks for matchs on domain and subdomain
    public function domain_match($domain){

        if($this->url==$domain || $this->subdomain==$domain) return true;

        return false;
    }
    public function find_by_url($url){
        $domain=URL::get_domain($url);
        $http="htpp://".$domain;
        $https="https://".$domain;

        $res=self::where('url',$http)->orWhere('url',$https)
            ->orWhere('subdomain',$http)->orWhere('subdomain',$https)->first();

        return ($res!=null?true:false);
    }
    public function slugs(){
        return $this->hasMany('App\SlugFilter');
    }
    public function status(){
        return $this->hasOne('App\PropertyStatus','id','status_id');
    }
    public function coupon(){
        return $this->hasOne('App\Coupon','id','promo_code_id');
    }

    public function pages(){
        return $this->hasMany('roboamp\robocore\Page');
    }


    public function get_property_name(){
        $url=new CLI();
        return $url->get_url_name($this->url);
    }


    public function customers(){
        return $this->belongsTo('App\Customer','customer_id','id');
    }
     public function white_label($property_id){
         $res=self::where('id',$property_id)->first();
         return $res->white_label;
     }
     public function get_domain($property_id){
        $res=$this::where('id',$property_id)->first();
        return CLI::get_domain($res->url);
     }

     public static function domain_exist(){

     }
     public function get_active_properties(){
         return $this::where('status_id',1)->with('pages')->get();
     }
    public function update_status($property_id,$status_id,$user_id){
        $now=Carbon::now();
        $property_selection= Property::where('properties.id',$property_id)
            ->leftJoin('customers','customers.id','properties.customer_id')
            ->leftJoin('users','users.id','customers.user_id')
            ->where('users.id',$user_id)->first();
        $status=PropertyStatus::where('id',$property_selection->status_id)->first();

        if($property_selection){
            //create a subscription
            //redirect to payment view with data;

            // Redirect::to('users.add.customer_from_property')->with('user_id', $user_id);
            return redirect()->route('users.add.customer_from_property',array($user_id,$property_id));

            $user= \Auth::user();
            $data['stripe_email']=$user->email;
            //used for the buttons on plan selection
            $data['plans'] = Plan::all();
            //image displayed on Stripe Form
            $data['stripe_form_image']=asset('img/ROBO_stripe.png');
            $data['stripe_key']= config('services.stripe.key');

            $data['customer']=$user_id;
            $data['property']=$property_id;


            return view('users.add', $data);



            /////////
            $property= Property::find($property_id);
            $property->status_id=$status_id;
            $property->updated_at=$now;
            $property->save();

            $message=array('error'=>0,'message'=>"Status has been changed to ".$status->status);
        }else{
            $message=array('error'=>87,'message'=>"Status has NOT been changed");
        }
        return json_encode($message);

    }

    //search for slugs that has been marked as problematic.
     //if we find them in the right position, then we return false and the render will stop
    public function cleared_slugs($slugs){
        $myArray= new Git();
        foreach ($this->slugs as $item){
            $res=$myArray->check_for_string_in_array($item->slug,$slugs,true);
            if(!is_null($res) && $item->position==$res+1){
               return false;
            }
        }
        return true;
    }
    public function platform_link($platform_id,$property_id){
        $platform= new Platform();

        return $platform->platform_link($platform_id->name,$property_id);


    }


    public function platform_id($platform){
        dd($platform);
    }


    public function routeNotificationForSlack($notification=NULL){
        return Notifications::Hook($notification);
    }
    public function send_notification($message,$email_admin=1,$notification_type='business',$status='success'){

        $this['channel']='#'.$notification_type."-alerts";
        $this['content']=$message;
        $this['status']=$status;
        $this['url']=route('users.coupons.edit',$this->id);
        $this['notification_type']=$notification_type;

        if($email_admin){
            $this->email="roberto@roboamp.com";

            $this->email_line1='I\'m THE ADMIN!!!';
            $this->email_action=['Notification Action', url('/')];
            $this->email_line2='BATMAN';

            $this->notify(new PropertyNotification($this));
        }

        $this->email_line1='I\'m THE USER!!!';
        $this->email_action=['Some copy', url('https://google.com')];
        $this->email_line2='Thank you for using our application!';

        $this->user_notification=$this->setup_user_notification($this);

        $this->notify(new PropertyNotification($this));
    }
    private function setup_user_notification($obj){

        return array([
            'line'=>'The introduction to the notification.',
            'action'=>['Notification Action', url('/')],
            'line'=>'Thank you for using our application!'
        ]);
    }



    public function get_foreign_keys($fields=null){

        if(is_null($fields))$fields=['properties.id as Property ID','pl.name as platform_name','ps.status','properties.url','properties.steps_id as steps'];
        $res=$this->select($fields)
            ->leftJoin('customers','customers.id','properties.customer_id')
            ->leftJoin('property_status as ps','ps.id','properties.status_id')
            ->leftJoin('platforms as pl','pl.id','properties.platform_id')
            ->leftJoin('steps','steps.id','properties.steps_id');


        return $res;

    }
    //detects if this is the
    public function created_via_coupon(){

        if(is_null($this->coupon_id)){
            //it has to be the only property and the customer has to be created using a coupon
            $customer=new Customer();

            $customer= $customer::find($this->customer_id);

            if(!$customer->more_than_one_property() && !is_null($customer->coupon_id)){
                $this->coupon_id=$customer->coupon_id;
                $this->save();
                return true;
            }else{
                return false;
            }


        }else{
            return true;
        }

    }
     public function activate_property_menu(){

     }

    public function get_unconfirmed_properties($toArray=true,$fields=null){
        $main_query=$this->get_foreign_keys($fields);
        $res=$main_query->where('steps_id','>=',3);

        if($toArray) return $res->get()->toArray();

        return $res;
    }

    public function get_all_urls_for_property($property_id, $url_type){
        $urls=Page::get_all_urls($property_id);
        $new_url=[];
        $local_server=config('app.url');
        switch($url_type){
            case 'local':
                foreach ($urls as $item){
                    $new_url[]=$local_server."/".$property_id."/".$item;
                }
                break;

        }
        return $new_url;
    }
    public function get_all_urls($status=2){


        $properties=$this::where('status_id',$status)->get();
        $base_url=url("/amp")."/";
        $urls=[];
        foreach($properties as $item){
            //$urls[]=$base_url.$item->customer_id."/".$item->id."/index.blade.php";
            $urls[]=$base_url.$item->id."/".$item->url;
        }
        return $urls;
    }

    public function get_all_active_urls(){
        return $this->get_all_urls(1);
    }
     //returns customer_id/property_id;
    public function full_path_to_property_folder(){
        $folder_name=$this->customer_id."/".$this->id;
        $paths=new Paths();
        return $paths->path_to_folder('customer')."/".$folder_name;
    }






}

