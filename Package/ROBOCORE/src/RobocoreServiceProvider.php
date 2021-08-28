<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;


class RobocoreServiceProvider extends ServiceProvider{
    public function boot(){


        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views','robocore');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');





        $this->publishes([
            __DIR__.'/models' => $this->app->basePath('app/'),
        ]);



    }
    public function register(){

        $this->app->singleton(Robocore::class, function () {
            return new Robocore();
        });

        $this->app->alias(Robocore::class, 'ROBOCORE');
    }

}