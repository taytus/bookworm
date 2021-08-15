<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;

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