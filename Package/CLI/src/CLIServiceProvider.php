<?php
namespace ROBOAMP\CLI;
use Illuminate\Support\ServiceProvider;

use ROBOAMP\CLI\CLI;

class CLIServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(CLI::class, function () {


            return new CLI();
        });

        $this->app->alias(CLI::class, 'CLI');
    }

}