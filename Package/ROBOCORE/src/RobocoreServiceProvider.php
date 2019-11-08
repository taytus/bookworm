<?php
namespace ROBOAMP\ROBOCORE;
use Illuminate\Support\ServiceProvider;
use ROBOAMP\ROBOCORE;


class RobocoreServiceProvider extends ServiceProvider{
    public function boot(){


        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views','ROBOCORE');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');





        $this->publishes([
            __DIR__.'/models' => $this->app->basePath('app/'),
        ]);

        /*
         * $this->publishes([
            __DIR__.'/config/robocore.php' => config_path('robocore.php'),
        ]);
        $this->publishes([
            __DIR__.'/assets' => public_path('ROBOCORE/assets'),
        ], 'public');

         $this->publishes([
            __DIR__ . '/Database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
        */

    }
    public function register(){

        $this->app->singleton(ROBOCORE::class, function () {
            return new ROBOCORE();
        });

        $this->app->alias(ROBOCORE::class, 'ROBOCORE');
    }

}