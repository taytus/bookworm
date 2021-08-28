<?php
namespace ROBOAMP\Git;
use Illuminate\Support\ServiceProvider;
use ROBOAMP\Git;


class GitServiceProvider extends ServiceProvider{

    public function boot(){

    }
    public function register(){
        $this->app->singleton(Git::class, function () {
            return new Git();
        });
        $this->app->alias(Git::class, 'Git');

    }

}