<?php
namespace roboamp\MyClass;
use Illuminate\Support\ServiceProvider;

use ROBOAMP\Axton;
use ROBOAMP\MyClass;

class MyClassServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(MyClass::class, function () {


            return new MyClass();
        });

        $this->app->alias(MyClass::class, 'MyClass');
    }

}