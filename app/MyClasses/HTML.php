<?php
namespace App\MyClasses;
use Illuminate\Support\Facades\Config;
use File;
use Illuminate\Support\Facades\View;
use App\MyClasses\Server;

class HTML {

    private $html_view_name;
    private $html_view_path;
    private $view;
    private $view_data;
    private $server;


    //used for developing so I don't have to manually delete the file after has been created
    private $delete_after_created=false;

    //if this is running in a live server, it will always try to return HTML static content


    public function __construct(){
        $this->server= new Server();
    }
    public function view($view,$data,$force_html=0){

        $this->setupView($view,$data);

        if($this->delete_after_created==true){
            File::delete($this->html_view_path);
            echo "File has been deleted<br>";
        }

        $force_html=1;

        if($force_html) return $this->output_html_file();

        if($this->server->testing_server()) {
            //returns regular template, no cached version
            return View::make($this->view,$data);
        }else{
            return $this->output_html_file();
        }
    }
    public function output_html_file($output=true){
        //check if file exist, if not, generate it
        if($this->server->testing_server()){
            if (File::exists($this->html_view_path)) {
                $file=new Files();
                $file->full_path_to_file=$this->html_view_path;
                $content=File::get($this->html_view_path);
                $localhost='127.0.0.1:8000';
                if (strpos($content, $localhost) !==false){
                    $res=$file->replace_placeholder($localhost,'roboamp.com',$file->full_path_to_file);
                    $file->re_write_file($res);
                }


                return \File::get($this->html_view_path);
            }else{
                return "Error: File doesn't exist";
            }
        }

        if (!File::exists($this->html_view_path)){

            $this->generate_html();
                $img=new IMG($this->setupImages());
                $minify=new Minify(array('all'),$this->html_view_path);
        }

        return ($output)? \File::get($this->html_view_path):true;


    }
    private function setupImages(){

        $images=array(
            //carousel
            ['source'=>'img/screenshot/wapo_logo_2.png','destination'=>'screenshot/wapo_logo'],
            ['source'=>'img/screenshot/transunion_logo.png','destination'=>'screenshot/transunion_logo'],
            ['source'=>'img/screenshot/bmw_logo.png','destination'=>'screenshot/bmw_logo'],
            ['source'=>'img/screenshot/wired_logo_2.png','destination'=>'screenshot/wired_logo'],
            ['source'=>'img/screenshot/etc_logo.png','destination'=>'screenshot/etc_logo'],
            ['source'=>'img/screenshot/usx_logo.png','destination'=>'screenshot/usx_logo'],
            ['source'=>'img/screenshot/grupo_logo.png','destination'=>'screenshot/grupo_logo'],
            ['source'=>'img/screenshot/innkeepers_logo.png','destination'=>'screenshot/innkeepers_logo'],
            //client
            ['source'=>'img/client/the-washington-post.png','destination'=>'client/the-washington-post'],
            ['source'=>'img/client/cnbc_logo_thumb.png','destination'=>'client/cnbc_logo_thumb'],
            ['source'=>'img/client/terra_logo.png','destination'=>'client/terra_logo'],
            ['source'=>'img/client/hearst_logo.png','destination'=>'client/hearst_logo'],
            //extra
            ['source'=>'img/mocks/feature-iPhone5-white.png','destination'=>'mockup/feature-iPhone5-white'],
            ['source'=>'images/iphone.png','destination'=>'mockup/iphone'],

            //icons
            ['source'=>'img/icons/moc-f-3.png','destination'=>'icons/moc-f-3'],
            ['source'=>'img/icons/moc-f-2.png','destination'=>'icons/moc-f-2'],
            ['source'=>'img/icons/how-2.png','destination'=>'icons/how-2'],
            ['source'=>'img/icons/moc-f-6.png','destination'=>'icons/moc-f-6'],
            ['source'=>'img/icons/moc-f-4.png','destination'=>'icons/moc-f-4'],
            ['source'=>'img/icons/moc-f-5.png','destination'=>'icons/moc-f-5'],




            //team
            ['source'=>'img/team/roberto.jpg', 'destination'=>'team/roberto'],
            ['source'=>'img/team/luke.jpg', 'destination'=>'team/luke'],
            ['source'=>'img/team/sean.jpg', 'destination'=>'team/sean'],

        );

            return $images;
    }


    //this only get all the individual views and rename the file as html
    private function generate_html(){
        $view = view($this->view,$this->view_data);
        $contents = $view->render();

        file_put_contents($this->html_view_path, $contents);
    }

    public function setupView($view,$data){

        $this->view = $view;
        $this->html_view_name = $this->view."_html.php";
        $this->html_view_path = Config::get('view.paths')[0].'/'.$this->html_view_name;
        $this->view_data=$data;

    }





    public function setHtmlViewPath($html_view_path){
        $this->html_view_path = $html_view_path;
    }






}