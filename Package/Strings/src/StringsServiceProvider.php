<?php
namespace roboamp\strings;

use Illuminate\Support\ServiceProvider;


class StringsServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Strings::class, function () {


            return new Strings();
        });

        $this->app->alias(Strings::class, 'Strings');
    }

}