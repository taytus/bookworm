<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;


class MyArrayServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){

        $this->app->singleton(Git::class, function () {


            return new Git();
        });

        $this->app->alias(Git::class, 'MyArray');
    }

}