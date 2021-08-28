<?php
namespace ROBOAMP;

use ROBOAMP\Git;
use Illuminate\Support\Facades\URL as Lara_URLS;

class URL extends Lara_URLs{

    public $root_amp_url;

    //get the property URL from the current URL
    public static function get_property_url_from_parser_url(String $property_id=null){
        $full_url=parent::current();
        if(!is_null($property_id)){
            $str=$property_id."/";
            $url_pieces=explode($str,$full_url);

        }else{
            $server_url=config('app.url')."/";
            $url_pieces=explode($server_url,$full_url);
            if(!isset($url_pieces[1])){
                dd('app.url var has not been set');
            }
            $url_pieces=explode("/",$url_pieces[1]);
        }
        $url=$url_pieces[1]."//";
        for($j=3;$j<count($url_pieces);$j++){
            $url.=$url_pieces[$j]."/";
        }
        return urldecode($url);

    }
    public function check_for_roboamp_code($url,$property=null){

        $HTML=self::curl($url);
        $amp_code=Git::get_string_between($HTML,"<link rel='amphtml' href=",'>');
        if($amp_code!=""){
            $amp_code_url_info=self::get_property_info_from_roboamp_install_code($amp_code);

            if(is_null($property))return $amp_code_url_info;
            $amp_domain=self::get_domain($property->url);
            if($amp_domain===$amp_code_url_info['domain']){
                if($amp_code_url_info['property_id']!=$property->id){
                    return ["error_message"=>"Properties IDs don't match"];
                }else{
                    return true;
                }
            }else{
                $str="Domains don't match\nExpected Domain= \t".$amp_domain."\n";
                $str.="Domain found=\t".$amp_code_url_info['amp_domain']."\n";
                return ["error_message"=>$str];
            }
        }else{
            return ["error_message"=>"AMP CODE HAS NOT BEEN FOUNDED"];
        }
    }
    public static function get_last_slug(){
        return self::get_slug_by_number(count(request()->segments()));
    }
    public static function get_slug_by_number($segment_number){
        return  request()->segment($segment_number);

    }
    public static function get_slugs($after_url=true){
        //remove the first two because
        //#1 is the property ID
        //#2 is the protocol
        //#3 is the URL
        $res=request()->segments();
        if(!$after_url) return $res;

        unset ($res[0]);
        unset ($res[1]);
        unset ($res[2]);

        return array_values ($res);

    }
    public static function get_first_slug(){
        return self::get_slug_by_number(1);
    }

    public static function get_slug_count(){
        return count(request()->segments());
    }
    public static function remove_trailing_slash($url){
        if(substr($url, -1) == '/') {
            $url=  substr($url, 0, -1);
        }
        //also checks for encoded URLs
        if(substr($url, -3) == '%2F') {
            $url=  substr($url, 0, -3);
        }
        return $url;
    }

    public static  function get_url_without_www($url){
        $host=parse_url($url);
        $host['path']=(isset($host['path'])?$host['path']:'');
        if(!isset($host['scheme'])) $host['scheme']="http";
        if(!isset($host['host'])) $host['host']="";
        return $host['scheme']."://".str_replace('www.','',$host['host']).$host['path'];
    }

    /**
     * checks if the url given exist
     * @param $url
     * @return bool
     */
    public static function url_exist($url){
        try {
            $array = get_headers($url);
            $string = $array[0];
            return (strpos($string, "200")?true:false);

        }catch(\ErrorException $e){
            dd($e);
            return false;
        }
    }

    public function get_url_name($url){
        $domain=$this->get_domain($url);
        $res=explode(".",$domain);
        return ucfirst($res[0]);
    }

    public function get_domain_info($url){
        $url=self::remove_trailing_slash($url);
        $data['url_name']=$this->get_url_name($url);
        $data['full_domain']=$this->get_full_domain($url);
        $data['scheme']=$this->get_scheme($url);
        $data['full_domain_with_schema']=$this->get_full_domain_with_scheme($url);
        $data['full_url_without_www']=self::get_url_without_www($data['full_domain_with_schema']);
        $data['full_url_without_schema']=$this->get_full_url_without_scheme($data['full_url_without_www']);
        return $data;

    }
    public static function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $return = curl_exec($ch);
        curl_close ($ch);
        return $return;
    }


    public function make_amp_url($url,$property_domain=null,$property_id=null,$white_label=false,$force_roboamp=true){
        $decoded_url=urldecode($url);
        //check what root should I use.
        $cdn_url=(!is_null($property_domain)?str_replace("-",'--',$property_domain):str_replace("-",'--',$decoded_url));
        $cdn_url=str_replace(".",'-',$cdn_url);
        $amp_url=".cdn.ampproject.org/c/s/";

        if($white_label){
            $amp_url.='amp.';
            $amp_url="https://amp-".$cdn_url.$amp_url.$property_domain."\\?id=".$property_id."&page=".$decoded_url;

        }else {
            if ($force_roboamp) {
                $url_without_scheme=self::get_full_url_without_scheme($url);
                $cdn_url = "parser-roboamp-com";
                $amp_url = $cdn_url . $amp_url .$url_without_scheme;
            }else{
                //https://ampbyexample-com.cdn.ampproject.org/c/s/ampbyexample.com/components/amp-img
                $domain=$this->get_domain_info($decoded_url);
                $cdn_url=$domain['full_domain'];
                $cdn_url=str_replace("-","--",$cdn_url);
                $cdn_url=str_replace(".",'-',$cdn_url);
                $amp_url=$domain['scheme'].$cdn_url.$amp_url.$domain['full_url_without_schema'];


            }
        }

        return $amp_url;
    }

    public  function make_amp_url2($property_id,$url,$ignore_white_label=true){
        //mansfield output
        //https://amp-mansfield--dentalcare-com.cdn.ampproject.org/c/s/amp.mansfield-dentalcare.com/8fc33172-1b47-4eb3-95b9-92e3d4007912/https://www.mansfield-dentalcare.com/team
        // https://amp-mansfield--dentalcare-com.cdn.ampproject.org/c/s/amp.mansfield-dentalcare.com/8fc33172-1b47-4eb3-95b9-92e3d4007912/https://www.mansfield-dentalcare.com/team
        $white_label=false;
        $decode_url=urldecode($url);

        $property=new Property();
        if(!$ignore_white_label)$white_label = $property->white_label($property_id);

        $property_url=Property::where('id',$property_id)->pluck('url')->first();



        //first I need to check if this is a full URL, if not I have to make it full URL
        $path=$this->get_full_domain_with_scheme($url,$property_id);
        //$url="";
        if($this->get_domain($url)!="roboamp.com"){
            $tmp_url=parse_url($url);
            //if already has the domain, ignore it.
            if(isset($tmp_url['host'])){

            }else{
                $url=$path."/".$url;
            }
        }
        $property_domain=self::get_domain($property_url);
        //check what root should I use.
        $cdn_url=str_replace("-",'--',$property_domain);
        $cdn_url=str_replace(".",'-',$cdn_url);
        $amp_url=".cdn.ampproject.org/c/s/";

        if($white_label){
            $amp_url.='amp.';
            $this->root_amp_url="https://amp-".$cdn_url.$amp_url.$property_domain."\\?id=".$property_id."&page=".$decode_url;

        }else{
            $cdn_url="https://parser-roboamp.com";
            $property_domain="roboamp.com";
            $amp_url.='parser.';
            $this->root_amp_url=$cdn_url.$amp_url.$property_domain."/".$property_id."/".$decode_url;
        }

        //$url=urlencode($url);
        //return $root.$property_id."/".$url;
        return $this->root_amp_url;
    }

    public static function get_domain($url)
    {
        $url=str_replace("'","",$url);
        $domain=urldecode($url);
        $parseUrl=parse_url($domain);
        if(isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        }
        else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return  str_replace('www.', '',  trim($host));


    }
    public  function get_scheme($url,$https=0,$search_on_pages=false,$property_id=null){

        $urlobj=parse_url($url);


        if(isset($urlobj['scheme'])){
            return $urlobj['scheme']."://";
        }else{
            //it is just a string without scheme defined
            //I search on pages to see if it exist
            //then I grab the scheme from that url
            if($search_on_pages){
                $res= Page::search_page_by_name($url,$property_id);
                if(!is_null($res)){
                    return self::get_scheme(urldecode($res->url));
                }
            }
        }
        //search on pages by name and return page info

        return ($https==0?'http://':'https://');
    }

    public static function get_full_domain($url){
        $host=parse_url($url);
        return (isset($host['host'])?$host['host']:$host['path']);

    }
    public  function get_full_domain_with_scheme($url,$https=0,$property_id=null){
        if(is_null($property_id)) {
            return $this->get_scheme($url,$https) . self::get_full_domain($url);


        }else{
            //this is an internal URL without domain;
            $domain= self::get_domain_from_property_id($property_id);
            $scheme= self::get_scheme($url,true,$property_id); //now get the schema
            $url=$scheme.$domain;
            return $url;
        }
    }
    public  function get_full_url_without_scheme($url){

        $url=str_replace('http://',"",$url);
        $url=str_replace('https://',"",$url);
        return $url;



    }
    //receibes an URL and returns the name of the html file
    //if $name_only, we don't return the extension
    public function get_page_name_from_local_url($url,$name_only=0){
        $local_server=config('app.url');
        $url=str_replace($local_server,"",$url);
        $url=explode("/",$url);
        $url=explode(".com%2F",$url[2]);

        $url=$url[1];
        if(!$name_only)$url.=".html";
        return $url;
    }

    public  function get_path_without_scheme($url){


        $host=parse_url($url);

        if(isset($host['host'])) return $host['host'];

        return null;

    }

    /**
     * returns true if the URL is an AMP Cache valid URL
     * @param $url
     * @return bool
     */
    public static function is_amp_url($url){
        $amp_url=parse_url($url);
        if(isset($amp_url['scheme'])&& $amp_url['scheme']=='https'){
            $domain=self::get_domain($url);
            if($domain=='ampproject.org'){
                return true;
            }
        }
        return false;

    }
    public function change_scheme($url){
        $scheme=$this->get_scheme($url);
        $scheme=($scheme=='http://'?'https://':'http://');

        return $scheme. $this->get_path_without_scheme($url);
    }
    //check if this domain has already been added to the database

    /**
     * @param $domain
     * @param int $http - By default search by http but also can be called to check for https
     * @return array|string
     */
    public function check_if_domain_exist_in_db($domain,$https=0){

        $property= new Property();
        $data=null;

        $full_url=$this->get_full_domain_with_scheme($domain,$https);

        $property_info=$property::where('url',$full_url)->first();

        $record_found=(!is_null($property_info)?count($property_info):0);



        $domain_info=new \stdClass();

        if(!$record_found && !$https){
            $data= $this->check_if_domain_exist_in_db($domain,1);
            return $data;
        }else{
            //second loop
            echo "Record found   = ". $record_found."\n\n";
            if($record_found){
                $domain_info->customer_id=$property_info->customer_id;
                $domain_info->property_id=$property_info->id;
                $domain_info->folder_name=$property_info->full_path_to_property_folder();
                $domain_info->schema=($https==0?'http://':'https://');

            }else{
                $domain_info->customer_id=null;
                $domain_info->schema='http://';

            }
            $domain_info->domain=$domain;
            $domain_info->full_url=$domain_info->schema.$domain_info->domain;





        }

        return $domain_info;
    }
    public static  function is_valid_url($url){

        $reg_ex="/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?/";
        if(preg_match($reg_ex,$url)){
            return true;
        }else{
            return false;
        }
    }

    public static function get_property_info_from_roboamp_install_code($amphtml_url){
        $data['amp_domain']=self::get_domain($amphtml_url);
        $domain=explode('amp.',$data['amp_domain']);

        dd($domain);
        $data['domain']=$domain[1];
        $id=explode('.com?id=',$amphtml_url);
        $id=explode('&page=',$id[1]);
        $data['property_id']=$id[0];
        $data['page']=$id[1];

        return $data;
    }





}