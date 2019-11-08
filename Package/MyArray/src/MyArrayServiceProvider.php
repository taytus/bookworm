<?php
namespace ROBOAMP\MyArray;
use Illuminate\Support\ServiceProvider;
use ROBOAMP\MyArray;
//use ROBOAMP\Strings\StringsServiceProvider;


class MyArrayServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){

        $this->app->singleton(MyArray::class, function () {


            return new MyArray();
        });

        $this->app->alias(MyArray::class, 'MyArray');
    }

}