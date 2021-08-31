<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;

class $$package_name$$ServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton($$package_name$$::class, function () {


            return new $$package_name$$();
        });

        $this->app->alias($$package_name$$::class, '$$package_name$$');
    }

}
