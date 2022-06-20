<?php
namespace App\MyClasses\AMP;

use App\MyClasses\AMP\Includes\ROBOAMP_Carousel_sections as Sections;
class ROBOAMP_Carousel{

    private $sections=array();
    private $body;
    public $label_style="H4";


    public function __construct(){

        $this->body=$this->setup_body();

    }

    private function setup_body(){
        return '<amp-carousel></amp-carousel>';
    }

    public function new_section($label,$content=null,$label_style=null){

        $section= new Sections();
        $section->label=$label;
        $section->body=$content;
        $section->label_style=(is_null($label_style))?$this->label_style:$label_style;
        $this->sections[]=$section;
       // return $section;

    }
    public function add_content($content){
        $section=end($this->sections);
        $section->add_content($content);

    }

    public function add_section($content="",$expanded=false, $end = true){

        $expanded=($expanded)?"expanded":"";
        $index=count($this->sections);
        $this->sections[$index]['content']="<section ".$expanded .">".$content."</section>";
        if($end) $this->add_section_at_the_end($index);
    }

    public function render(){

        $content="<amp-accordion>";
        foreach ($this->sections as $sections){
            $content.=$sections->render();
        }
        $content.="</amp-accordion>";
        return $content;
    }




    private function add_section_at_the_end($section_id){
        $body=$this->body;
        $content=$this->sections[$section_id]['content'];
        $this->body= substr_replace($body,$content,$this->insert_position('accordion'),0);

    }

    private function insert_position($tag='accordion'){
        switch($tag){
            case 'accordion':
                return strlen($this->body)-16;
            break;

            case 'section':
                return strlen($this->body)-16;
            break;

        }
    }

}