<?php
namespace ROBOAMP\Axton;
use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use ROBOAMP\Axton;
use ROBOAMP\Axton\Commands\SeederCommand;

class AxtonServiceProvider extends ServiceProvider{

    protected $commands=[
        Seeder::class
    ];

    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);

        }

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views','Axton');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        $this->publishes([
            __DIR__ . '/Database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
        $this->publishes([
            __DIR__.'/config/axton.php' => config_path('axton.php'),
        ]);
        $this->publishes([
            __DIR__.'/assets' => public_path('Axton/assets'),
        ], 'public');




    }
    public function register(){

        $this->app->singleton(Axton::class, function () {
            return new Axton();
        });
        $this->app->alias(Axton::class, 'Axton');
        config([
            'config/axton.php',
        ]);
    }

}