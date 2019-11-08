<?php
namespace ROBOAMP\URL;
use Illuminate\Support\ServiceProvider;

use ROBOAMP\URL;

class URLServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(URL::class, function () {


            return new URL();
        });

        $this->app->alias(URL::class, 'URL');
    }

}