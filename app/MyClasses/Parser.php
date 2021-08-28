<?php

/*
 * This controller is the one called from ***EVERY*** client
 *
 */
namespace App\MyClasses;

use App\Page;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sunra\PhpSimple\HtmlDomParser;
use simple_html_dom;
use App\MyClasses\URL;


class Parser
{
    
    private $validated=false;

    public function __construct($validated=false){

          $this->validated= $validated;

    }

    public function paginator($page_id,$div=null){

        //return content from that page's paginator
        return get_content($page_id,$div);

        //if div is sent, add div to the DB

    }





    public static function get_total_pages_in_paginator($div_class)
    {
        $total = 0;
        foreach ($div_class as $element) {
            foreach ($element->childNodes() as $child) {
                if($child->href!="") {
                    $total++;
                }
            }
        }
        return ($total>2?$total -1:1);
    }

    //return the content of a page, or content from a specific div in that page
    public function get_content($page_id,$div=null){
        if(is_null($div)) return $this->get_content_from_page($page_id);

        //return $page;
        dd($page_id,$div);
    }

    //returns true if the page exist

    public function validate_page($page,$property_id,$check_for_https=1){

        //some validators decode the URL so I need to test for both
        $page_exist=Page::where('url',$page)

            ->where('property_id',$property_id)->first();
        if(!is_null($page_exist)) {

            return $page_exist;
        }else{

            if($check_for_https==1){
                $url=new URL();
                //check if the https version does exist
                $page=$url->change_scheme($page);

                return $this->validate_page($page,$property_id,0);
            }else{
                return false;
            }
        }

    }

    public function get_content_from_page($page_id){
        return "(from get_content_from_page)";
    }


    public static function parse_response($str=""){

        // Create a DOM object
        $html = new simple_html_dom();
        $content=$html->load('

<pre class="html hljs xml"><code class=""><span class="hljs-meta">&lt;!doctype html&gt;</span>\n
<span class="hljs-comment">&lt;!--{/*\n
    @info\n
Generated on: Fri, 09 Feb 2018 01:27:57 GMT\n
Initiator: MobilizeToday AMP Generator\n
Generator version: 0.9.6\n
*/}--&gt;</span>\n
<span class="hljs-tag">&lt;<span class="hljs-name">html</span> ⚡ <span class="hljs-attr">lang</span>=<span class="hljs-string">"en"</span>&gt;</span>\n
    <span class="hljs-tag">&lt;<span class="hljs-name">head</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">charset</span>=<span class="hljs-string">"utf-8"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Playboy | Articles, Interviews &amp;amp; More Since 1953 | Playboy<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">script</span> <span class="hljs-attr">async</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://cdn.ampproject.org/v0.js"</span>&gt;</span><span class="undefined"></span><span class="hljs-tag">&lt;/<span class="hljs-name">script</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">script</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://cdn.ampproject.org/v0/amp-accordion-0.1.js"</span> <span class="hljs-attr">async</span>=<span class="hljs-string">"async"</span> <span class="hljs-attr">custom-element</span>=<span class="hljs-string">"amp-accordion"</span>&gt;</span><span class="undefined"></span><span class="hljs-tag">&lt;/<span class="hljs-name">script</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">script</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"</span> <span class="hljs-attr">async</span>=<span class="hljs-string">"async"</span> <span class="hljs-attr">custom-element</span>=<span class="hljs-string">"amp-sidebar"</span>&gt;</span><span class="undefined"></span><span class="hljs-tag">&lt;/<span class="hljs-name">script</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">link</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">"canonical"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"generator"</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"https://html2amp.mobilizetoday.ru"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"viewport"</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"width=device-width,minimum-scale=1,initial-scale=1"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"The original men&amp;#39;s magazine, Playboy&amp;#39;s been pushing (and removing) buttons for 60+ years. Playboy.com features: beautiful women &amp;amp; celebrities; sex, culture, humor &amp;amp; style; Hef, Playmates &amp;amp; the Mansion."</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"description"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"summary_large_image"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"twitter:card"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"@playboy"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"twitter:site"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"Playboy | Articles, Interviews &amp;amp; More Since 1953"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"twitter:title"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"The original men&amp;#39;s magazine, Playboy&amp;#39;s been pushing (and removing) buttons for 60+ years. Playboy.com features: beautiful women &amp;amp; celebrities; sex, culture, humor &amp;amp; style; Hef, Playmates &amp;amp; the Mansion."</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"twitter:description"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"https://cdn.playboy.com/assets/logo-black-box-b444c507e346c7476f6b5872fd3933e45d72a1f05c79d2f3a571f52668e7768d.png"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"twitter:image"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"290743504454630"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"fb:app_id"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"6280019085"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"fb:pages"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"http://www.playboy.com/"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:url"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:type"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"Playboy"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:site_name"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"Playboy | Articles, Interviews &amp;amp; More Since 1953"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:title"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"The original men&amp;#39;s magazine, Playboy&amp;#39;s been pushing (and removing) buttons for 60+ years. Playboy.com features: beautiful women &amp;amp; celebrities; sex, culture, humor &amp;amp; style; Hef, Playmates &amp;amp; the Mansion."</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:description"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"https://cdn.playboy.com/assets/logo-black-box-b444c507e346c7476f6b5872fd3933e45d72a1f05c79d2f3a571f52668e7768d.png"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:image"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"image/jpeg"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:image:type"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"438"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:image:width"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"220"</span> <span class="hljs-attr">property</span>=<span class="hljs-string">"og:image:height"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"Playboy | Articles, Interviews &amp;amp; More Since 1953"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"name"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"The original men&amp;#39;s magazine, Playboy&amp;#39;s been pushing (and removing) buttons for 60+ years. Playboy.com features: beautiful women &amp;amp; celebrities; sex, culture, humor &amp;amp; style; Hef, Playmates &amp;amp; the Mansion."</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"description"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"https://cdn.playboy.com/assets/logo-black-box-b444c507e346c7476f6b5872fd3933e45d72a1f05c79d2f3a571f52668e7768d.png"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"image"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"Playboy | Articles, Interviews &amp;amp; More Since 1953"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"sailthru.title"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"playboy,playmates"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"sailthru.tags"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"app-id=com.playboy.playboynow"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"google-play-app"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"app-id=930678202 app-argument=pbnow://"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"itunes-app"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"noindex, follow"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"robots"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"noindex, follow"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"robots"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">style</span> <span class="hljs-attr">amp-boilerplate</span>=<span class="hljs-string">""</span>&gt;</span><span class="css"><span class="hljs-selector-tag">body</span>{<span class="hljs-attribute">-webkit-animation</span>:-amp-start <span class="hljs-number">8s</span> <span class="hljs-built_in">steps</span>(1,end) <span class="hljs-number">0s</span> <span class="hljs-number">1</span> normal both;<span class="hljs-attribute">-moz-animation</span>:-amp-start <span class="hljs-number">8s</span> <span class="hljs-built_in">steps</span>(1,end) <span class="hljs-number">0s</span> <span class="hljs-number">1</span> normal both;<span class="hljs-attribute">-ms-animation</span>:-amp-start <span class="hljs-number">8s</span> <span class="hljs-built_in">steps</span>(1,end) <span class="hljs-number">0s</span> <span class="hljs-number">1</span> normal both;<span class="hljs-attribute">animation</span>:-amp-start <span class="hljs-number">8s</span> <span class="hljs-built_in">steps</span>(1,end) <span class="hljs-number">0s</span> <span class="hljs-number">1</span> normal both}@-<span class="hljs-keyword">webkit</span>-<span class="hljs-keyword">keyframes</span> -amp-start{<span class="hljs-selector-tag">from</span>{<span class="hljs-attribute">visibility</span>:hidden}<span class="hljs-selector-tag">to</span>{<span class="hljs-attribute">visibility</span>:visible}}@-<span class="hljs-keyword">moz</span>-<span class="hljs-keyword">keyframes</span> -amp-start{<span class="hljs-selector-tag">from</span>{<span class="hljs-attribute">visibility</span>:hidden}<span class="hljs-selector-tag">to</span>{<span class="hljs-attribute">visibility</span>:visible}}@-<span class="hljs-keyword">ms</span>-<span class="hljs-keyword">keyframes</span> -amp-start{<span class="hljs-selector-tag">from</span>{<span class="hljs-attribute">visibility</span>:hidden}<span class="hljs-selector-tag">to</span>{<span class="hljs-attribute">visibility</span>:visible}}@-<span class="hljs-keyword">o</span>-<span class="hljs-keyword">keyframes</span> -amp-start{<span class="hljs-selector-tag">from</span>{<span class="hljs-attribute">visibility</span>:hidden}<span class="hljs-selector-tag">to</span>{<span class="hljs-attribute">visibility</span>:visible}}@<span class="hljs-keyword">keyframes</span> -amp-start{<span class="hljs-selector-tag">from</span>{<span class="hljs-attribute">visibility</span>:hidden}<span class="hljs-selector-tag">to</span>{<span class="hljs-attribute">visibility</span>:visible}}</span><span class="hljs-tag">&lt;/<span class="hljs-name">style</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">noscript</span> <span class="hljs-attr">data-amp-spec</span>=<span class="hljs-string">""</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">style</span> <span class="hljs-attr">amp-boilerplate</span>=<span class="hljs-string">""</span>&gt;</span><span class="css"><span class="hljs-selector-tag">body</span>{<span class="hljs-attribute">-webkit-animation</span>:none;<span class="hljs-attribute">-moz-animation</span>:none;<span class="hljs-attribute">-ms-animation</span>:none;<span class="hljs-attribute">animation</span>:none}</span><span class="hljs-tag">&lt;/<span class="hljs-name">style</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">noscript</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">style</span> <span class="hljs-attr">amp-custom</span>=<span class="hljs-string">""</span>&gt;</span><span class="css">@<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-Medium-5fcf3922f88c2e2f73bc592e539def6c793b95cf5c57d161b86a7b3cc265c772.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-Medium-e5aa70cea36623298af1c495d188dcc929945b8d4f3e9c9502c01dc791a4ccfe.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-MediumItalic-5d9b969037cb69c54c91a0f2a424e964b1e79ab6adce24ab191be1420fd0fad3.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-MediumItalic-d325ab091c5a2a6239212c9a7effab08f2a64a3e1456e0460a1dcb521a1980b4.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-Bold-f60d49db3701075e58745d7c458d92652bb6db92a3d4b0cf53cf58455dfdc087.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-Bold-a0144e7f6348c117432b65d006b57dc413adf514bba3a5125f5f3b4974daa409.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">600</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-BoldItalic-ad13ab5af8893b2434d3817a1db48b70b25a4ce452491fab0977fefe5994f577.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-BoldItalic-5fa95f5356021914325994601400ba2b2614990d507cd4b2f0f902ed5b787d0c.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">600</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-Black-10e227fe8916c11a46a262cb62ec37ac36c7f23abba8ac651d4f9b418314e7c3.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-Black-92cf096b7fd01c8288f054181104558f5712c5413ee37deab0874e15e9a0d31a.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-BlackItalic-b7e501433a86146ce2acf795b55ec70260d862a0d2bf3141b9cdddbbe52a4426.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/rabbitslab/RabbitSlab-BlackItalic-dceb0dd3ae0b03781d1e72513d90139b5c35b5ae0a07279ff59729f639b2dbbb.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-ExThin-5cacc1371cc6bdcb4951521b792dadecc634a2deb72bc54e2917b368a92714e9.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-ExThin-ff80b798fca8b3fc4557dafea3839b5d2e8688b5c105b417253641de79fa39b5.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">100</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-ExThinItalic-da91a53c9f6fe36878a484963ea77f348e5ab1787e6bed959b459eadbde7293e.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-ExThinItalic-e5e6c5349da2362f7f535304f86af48d27011ffd365c26a1366d23e16b9dbd84.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">100</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Thin-72855bb49675c9fedd8d790be0e3013903fd730b06cb5c3e076c1efe112bb598.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Thin-89c69a493f2816473306374bc9650a4810723c9c57942c4db6ff905b0a7cdefd.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">200</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-ThinItalic-f7a9d207c0c57b116d26c0a3095a31dc16bf67f21bd5f9ad8edc5e3c71055320.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-ThinItalic-fbfc0b679ea4ce99f4e2b03cb98478e807accbcaf4a7a5946667de79bcedc3f3.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">200</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Light-e0b3c237749a9afc1109b1332ca5498b437205faebf0cbd4ea2a0bce938d6b5b.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Light-c6e2ee0f6a78a6c71cce4c6f2cef85ce5317aca077a18474898280ee9321fbc8.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">300</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-LightItalic-f2007d5364f5e078c815e3a6ff2308d3dbe4930357b014de0bf5b6b9bfc5cc94.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-LightItalic-f2abfeeff93f8dd3063bead0c33529d71ab25dc154f6cb9d3b69d042ab5c8915.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">300</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Regular-2e4a68670b74b0ff8e7aa88febd9c4a5505878e2f7f4cc5abbac73055c4d5f58.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Regular-db3976c941fe61ad24ed9d130e86c28e5a493eb8f0b345b07ef1c19a8754a201.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">400</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-RegItalic-e664afbb352705a060a5e84a4aa890aabfb537ab3fcf7c0524aa2bee50524729.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-RegItalic-a7357958b024ca64e5cf23b656f870477986cc4cccff0b59568b6598963d9042.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">400</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Medium-2a65b2cf5a29c9512fe01cac922e7d7a50a5b52ed305d71dd2a74757f24aa2d8.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Medium-a26c5b8c1301a0cd2acf5ec34ec1514b8eabffd11633f6b0f7fbb2f6770849e6.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-MedItalic-1bc1b56bb8fedac9c002664fbd55d93947739bd571e9f508b4ed8b69006c83ba.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-MedItalic-241ca70917b8124d7d74cea5e299f7398a44db3b26be26b335c532766b41743b.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Bold-7560f3997eba4185f99ed865bdc21d434402cddd16ee3c0f2ed0d2dd3f41ef73.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Bold-1acf1829efb56763ef66d52e75fa51ef37851602db767c8374719e550f122dcd.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-BoldItalic-1fd921a50a8c47b963ca3e05dd17944c0ba542774079a215b2378a871fa96f3f.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-BoldItalic-8f2ae0e439df4340706bdac0a9f8cb26242dd954517a3d15a113cfb15699f045.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Ultra-23f52adfef07f0de5a0ff20024cf5e2275ec2b1c2383253f85e3e413ad458b5b.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-Ultra-e36105257d190aad1a2c1f07586ccf755ab2a3fcc6cc9e247b93072ee642dc20.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: normal;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">900</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-UltraItalic-0f3d03806a9d4239ebf4814f0e4738acafdf981313ead29a91d514e2239cf4b8.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/alrightsans/AlrightSans-UltraItalic-4c49c19ab6029947b5f3f6b515ff97cb29c1176afa0627fd5671b3a110e912d5.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>);\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">900</span>\n
}\n
<span class="hljs-selector-tag">a</span>,\n
<span class="hljs-selector-tag">amp-img</span>,\n
<span class="hljs-selector-tag">aside</span>,\n
<span class="hljs-selector-tag">body</span>,\n
<span class="hljs-selector-tag">div</span>,\n
<span class="hljs-selector-tag">em</span>,\n
<span class="hljs-selector-tag">footer</span>,\n
<span class="hljs-selector-tag">h2</span>,\n
<span class="hljs-selector-tag">h3</span>,\n
<span class="hljs-selector-tag">h5</span>,\n
<span class="hljs-selector-tag">header</span>,\n
<span class="hljs-selector-tag">html</span>,\n
<span class="hljs-selector-tag">iframe</span>,\n
<span class="hljs-selector-tag">li</span>,\n
<span class="hljs-selector-tag">nav</span>,\n
<span class="hljs-selector-tag">p</span>,\n
<span class="hljs-selector-tag">section</span>,\n
<span class="hljs-selector-tag">span</span>,\n
<span class="hljs-selector-tag">strong</span>,\n
<span class="hljs-selector-tag">ul</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">border</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">aside</span>,\n
<span class="hljs-selector-tag">footer</span>,\n
<span class="hljs-selector-tag">header</span>,\n
<span class="hljs-selector-tag">nav</span>,\n
<span class="hljs-selector-tag">section</span> {\n
  <span class="hljs-attribute">display</span>: block\n
}\n
<span class="hljs-selector-tag">body</span> {\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1</span>\n
}\n
<span class="hljs-selector-tag">body</span> {\n
  <span class="hljs-attribute">-webkit-font-smoothing</span>: antialiased;\n
  <span class="hljs-attribute">font-smoothing</span>: antialiased;\n
  <span class="hljs-attribute">padding-top</span>: <span class="hljs-number">60px</span>;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">overflow-x</span>: hidden;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#000</span>;\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">16px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">400</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1.5</span>\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">h2</span>,\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">h3</span>,\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">h5</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab,Georgia,serif\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">a</span>,\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">p</span>,\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">color</span>: inherit;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">300</span>;\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1.5em</span>\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">p</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">20px</span> <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">16px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">400</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">25px</span>\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">text-decoration</span>: none;\n
  <span class="hljs-attribute">cursor</span>: pointer\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">a</span><span class="hljs-selector-pseudo">:hover</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#999</span>\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">amp-img</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">strong</span> {\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
<span class="hljs-selector-tag">body</span> <span class="hljs-selector-tag">em</span> {\n
  <span class="hljs-attribute">font-style</span>: italic\n
}\n
<span class="hljs-selector-id">#social-icon-sprite</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.main</span><span class="hljs-selector-class">.body</span> {\n
  <span class="hljs-attribute">overflow</span>: hidden;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#fff</span>\n
}\n
<span class="hljs-selector-class">.content</span><span class="hljs-selector-class">.left</span> {\n
  <span class="hljs-attribute">float</span>: none\n
}\n
<span class="hljs-selector-class">.container</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto\n
}\n
<span class="hljs-selector-class">.nsfw</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#ad7cab</span>\n
}\n
<span class="hljs-selector-class">.nsfw</span><span class="hljs-selector-pseudo">:visited</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#ad7cab</span>\n
}\n
<span class="hljs-selector-class">.bg-bunny</span> {\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/bunny20x30-47d08f18fecbed38462ee3f8decbff3d432e30c98fe22c49429cf5b7ff5590a0.svg);\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat\n
}\n
<span class="hljs-selector-class">.bg-bunny-inverse</span> {\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/bunny-inverse-552163f3d0bf7acaa9b26fee81c5b076fdddf5310c748864f331c89f3353f4c2.svg);\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat\n
}\n
<span class="hljs-selector-tag">a</span><span class="hljs-selector-class">.button</span> {\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">50px</span>;\n
  <span class="hljs-attribute">text-transform</span>: uppercase;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">14px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">5px</span>;\n
  <span class="hljs-attribute">text-align</span>: center\n
}\n
<span class="hljs-selector-tag">li</span><span class="hljs-selector-class">.layout</span> {\n
  <span class="hljs-attribute">list-style</span>: none\n
}\n
<span class="hljs-selector-class">.module</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">25px</span>;\n
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.left</span> {\n
  <span class="hljs-attribute">float</span>: left\n
}\n
<span class="hljs-selector-class">.right</span> {\n
  <span class="hljs-attribute">float</span>: right\n
}\n
<span class="hljs-selector-class">.box-1</span> {\n
  <span class="hljs-attribute">box-shadow</span>: <span class="hljs-number">1px</span> <span class="hljs-number">1px</span> <span class="hljs-number">3px</span> <span class="hljs-number">#aaa</span>\n
}\n
<span class="hljs-selector-id">#social-icon-sprite</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.padless-right</span> {\n
  <span class="hljs-attribute">margin-right</span>: -<span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.ad</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">3px</span> <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">text-align</span>: center;\n
  <span class="hljs-attribute">position</span>: relative\n
}\n
<span class="hljs-selector-class">.ad</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">"Advertisement"</span>;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#999</span>;\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">left</span>: .<span class="hljs-number">5em</span>;\n
  <span class="hljs-attribute">bottom</span>: -<span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif\n
}\n
<span class="hljs-selector-class">.ad</span><span class="hljs-selector-pseudo">:empty</span> {\n
  <span class="hljs-attribute">display</span>: none;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.ad</span><span class="hljs-selector-pseudo">:empty</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">""</span>\n
}\n
<span class="hljs-selector-class">.ad-bg</span> {\n
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">position</span>: fixed;\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">1</span>;\n
  <span class="hljs-attribute">bottom</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.ad-bg</span> <span class="hljs-selector-class">.ad</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto\n
}\n
<span class="hljs-selector-class">.ad-bg</span> <span class="hljs-selector-class">.ad</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">""</span>\n
}\n
<span class="hljs-selector-tag">body</span> &gt; <span class="hljs-selector-class">.ad</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto\n
}\n
<span class="hljs-selector-tag">body</span> &gt; <span class="hljs-selector-class">.ad</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">""</span>\n
}\n
<span class="hljs-selector-class">.main</span><span class="hljs-selector-class">.content</span> <span class="hljs-selector-class">.ad</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">10px</span> auto;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">300px</span>\n
}\n
<span class="hljs-selector-class">.sidebar</span> <span class="hljs-selector-class">.ad</span> {\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">300px</span>;\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.sidebar</span> <span class="hljs-selector-class">.ad</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">""</span>\n
}\n
<span class="hljs-selector-tag">body</span> {\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.hamburger</span>,\n
<span class="hljs-selector-tag">header</span><span class="hljs-selector-class">.main</span> {\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">2</span>\n
}\n
<span class="hljs-selector-class">.icon</span><span class="hljs-selector-class">.hamburger</span> {\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">2</span>\n
}\n
<span class="hljs-selector-class">.magazine-cta</span> {\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">2</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> {\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">2</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.form</span> {\n
  <span class="hljs-attribute">z-index</span>: <span class="hljs-number">2</span>\n
}\n
<span class="hljs-selector-tag">input</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 20px);\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">14px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">1px</span>;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">13px</span> <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">border</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">input</span><span class="hljs-selector-pseudo">:focus</span> {\n
  <span class="hljs-attribute">outline</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">header</span><span class="hljs-selector-class">.main</span> {\n
  <span class="hljs-attribute">background-position</span>: <span class="hljs-number">20px</span> <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#f6f6f6</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 70px);\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">36px</span>;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">12px</span> <span class="hljs-number">20px</span> <span class="hljs-number">12px</span> <span class="hljs-number">50px</span>;\n
  <span class="hljs-attribute">position</span>: fixed;\n
  <span class="hljs-attribute">left</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">header</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.logo</span> {\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">131px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">43px</span>;\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/logo-outline-black-c028ac1e563ce2db073e806858a384b4cc99624dc7cb37f1ec2ade745c988c66.svg);\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat;\n
  <span class="hljs-attribute">background-size</span>: contain\n
}\n
<span class="hljs-selector-tag">header</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.search</span> {\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">right</span>: <span class="hljs-number">54px</span>;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/search/search-50a61bec78b9d4e85846a50806d439f25c1dd45783d2f3d449ab5bae846b3029.svg)\n
}\n
<span class="hljs-selector-class">.icon</span> {\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">background-position</span>: center;\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat;\n
  <span class="hljs-attribute">background-size</span>: <span class="hljs-number">20px</span>\n
}\n
<span class="hljs-selector-class">.hamburger</span> {\n
  <span class="hljs-attribute">position</span>: fixed;\n
  <span class="hljs-attribute">right</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/buttons/hamburger-btn-5e797ff7ae4e509422188a36142049ca9bb8b2598dded0b2d042e160652d4a7f.svg)\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> {\n
  <span class="hljs-attribute">position</span>: fixed;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">bottom</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">left</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#000</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.bg-global</span>,\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.bg-super</span> {\n
  <span class="hljs-attribute">background-color</span>: inherit;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#999</span>;\n
  <span class="hljs-attribute">overflow</span>: hidden\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.bg-global</span> {\n
  <span class="hljs-attribute">position</span>: fixed;\n
  <span class="hljs-attribute">overflow-y</span>: none;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">70%</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">105%</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span>,\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.super</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.super</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">position</span>: relative\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-tag">li</span> {\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">margin-left</span>: <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">padding-left</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-tag">li</span><span class="hljs-selector-pseudo">:first-child</span> {\n
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">10px</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-tag">li</span><span class="hljs-selector-class">.active</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">border-left</span>: <span class="hljs-number">#fff</span> solid <span class="hljs-number">3px</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-tag">li</span><span class="hljs-selector-class">.nsfw</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#ad7cab</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-tag">li</span><span class="hljs-selector-class">.holiday</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/shop-13df96f9fb855a108968c8cddde936124775392a9ba1eb5f3ccf60ad391dfeb7.svg);\n
  <span class="hljs-attribute">background-position</span>: <span class="hljs-number">0</span> <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat;\n
  <span class="hljs-attribute">color</span>: red;\n
  <span class="hljs-attribute">padding-left</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">background-size</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-class">.magazine-dropdown</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#f43</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.global</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab,Georgia,serif;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">21px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">40px</span>;\n
  <span class="hljs-attribute">white-space</span>: nowrap\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.cta-link</span> {\n
  <span class="hljs-attribute">background-color</span>: inherit;\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">bottom</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">padding-bottom</span>: <span class="hljs-number">25px</span>;\n
  <span class="hljs-attribute">left</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">60px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 60px)\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.cta-link</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">overflow</span>: visible;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.cta-link</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">border-top</span>: <span class="hljs-number">#fff</span> solid <span class="hljs-number">1px</span>;\n
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">270px</span>;\n
  <span class="hljs-attribute">padding-top</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/bunny-inverse-552163f3d0bf7acaa9b26fee81c5b076fdddf5310c748864f331c89f3353f4c2.svg);\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat;\n
  <span class="hljs-attribute">background-position</span>: <span class="hljs-number">250px</span> <span class="hljs-number">17px</span>;\n
  <span class="hljs-attribute">background-size</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab,Georgia,serif;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">21px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.magazine-cta</span> {\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">70px</span>;\n
  <span class="hljs-attribute">right</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">300px</span>;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#222</span>;\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.magazine-cta</span> <span class="hljs-selector-class">.thumbnail</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">30%</span>;\n
  <span class="hljs-attribute">float</span>: left\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.magazine-cta</span> <span class="hljs-selector-class">.copy</span> <span class="hljs-selector-tag">p</span> {\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab,Georgia,serif;\n
  <span class="hljs-attribute">font-style</span>: italic;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1.2</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>;\n
  <span class="hljs-attribute">text-transform</span>: none;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">text-align</span>: left;\n
  <span class="hljs-attribute">float</span>: right;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">62%</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.magazine-cta</span> <span class="hljs-selector-class">.button</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#f43</span>;\n
  <span class="hljs-attribute">text-transform</span>: none;\n
  <span class="hljs-attribute">letter-spacing</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">40px</span>;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">width</span>: auto;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">40px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">16px</span>;\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab,Georgia,serif;\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">12px</span> <span class="hljs-number">0</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.magazine-cta</span><span class="hljs-selector-pseudo">:hover</span> {\n
  <span class="hljs-attribute">display</span>: block\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.login</span><span class="hljs-selector-pseudo">:hover</span> {\n
  <span class="hljs-attribute">text-shadow</span>: -<span class="hljs-number">1px</span> <span class="hljs-number">1px</span> <span class="hljs-number">8px</span> <span class="hljs-number">#fff</span>,<span class="hljs-number">1px</span> -<span class="hljs-number">1px</span> <span class="hljs-number">8px</span> <span class="hljs-number">#fff</span>\n
}\n
<span class="hljs-selector-tag">nav</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.login</span><span class="hljs-selector-pseudo">:hover</span> <span class="hljs-selector-tag">svg</span> {\n
  <span class="hljs-attribute">fill</span>: <span class="hljs-number">#fff</span>\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 40px);\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">20px</span> <span class="hljs-number">20px</span> <span class="hljs-number">100px</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#000</span>;\n
  <span class="hljs-attribute">background-position</span>: <span class="hljs-number">50%</span> <span class="hljs-number">95%</span>;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">text-align</span>: center\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">h3</span> {\n
  <span class="hljs-attribute">text-align</span>: center;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">letter-spacing</span>: -.<span class="hljs-number">5px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">40px</span> <span class="hljs-number">0</span> <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">a</span>,\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">p</span> {\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">14px</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1.3em</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">10px</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">display</span>: block\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">a</span><span class="hljs-selector-class">.button</span> {\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">text-transform</span>: uppercase;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#eee</span>;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#000</span>;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">20px</span> <span class="hljs-number">0</span> <span class="hljs-number">17px</span>;\n
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">20px</span>\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">p</span> {\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">clear</span>: both\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-tag">amp-img</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.footer-nav</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">2px</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> <span class="hljs-selector-class">.wrapper</span> {\n
  <span class="hljs-attribute">display</span>: inline-block\n
}\n
<span class="hljs-selector-tag">footer</span><span class="hljs-selector-class">.main</span> &gt; <span class="hljs-selector-class">.wrapper</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">max-width</span>: <span class="hljs-number">1024px</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto;\n
  <span class="hljs-attribute">display</span>: block\n
}\n
<span class="hljs-selector-class">.login</span> <span class="hljs-selector-class">.toggle</span> {\n
  <span class="hljs-attribute">width</span>: auto;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">60px</span>;\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">padding-left</span>: <span class="hljs-number">20px</span>\n
}\n
<span class="hljs-selector-class">.login</span> <span class="hljs-selector-class">.toggle</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">text-transform</span>: uppercase\n
}\n
<span class="hljs-selector-class">.login</span> <span class="hljs-selector-class">.toggle</span> <span class="hljs-selector-tag">svg</span> {\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">16px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">40px</span>;\n
  <span class="hljs-attribute">stroke</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">fill</span>: transparent;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">3px</span>;\n
  <span class="hljs-attribute">left</span>: -<span class="hljs-number">7px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">display</span>: none;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.form</span> {\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">60px</span>;\n
  <span class="hljs-attribute">position</span>: fixed;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">max-width</span>: inherit\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.form</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">\'\'</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/search/search-50a61bec78b9d4e85846a50806d439f25c1dd45783d2f3d449ab5bae846b3029.svg);\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat;\n
  <span class="hljs-attribute">background-size</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">left</span>: <span class="hljs-number">80px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.results</span> {\n
  <span class="hljs-attribute">clear</span>: both;\n
  <span class="hljs-attribute">overflow</span>: none;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">display</span>: flex;\n
  <span class="hljs-attribute">display</span>: -webkit-flex;\n
  <span class="hljs-attribute">flex-wrap</span>: wrap;\n
  <span class="hljs-attribute">-webkit-flex-wrap</span>: wrap\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-tag">input</span> {\n
  <span class="hljs-attribute">border</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#f6f6f6</span>;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">0</span> <span class="hljs-number">50px</span> <span class="hljs-number">0</span> <span class="hljs-number">110px</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">60px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 160px);\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">24px</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">21px</span>;\n
  <span class="hljs-attribute">letter-spacing</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.clear</span>,\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.exit</span> {\n
  <span class="hljs-attribute">position</span>: absolute\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.clear</span><span class="hljs-selector-pseudo">:after</span>,\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.exit</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">\'\'</span>;\n
  <span class="hljs-attribute">border-right</span>: <span class="hljs-number">#ccc</span> solid <span class="hljs-number">1px</span>;\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">right</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">40px</span>;\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">top</span>: <span class="hljs-number">10px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.exit</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">20px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.clear</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">18px</span>;\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.toolbar</span> {\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">11px</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">11px</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> <span class="hljs-number">15px</span> <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">border-bottom</span>: <span class="hljs-number">1px</span> solid <span class="hljs-number">#999</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 30px);\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">40px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.facet</span> {\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">cursor</span>: pointer;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.stats</span> {\n
  <span class="hljs-attribute">float</span>: right;\n
  <span class="hljs-attribute">display</span>: inline-block\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.series</span>,\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.tags</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">60px</span> <span class="hljs-number">10px</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.series</span> <span class="hljs-selector-tag">header</span> <span class="hljs-selector-tag">h5</span>,\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.tags</span> <span class="hljs-selector-tag">header</span> <span class="hljs-selector-tag">h5</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">15px</span> <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">14px</span>;\n
  <span class="hljs-attribute">text-transform</span>: uppercase;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.series</span> <span class="hljs-selector-tag">a</span>,\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.tags</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">border</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#eee</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.series</span> <span class="hljs-selector-tag">a</span> <span class="hljs-selector-tag">h5</span> {\n
  <span class="hljs-attribute">white-space</span>: nowrap;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">20px</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">18px</span> <span class="hljs-number">50px</span> <span class="hljs-number">12px</span> <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">font-family</span>: RabbitSlab,Georgia,serif;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">600</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.series</span> <span class="hljs-selector-tag">amp-img</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">float</span>: left\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.tags</span> {\n
  <span class="hljs-attribute">padding-bottom</span>: <span class="hljs-number">60px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.tags</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">text-decoration</span>: none;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#eee</span>;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">13px</span> <span class="hljs-number">10px</span> <span class="hljs-number">8px</span>;\n
  <span class="hljs-attribute">margin-right</span>: <span class="hljs-number">4px</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">text-transform</span>: uppercase;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">700</span>;\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">width</span>: auto;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.loading-indicator</span> {\n
  <span class="hljs-attribute">text-align</span>: center;\n
  <span class="hljs-attribute">border</span>: <span class="hljs-number">#ccc</span> solid <span class="hljs-number">2px</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">54px</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 49px);\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif\n
}\n
<span class="hljs-selector-class">.search-base</span> <span class="hljs-selector-class">.padless-right</span> {\n
  <span class="hljs-attribute">margin-right</span>: -<span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.tile</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 15px);\n
  <span class="hljs-attribute">flex</span>: <span class="hljs-number">1</span> <span class="hljs-number">0</span> auto;\n
  <span class="hljs-attribute">-webkit-flex</span>: <span class="hljs-number">1</span> <span class="hljs-number">0</span> auto;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> <span class="hljs-number">0</span> <span class="hljs-number">15px</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-tag">picture</span> {\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-tag">picture</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">background-repeat</span>: no-repeat;\n
  <span class="hljs-attribute">background-size</span>: contain;\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">""</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">32px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">32px</span>;\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">bottom</span>: <span class="hljs-number">8px</span>;\n
  <span class="hljs-attribute">left</span>: <span class="hljs-number">8px</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-class">.article</span> <span class="hljs-selector-tag">picture</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/search/icon-article-5e69c8fdc1ba221c745c0f98262a0021d46a16d7a42951d3f200e2ef9ac0e3d1.svg)\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-class">.gallery</span> <span class="hljs-selector-tag">picture</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">background-image</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/dashboard_assets/icons/search/icon-gallery-d5b386f14735f363a050405c3ead154dc14205c36da1fe804ca3258379f593f1.svg)\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-tag">amp-img</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-tag">div</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">10px</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-class">.title</span> {\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">18px</span>;\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#000</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1.1</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">10px</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-class">.author</span> {\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#666</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">14px</span>\n
}\n
<span class="hljs-selector-class">.tile-container</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">0</span> <span class="hljs-number">15px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(100% - 30px);\n
  <span class="hljs-attribute">display</span>: -webkit-flex;\n
  <span class="hljs-attribute">display</span>: flex;\n
  <span class="hljs-attribute">-webkit-flex-wrap</span>: wrap;\n
  <span class="hljs-attribute">flex-wrap</span>: wrap\n
}\n
<span class="hljs-selector-class">.tile</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-built_in">calc</span>(50% - 15px);\n
  <span class="hljs-attribute">max-width</span>: <span class="hljs-built_in">calc</span>(50% - 15px);\n
  <span class="hljs-attribute">margin-right</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.tile</span> <span class="hljs-selector-class">.title</span> {\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">14px</span>\n
}\n
<span class="hljs-selector-class">.voices</span> <span class="hljs-selector-tag">h2</span> {\n
  <span class="hljs-attribute">border-bottom</span>: <span class="hljs-number">1px</span> solid <span class="hljs-built_in">rgba</span>(0,0,0,.7);\n
  <span class="hljs-attribute">padding-bottom</span>: <span class="hljs-number">5px</span>;\n
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">500</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">21px</span>;\n
  <span class="hljs-attribute">letter-spacing</span>: -.<span class="hljs-number">25px</span>\n
}\n
<span class="hljs-selector-class">.voices</span> <span class="hljs-selector-tag">ul</span> <span class="hljs-selector-tag">li</span> {\n
  <span class="hljs-attribute">border-bottom</span>: <span class="hljs-number">1px</span> solid <span class="hljs-built_in">rgba</span>(0,0,0,.7);\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">7.5px</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.voices</span> <span class="hljs-selector-tag">ul</span> <span class="hljs-selector-tag">li</span> &gt; <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">70px</span>;\n
  <span class="hljs-attribute">position</span>: absolute\n
}\n
<span class="hljs-selector-class">.voices</span> <span class="hljs-selector-tag">ul</span> <span class="hljs-selector-tag">li</span> <span class="hljs-selector-tag">p</span> {\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> <span class="hljs-number">0</span> <span class="hljs-number">0</span> <span class="hljs-number">85px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">70px</span>;\n
  <span class="hljs-attribute">display</span>: inline-flex;\n
  <span class="hljs-attribute">display</span>: -webkit-inline-flex;\n
  <span class="hljs-attribute">flex-direction</span>: column;\n
  <span class="hljs-attribute">-webkit-flex-direction</span>: column;\n
  <span class="hljs-attribute">vertical-align</span>: middle;\n
  <span class="hljs-attribute">justify-content</span>: center;\n
  <span class="hljs-attribute">-webkit-justify-content</span>: center\n
}\n
<span class="hljs-selector-class">.voices</span> <span class="hljs-selector-tag">ul</span> <span class="hljs-selector-tag">li</span> <span class="hljs-selector-tag">p</span> <span class="hljs-selector-tag">a</span><span class="hljs-selector-pseudo">:last-child</span> {\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">13px</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-tag">ul</span> {\n
  <span class="hljs-attribute">display</span>: flex;\n
  <span class="hljs-attribute">flex-wrap</span>: nowrap;\n
  <span class="hljs-attribute">justify-content</span>: space-between;\n
  <span class="hljs-attribute">display</span>: -webkit-flex;\n
  <span class="hljs-attribute">-webkit-flex-wrap</span>: nowrap;\n
  <span class="hljs-attribute">-webkit-justify-content</span>: space-between;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-tag">h2</span> {\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">21px</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">10px</span> <span class="hljs-number">0</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-tag">li</span> {\n
  <span class="hljs-attribute">list-style</span>: none;\n
  <span class="hljs-attribute">max-width</span>: <span class="hljs-number">50px</span>;\n
  <span class="hljs-attribute">max-height</span>: <span class="hljs-number">50px</span>;\n
  <span class="hljs-attribute">flex</span>: <span class="hljs-number">1</span> <span class="hljs-number">0</span> auto\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-tag">a</span> {\n
  <span class="hljs-attribute">display</span>: inline-block\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">10px</span>;\n
  <span class="hljs-attribute">border-radius</span>: <span class="hljs-number">25px</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#000</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-tag">svg</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">height</span>: <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">fill</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">display</span>: block;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-class">.facebook</span><span class="hljs-selector-pseudo">:hover</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#4964a1</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-class">.twitter</span><span class="hljs-selector-pseudo">:hover</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#59adeb</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-class">.google-plus</span><span class="hljs-selector-pseudo">:hover</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#d94b3f</span>\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-class">.instagram</span><span class="hljs-selector-pseudo">:hover</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">background</span>: <span class="hljs-built_in">radial-gradient</span>(circle at 33% 100%,#fed373 4%,#f15245 30%,#d92e7f 62%,#9b36b7 85%,#515ecf)\n
}\n
<span class="hljs-selector-class">.home-social-links</span> <span class="hljs-selector-class">.youtube</span><span class="hljs-selector-pseudo">:hover</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#cd201f</span>\n
}\n
            @<span class="hljs-keyword">font-face</span> {\n
  <span class="hljs-attribute">font-family</span>: slick;\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/slick-carousel/slick-06d80cf01250132fd1068701108453feee68854b750d22c344ffc0de395e1dcb.eot);\n
  <span class="hljs-attribute">src</span>: <span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/slick-carousel/slick-06d80cf01250132fd1068701108453feee68854b750d22c344ffc0de395e1dcb.eot?#iefix) <span class="hljs-built_in">format</span>(<span class="hljs-string">"embedded-opentype"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/slick-carousel/slick-26726bac4060abb1226e6ceebc1336e84930fe7a7af1b3895a109d067f5b5dcc.woff) <span class="hljs-built_in">format</span>(<span class="hljs-string">"woff"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/slick-carousel/slick-37bc99cfdbbc046193a26396787374d00e7b10d3a758a36045c07bd8886360d2.ttf) <span class="hljs-built_in">format</span>(<span class="hljs-string">"truetype"</span>),<span class="hljs-built_in">url</span>(http://cdn.playboy.com/assets/slick-carousel/slick-12459f221a0b787bf1eaebf2e4c48fca2bd9f8493f71256c3043e7a0c7e932f6.svg#slick) <span class="hljs-built_in">format</span>(<span class="hljs-string">"svg"</span>);\n
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">400</span>;\n
  <span class="hljs-attribute">font-style</span>: normal\n
}\n
<span class="hljs-selector-class">.feature-carousel</span> {\n
  <span class="hljs-attribute">overflow</span>: hidden;\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">15px</span>\n
}\n
<span class="hljs-selector-class">.feature-carousel</span> <span class="hljs-selector-class">.slide</span><span class="hljs-selector-pseudo">:not(.slick-slide)</span><span class="hljs-selector-pseudo">:not(</span><span class="hljs-selector-pseudo">:first-child)</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.feature-carousel</span> <span class="hljs-selector-class">.title</span> {\n
  <span class="hljs-attribute">position</span>: absolute;\n
  <span class="hljs-attribute">bottom</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">background</span>: <span class="hljs-built_in">-webkit-linear-gradient</span>(bottom,#000,transparent);\n
  <span class="hljs-attribute">background</span>: <span class="hljs-built_in">linear-gradient</span>(bottom,#000,transparent);\n
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-class">.feature-carousel</span> <span class="hljs-selector-class">.title</span> <span class="hljs-selector-tag">h2</span> {\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">0</span> <span class="hljs-number">20px</span> <span class="hljs-number">30px</span>;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">1.75em</span>;\n
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1</span>;\n
  <span class="hljs-attribute">text-shadow</span>: <span class="hljs-number">1px</span> <span class="hljs-number">1px</span> <span class="hljs-number">2px</span> <span class="hljs-built_in">rgba</span>(0,0,0,.8)\n
}\n
<span class="hljs-selector-class">.feature-carousel</span> <span class="hljs-selector-class">.title</span> <span class="hljs-selector-tag">h2</span> <span class="hljs-selector-tag">span</span> {\n
  <span class="hljs-attribute">border-bottom</span>: <span class="hljs-number">2px</span> solid <span class="hljs-number">#fff</span>;\n
  <span class="hljs-attribute">font-family</span>: AlrightSans,<span class="hljs-string">"Lucida Grande"</span>,<span class="hljs-string">"Lucida Sans Unicode"</span>,<span class="hljs-string">"Lucida Sans"</span>,Geneva,Verdana,sans-serif;\n
  <span class="hljs-attribute">display</span>: inline-block;\n
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">9px</span>;\n
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">8px</span>;\n
  <span class="hljs-attribute">padding-bottom</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">letter-spacing</span>: <span class="hljs-number">2px</span>\n
}\n
<span class="hljs-selector-class">.main</span><span class="hljs-selector-class">.body</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#fff</span>\n
}\n
<span class="hljs-selector-class">.main</span><span class="hljs-selector-class">.body</span><span class="hljs-selector-pseudo">:after</span> {\n
  <span class="hljs-attribute">content</span>: <span class="hljs-string">""</span>;\n
  <span class="hljs-attribute">display</span>: table;\n
  <span class="hljs-attribute">clear</span>: both\n
}\n
<span class="hljs-selector-class">.sidebar</span> {\n
  <span class="hljs-attribute">position</span>: relative;\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>\n
}\n
<span class="hljs-selector-class">.rbt-inline-0</span> {\n
  <span class="hljs-attribute">display</span>: none;\n
  <span class="hljs-attribute">visibility</span>: hidden\n
}\n
<span class="hljs-selector-class">.rbt-inline-1</span> {\n
  <span class="hljs-attribute">fill</span>: <span class="hljs-number">#fff</span>\n
}\n
<span class="hljs-selector-id">#search-toolbar</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.rbt-inline-3</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-class">.rbt-inline-4</span> {\n
  <span class="hljs-attribute">display</span>: none\n
}\n
<span class="hljs-selector-id">#rbt-sidebar</span> {\n
  <span class="hljs-attribute">width</span>: <span class="hljs-number">80%</span>;\n
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#eee</span>\n
}\n
<span class="hljs-selector-id">#rbt-sidebar</span> <span class="hljs-selector-tag">ul</span> <span class="hljs-selector-tag">li</span> {\n
  <span class="hljs-attribute">display</span>: block\n
}\n
<span class="hljs-selector-id">#rbt-sidebar</span> &gt; <span class="hljs-selector-tag">nav</span> {\n
  <span class="hljs-attribute">position</span>: static\n
}\n
<span class="hljs-selector-id">#rbt-sidebar</span> {\n
  <span class="hljs-attribute">background-color</span>: <span class="hljs-number">#000</span>\n
}\n
<span class="hljs-selector-id">#rbt-sidebar</span> &gt; <span class="hljs-selector-tag">nav</span> &gt; <span class="hljs-selector-tag">div</span> &gt; <span class="hljs-selector-tag">div</span> &gt; <span class="hljs-selector-tag">ul</span> {\n
  <span class="hljs-attribute">display</span>: block\n
}\n
<span class="hljs-selector-tag">section</span><span class="hljs-selector-class">.rbt-accordion-section</span> &gt; <span class="hljs-selector-tag">header</span> {\n
  <span class="hljs-attribute">background-color</span>: transparent;\n
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span>;\n
  <span class="hljs-attribute">border</span>: <span class="hljs-number">0</span>\n
}</span><span class="hljs-tag">&lt;/<span class="hljs-name">style</span>&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">head</span>&gt;</span>\n
    <span class="hljs-tag">&lt;<span class="hljs-name">body</span> <span class="hljs-attr">class</span>=<span class="hljs-string">" verticals index"</span> <span class="hljs-attr">itemscope</span>=<span class="hljs-string">"itemscope"</span> <span class="hljs-attr">itemtype</span>=<span class="hljs-string">"http://schema.org/WebPage"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">amp-sidebar</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"rbt-sidebar"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"nodisplay"</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">nav</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"main"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"bg-super"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"container"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">ul</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"super"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Hop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://hop.playboy.com/"</span>&gt;</span>Experience the Rabbit<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Pose For Playboy"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/pose-for-playboy"</span>&gt;</span>Pose for Playboy<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"signup"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"nsfw"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PB Plus Sign Up"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://join.playboyplus.com/track/MTAwMzk1OS4xMDAxMS4xMDIzLjMwNDEuMC4wLjAuMC4w/join?autocamp=pbcomtopbar"</span>&gt;</span>Sign Up For Playboy Plus<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">ul</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"container"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"login"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">template</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">template</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">template</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"toggle"</span> <span class="hljs-attr">data-eventaction</span>=<span class="hljs-string">"Super Nav"</span> <span class="hljs-attr">data-eventlabel</span>=<span class="hljs-string">"Login Modal"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"#"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"login-modal"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-bow-tie"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span>Sign In To Playboy<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">template</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"bg-global"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"container"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">ul</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"global"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"active"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/"</span>&gt;</span>Home<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Entertainment"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/entertainment"</span>&gt;</span>Entertainment<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Off Hours"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/off-hours"</span>&gt;</span>Off Hours<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Bunnies"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/bunnies"</span>&gt;</span>Bunnies<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Sex &amp;amp; Culture"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/sex-and-culture"</span>&gt;</span>Sex &amp;amp; Culture<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Heritage"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/heritage"</span>&gt;</span>Heritage<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Video"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/videos"</span>&gt;</span>Video<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"nsfw "</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-cta"</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"thumbnail"</span>&gt;</span>\n
                                        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                        <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                        <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"copy"</span>&gt;</span>\n
                                        <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>Get the Magazine That Changed It All<span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://ma.playboyplus.com/age-gate?rul=http://www.playboyplus.com/go/?id=ed5075f65e183695"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PlayboyNSFW"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://ma.playboyplus.com/age-gate?rul=http://www.playboyplus.com/go/?id=ed5075f65e183695"</span>&gt;</span>PlayboyNSFW<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"holiday "</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-cta"</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"thumbnail"</span>&gt;</span>\n
                                        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                        <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                        <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"copy"</span>&gt;</span>\n
                                        <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>Get the Magazine That Changed It All<span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyshop.com/?utm_source=playboy&amp;amp;utm_medium=native&amp;amp;utm_campaign=topnav"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"holiday"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Shop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyshop.com/?utm_source=playboy&amp;amp;utm_medium=native&amp;amp;utm_campaign=topnav"</span>&gt;</span>Shop<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-dropdown "</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-cta"</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"thumbnail"</span>&gt;</span>\n
                                        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                        <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                        <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"copy"</span>&gt;</span>\n
                                        <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>Get the Magazine That Changed It All<span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/magazine"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Magazine"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/magazine"</span>&gt;</span>Magazine<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">ul</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"cta-link"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Global Navigation"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Navigation"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Hop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://hop.playboy.com/"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span>Experience the Rabbit<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">nav</span>&gt;</span>\n
        <span class="hljs-tag">&lt;/<span class="hljs-name">amp-sidebar</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"social-icon-sprite"</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-twitter"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Twitter<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M12.582156,2.5 C10.6868857,2.5 9.15003071,4.11419355 9.15003071,6.10483871 C9.15003071,6.38741935 9.18043612,6.66274194 9.23894349,6.92645161 C6.38636364,6.77645161 3.85718673,5.34129032 2.16461916,3.16 C1.86885749,3.69225806 1.69978501,4.3116129 1.69978501,4.97258065 C1.69978501,6.22290323 2.30558968,7.3266129 3.22650491,7.97306452 C2.66400491,7.95419355 2.13467445,7.79209677 1.67214373,7.52209677 L1.67168305,7.56758065 C1.67168305,9.31387097 2.85472973,10.7712903 4.42521499,11.1022581 C4.13682432,11.1845161 3.83369165,11.2285484 3.52088452,11.2285484 C3.2997543,11.2285484 3.08461302,11.2058065 2.875,11.1641935 C3.31173219,12.5959677 4.57954545,13.6382258 6.08138821,13.6677419 C4.90663391,14.6345161 3.42644349,15.2108065 1.81864251,15.2108065 C1.54176904,15.2108065 1.26858108,15.193871 1,15.1604839 C2.51888821,16.1833871 4.32294226,16.78 6.26105651,16.78 C12.5743243,16.78 16.0267199,11.2870968 16.0267199,6.52290323 C16.0267199,6.3666129 16.0230344,6.21129032 16.0165848,6.05693548 C16.6873464,5.5483871 17.2691953,4.91354839 17.7294226,4.19064516 C17.1139435,4.47709677 16.4523956,4.67112903 15.7576781,4.75822581 C16.4666769,4.31209677 17.0107494,3.60564516 17.2668919,2.76370968 C16.6039619,3.17693548 15.8691646,3.47693548 15.0873771,3.63854839 C14.4613022,2.93790323 13.5694103,2.5 12.582156,2.5"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-facebook"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Facebook<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M10.78265,18.5827895 L10.78265,10.5625526 L13.40845,10.5625526 L13.80175,7.43702632 L10.78265,7.43702632 L10.78265,5.44097368 C10.78265,4.53642105 11.02775,3.91910526 12.29315,3.91910526 L13.90815,3.91910526 L13.90815,1.12365789 C13.62885,1.08471053 12.6703,1 11.555,1 C9.22655,1 7.6334,2.45663158 7.6334,5.13134211 L7.6334,7.43702632 L5,7.43702632 L5,10.5625526 L7.6334,10.5625526 L7.6334,18.5827895 L10.78265,18.5827895"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-instagram"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Instagram<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M3.176,0.5 L15.7774646,0.5 C16.9743333,0.5 17.9534646,1.47930303 17.9534646,2.676 L17.9534646,15.2774646 C17.9534646,16.4743333 16.9743333,17.4534646 15.7774646,17.4534646 L3.176,17.4534646 C1.97930303,17.4534646 1,16.4743333 1,15.2774646 L1,2.676 C1,1.47930303 1.97930303,0.5 3.176,0.5 L3.176,0.5 Z M13.349899,2.38373737 C12.9300505,2.38373737 12.5866162,2.72717172 12.5866162,3.14684848 L12.5866162,4.97374747 C12.5866162,5.39359596 12.9300505,5.7370303 13.349899,5.7370303 L15.2660909,5.7370303 C15.6859394,5.7370303 16.0293737,5.39359596 16.0293737,4.97374747 L16.0293737,3.14684848 C16.0293737,2.72717172 15.6859394,2.38373737 15.2660909,2.38373737 L13.349899,2.38373737 L13.349899,2.38373737 Z M16.0372727,7.66953535 L14.5450505,7.66953535 C14.6863737,8.13059596 14.7624444,8.61878788 14.7624444,9.12415152 C14.7624444,11.9440909 12.4032222,14.2299899 9.4929596,14.2299899 C6.58269697,14.2299899 4.22330303,11.9440909 4.22330303,9.12415152 C4.22330303,8.61878788 4.29954545,8.13059596 4.44069697,7.66953535 L2.88373737,7.66953535 L2.88373737,14.831 C2.88373737,15.2015657 3.1869899,15.5048182 3.55772727,15.5048182 L15.3634545,15.5048182 C15.7340202,15.5048182 16.0372727,15.2015657 16.0372727,14.831 L16.0372727,7.66953535 L16.0372727,7.66953535 Z M9.4929596,5.64086869 C7.61248485,5.64086869 6.0879798,7.1179798 6.0879798,8.94007071 C6.0879798,10.7621616 7.61248485,12.239101 9.4929596,12.239101 C11.3734343,12.239101 12.8977677,10.7621616 12.8977677,8.94007071 C12.8977677,7.1179798 11.3734343,5.64086869 9.4929596,5.64086869 L9.4929596,5.64086869 Z"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-google-plus"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Google+<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M15.778875,8.875 L15.778875,6.8125 L14.403875,6.8125 L14.403875,8.875 L12.341375,8.875 L12.341375,10.25 L14.403875,10.25 L14.403875,12.3125 L15.778875,12.3125 L15.778875,10.25 L17.841375,10.25 L17.841375,8.875 L15.778875,8.875 L15.778875,8.875 Z M12.1261875,2 L7.5886875,2 C4.7781875,2 2.7060625,3.700875 2.7060625,5.8891875 C2.7060625,8.0775 4.6613125,8.9245 6.261125,8.9245 C6.6399375,8.9245 6.99125,8.89975 7.3219375,8.8585 C7.138375,9.110125 6.939,9.484125 6.939,9.9330625 C6.939,10.589625 7.3274375,11.139625 7.841,11.596125 C7.7365,11.5940625 7.63475,11.5899375 7.5254375,11.5899375 C4.61525,11.5899375 2,12.6115625 2,14.841125 C2,15.3656875 2.6180625,17.82625 6.833125,17.82625 C11.0481875,17.82625 11.66075,15.2715 11.66075,13.884125 C11.66075,13.7858125 11.6525,13.6909375 11.640125,13.5974375 C11.5404375,12.527 10.8983125,11.7508125 10.0245,11.075 C9.0736875,10.3400625 8.8839375,10.0843125 8.8839375,9.500625 C8.8839375,8.917625 9.16375,8.4783125 9.8230625,7.9090625 C9.81275,7.916625 9.803125,7.92075 9.792125,7.9283125 C10.6095625,7.292375 10.9931875,6.4275 10.9931875,5.5495625 C10.9931875,3.7386875 9.563875,2.697125 9.563875,2.697125 L10.8295625,2.697125 L12.1261875,2 L12.1261875,2 Z M10.2919375,14.6561875 C10.2919375,15.9404375 9.04,17.107125 7.02975,17.107125 C5.0201875,17.107125 4.0796875,16.0408125 4.0796875,14.37775 C4.0796875,12.715375 5.91875,12.2843125 8.7175625,12.2843125 C9.599625,12.9718125 10.2919375,13.37125 10.2919375,14.6561875 L10.2919375,14.6561875 Z M7.3563125,8.1758125 C6.0610625,8.1758125 4.76375,7.0263125 4.76375,4.8703125 C4.76375,3.2120625 5.8369375,2.6785625 6.708,2.6785625 C8.2541875,2.6785625 8.9141875,4.5905 8.9141875,6.261125 C8.9141875,7.9310625 8.0561875,8.1758125 7.3563125,8.1758125 L7.3563125,8.1758125 Z"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-tumblr"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Tumblr<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M11.2264583,17.4664 C7.87295833,17.4664 6.59916667,14.9672 6.59916667,13.2016 L6.59916667,7.984 L5,7.984 L5,5.9216 C7.396375,5.0488 7.9735,2.864 8.108875,1.6192 C8.11758333,1.5336 8.18408333,1.5 8.22208333,1.5 L10.5369167,1.5 L10.5369167,5.5672 L13.6980417,5.5672 L13.6980417,7.984 L10.5250417,7.984 L10.5250417,12.9544 C10.536125,13.6192 10.7720417,14.5296 11.9785417,14.5296 C12.0007083,14.5296 12.0236667,14.5296 12.0458333,14.5288 C12.4654167,14.5176 13.0275,14.3944 13.3212083,14.2528 L14.0812083,16.5304 C13.7954167,16.9536 12.5057917,17.4456 11.3452083,17.4656 C11.3048333,17.4664 11.2660417,17.4664 11.2264583,17.4664"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-youtube"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 20 20"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>YouTube<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M19.6792314,13.9767318 C19.6792314,13.9767318 19.4849385,15.3469434 18.8887643,15.950359 C18.1326748,16.7423055 17.2851521,16.7462376 16.8964885,16.7925868 C14.1140375,16.9937319 9.93591314,17 9.93591314,17 C9.93591314,17 4.76621564,16.9528138 3.17547061,16.800276 C2.73294378,16.7172718 1.73938512,16.7423055 0.983003552,15.950359 C0.38684889,15.3469434 0.192847996,13.9767318 0.192847996,13.9767318 C0.192847996,13.9767318 -0.006,12.367669 -0.006,10.7586062 L-0.006,9.25010618 C-0.006,7.64104338 0.192847996,6.03198058 0.192847996,6.03198058 C0.192847996,6.03198058 0.38684889,4.66176897 0.983003552,4.05837286 C1.73938512,3.26640694 2.5866158,3.26249422 2.9752989,3.21612555 C5.75784714,3.015 9.93157217,3.015 9.93157217,3.015 L9.94021519,3.015 C9.94021519,3.015 14.1140375,3.015 16.8964885,3.21612555 C17.2851521,3.26249422 18.1326748,3.26640694 18.8887643,4.05837286 C19.4849385,4.66176897 19.6792314,6.03198058 19.6792314,6.03198058 C19.6792314,6.03198058 19.8777874,7.64104338 19.8777874,9.25010618 L19.8777874,10.7586062 C19.8777874,12.367669 19.6792314,13.9767318 19.6792314,13.9767318 L19.6792314,13.9767318 Z M7.91142058,6.9998243 L7.91142058,12.6061114 L13.2451798,9.80296785 L7.91142058,6.9998243 L7.91142058,6.9998243 Z"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-email"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>E-Mail<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M15.6383077,0 L-0.138307692,0 L7.75,7.9392 L15.6383077,0"</span>/&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M15.6985192,9.9396 L15.6985192,2.0604 L11.7847692,6 L15.6985192,9.9396"</span>/&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M3.71523077,6 L-0.198519231,2.0604 L-0.198519231,9.9396 L3.71523077,6"</span>/&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M-0.138307692,12 L15.6383077,12 L10.7307692,7.0608 L7.75,10.0608 L4.76923077,7.0608 L-0.138307692,12"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-whatsapp"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 19 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>WhatsApp<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M9.5,0 C4.41290323,0 0.306451613,4.10645161 0.306451613,9.19354839 C0.306451613,10.9403226 0.796774194,12.5645161 1.62419355,13.9435484 L-0.0306451613,18.8774194 L5.05645161,17.2532258 C6.37419355,17.9887097 7.90645161,18.3870968 9.5,18.3870968 C14.5870968,18.3870968 18.6935484,14.2806452 18.6935484,9.19354839 C18.7241935,4.10645161 14.5870968,0 9.5,0 L9.5,0 Z M9.5,16.8548387 C7.93709677,16.8548387 6.49677419,16.3951613 5.27096774,15.5983871 L2.35967742,16.5483871 L3.30967742,13.6983871 C2.39032258,12.4419355 1.83870968,10.8790323 1.83870968,9.19354839 C1.83870968,4.96451613 5.27096774,1.53225806 9.5,1.53225806 C13.7290323,1.53225806 17.1612903,4.96451613 17.1612903,9.19354839 C17.1612903,13.4225806 13.7290323,16.8548387 9.5,16.8548387 L9.5,16.8548387 Z M13.8209677,11.2774194 C13.5758065,11.1548387 12.4725806,10.5419355 12.2580645,10.45 C12.0435484,10.3580645 11.8903226,10.3274194 11.7370968,10.5419355 C11.583871,10.7564516 11.0935484,11.2774194 10.9709677,11.4306452 C10.8177419,11.583871 10.6951613,11.583871 10.45,11.4612903 C10.2048387,11.3387097 9.46935484,11.0629032 8.61129032,10.2354839 C7.93709677,9.59193548 7.50806452,8.79516129 7.35483871,8.55 C7.23225806,8.30483871 7.35483871,8.18225806 7.47741935,8.05967742 C7.6,7.96774194 7.72258065,7.78387097 7.84516129,7.66129032 C7.96774194,7.53870968 7.9983871,7.44677419 8.09032258,7.29354839 C8.18225806,7.14032258 8.1516129,6.98709677 8.09032258,6.89516129 C8.02903226,6.77258065 7.6,5.60806452 7.44677419,5.11774194 C7.26290323,4.62741935 7.07903226,4.71935484 6.92580645,4.71935484 C6.80322581,4.71935484 6.61935484,4.68870968 6.46612903,4.68870968 C6.31290323,4.68870968 6.06774194,4.71935484 5.82258065,4.96451613 C5.60806452,5.17903226 4.96451613,5.73064516 4.93387097,6.89516129 C4.90322581,8.05967742 5.7,9.19354839 5.79193548,9.34677419 C5.91451613,9.5 7.32419355,12.0129032 9.68387097,13.0548387 C12.0435484,14.0967742 12.0435484,13.7596774 12.4725806,13.7596774 C12.9016129,13.7290323 13.8822581,13.2387097 14.0967742,12.7177419 C14.3112903,12.166129 14.3419355,11.7064516 14.2806452,11.6145161 C14.2193548,11.4919355 14.066129,11.4306452 13.8209677,11.2774194 L13.8209677,11.2774194 Z"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-bow-tie"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 26 16"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Sign In<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M2,2 L2,14 L24,2 L24,14 L2,2 Z"</span> <span class="hljs-attr">stroke-width</span>=<span class="hljs-string">"2"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-check"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 25 19"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Check<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M8.48528137,14.1421356 L2.12132034,7.77817459 L-1.77635684e-15,9.89949494 L7.4246212,17.3241161 L8.48528137,18.3847763 L24.7487373,2.12132034 L22.627417,0 L8.48528137,14.1421356 L8.48528137,14.1421356 Z"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-close"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 23 23"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>Close<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M9.19238816,7.07106781 L2.12132034,1.77635684e-15 L8.8817842e-16,2.12132034 L7.07106781,9.19238816 L0,16.263456 L2.12132034,18.3847763 L9.19238816,11.3137085 L16.263456,18.3847763 L18.3847763,16.263456 L11.3137085,9.19238816 L18.3847763,2.12132034 L16.263456,0 L9.19238816,7.07106781 L9.19238816,7.07106781 L9.19238816,7.07106781 Z"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
    <span class="hljs-tag">&lt;<span class="hljs-name">symbol</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"icon-snapchat"</span> <span class="hljs-attr">viewbox</span>=<span class="hljs-string">"0 0 20 20"</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">title</span>&gt;</span>snapchat<span class="hljs-tag">&lt;/<span class="hljs-name">title</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">path</span> <span class="hljs-attr">d</span>=<span class="hljs-string">"M10.12,19.25H9.88a4.38,4.38,0,0,1-2.65-1,3.82,3.82,0,0,0-1.51-.77,4.88,4.88,0,0,0-.8-0.07,5.45,5.45,0,0,0-1.1.12,2.45,2.45,0,0,1-.42.06,0.29,0.29,0,0,1-.31-0.23C3,17.17,3,17,3,16.87a0.74,0.74,0,0,0-.28-0.61C1.22,16,.35,15.69.18,15.29a0.38,0.38,0,0,1,0-.13,0.24,0.24,0,0,1,.2-0.25,5.14,5.14,0,0,0,3.09-1.84,6.92,6.92,0,0,0,1.05-1.64h0a1.06,1.06,0,0,0,.1-0.88,1.9,1.9,0,0,0-1.23-.78L3.08,9.67a1.11,1.11,0,0,1-.89-0.88A0.82,0.82,0,0,1,3,8.27a0.57,0.57,0,0,1,.24,0,2.42,2.42,0,0,0,1,.26A0.84,0.84,0,0,0,4.8,8.41c0-.19,0-0.39,0-0.59h0a9.94,9.94,0,0,1,.24-4A5.16,5.16,0,0,1,9.8.75h0.4A5.17,5.17,0,0,1,15,3.84a10,10,0,0,1,.24,4V7.88c0,0.18,0,.36,0,0.52a0.81,0.81,0,0,0,.52.17,2.5,2.5,0,0,0,.94-0.26A0.74,0.74,0,0,1,17,8.26a0.93,0.93,0,0,1,.35.07h0a0.65,0.65,0,0,1,.49.54,1.06,1.06,0,0,1-.9.81l-0.28.09a1.9,1.9,0,0,0-1.23.78,1.05,1.05,0,0,0,.1.88h0c0.05,0.12,1.32,3,4.14,3.47a0.24,0.24,0,0,1,.2.25,0.38,0.38,0,0,1,0,.13c-0.17.4-1,.74-2.51,1a0.73,0.73,0,0,0-.28.61c0,0.15-.07.3-0.11,0.45a0.27,0.27,0,0,1-.29.22h0a2.36,2.36,0,0,1-.42-0.05,5.51,5.51,0,0,0-1.1-.12,4.89,4.89,0,0,0-.8.07,3.82,3.82,0,0,0-1.51.77,4.38,4.38,0,0,1-2.65,1"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"rbt-inline-1"</span>/&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">symbol</span>&gt;</span>\n
\n
<span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"vue-app"</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad-bg"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"a970"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">header</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"main bg-bunny box-1"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"toggle"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Super Nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"My Account"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/accounts"</span> <span class="hljs-attr">on</span>=<span class="hljs-string">"tap:rbt-sidebar.toggle"</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">tabindex</span>=<span class="hljs-string">"-1"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-bow-tie"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span>My Account<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                <span class="hljs-comment">&lt;!--{/* The following code was moved to amp-sidebar. */}--&gt;</span>\n
                <span class="hljs-comment">&lt;!-- &lt;nav class="main"&gt;&lt;div class="bg-super"&gt;&lt;div class="container"&gt;&lt;ul class="super"&gt;&lt;li&gt;&lt;a data-label="Hop" href="https://hop.playboy.com/"&gt;Experience the Rabbit&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Pose For Playboy" href="http://www.playboy.com/pose-for-playboy"&gt;Pose for Playboy&lt;/a&gt;&lt;/li&gt;&lt;li class="signup"&gt;&lt;a class="nsfw" data-label="PB Plus Sign Up" href="http://join.playboyplus.com/track/MTAwMzk1OS4xMDAxMS4xMDIzLjMwNDEuMC4wLjAuMC4w/join?autocamp=pbcomtopbar"&gt;Sign Up For Playboy Plus&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class="container"&gt;&lt;div class="login"&gt;&lt;template v-if="isLoggedIn"&gt;&lt;/template&gt;&lt;template v-else=""&gt;&lt;a @click.prevent="toggleLoginModal" class="toggle" data-eventaction="Super Nav" data-eventlabel="Login Modal" href="#" id="login-modal"&gt;&lt;svg role="img"&gt;&lt;use xlink:href="#icon-bow-tie" xmlns:xlink="http://www.w3.org/1999/xlink"/&gt;&lt;/svg&gt;&lt;span&gt;Sign In To Playboy&lt;/span&gt;&lt;/a&gt;&lt;/template&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class="bg-global"&gt;&lt;div class="container"&gt;&lt;ul class="global"&gt;&lt;li class="active"&gt;&lt;a href="http://www.playboy.com/"&gt;Home&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Entertainment" href="http://www.playboy.com/entertainment"&gt;Entertainment&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Off Hours" href="http://www.playboy.com/off-hours"&gt;Off Hours&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Bunnies" href="http://www.playboy.com/bunnies"&gt;Bunnies&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Sex &amp;amp; Culture" href="http://www.playboy.com/sex-and-culture"&gt;Sex &amp;amp; Culture&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Heritage" href="http://www.playboy.com/heritage"&gt;Heritage&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a data-label="Video" href="http://www.playboy.com/videos"&gt;Video&lt;/a&gt;&lt;/li&gt;&lt;li class="nsfw "&gt;&lt;div class="magazine-cta"&gt;&lt;div class="thumbnail"&gt;&lt;!--{/* @notice */}--&gt;</span>\n
                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"copy"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>Get the Magazine That Changed It All<span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://ma.playboyplus.com/age-gate?rul=http://www.playboyplus.com/go/?id=ed5075f65e183695"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PlayboyNSFW"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://ma.playboyplus.com/age-gate?rul=http://www.playboyplus.com/go/?id=ed5075f65e183695"</span>&gt;</span>PlayboyNSFW<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"holiday "</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-cta"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"thumbnail"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"copy"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>Get the Magazine That Changed It All<span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyshop.com/?utm_source=playboy&amp;amp;utm_medium=native&amp;amp;utm_campaign=topnav"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"holiday"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Shop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyshop.com/?utm_source=playboy&amp;amp;utm_medium=native&amp;amp;utm_campaign=topnav"</span>&gt;</span>Shop<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-dropdown "</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"magazine-cta"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"thumbnail"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"copy"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>Get the Magazine That Changed It All<span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/magazine"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Magazine"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/magazine"</span>&gt;</span>Magazine<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"cta-link"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Global Navigation"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Navigation"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Hop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://hop.playboy.com/"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span>Experience the Rabbit<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span> --&gt;\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"container"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"logo"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Home Logo"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"icon search"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">header</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"icon hamburger"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
            <span class="hljs-comment">&lt;!--{/* Tag account-login isn\'t supported in AMP. */}--&gt;</span>\n
            <span class="hljs-comment">&lt;!-- &lt;account-login @close="showLoginModal = false" v-if="showLoginModal"&gt; --&gt;</span>\n
            <span class="hljs-comment">&lt;!-- &lt;/account-login&gt; --&gt;</span>\n
            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
            <span class="hljs-comment">&lt;!--{/* Tag age-gate isn\'t supported in AMP. */}--&gt;</span>\n
            <span class="hljs-comment">&lt;!-- &lt;age-gate :url="ageGateTargetHref" @close="showAgeGate = false" v-if="showAgeGate"&gt; --&gt;</span>\n
            <span class="hljs-comment">&lt;!-- &lt;/age-gate&gt; --&gt;</span>\n
        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"main body container"</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"feature-carousel"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"slide"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Feature Carousel"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Homepage"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Home Feature: Out on the Mountain"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/out-on-the-mountain"</span>&gt;</span>\n
                        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                        <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                        <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">media</span>=<span class="hljs-string">"(max-width: 362px)"</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/yCQMA8UREWYgsGoIwmSMm/95c56ac03742824f00d4404f2aa80561/Gay-olympians_thumb.jpg?w=370&amp;amp;h=370&amp;amp;fm=jpg&amp;amp;fit=fill"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">media</span>=<span class="hljs-string">"(max-width: 481px)"</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/yCQMA8UREWYgsGoIwmSMm/95c56ac03742824f00d4404f2aa80561/Gay-olympians_thumb.jpg?w=500&amp;amp;h=500&amp;amp;fm=jpg&amp;amp;fit=fill"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">media</span>=<span class="hljs-string">"(max-width: 541px)"</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/yCQMA8UREWYgsGoIwmSMm/95c56ac03742824f00d4404f2aa80561/Gay-olympians_thumb.jpg?w=550&amp;amp;h=550&amp;amp;fm=jpg&amp;amp;fit=fill"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">media</span>=<span class="hljs-string">"(max-width: 768px)"</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/24HfsDMoDmMIYWCK4KUyGe/9ed16426d3287ce5d64f6258d9d9ff94/olympians-gay-caro.jpg?w=800&amp;amp;h=320&amp;amp;fm=jpg&amp;amp;f=faces&amp;amp;fit=fill"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">media</span>=<span class="hljs-string">"(min-width: 769px)"</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/24HfsDMoDmMIYWCK4KUyGe/9ed16426d3287ce5d64f6258d9d9ff94/olympians-gay-caro.jpg?w=1240&amp;amp;h=451&amp;amp;fm=jpg&amp;amp;f=faces&amp;amp;fit=fill"</span>&gt;</span>\n
                        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                        <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                        <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/24HfsDMoDmMIYWCK4KUyGe/9ed16426d3287ce5d64f6258d9d9ff94/olympians-gay-caro.jpg?w=400&amp;amp;h=400&amp;amp;fm=jpg&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                        <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h2</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span>SEX &amp;amp; CULTURE<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">br</span>&gt;</span>Out on the Mountain: How Gay Olympians Are Changing the Face of Masculinity<span class="hljs-tag">&lt;/<span class="hljs-name">h2</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"main content left padless-right"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile-container"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Home Story Tiles"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Navigation"</span> <span class="hljs-attr">data-vert</span>=<span class="hljs-string">"home"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"vue-load"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/stuart-parr-vintage-motorcycles"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/83c16UaVygY6owW064kAo/ef6ccf1191187609566a8cd0e90045f9/motorcycles_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>A Hollywood Producer’s Love for Vintage Motorcycles Has Birthed a Beautiful Collection<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Marcus Amick<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"nativo-container"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"nativo"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"gallery"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/galleries/all-day-and-night-with-danielle-krivak"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/G4WeCVuuSkuiMu6SeusAW/cd3528e37cd0752ec13b04d298551d9f/BenTsui_DanielleKrivak_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>All Day and Night With Danielle Křivák<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Ben Tsui<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/black-panther-movie-review"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/AYphZD4HYsI4qSWYWyw2c/78218a9e87a651e9727d0e8bb6a290f0/black-panther_review_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Revolutionary &amp;#39;Black Panther&amp;#39; Lives Up to the Hype<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Stephen Rebello<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/fifty-shades-of-grey-legacy-sex"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/7vY980bUXYw6mu2sg4aQoc/e99f744bbca437d166166e11e12b3fa8/fifty-shades-freed_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>The Complicated Legacy of &amp;#39;Fifty Shades of Grey&amp;#39;<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Adam Howard<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/the-chunky-sneaker-vetements-balenciaga"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/4QdTZZTGXCs6sCki2Yc2kI/7d947a88d3ff2636c98861f32c0660ab/Vetements_sneakers_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>The Chunky Sneaker Trend is Only Going to Get More Bizarre<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Tyler Watamanuk<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/opioids-epidemic-saves-kills"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/6L0M0vJ8XugWAEmeKKaiwk/5bb457f892b512804f4575ceafc5fcbe/opioid-thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>The Opioid Epidemic: How to Combat the Drug That Helps As Many Lives As It Kills<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Tori Bilcik<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"a300-mobile"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"a300-tablet"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/quentin-tarantino-uma-thurman-controversy"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/5I5074jSQEei2M8eQ8W0WS/ac12ac5296de591d72e7d9433ee35bbf/Screen_Shot_2018-02-08_at_12.27.35_AM.png?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Will Quentin Tarantino&amp;#39;s Early Retirement Come Sooner Than He Planned?<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Daniel Barna<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/channel-zero-butchers-block-horror"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/3FUbGMbslGIgSoa8kayoS8/f9c4148199dd094d4e8b81582abac716/channel-zero_thumb_copy.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>How &amp;#39;Channel Zero: Butcher&amp;#39;s Block&amp;#39; Slices a New Path for Horror<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Carli Velocci<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/declaring-dissent-as-un-american"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/1oBz724qg8y8syk4YWM4Uq/97c27373ef251db4339e4d1059547e19/shutterstock_6727174e.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Lest We Forget What It Means to Be an American...<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Brian Karem<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/vagina-camera-artist-dani-lessnau"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/2qmKioDNOo0iU08cM2y0cW/a8627954c721b8c90fdc51c37c863062/Untitled_3.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>The Artist Who Turned Her Vagina Into a Camera<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Kyle Fitzpatrick<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/game-of-thrones-creators-star-wars"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/4xM040VBqEWcIkWyw0Eayy/268ee1e7341b16006ed4a9bc63fcf1b5/game_of_thrones_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Will &amp;#39;Game of Thrones&amp;#39; Creators Fit With the &amp;#39;Star Wars&amp;#39; Universe?<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Matthew Jackson<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/contract-for-consent"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/1ez7vLRk4eWQwAYoUKqoK/4d19a0cc9069b6b1cfa81d56afc02dcd/consent-contracts-app_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Contracts for Consent Might Be The Future of Sex<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Bobby Box<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"b300-mobile"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"b300-tablet"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/disney-solo-a-star-wars-story-trailer"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/2ckc7r0Z1yaasgCMqAokWW/5129321601cbe5811dae9991d4042667/han-solo_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Should &amp;#39;Star Wars&amp;#39; Fans Still Worry About the Han Solo Movie?<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Daniel Barna<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/robot-sex-dating"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/1O9idGmT3eCISiuIaakw4O/97fa35d2b42001f88f55e229acb15bb0/sex-robot-thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Let&amp;#39;s Experiment With Robot Sex<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Lisa Beebe<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/why-this-years-winter-olympics-are-a-letdown"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/6nioPhiR9u4uKKggwGkIsK/7ecae44cc40b897d10162baf21e2ea93/winter-olympics_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Why Americans Won&amp;#39;t Tune Into the Winter Olympics This Year<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Aaron Gordon<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/super-bowl-eagles-justin-timberlake"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/3vbMq46jO8W8qCUWiomiqK/87f7e6e7401db22f38a912f486fd3022/JT-superbowl_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Justin Timberlake Gave Us a Halftime Show Devoid of Meaning<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Tom Carson<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/devin-nunes-memo"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/61IX2tqKFqOYyGwoyWAkO8/5eb92314ba8c33f6f37bc229aef2a9f9/8536263j.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>There is No Such Thing as Transparency Anymore<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Brian Karem<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/this-week-in-sex-your-dick-is-attractive"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/3tKlAyQcQo2Q824k68yWYi/b9069574bae60d637bec516f547463c2/Cherie-Noel_Evan-Woods__03_-thumbnail.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>This Week in Sex: A Primer on Hot Tub Sex, Dirty Talk and More<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Zaron Burnett III<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/incest-porn-playboy"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/30KnL87gZGQSI0EK0MKoQi/4f154845d907ab72c9b5f3901198b67e/incest-porn_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Incest Porn Is More Popular than You Think<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Debra W. Soh<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"gallery"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/galleries/christine-sofie-johansen-is-a-force-of-nature"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/5fu8Adkm2AaMqc0c2U4Iao/fbec073cf9dccedd91cb17d3c62e42b7/CHRISTINE-SOFIE-JOHANSEN_HeatherHazzan_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Christine Sofie Johansen Is a Force of Nature<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Heather Hazzan<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/a-fantastic-woman-chile-movie-review"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/1tGCpQdEgAQkOOyykkCYg6/8fd1f9a1ad7d95c7d7afb35c952c2b61/fantastic-woman_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Examining Gender Identity, &amp;#39;A Fantastic Woman&amp;#39; Deserves Its Oscars Love<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Stephen Rebello<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/8-former-nfl-players-cannabis"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/2BRYtPM9HuWmS62meqo6Kq/a38928216ec82baed775a7989607a516/cannabis-nfl_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>8 Former NFL Players Share Their Thoughts on Cannabis<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Javier Hasse<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/bloom-farms-socially-conscious-cannabis"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/2jJ1YRzvragka0MSCgImEi/1937c9141f096559ed38e765eea2ba09/bloom-farm_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>Bloom Farms: For the Socially Conscious Stoner<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Kyle Fitzpatrick<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tile box-1"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"article"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/the-art-of-apology-respect-means-having-to-say-youre-sorry"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Tag picture isn\'t supported in AMP. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://images.contentful.com/ogz4nxetbde6/4QNKyYrtkswyMMKG4ksmmE/48015608d1683ea1198c95cf3000dd98/how-to-apologize_thumb.jpg?w=400&amp;h=400&amp;fm=jpg&amp;f=faces&amp;fit=fill"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"400"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"responsive"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;/picture&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"title"</span>&gt;</span>The Art of Apology: Respect Means Having to Say You&amp;#39;re Sorry<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                                <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"author"</span>&gt;</span>by Jennifer Neal<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                    <span class="hljs-comment">&lt;!--{/* Tag load-more isn\'t supported in AMP. */}--&gt;</span>\n
                    <span class="hljs-comment">&lt;!-- &lt;load-more&gt; --&gt;</span>\n
                    <span class="hljs-comment">&lt;!-- &lt;/load-more&gt; --&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">aside</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"sidebar right"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"a300-desktop"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"module voices"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Voices"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"noindex, follow"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"robots"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h2</span>&gt;</span>Voices<span class="hljs-tag">&lt;/<span class="hljs-name">h2</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">ul</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Voices"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"4tJHIeBl8sIGucEKmekequ"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Minda Honey"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/minda-honey"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Minda Honey" src="https://images.contentful.com/ogz4nxetbde6/6vSbg3TGs8q4SQqUiKQs6g/c25925a4aade134f043ace51dbc4aff6/profile-author_minda-honey.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Minda Honey"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/minda-honey"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Minda Honey<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author Feature select: At O.School, Queer Women and People of Color Are Changing the Meaning of Sex Ed"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/o-school-profile"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">em</span>&gt;</span>Redefining sex-ed<span class="hljs-tag">&lt;/<span class="hljs-name">em</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"1DFbKvLiIAoI8SG0AyAISw"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Buzz Poole"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/buzz-poole"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Buzz Poole" src="https://images.contentful.com/ogz4nxetbde6/76nZn2rfFYAqSiwOMiqYyW/583f39e93d65862837cb737f0d41a8a3/Buzz_Poole_Pic.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Buzz Poole"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/buzz-poole"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Buzz Poole<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author Feature select: &amp;#39;Slugfest&amp;#39; Explores the Raging Rivalry Between Marvel and DC Comics"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/slugfest-marvel-dc-comics-rivalry-reed-tucker"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">em</span>&gt;</span>Probing the Marvel/DC rivalry<span class="hljs-tag">&lt;/<span class="hljs-name">em</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"18NHDKTjUyc8QMswso4u8A"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Caroline Orr"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/caroline-orr"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Caroline Orr" src="https://images.contentful.com/ogz4nxetbde6/4R5dG5C8HYiEu22Kyu8qcW/0b4ac331b3e832cc0d3a2752aac2d19b/profile_caroline-orr.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Caroline Orr"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/caroline-orr"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Caroline Orr<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author Feature select: Donald Trump Doesn&amp;#39;t Care About Young People"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/trumpcare-healthcare-young-people"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">em</span>&gt;</span>Trump doesn’t care about young people<span class="hljs-tag">&lt;/<span class="hljs-name">em</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"7G1K2enUJOYkeieWiq2ew"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Shane Michael Singh"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/shane-michael-singh"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Shane Michael Singh" src="https://images.contentful.com/ogz4nxetbde6/56dssyD1HWoos8yQMYKQW8/356f6a8dbc9ba328a03d0f6755baef1f/3838_10100551687969705_240164078_n.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Shane Michael Singh"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/shane-michael-singh"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Shane Michael Singh<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author Feature select: The Female Sexual Revolution Will Be Televised"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/female-sexuality-on-tv"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">em</span>&gt;</span>Women tackle sex on TV better<span class="hljs-tag">&lt;/<span class="hljs-name">em</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"1znyzd7KZic40ygw8aYK2W"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Bridget Phetasy"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/bridget-phetasy"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Bridget Phetasy" src="https://images.contentful.com/ogz4nxetbde6/5Tp8JTvYiIsoA8cguC024u/0b5536c654226279f83f9ec3df644917/thumb_bridget.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Bridget Phetasy"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/bridget-phetasy"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Bridget Phetasy<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author Feature select: Should You Ghost Her? A Flowchart"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/should-you-ghost-her-a-flowchart"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">em</span>&gt;</span>Should you ghost her?<span class="hljs-tag">&lt;/<span class="hljs-name">em</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"6Kgtf0jx8Qm8qaUy202Cu0"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Anna del Gaizo"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/anna-del-gaizo"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Anna del Gaizo" src="https://images.contentful.com/ogz4nxetbde6/3ev0wg9RUAWeGI0EWYuqc8/fdbc08eb020f23659bab1374acc36c82/author_anna-del-gaizo.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author select: Anna del Gaizo"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/authors/anna-del-gaizo"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Anna del Gaizo<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Author Feature select: How Weed Is Making Sex More Fun for Women "</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/how-weed-is-making-sex-more-fun-for-women"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">em</span>&gt;</span>Weed is the new aphrodisiac<span class="hljs-tag">&lt;/<span class="hljs-name">em</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">ul</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"b300-desktop"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"module voices"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Most Popular"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">meta</span> <span class="hljs-attr">content</span>=<span class="hljs-string">"noindex, follow"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"robots"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h2</span>&gt;</span>Most Popular<span class="hljs-tag">&lt;/<span class="hljs-name">h2</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">ul</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Most Popular"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"1085pVAbiE0W0QueE8w0SQ"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: The Social Influencer: How Jeff Flake Became the Senate&amp;#39;s Most Watched Man"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/jeff-flake"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="The Social Influencer: How Jeff Flake Became the Senate&amp;#39;s Most Watched Man" src="https://images.contentful.com/ogz4nxetbde6/6Tcbj6aDZeYyAmqaa8McOq/b77c962c2ce2f41d9c2511028b4f2a6c/thumb_jeffflake_final_w1.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: The Social Influencer: How Jeff Flake Became the Senate&amp;#39;s Most Watched Man"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/jeff-flake"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>The Social Influencer: How Jeff Flake Became the Senate&amp;#39;s Most Watched Man<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"2h5myrcnB6eEqYs8wUooIk"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select:  Dating a Hacker is a Dark Web"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/dating-hacker"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt=" Dating a Hacker is a Dark Web" src="https://images.contentful.com/ogz4nxetbde6/3lbDpukUFWmE0KaGeuUYA4/86d15d3c9c07960d8f2f52f37b68caa1/darkside-hacker-thumb.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select:  Dating a Hacker is a Dark Web"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/dating-hacker"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span> Dating a Hacker is a Dark Web<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"3N7Jwy5cCA4qEiEESiwkmC"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: The Myth of the Male Feminist"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/male-feminists"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="The Myth of the Male Feminist" src="https://images.contentful.com/ogz4nxetbde6/1YeAdCPfAgqO4Wois26kaw/8daa2a6f7807937258b89440c26d5f69/male-feminist-thumb.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: The Myth of the Male Feminist"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/male-feminists"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>The Myth of the Male Feminist<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"12G88oZAnKe0keoaSW6iqE"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: Navigating Tinder in Lebanon"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/navigating-tinder-in-lebanon"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Navigating Tinder in Lebanon" src="https://images.contentful.com/ogz4nxetbde6/2INjA6Gjw4YUu44KYEwYA6/8f65c2e9a86f6b0c5877cea1ba763d72/Lebanon-tinder_thumb.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: Navigating Tinder in Lebanon"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/navigating-tinder-in-lebanon"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Navigating Tinder in Lebanon<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"6kHhN4qbPaUKUkc60M0sIa"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: What 2018 Could Look Like For Our National Parks"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/2018-national-parks"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="What 2018 Could Look Like For Our National Parks" src="https://images.contentful.com/ogz4nxetbde6/2E6SzQH8JeUSUIwYqMUeOg/78d439e72c3c4ff3cd3117346e996945/national-parks_thumb_480.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: What 2018 Could Look Like For Our National Parks"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/2018-national-parks"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>What 2018 Could Look Like For Our National Parks<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"layout"</span> <span class="hljs-attr">data-ident</span>=<span class="hljs-string">"nYEzZRUs7IG22SIUEa4Um"</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: Meet Luci 6000, the Sexting Robot"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/luci-6000-sexting-robot"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                                <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Meet Luci 6000, the Sexting Robot" src="https://images.contentful.com/ogz4nxetbde6/36up25xpMk60qywEqwIG2u/183152a08c283476767f31b47fe2797b/luci-by-maggie-west-8.jpg?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;f=face&amp;amp;fit=thumb" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Post select: Meet Luci 6000, the Sexting Robot"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/articles/luci-6000-sexting-robot"</span> <span class="hljs-attr">itemprop</span>=<span class="hljs-string">"relatedLink"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">strong</span>&gt;</span>Meet Luci 6000, the Sexting Robot<span class="hljs-tag">&lt;/<span class="hljs-name">strong</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">ul</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad sticky"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"c300-desktop"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"module home-social-links"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Follow:Modal"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Social"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h2</span>&gt;</span>Follow The Bunnies<span class="hljs-tag">&lt;/<span class="hljs-name">h2</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">ul</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"facebook"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Follow Facebook"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://www.facebook.com/playboy"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Playboy on Facebook"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Facebook"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-facebook"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"twitter"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Follow Twitter"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://twitter.com/playboy"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Playboy on Twitter"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Twitter"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-twitter"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"instagram"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Follow Instagram"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://instagram.com/playboy"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Playboy on Instagram"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Instagram"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-instagram"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"google-plus"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Follow GooglePlus"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://plus.google.com/108330879683865530444/about"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Playboy on Google+"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Google+"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-google-plus"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">li</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"youtube"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Follow YouTube"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://www.youtube.com/playboy"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"Playboy on YouTube"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">svg</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"img"</span> <span class="hljs-attr">title</span>=<span class="hljs-string">"YouTube"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">use</span> <span class="hljs-attr">xlink:href</span>=<span class="hljs-string">"#icon-youtube"</span> <span class="hljs-attr">xmlns:xlink</span>=<span class="hljs-string">"http://www.w3.org/1999/xlink"</span>/&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">svg</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">li</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">ul</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">aside</span>&gt;</span>\n
        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"search-base"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-base"</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"container"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"form"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-form"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"exit"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Search Exit"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Click X to Exit"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">alt</span>=<span class="hljs-string">"Exit"</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"http://cdn.playboy.com/dashboard_assets/icons/close-8458884cd4bdc91198a3ea80f823651dbc8739587c228c579377a410c7ca8bdc.svg"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"19"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"19"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"fixed"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"clear"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Search Box"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Click X to Clear"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">amp-img</span> <span class="hljs-attr">alt</span>=<span class="hljs-string">"Clear"</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"http://cdn.playboy.com/dashboard_assets/icons/search/search-clear-5ee5ce2a713b25f0eef519c1c4f1e2b93eb03d7e806717656282c6ed16c00006.svg"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"22"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"22"</span> <span class="hljs-attr">layout</span>=<span class="hljs-string">"fixed"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">amp-img</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">autocomplete</span>=<span class="hljs-string">"off"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-input"</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"toolbar"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-toolbar"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"facet"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"facet-refine"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"stats"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-stats"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">amp-accordion</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"padless-right"</span>&gt;</span>\n
                        <span class="hljs-comment">&lt;!-- &lt;div class="padless-right"&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">header</span>&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"results"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-results"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">header</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"loading-indicator rbt-inline-3"</span>&gt;</span>Loading...<span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                        <span class="hljs-comment">&lt;!-- &lt;/div&gt; --&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">amp-accordion</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"series"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-series"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">header</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Popular Series<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">header</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"content"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Fiction"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/playboy-fiction"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Playboy Fiction" src="https://images.contentful.com/ogz4nxetbde6/1u6rzMjdFeKuK8IwAQsKo2/8ed2dce32f9853768b5b2e1e9d8e758b/PlayboyFiction.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Playboy Fiction<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"American Playboy"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/american-playboy"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="American Playboy" src="https://images.contentful.com/ogz4nxetbde6/6c6Ye3QYUwmmgAcseikEOM/06275290437262d37195a95be0ea2eda/american-playboy-icon.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>American Playboy<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"The New Creatives"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/the-new-creatives"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="The New Creatives" src="https://images.contentful.com/ogz4nxetbde6/5T5nnl2NfawAAsuGSaukKY/5909fc034755e1e8bd5b41609d8d11a2/new-creatives.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>The New Creatives<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Interview"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/playboy-interview"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Playboy Interview" src="https://images.contentful.com/ogz4nxetbde6/3YVFuy60LYAycgOiuOKeEO/9e8dd8720d5c5b1c9d75141fe44a6612/PlayboyInterview.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Playboy Interview<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Advisor"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/playboy-advisor"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Playboy Advisor" src="https://images.contentful.com/ogz4nxetbde6/jZwaGtkAKsk0oiyQm2EiK/23bf8dc9b81a435a403615c97ab1e09c/PlayboyAdvisorWhite_vhghev_.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Playboy Advisor<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Turn Ons/Turns Offs"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/turn-ons-turn-offs"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Turn Ons/Turns Offs" src="https://images.contentful.com/ogz4nxetbde6/2QHOcQo5qE8KGIaUMYOIk2/b32546c0501ecac80e04f029de0faf80/turnons.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Turn Ons/Turns Offs<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Adults &amp;amp; Crafts"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/adults-and-crafts"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Adults &amp;amp; Crafts" src="https://images.contentful.com/ogz4nxetbde6/6vJePhCkAoaKA4eKaSMaeM/40a9b8af933a3acd1155a27ee55da0a8/Adults.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Adults &amp;amp; Crafts<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Conversation"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/playboy-conversation"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Playboy Conversation" src="https://images.contentful.com/ogz4nxetbde6/7lR6qNGbZuEycsYoK2kSEW/7ce711d93422610ea9e6c0dc4318deb2/PBConversation.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Playboy Conversation<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Just The Tips"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/just-the-tips"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Just The Tips" src="https://images.contentful.com/ogz4nxetbde6/12kGYqswhoG4eaeuYqEkcK/f42c89725b387e0c8b8c54fda1e0f88c/JustTheTips.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Just The Tips<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playmates On"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/playmates-on"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Playmates On" src="https://images.contentful.com/ogz4nxetbde6/5mwQnYL3EsOKCsKakuwU2k/2d44f8a5a1c9aa63fabfa823d04375e8/Playmates-On.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Playmates On<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Drinking Decoded"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/drinking-decoded"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Drinking Decoded" src="https://images.contentful.com/ogz4nxetbde6/37zXLYoWWsCaOwQ02C6Qkw/10dba5b67a84d3833bbb9ae2b4302a09/drinking-decoded.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Drinking Decoded<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Popular Series"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Bartender Confidential"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/series/bartender-confidential"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img alt="Bartender Confidential" src="https://images.contentful.com/ogz4nxetbde6/1T38QuN9dOAIy6YQqWSu2C/5e9f7e044fd80cbd98972873a5ae3a33/BartenderConfidential.png?w=70&amp;amp;h=70&amp;amp;fm=jpg&amp;amp;fit=scale" width="200" height="150" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                            <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Bartender Confidential<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"search-tags"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">header</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">h5</span>&gt;</span>Trending Tags<span class="hljs-tag">&lt;/<span class="hljs-name">h5</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;/<span class="hljs-name">header</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"content"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"blondes"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/blondes"</span>&gt;</span>blondes<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"brunettes"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/brunettes"</span>&gt;</span>brunettes<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"cars"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/cars"</span>&gt;</span>cars<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"celebrities"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/celebrities"</span>&gt;</span>celebrities<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"dating advice"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/dating-advice"</span>&gt;</span>dating advice<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"food and drink"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/food-and-drink"</span>&gt;</span>food and drink<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"funny"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/funny"</span>&gt;</span>funny<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"gaming"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/gaming"</span>&gt;</span>gaming<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"gear"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/gear"</span>&gt;</span>gear<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Health &amp;amp; Fitness"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/health-fitness"</span>&gt;</span>Health &amp;amp; Fitness<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"hugh hefner"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/hugh-hefner"</span>&gt;</span>hugh hefner<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"movies"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/movies"</span>&gt;</span>movies<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"music"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/music"</span>&gt;</span>music<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"music festival"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/music-festival"</span>&gt;</span>music festival<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"news"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/news"</span>&gt;</span>news<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"playboy mansion"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/playboy-mansion"</span>&gt;</span>playboy mansion<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"playmates"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/playmates"</span>&gt;</span>playmates<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"sports"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/sports"</span>&gt;</span>sports<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"travel"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/travel"</span>&gt;</span>travel<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"tv"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/tv"</span>&gt;</span>tv<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"Trending Tags"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Search"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"weed"</span> <span class="hljs-attr">data-type</span>=<span class="hljs-string">"tags"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/tags/weed"</span>&gt;</span>weed<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"b970"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">footer</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"main bg-bunny-inverse"</span> <span class="hljs-attr">data-action</span>=<span class="hljs-string">"footer"</span> <span class="hljs-attr">data-category</span>=<span class="hljs-string">"Navigation"</span> <span class="hljs-attr">role</span>=<span class="hljs-string">"contentinfo"</span>&gt;</span>\n
            <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"wrapper"</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">data-label-prefix</span>=<span class="hljs-string">"Magazine"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h3</span>&gt;</span>Magazine<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"wrapper"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"MagCover Icon"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://secure.customersvc.com/servlet/Show?WESPAGE=pm/Pages/load_order.jsp&amp;amp;WESACTIVESESSION=TRUE&amp;amp;PAGE_ID=14198DG001&amp;amp;MAGCODE=PY&amp;amp;MSCCMPLX=1004"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/4PA10HPf7q6Y2uqGWoYqW/ce0f9027ec0fac1ec2b6e65d966a907f/magazine-cover.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="215" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"MagCover Icon"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://secure.customersvc.com/servlet/Show?WESPAGE=pm/Pages/load_order.jsp&amp;amp;WESACTIVESESSION=TRUE&amp;amp;PAGE_ID=14198DG001&amp;amp;MAGCODE=PY&amp;amp;MSCCMPLX=1004"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">data-label-prefix</span>=<span class="hljs-string">"NSFW"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h3</span>&gt;</span>NSFW<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"wrapper"</span>&gt;</span>\n
                        <span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PB Plus Icon"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://ma.playboyplus.com/age-gate?url=http://www.playboyplus.com/go/?id=f6b9321b495bf7d2"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">"nofollow"</span>&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!--{/* Unable to detect image width or height. Default values were applied. */}--&gt;</span>\n
                            <span class="hljs-comment">&lt;!-- &lt;amp-img src="https://images.contentful.com/ogz4nxetbde6/23YnwYGAwIqYaIYmYUYSSw/8419cfaf8cdcf44fb8785f0fa3f0cf6a/pb-plus-house-ad-SM.jpg?fm=jpg&amp;amp;fit=scale&amp;amp;h=215" width="200" height="215" layout="fixed"&gt;&lt;/amp-img&gt; --&gt;</span>\n
                        <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"button"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PB Plus Icon"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://ma.playboyplus.com/age-gate?url=http://www.playboyplus.com/go/?id=f6b9321b495bf7d2"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">"nofollow"</span>&gt;</span>Subscribe<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">data-label-prefix</span>=<span class="hljs-string">"Content"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h3</span>&gt;</span>Content<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"wrapper"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Entertainment"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/entertainment"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Entertainment<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Off Hours"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/off-hours"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Off Hours<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Bunnies"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/bunnies"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Bunnies<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"SexCulture"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/sex-and-culture"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Sex &amp;amp; Culture<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"heritage"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/heritage"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Heritage<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Video"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/videos"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Video<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">""</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://s3.amazonaws.com/playboy-www-production/assets/Playboy_2018_Media_Kit.pdf"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Advertise With Us <span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"About Us"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/about"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>About Us<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Privacy"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/privacy-policy"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Privacy Policy<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Sitemap"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboy.com/sitemap"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Sitemap<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"TOS"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyenterprises.com/terms-of-use/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Terms of Use<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">section</span> <span class="hljs-attr">data-label-prefix</span>=<span class="hljs-string">"Sites"</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">h3</span>&gt;</span>Sites<span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>\n
                    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"wrapper"</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playmates.com"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://playmates.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playmates.com<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Mobile"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://playboymobile.com/mobile/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Download the App<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PB Shop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyshop.com/?utm_source=playboy&amp;amp;utm_medium=native&amp;amp;utm_campaign=footer"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Shop<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Archive"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://join-iplayboy.covertocover.com/track/MTAwMzk1OS4xLjExLjExLjAuMC4wLjAuMA?autocamp=playboycom_footer"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Archive<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"studios.playboy.com"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://studios.playboy.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Studios<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"PB Enterprises"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://www.playboyenterprises.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Enterprises<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">""</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://careers-playboy.icims.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Careers<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Hop"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://hop.playboy.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Events<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Events"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://playboyevents.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playmate Promotions<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy Radio"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://playboyradio.com/"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy Radio<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Playboy TV"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"http://join.playboy.tv/track/MTAwMzk1OS4xMDAxMS4xMDMxLjExMDMuNjk0LjAuMC4wLjA/join?layout=showpage&amp;amp;pg=1"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Playboy.TV<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"footer-nav"</span> <span class="hljs-attr">data-label</span>=<span class="hljs-string">"Mag Support"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"https://secure.customersvc.com/servlet/Show?WESPAGE=csp/PB/login.jsp&amp;amp;MSRSMAG=PY"</span> <span class="hljs-attr">rel</span>=<span class="hljs-string">""</span>&gt;</span>Magazine Customer Support<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
                <span class="hljs-tag">&lt;/<span class="hljs-name">section</span>&gt;</span>\n
                <span class="hljs-tag">&lt;<span class="hljs-name">p</span>&gt;</span>&amp;copy2018 Playboy Enterprises All&amp;nbsp;rights&amp;nbsp;reserved<span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>\n
            <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;/<span class="hljs-name">footer</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"footerOverlay"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"flexTakeover"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"ad"</span> <span class="hljs-attr">id</span>=<span class="hljs-string">"sideSkins"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>\n
        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
        <span class="hljs-comment">&lt;!--{/* Tag transition isn\'t supported in AMP. */}--&gt;</span>\n
        <span class="hljs-comment">&lt;!-- &lt;transition name="modal"&gt; --&gt;</span>\n
        <span class="hljs-comment">&lt;!-- &lt;/transition&gt; --&gt;</span>\n
        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
        <span class="hljs-comment">&lt;!--{/* Tag transition isn\'t supported in AMP. */}--&gt;</span>\n
        <span class="hljs-comment">&lt;!-- &lt;transition name="modal"&gt; --&gt;</span>\n
        <span class="hljs-comment">&lt;!-- &lt;/transition&gt; --&gt;</span>\n
        <span class="hljs-comment">&lt;!--{/* @notice */}--&gt;</span>\n
        <span class="hljs-comment">&lt;!--{/* Tag transition isn\'t supported in AMP. */}--&gt;</span>\n
        <span class="hljs-comment">&lt;!-- &lt;transition name="modal"&gt; --&gt;</span>\n
        <span class="hljs-comment">&lt;!-- &lt;/transition&gt; --&gt;</span>\n
    <span class="hljs-tag">&lt;/<span class="hljs-name">body</span>&gt;</span>\n
<span class="hljs-tag">&lt;/<span class="hljs-name">html</span>&gt;</span></code></pre>');
// Load HTML from a string
        /*$result=$html->load('<html><body>Hello!<span class="hljs-tag">Batman</span> </body></html>');
*/

        foreach($content->find('.hljs-tag') as $ul){
           // dd('nothing');
            echo $ul. " ";

        }
        echo "\ndone!\n";

    }


    //start parsing the top menu
    //          assumptions
    //**** the menu is list based (UL/LI)
    //**** the menu has a top NAV class
    //let's assume we already have the string we need.

    public static function menu(){


        $str='<nav class="main-menu mt30">
<ul id="menu-main-nav" class="menu"><li id="menu-item-27" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current-menu-ancestor current-menu-parent current-page-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-27"><a href="http://www.bigbearair.com/about/">Our Story</a>
<ul class="sub-menu">
	<li id="menu-item-31" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-6 current_page_item menu-item-31"><a href="http://www.bigbearair.com/about/our-process/">Our Process</a></li>
	<li id="menu-item-32" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-32"><a href="http://www.bigbearair.com/about/our-team/">Our Team</a></li>
</ul>
</li>
<li id="menu-item-30" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-30"><a href="http://www.bigbearair.com/services/">Services</a>
<ul class="sub-menu">
	<li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-35"><a href="http://www.bigbearair.com/services/duct-work/">Duct Work</a></li>
	<li id="menu-item-34" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-34"><a href="http://www.bigbearair.com/services/indoor-air-quality/">Air Filtration Systems / HEPA</a></li>
	<li id="menu-item-33" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-33"><a href="http://www.bigbearair.com/services/air-conditioning-repair-installation/">A/C Repair &amp; Installation</a></li>
	<li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38"><a href="http://www.bigbearair.com/services/heating-repair-and-installation/">Heating Repair &amp; Installation</a></li>
	<li id="menu-item-39" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-39"><a href="http://www.bigbearair.com/services/humidifiers-and-dehumidifiers/">Humidifiers &amp; Dehumidifiers</a></li>
	<li id="menu-item-36" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-36"><a href="http://www.bigbearair.com/services/ductless-minisplit-systems/">Ductless Mini-Split Systems</a></li>
	<li id="menu-item-41" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41"><a href="http://www.bigbearair.com/services/zoning-systems/">Zoning Systems</a></li>
	<li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-40"><a href="http://www.bigbearair.com/services/ongoing-maintenance/">Ongoing Maintenance</a></li>
	<li id="menu-item-37" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37"><a href="http://www.bigbearair.com/services/emergency-services/">Emergency Services</a></li>
</ul>
</li>
<li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29"><a href="http://www.bigbearair.com/service-area/">Service Area</a></li>
<li id="menu-item-28" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-28"><a href="http://www.bigbearair.com/financing/">Payments / Financing</a></li>
<li id="menu-item-26" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26"><a href="http://www.bigbearair.com/contact/">Contact Us</a></li>
</ul>                                </nav>';

        $dom = HtmlDomParser::str_get_html( $str );

       // $top_menus=$dom->root->nodes[0]->children[0]->children;

        //$top_menus=$dom->find('nav ul li');

        foreach($dom->find('nav ul') as $ul)
        {
            //echo $ul;
            //$res=$ul->find('.sub-menu');
            echo $ul;
            dd($ul);
            /*foreach ($res as $element){
              //  echo Format::tabs(10).$element;
            }

            dd('master menu');


            if(!is_null($res)) {
                foreach ($res as $li) {
                    // do something...
                    echo $li;
                }
            }else{
                echo "papa";
            }
            dd("ja");
        */
            }

        dd("nope");

        foreach ($top_menus as $menu){

            $child=$menu->firstChild();
            if(count($child)>1){
                echo "we have a child<br>";
            }else{
                echo "ends here<br>";
            }

/*
           dd("end");

            dd($menu->nodes);
            foreach ($menu->nodes as $items){
                $child=($menu->firstChild()->firstChild());
                if(!is_null($child)){
                    echo "we have a child<br>";
                }else{
                    echo "ends here<br>";
                }
            }

            dd("boom");
                dd($menu,"Taytus");

           $caption=$menu->find('a');

           //list all nodes


            //dd($caption);

            //0 is the top menu and the others are the childrens
           /* $sub_menu=$caption[1]->find('a');

            foreach($sub_menu as $child){
                dd($child);
            }
            ($sub_menu);


            $caption=$caption[0]->nodes[0]->_;
            $caption=$caption[4];
            //$url=

            echo $caption;
*/
        }


        dd($top_menus);
        dd($dom);



    }



}
