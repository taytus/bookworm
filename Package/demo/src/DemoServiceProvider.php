<?php
namespace roboamp\Demo;
use Illuminate\Support\ServiceProvider;

use roboamp\Demo;

class DemoServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Demo::class, function () {

            return new Demo();
        });

        $this->app->alias(Demo::class, 'Demo');
    }

}