<?php
namespace ROBOAMP;
use Illuminate\Support\ServiceProvider;


class DBServiceProvider extends ServiceProvider{
    public function boot(){

    }
    public function register(){

        $this->app->singleton(DB::class, function () {
            return new DB();
        });


        $this->app->alias(DB::class, 'DB');
    }

}
