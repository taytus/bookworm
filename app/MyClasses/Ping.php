<?php
namespace App\MyClasses;
use App\MyClasses\CliFormat;
use App\MyClasses\URL;
use App\Page;
use Sunra\PhpSimple\HtmlDomParser;

class Ping{

    private static $pagination=['pagination','paginator'];
    private static $html='';
    public static $links=[];

    /*
     * returns the number of pages (pagination) and links for that url
     */
    public static function Paginator($url){
        self::$html=new HtmlDomParser();
        $scheme=URL::get_scheme($url);
        $domain=URL::get_domain($url);
        $full_domain=URL::get_full_domain($url);

        $content= self::$html->file_get_html($url,false,null,false);

        $position=0;

        foreach (self::$pagination as $page){

            $res=$content->find('div.'.$page.' a]');
            if(count($res)>0){
                echo "found it on position ".$position."<br>";
                //echo $res->children();

                foreach ($res as $element){
                    echo $element->innertext."<br>";
                    //get links from the paginator
                    foreach ($element->childNodes() as $child){
                        if($child->href!="" && !in_array($scheme.$full_domain."/".$child->href,self::$links) ){



                            //if the URL don't have a domain
                            $have_domain=URL::get_domain($child->href);
                            if (count($have_domain)<2){
                                echo "URL doesn't have a domain ".$child->href."<br>";
                                $href=$scheme.$full_domain."/".$child->href;
                                echo "UPDATED URL =  ".$href."<br>";
                                echo "<br><br><br>";
                            }else{
                                $href=$child->href;

                            }
                            self::$links[]=$href;
                        }
                    }
                    //if first position==# means I'm #1
                    //I need to update myself
                    self::$links[0]=(self::$links[0]===URL::get_full_domain_with_scheme($url)."/#"?$url:self::$links[0]);




                    //self::$links[]=$element->children(0)->innertext();
                }

                break;
            }else{
                //this is a one page only without pagination
                //maybe is using another menu style type
                //like UL - LI



                self::$links[]=$url;
                break;

            }
            //echo $page."<br>";

            $position++;
        }

    }



    public static function update_amp_cache($property_id){

        $amp_urls=Page::get_all_amp_urls($property_id);



        foreach ($amp_urls as $url){
            URL::curl($url);
            CliFormat::jump("visited: ".$url);
        }

    }



}
