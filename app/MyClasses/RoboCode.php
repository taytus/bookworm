<?php
/**
 * Created by ROBOAMP
 * User: taytus
 * Date: 6/25/19
 * Time: 6:31 PM
 */

namespace App\MyClasses;


class RoboCode{

    public static function all($property){
        $property_domain=URL::get_domain($property->url);

        $data['property_domain']=$property_domain;
        $data['upper_property_domain']=strtoupper($property_domain);

        $data[]=self::wordpress_custom_domain($property->id,$property_domain);
        $data[]=self::wordpress_blacklisting();
        $data[]=self::wordpress_roboamp_parser($property->id);
        $data[]=self::javascript_custom_domain($property_domain);
        $data[]=self::javascript_roboamp_parser($property->id);


        return Git::array_flatten($data);
    }
    public static function wordpress_custom_domain($property_id,$property_domain){
        $data['wordpress_custom_domain']=htmlspecialchars("<link rel='amphtml' href='https://amp.{$property_domain}?id={$property_id}&page=<?php echo urlencode(get_the_permalink()); ?>'>");
        $data['result_wordpress_custom_domain']='super';
        return $data;
    }

    public static function wordpress_blacklisting(){
        $data['wordpress_blacklisting']=htmlspecialchars("<?php include_once('roboamp.php'); \$roboamp=new ROBOAMP(urlencode(get_the_permalink())) ?>");
        $data['result_wordpress_blacklisting']="some url";
        return $data;
    }
    
    public static function wordpress_roboamp_parser($property_id){
        $data['wordpress_parser_roboamp']=htmlspecialchars("<link rel='amphtml' href='https://parser.roboamp.com/{$property_id}/<?php echo urlencode(get_the_permalink()); ?>'>");
        $data['result_wordpress_parser_roboamp']="nanananananan";
        return $data;
    }

    public static function javascript_custom_domain($property_domain){
        $data['javascript_custom_domain']=htmlspecialchars("<script type='text/javascript'>
  var link = document.createElement('link');
  link.setAttribute('rel', 'amphtml');
    link.setAttribute('href', 'https://amp.{$property_domain}/'+window.location.href);
    \$res=document.head.appendChild(link);
</script>");
        $data['result_javascript_custom_domain']='kiko';
        return $data;
    }

    public static function javascript_roboamp_parser($property_id){

        $data['javascript']=htmlspecialchars("<script type='text/javascript'>
  var link = document.createElement('link');
  link.setAttribute('rel', 'amphtml');
    link.setAttribute('href', 'https://parser.roboamp.com/".$property_id."/'+window.location.href);
    \$res=document.head.appendChild(link);
</script>");
        $data['result_javascript']="result javascript";
        return $data;
    }
}