<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;

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