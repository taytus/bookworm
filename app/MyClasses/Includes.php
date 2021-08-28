<?php


namespace App\MyClasses;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Webpatser\Uuid\Uuid;


class Includes{

    protected $path_to_includes;
    protected $destination;
    protected $property_id;
    protected $file_name;
    protected $includes=['scripts','style','analytics','footer','menu','roboamp_analytics'];


    function __construct(string $property_id)
    {
        $this->property_id=$property_id;
        $this->path_to_includes=base_path('app/MyClasses/includes/');
        $this->destination=base_path('resources/views/properties/'.$this->property_id);


        $this->create_index();

        $this->run();


    }

    //moves the files in the includes folder to the new property's includes folder
    private function run(){

        foreach($this->includes as $file_name){
            $this->file_name=$file_name.'.blade.php';

            $this->create_include();

            echo "\n".$file_name." created  \n";
        }
    }


    private function create_index(){
        $this->file_name='index.blade.php';

        $this->create_include();

        $now=Carbon::now();

        //create the record in the DB

        $page_id=(string)Uuid::generate();
        $url='http%3A%2F%2Findex.com';
        DB::table('pages')->insert([

            'id'=>$page_id,
            'property_id'=>$this->property_id,
            'name'=>'index',
            'label'=>'HOME',
            'parent_id'=>0,
            'url'=>$url,
            'created_at'=>$now,
            'updated_at'=>$now,
        ]);


        echo "\n INDEX CREATED \n";

        echo "\n127.0.0.1:8000/amp/".$this->property_id."/".$url."\n";

        //set the path for the rest of includes
        $this->destination=base_path('resources/views/properties/'.$this->property_id.'/includes');


    }

    private function create_include(){
        $origin=$this->path_to_includes.$this->file_name;

        $destination=$this->destination."/".$this->file_name;
        File::copy($origin,$destination);
    }

}