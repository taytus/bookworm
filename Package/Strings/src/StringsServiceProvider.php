<?php
namespace ROBOAMP\MyClass;
use Illuminate\Support\ServiceProvider;

use ROBOAMP\MyClass;

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