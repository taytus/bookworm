<?php
/**
 * Created by ROBOAMP
 * User: taytus
 * Date: 6/20/19
 * Time: 3:39 AM
 */

namespace App\MyClasses;


class Curl
{

    var $cookie;
    var $http_response;
    var $user_agent;
    private $url;
    public $content="";

    function __construct($url){
        $this->url=$url;
    }
    public function get_content(){
        $this->cookie     = "./cookies.txt";
        //$this->user_agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0';
        //$this->user_agent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';
        //$this->user_agent='Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        $this->user_agent='Googlebot/2.1 (+http://www.google.com/bot.html';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>$this->url,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_CONNECTTIMEOUT=>5,

            //follow redirect
            CURLOPT_FOLLOWLOCATION=>true,

            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: s-cae4-4ac6-80ed-lol",
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);

        $err = curl_error($curl);

        if (!curl_errno($curl)) {
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    $this->content=$response;
                    return $this->content;
                    break;
                default:
                    curl_close($curl);

                    dd("Unexpected HTTP code: ". $http_code,"URL: ".$this->url);
            }
        }
        curl_close($curl);

        return $response;


    }

    function postman(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Postman-Token: 84d45dd4-c2f7-4b9c-b4ae-26dda58afb25';
        $headers[] = 'Cache-Control: no-cache';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
    function get(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
        curl_setopt($ch, CURLOPT_NOBODY, false);

        $return = curl_exec($ch);
        curl_close ($ch);
        return $return;

    }

    function get_with_cookies(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
        // Here we can re-use the cookie file keeping the save of the cookies
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);

        curl_setopt($ch, CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $return = curl_exec($ch);
        curl_close ($ch);
        return $return;
    }

    public static function page_exist($url){
        $ch = curl_init($url."/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);


// Execute
        curl_exec($ch);

// Check HTTP status code
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    curl_close($ch);
                    return true;
                    break;
            }
        }

// Close handle
        curl_close($ch);
        return false;
    }
}