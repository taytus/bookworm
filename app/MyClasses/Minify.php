<?php
namespace App\MyClasses;

use Symfony\Component\Process\Process;
use Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Minify{

    private $html_view_path;
    private $path_info;
    //public/minified_css.css

    private $css_minified_path="public/css/minified_css.css";


    //path inside the resource folders used by the minifiers
    private $resource_path;
    private $resource_html_path;
    public function __construct($type,$html_view_path){




        $this->setHtmlViewPath($html_view_path);
        $this->setResourcePath();
        $this->setPathInfo();
        $this->setResourceHtmlPath();



        //dd($html_view_path,$this->getPathInfo(), ltrim($html_view_path, '/'));
        if($type=='all'){
            $this->minify_all();
        }else {
            foreach ($type as $file_type) {
                $function = call_user_func(array($this, 'minify_' . $file_type));
            }
        }

    }
    public function minify_all(){

        $this->minify_css();
        $this->minify_html();
        $this->minify_js();
        $this->rename_html_to_php();
    }

    public function minify_css(){

        $this->re_write_css();

        system('grunt');





        return true;
        $html_document=$this->getResourceHtmlPath();
        $css_files=$this->get_css_files();
        $content='var purify=require(\'purify-css\');
purify( [\''.$html_document.'\'],
        [\''.$css_files.'\'
        ],
    {
        output: \''.$this->css_minified_path.'\',
        rejected:true,
        info:true,
        minify:true

    }
);';

       // file_put_contents(base_path().'/'."app.js", $content);
        //chdir('../');
/*
        $process=new Process('node app.js');
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

*/
        $this->re_write_css();

    }
    public function minify_html(){
        $input=$this->getResourceHtmlPath();
        $output=$input;
        chdir('../');
        $res=system('html-minifier --collapse-whitespace --remove-comments --minify-js true --minify-css true resources/views/landing_html.html -o resources/views/landing_html.html');
       
    }
    public function minify_js(){
      //  echo "JAVASCRIPT <BR>";
    }


    //getters and setters

    public function setHtmlViewPath($html_view_path){
        $this->html_view_path = $html_view_path;
    }


    public function getHtmlViewPath(){
        return $this->html_view_path;
    }
    private function rename_php_to_html(){
        $path_info=$this->getPathInfo();
        $original_file="/".$this->getResourcePath();
        $destination_file="/".$path_info['dirname']."/".$path_info['filename'].".html";

        if (Storage::exists($destination_file)) {
            Storage::delete($destination_file);
        }

        Storage::disk('html')->move($original_file,$destination_file);
        return ltrim($destination_file,'/');
    }
    public function rename_html_to_php(){
        $original_file = $this->change_str_file_name_extension("/".$this->getResourcePath(),'html');
        $destination_file=$this->change_str_file_name_extension($original_file,'php');
        if (Storage::exists($destination_file)) {
            Storage::delete($destination_file);
        }

        Storage::disk('html')->move($original_file,$destination_file);
    }
    private function get_view_name_from_path(){

        return basename($this->getHtmlViewPath());
    }


    public function setPathInfo(){
        $this->path_info = pathinfo($this->getResourcePath());
    }

    public function getPathInfo(){
        return $this->path_info;
    }

    //this function saves how many folders inside 'views' folder the file is


    public function setResourcePath(){
        $folders=explode("/",$this->getHtmlViewPath());
        $index = array_search('resources', $folders); // $key = 2;
        $new_array=array_slice($folders,$index);
        $str="";
        foreach ($new_array as $path_element){
            $str.=$path_element."/";
        }
        $str=rtrim($str,"/");
        $this->resource_path = $str;
    }


    public function getResourcePath(){
        return $this->resource_path;
    }

    public function get_css_files(){
        $css_files=array(
            'public/css/navbar_css.css',
            'public/css/landing_css.css',
            'public/css/media_query_css.css',
            'public/css/accordion_css.css',

        );

        return implode($css_files,"',\n'");
    }

    /**
     * @param mixed $resource_html_path
     */
    public function setResourceHtmlPath(){
        $this->resource_html_path = $this->rename_php_to_html();
    }

    public function getResourceHtmlPath(){
        return $this->resource_html_path;
    }

    //searches for a string and put the new css file that needs to be loaded
    public function re_write_css(){
        //get the string we are going to search for
        $css_target=$this->get_css_str_target();

        $path_to_file = $this->change_str_file_name_extension($this->html_view_path,'html');
        $file_contents = file_get_contents($path_to_file);
        //new css stylesheet
        $script_tag='<link rel="stylesheet" href="'. asset('css/roboamp.css').'">';

        $file_contents = str_replace($css_target,"\n".$script_tag,$file_contents);
        file_put_contents($path_to_file,$file_contents);

    }
    private function get_css_str_target(){
        return '<link rel="stylesheet" href="'.asset('css/landing_css.css').'">';
    }
    private function get_paths(){

        $paths=array(
            'HhtmlViewPath'=>$this->getHtmlViewPath(),
            'ResourceHtmlPath'=>$this->getResourceHtmlPath(),
            'ResourcePath'=>$this->getResourcePath(),
            'PathInfo'=>$this->getPathInfo()
        );

        return $paths;
    }
    private function change_str_file_name_extension($file_path,$new_extension){
        $info=pathinfo($file_path);
        $new_file_name=$info['dirname']."/".$info['filename'].".".$new_extension;

        return $new_file_name;
    }


}