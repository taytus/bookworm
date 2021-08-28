<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;

class FilesServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Files::class, function () {


            return new Files();
        });

        $this->app->alias(Files::class, 'Files');
    }

}