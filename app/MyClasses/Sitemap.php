<?php


namespace App\MyClasses;
use Spatie\Sitemap\Tags\Url;

use App\Page;
use App\Property;
use Carbon\Carbon;


/**
 * Class URL
 * @package App\MyClasses
 */
class Sitemap  {
    private $sitemap_path="";
    protected $sitemampClass;

    public function __construct(){
        return true;
        $this->sitemap_path=base_path('/public/sitemap.xml');

    }

    public function create_sitemap(){
        classSitemap::create()
            ->add(Url::create('/kakatua')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.1))
            ->writeToFile($this->sitemap_path);
    }
    public function add_pages($pages)
    {

        return true;
        foreach ($pages as $item) {
            $parser_url = "https://parser.roboamp.com/trigger/";

            $url = $parser_url . $item['property_id'] . "/" . $item['url'];
            $this->sitemapClass->add(Url::create($url)
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.1));


        }

        $this->sitemapClass->writeToFile($this->sitemap_path);


        echo "\n SITEMAP has been updated : \n";

        /*
            // here we add one extra link, but you can add as many as you'd like
            ->add(Url::create('/extra-page')->setPriority(0.5))
            ->add(Url::create('/extra-hello')->setPriority(0.5))

            ->writeToFile($this->sitemap_path);*/
    }

    public function create_from_all_active_properties(){

        $pages=Page::pages_from_active_properties();

            foreach ($pages as $item) {
                $parser_url = "https://parser.roboamp.com/trigger/";

                $url = $parser_url . $item->property_id . "/" . $item->url;
                $this->sitemapClass->add(Url::create($url)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.1));


            }
        $this->sitemapClass->writeToFile($this->sitemap_path);


    }

}