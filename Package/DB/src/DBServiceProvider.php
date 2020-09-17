<?php
namespace roboamp\db;
use Illuminate\Support\ServiceProvider;


class DbServiceProvider extends ServiceProvider{
    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeederCommand::class,
            ]);
        }
    }
    public function register(){

        $this->app->singleton(DB::class, function () {
            return new DB();
        });


        $this->app->alias(DB::class, 'DB');
    }

}