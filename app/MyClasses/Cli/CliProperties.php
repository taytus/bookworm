<?php
namespace App\MyClasses\Cli;

use App\Page;
use App\Property;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use App\MyClasses\CliFormat;
use App\MyClasses\Directory;
use App\MyClasses\Includes;
use App\User;
use Symfony\Component\Console\Helper\TableStyle;




class CliProperties {

    protected $selected_user=null;
    public $properties;
    public $options;
    public $output;

    protected static $callback="create_new_property";


    public function __construct($output)
    {
        $this->output=$output;

    }

    //list all the users and send back callback functions

    public static function create_new_property_options(){


            dd('nononono');
            $cliUsers=new CliUsers();




            $data['question']="Select an user";
            $data['menu']=true;
            $data['menu_options']=$cliUsers->list_all_users();
            $data['users']=$cliUsers->users;
            $data['callback']=self::$callback;

            return $data;


        }
        public static function add_new_property($property_name,$user_id){
            $now=Carbon::now();
            $property_id=(string)Uuid::generate();

            DB::table('properties')->insert([
                'id'=>$property_id,
                'user_id'=>$user_id,
                'status_id'=>1,
                'name'=>$property_name,
                'created_at'=>$now,
                'updated_at'=>$now,
            ]);
            CliFormat::my_message("Property " .$property_name." has been created");

            //now create the folders for the views and for the public assets
            Directory::create_folders_for_new_property($property_id);

            $includes=new Includes($property_id);

            CliFormat::my_message("Folder and include files has been created");


        }

    public function list_active_properties(){

        $this->properties=Property::select('id','name')->where('status_id','=',1)->get();
        $this->options=[];

        foreach($this->properties as $property){


            $this->options[]= $property['name'];
            $this->properties[]=$property->toArray();


        };
        return $this->options;

    }

    public static function update_property_url($property_id, $new_property_url){
        Page::where('property_id',$property_id)
            ->update(['url'=>$new_property_url]);
        CliFormat::my_message("Property URL has been Updated");


    }
    public static function update_property_domain($property_id, $new_property_domain){

        //get the URL
        $url=urldecode(Page::where('property_id',$property_id)->pluck('url')->first());
        $domain=parse_url($url);
        $original_domain=urlencode($domain['scheme']."://".$domain['host']);
        $new_domain=urlencode($domain['scheme']."://".$new_property_domain);

        $res=Page::where('property_id',$property_id)->get();

        foreach ($res as $page){

            $new_page_domain=str_replace($original_domain,$new_domain,$page->url);

            Page::where('id',$page->id)
                ->update(['url'=>$new_page_domain]);


        }

        CliFormat::my_message("Property Domain has been Updated");


    }

    /// returns all the pages associated with an account.
    /// an account can have several pages

    public  function pages_for_account_x_options(){

        $headers=['Name','ID','URL'];

        $properties=Property::where('status_id',"=",1)->get();


        foreach ($properties as $property){

            $page=Page::where('property_id','=',$property->id)->first();


            if(!is_null($page)) {
                $item['name']=$property->name;//."\t".$url."\n";
                $item['id']=$property->id;//."/".$page->url;
                $item['url']=$page->url;
                $items[]=$item;
            }
        }

        $this->output->table($headers,$items);


    }


}

