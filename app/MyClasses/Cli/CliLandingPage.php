<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 5/16/18
 * Time: 2:37 PM
 */

namespace App\MyClasses\Cli;

use App\MyClasses\HTML;
use App\MyClasses\Files;
use App\MyClasses\LandingPageData;


class CliLandingPage
{
    private $landing_page_php="landing_html.php";
    private $landing_page_html="landing_html.html";
    private $views_path="";
    private $landing_page_php_path="";
    private $landing_page_html_path="";

    protected $menu=array(
        'title'=>'Landing Page Operations','items'=>[

            ['menu item' =>'Delete Landing HTML Page','method'=>'LandingPage__delete_landing_page'],
            ['menu item' =>'Create Landing Page','method'=>'LandingPage__create_landing_page']
]
    );


    public function __construct(){

        $this->init();
    }
    public function menu(){
        return $this->menu;
    }

    public function delete_landing_page(){

        Files::delete_file($this->landing_page_html_path,true);
        Files::delete_file($this->landing_page_php_path,true);


    }

    public function create_landing_page(){
        Files::delete_file($this->landing_page_html_path);
        $data=new LandingPageData();
        $html=new HTML();
        $res=$html->view('landing',$data->getData());
        dd($res,'batman');

    }




    private function init(){

        $this->views_path=base_path('resources/views/');
        $this->landing_page_html=$this->views_path.$this->landing_page_html;
        $this->landing_page_php_path=$this->views_path.$this->landing_page_php;
    }




}