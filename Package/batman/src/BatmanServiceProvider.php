<?php
namespace roboamp\batman;

use Illuminate\Support\ServiceProvider;


class BatmanServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Batman::class, function () {


            return new Batman();
        });

        $this->app->alias(Batman::class, 'Batman');
    }

}