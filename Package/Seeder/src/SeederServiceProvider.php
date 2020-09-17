<?php
namespace roboamp\Seeder;
use Illuminate\Support\ServiceProvider;


class SeederServiceProvider extends ServiceProvider{

    public function boot(){

    }
    public function register(){
        $this->app->singleton(Seeder::class, function () {
            return new Seeder();
        });
        $this->app->alias(Seeder::class, 'Seeder');

    }

}