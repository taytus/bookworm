<?php


namespace App\MyClasses\Cli\Properties;

use App\MyClasses\Sitemap;
use App\MyClasses\Templates;
use App\MyClasses\URL;
use FontLib\Table\Type\loca;

class PropertiesURL {
    private $url;
    private $local_server;
    private $cli;

    public function __construct($cli){
        $this->cli=$cli;
        $this->url=new URL();
    }
    public function display_local_pages_urls($pages,$html=null){
        list($pages)=$this->process_pages($pages,1);
        $this->local_server=config('app.url');
        if(is_null($html)){
            foreach ($pages as $item){
                echo $this->local_server."/".$item['property_id']."/".$item['url']."\n";
            }
        }else{
            $str_url="local_pages_urls";
            return $this->generate_links($pages,$str_url);
        }
    }
    public function display_white_listed_pages($pages,$html=null){
        list($pages)=$this->process_pages($pages,1);
        if(is_null($html)){
            foreach($pages as $item){
                echo $item['url']."\n";
            }
        }else{
            $str_url="white_listed_pages";
            return $this->generate_links($pages,$str_url);


        }

    }
    public function display_ROBOAMP_pages_links($pages,$html=null,$triggers=null){
        //debug
        //$sitemap= new Sitemap();
        //$sitemap->create_from_all_active_properties();

        list($pages)=$this->process_pages($pages,1);




        $parser_url=(is_null($triggers)?"https://parser.roboamp.com/":"https://parser.roboamp.com/trigger/");
        if(is_null($html)){
            foreach($pages as $item){
                echo $parser_url.$item['property_id']."/".$item['url']."\n";
            }
        }else{
            $str_url="ROBOAMP_links";
            return $this->generate_links($pages,$str_url,$parser_url);


        }

    }
    public function display_amp_links($pages,$html=null){

        list($pages,$property_id,$white_label)=$this->process_pages($pages);
        if(is_null($html)){
            foreach($pages as $item){
                $amp_link = urldecode($this->url->make_amp_url_from_property($property_id, $item['url'],$white_label)) . "\n";
                echo $amp_link;
            }
        }else{
            $str_url="amp_links";
            return $this->generate_links($pages,$str_url,$white_label);
        }
    }
    public function display_white_label_urls($pages,$html=null){
        list($pages,$property_id,$white_label)=$this->process_pages($pages);

        $property_domain="https://amp.".URL::get_domain_from_property_id($property_id);

        if(is_null($html)){
            foreach($pages as $item){
                echo "\n".$property_domain."?id=".$property_id."&page=".$item['url'];
            }
        }else{
            if($white_label) {
                $str_url="white_label_links";
                return $this->generate_links($pages,$str_url,$property_domain);
            }else{
                return "<h5>This property is not White Label.<br>No white-label links has been generated</h5>";
            }
        }

    }

    public function create_urls_report($pages){
        $white_label_links=$this->display_white_label_urls($pages,true);

        $amp_links=$this->display_amp_links($pages,true);


        $roboamp_parser_links=$this->display_ROBOAMP_pages_links($pages,true);
        $triggers_link=$this->display_ROBOAMP_pages_links($pages,true,true);

        $white_listed_pages=$this->display_white_listed_pages($pages,true);

        $local_urls=$this->display_local_pages_urls($pages,true);

        list($pages,$property_id,$white_label_links)=$this->process_pages($pages);

        $template=new Templates();
        //$property_id=$pages[0]['property_id'];
        //$roboamp_parser_links='a<br>b<br>c';


        $res=$template->create_urls_report($property_id,$white_label_links,$amp_links,$roboamp_parser_links,$triggers_link,$white_listed_pages,$local_urls);

        $sitemap=new Sitemap();
        $sitemap->add_pages($pages);
        return true;
    }


    public function process_pages($pages,$pages_only=null){
        $pages=$pages[0];
        if(is_null($pages_only)) {
            $data[] = $pages['pages'];
            $data[] = $pages['property_id'][1];
            $data[] = $pages['white_label'];

        }else{
            $data[] = $pages['pages'];
        }
        return $data;

    }
    //$pages is an array with all the pages
    //$url_type will generate the links in different formats
    //$extra is some extra parameters
    private function generate_links($pages,$url_type,$extra=null){
        $property_id=null;
        $links="";
        $label=null;
        foreach ($pages as $item) {
            if(is_null($property_id))$property_id=$item['property_id'];
            switch($url_type){
                case 'amp_links':

                    $url=urldecode($this->url->make_amp_url_from_property($property_id, $item['url'],$extra));
                    $label=$url;
                    break;
                case 'ROBOAMP_links':
                    $url=$extra.$item['property_id']."/".$item['url'];
                    $label=$url;
                break;
                case 'white_label_links':
                    $url = $extra . "?id=" . $property_id . "&page=" . $item['url'];
                    $label = $item['url'];
                break;
                case 'white_listed_pages':
                    $url=urldecode($item['url']);
                    $label = $item['url'];
                    break;
                case 'local_pages_urls':
                     $url=$this->local_server."/".$item['property_id']."/".$item['url'];
                     $label=$url;

            }
            $links .= "<a href='" . $url . "'>" . $label . "</a><br>\n";

        }
        return $links;


    }

    public function generate_url_report(){
        $template= new Templates();

    }
} 