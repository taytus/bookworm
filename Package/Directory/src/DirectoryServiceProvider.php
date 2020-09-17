<?php
namespace roboamp\Directory;
use Illuminate\Support\ServiceProvider;

use ROBOAMP\Axton;
use ROBOAMP\Directory;

class DirectoryServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Directory::class, function () {


            return new Directory();
        });

        $this->app->alias(Directory::class, 'Directory');
    }

}