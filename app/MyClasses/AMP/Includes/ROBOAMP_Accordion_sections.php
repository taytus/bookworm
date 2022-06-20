<?php
namespace App\MyClasses\AMP\Includes;


class ROBOAMP_Accordion_sections{

    public $label="";
    public $label_style="H4";
    public $extended=false;
    public $body="";


    public function __construct($label=""){
        $this->label=$label;
        return $this;
    }

    public function demo(){
        dd("demo_old");
    }
    public function render_header(){
        return "<".$this->label_style.">".$this->label."</".$this->label_style.">";
    }
    public function render(){
        return '<section>'.$this->render_header().$this->body.'</section>';
     return $this->body;
    }

    public function add_content($content){
        $this->body.=$content;
    }

    private function get_tags_length($str){
        $success = preg_match('/<\/[^>]+>/', $str, $match);
        $render=$this->render();
      //  dd(strlen($render),$render,$str);
        if($success){
            $pointer=strlen($this->body)-strlen($match[0])+1;
        }

        return $pointer;

    }

}