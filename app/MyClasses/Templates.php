<?php
namespace App\MyClasses;
use App\MyClasses\Paths;
use App\MyClasses\Files;
use Spatie\Sitemap\SitemapGenerator;
use App\MyClasses\URL;
use Carbon\Carbon;
class Templates {
    public $template_path;

    //this method creates a test as ExampleTest to run on default dusk path

    public function create_test_from_template($template_name,$url_info,$placeholders,$substitutions){
        $url=$url_info->full_url;
        $path_to_template="/Tests/".$template_name;
        $file_name='ExampleTest';
        $origin=Paths::path_to_template($path_to_template);
        $destination=Paths::path_to_folder('Dusk');
        $destination=$destination."/".$file_name.".php";



        $file=new Files();

        //move the file
        $file->copy_file($origin,$destination,null,null,0);

        //apply placeholders;
        $file->replace_all_placeholders($placeholders,$substitutions,$destination);
    }
    //get the customer ID and property ID based on the URL


    public function create_urls_report_from_tools($pages,$property_url){
        $template_source=$this->get_template('HTML_URL_report',1);
        $template_destination=Paths::path_to_folder('properties').$property_url."/reports/URLs.html";

        $data['white_label_links']='';
        $data['amp_links']='';
        $data['ROBOAMP_parser_links']=$pages;
        $data['triggers_links']='';


        $this->move_template($template_source,$template_destination,$data);

    }

    //when $type=1 the extension is set up to blade.php
    public function get_template($file_name,$type=0){

        $extension=($type?".blade.php":"");

        return Paths::full_path_to_file($file_name.$extension,'Templates');

    }
    public function create_urls_report($property_id,$white_label_links,$amp_links,$roboamp_parser_links,$triggers_links,$white_listed_pages,$local_urls){
        $property_url=URL::get_domain_from_property_id($property_id);
        $template_source=$this->get_template('HTML_URL_report',1);
        $template_destination=Paths::path_to_folder('properties')."/".$property_url."/reports/URLs.html";

        $data['local_urls']=$local_urls;
        $data['white_label_links']=$white_label_links;
        $data['amp_links']=$amp_links;
        $data['ROBOAMP_parser_links']=$roboamp_parser_links;
        $data['triggers_links']=$triggers_links;
        $data['white_listed_pages']=$white_listed_pages;



        $this->move_template($template_source,$template_destination,$data);

        echo "URL Report has been generated: \n";
        echo "file:///".$template_destination;

    }

    public function create_default_AMP_trigger($property_url,$template_destination,$property_id){
        $template_source=$this->get_template('AMP_trigger',1);
        $template_destination.="/test_index.blade.php";
        $data['property_id']=$property_id;
        $data['page_name']=$property_url;
        $this->move_template($template_source,$template_destination,$data);
        $this->add_to_sitemap($property_id."/".$property_url);
    }

    public function create_AMP_triggers($page,$white_label=false){
        $url=new URL();
        $template_source=$this->get_template('AMP_trigger',1);
        $property_url=$url::get_domain_from_property_id($page['property_id']);
        $template_destination=Paths::path_to_folder('properties').$property_url."/trigger/";
        $property_domain='https://amp.'.$url->get_domain(urldecode($page['url']));


        $template_destination.=$page['name'].".blade.php";

        $data['property_id']=$page['property_id'];
        $data['page_url']=$page['url'];
        $data['url']=($white_label?$property_domain:'https://parser.roboamp.com');
        $data['page_url_decoded']=urldecode($page['url']);

        $this->move_template($template_source,$template_destination,$data);
        echo "\n"."Trigger created in: ". $template_destination;
    }

    private function add_to_sitemap($url){
        $base_url="https://parser.roboamp.com";
        SitemapGenerator::create($base_url)
            ->getSitemap()
            ->add(Url::create($base_url.'/test/'.$url)
                ->setLastModificationDate(Carbon::yesterday())
                 ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                 ->setPriority(0.1))
            ->writeToFile(base_path().'/sitemap.xml');
    }

    public function move_template($source,$destination,$data=null){
        $directory=new Directory();

        $tmp_destination=dirname($destination);
        if(!is_dir($tmp_destination))$directory->create($tmp_destination);

        $file=new Files();
        $file->copy_file($source,$destination,null,null,0);
        if(!is_null($data)) {
            foreach ($data as $key => $value) {
                $placeholders[] = "{{" . $key . "}}";
                $substitutions[] = $value;
            }
            $res=$file->replace_all_placeholders($placeholders,$substitutions,$destination);
        }

    }




}