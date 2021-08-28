<?php
namespace ROBOAMP;

use Illuminate\Support\ServiceProvider;


class ServerServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){
        $this->app->singleton(Server::class, function () {
            return new Server();
        });
        $this->app->alias(Server::class, 'Server');

    }

}
