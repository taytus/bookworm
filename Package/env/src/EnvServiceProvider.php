<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;
use ROBOAMP\Commands\EnvCommand;

class EnvServiceProvider extends ServiceProvider{
    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->commands([
                EnvCommand::class,
            ]);
        }
    }
    public function register(){
        $this->app->singleton(Env::class, function () {


            return new Env();
        });

        $this->app->alias(Env::class, 'EnvCommand');
    }

}
