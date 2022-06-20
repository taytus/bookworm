<?php
namespace ROBOAMP;

use Illuminate\Support\ServiceProvider;


class ValidatorServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){

        $this->app->singleton(Validator::class, function () {


            return new Validator();
        });

        $this->app->alias(Validator::class, 'Validator');
    }

}