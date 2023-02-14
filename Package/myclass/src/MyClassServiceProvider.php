<?php
namespace ROBOAMP;

use Illuminate\Support\ServiceProvider;



class MyClassServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(MyClassServiceProvider::class, function () {


            return new Dusk();
        });

        $this->app->alias(MyClass::class, 'MyClass');
    }

}
