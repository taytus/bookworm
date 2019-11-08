<?php
namespace ROBOAMP\Validator;
use Illuminate\Support\ServiceProvider;
use ROBOAMP\Validator;
//use ROBOAMP\Strings\StringsServiceProvider;


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