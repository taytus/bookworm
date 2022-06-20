<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 5/17/18
 * Time: 1:38 AM
 */

namespace App\MyClasses;
use App\MyClasses\Git;

class LandingPageData{

    private $data;
    private $team_members;
    private $case_studies;
    private $plans;
    private $carousel_testimonials;
    private $exclusions;

    //exclusions is an array with fields to be ignored;
    function __construct($exlusions=null){

        $this->exclusions=$exlusions;
        $this->init();

        return $this->getData();
    }



    public function init(){

        $this->preload_data();

        $this->data['team_members']=$this->team_members;
        $this->data['case_studies']=$this->case_studies;
        $this->data['carousel_testimonials']=$this->carousel_testimonials;
        $this->data['plans']=$this->plans;

        if(!is_null($this->exclusions)) {
            foreach ($this->exclusions as $exlusion) {
                if (array_key_exists($exlusion, $this->data)) {
                    unset ($this->data[$exlusion]);

                }
            }
        }

    }





    public function getData(){return $this->data;}




    private function preload_data(){

        $this->team_members=array(
            ['image'=>'roberto', 'name'=>'Roberto Inetti', 'title'=>'CEO', 'social_media'=>['facebook'=>'', 'twitter'=>'https://twitter.com/Taytus', 'google'=>'', 'linkedin'=>'https://www.linkedin.com/in/robertoinetti/']],
            ['image'=>'luke', 'name'=>'Luke Pettyjohn', 'title'=>'COO', 'social_media'=>['facebook'=>'', 'twitter'=>'https://twitter.com/LukePettyjohn', 'google'=>'', 'linkedin'=>'https://www.linkedin.com/in/luke-m-pettyjohn-78b88335/']],
            ['image'=>'sean', 'name'=>'Sean McElduff', 'title'=>'CFO', 'social_media'=>['facebook'=>'', 'twitter'=>'', 'google'=>'', 'linkedin'=>'https://www.linkedin.com/in/sean-mcelduff-9571b3/']],

        );
        $this->case_studies=array(
            ['url'=>'https://www.ampproject.org/case-studies/transunion/', 'date'=>'APR 9, 2018', 'image'=>'transunion_logo', 'content'=>'TransUnion scores more conversions with faster page loads via AMP'],
            ['url'=>'https://www.ampproject.org/case-studies/bmw/', 'date'=>'MAR 12, 2018', 'image'=>'bmw_logo', 'content'=>'Carmaker quickly, smoothly shares stories via AMP on BMW.com'],
            ['url'=>'https://www.ampproject.org/case-studies/wired/', 'date'=>'OCT 7, 2016', 'image'=>'wired_logo', 'content'=>'Wired AMP’s its 20+ year archive to meet audiences online'],
            ['url'=>'https://www.ampproject.org/case-studies/washingtonpost/', 'date'=>'JUL 18, 2016', 'image'=>'wapo_logo', 'content'=>'WAPO increases returning users from mobile search by 23%'],
            ['url'=>'https://www.ampproject.org/case-studies/event_ticket_center/', 'date'=>'DEC 20, 2017', 'image'=>'etc_logo', 'content'=>'Event Tickets Center significantly boosts conversions with AMP'],
            ['url'=>'https://www.ampproject.org/case-studies/us_xpress/', 'date'=>'DEC 20, 2017', 'image'=>'usx_logo', 'content'=>'Faster page loads with AMP deliver truckloads of new drivers to U.S. Xpress'],
            ['url'=>'https://www.ampproject.org/case-studies/grupo/', 'date'=>'FEB 13, 2018', 'image'=>'grupo_logo', 'content'=>'Grupo Expansión boosts monetization with AMP'],
            ['url'=>'https://www.ampproject.org/case-studies/innkeepers/', 'date'=>'MAR 2, 2018', 'image'=>'innkeepers_logo', 'content'=>'Innkeeper’s Advantage helps book guests quicker with AMP']
        );

        $this->carousel_testimonials=array(
            ['image'=>'the-washington-post', 'name'=>'David Merrell', 'testimonial'=>' “We have seen load times
                    average 400 milliseconds, an 88% improvement over our traditional mobile website. This has made readers more likely to tap on
                    Washington Post stories because they know our articles will load consistently fast.”'
                , 'rating'=>['star1'=>'x', 'star2'=>'x', 'star3'=>'x', 'star4'=>'x', 'star5'=>'']
            ],
            ['image'=>'cnbc_logo_thumb', 'name'=>'Roshan Varghese', 'testimonial'=>'“AMP is like web on steroids. We were able to achieve huge performance gains by using the format’s approach of going back to the basics and making user experience the primary goal.”'
                , 'rating'=>['star1'=>'x', 'star2'=>'x', 'star3'=>'x', 'star4'=>'x', 'star5'=>'']
            ],
            ['image'=>'terra_logo', 'name'=>'Souza', 'testimonial'=>'“The benefit of AMP is already paying off in terms of our readers’ user experience, our advertisers’ results, and our company’s bottom line. We’re thrilled at how quickly going AMP has made a difference.”'
                , 'rating'=>['star1'=>'x', 'star2'=>'x', 'star3'=>'x', 'star4'=>'x', 'star5'=>'x']
            ],
            ['image'=>'hearst_logo', 'name'=>'Phil Wiser', 'testimonial'=>'“We’re constantly looking for creative new ways to engage our audiences with unique, compelling content and bringing those experiences to the AMP platform is a key part of our product roadmap on mobile,”'
                , 'rating'=>['star1'=>'x', 'star2'=>'x', 'star3'=>'x', 'star4'=>'x', 'star5'=>'x']
            ]
        );
        $this->plans=array(
            ['price_color' => '', 'button_color' => '', 'title'=>'Monthly', 'sub_header' => '', 'payment'=>'monthly', 'price'=>'$30.00/mo', 'feature_list'=>['100% valid AMP conversion', 'Nothing to install', 'Email Support']],
            ['price_color' => 'annual_price_color', 'button_color' => 'annual_button', 'title'=>'Annually', 'sub_header' => '', 'payment'=>'annually', 'price'=>'$300.00/year', 'feature_list'=>['Everything in Monthly Plan', '2 Months Free!', 'Customer Preferred']]
        );



    }

}