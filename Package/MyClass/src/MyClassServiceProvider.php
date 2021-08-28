<?php
namespace ROBOAMP;

use Illuminate\Support\ServiceProvider;



class MyClassServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Dusk::class, function () {


            return new Dusk();
        });

        $this->app->alias(Dusk::class, 'MyClass');
    }

}
