<?php
namespace ROBOAMP\Files;
use Illuminate\Support\ServiceProvider;

use ROBOAMP\Axton;

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