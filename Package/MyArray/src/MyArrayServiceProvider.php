<?php
namespace roboamp\myarray;
use Illuminate\Support\ServiceProvider;


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