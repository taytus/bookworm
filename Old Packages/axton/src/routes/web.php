<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['namespace'=>'ROBOAMP\Axton\Http\Controllers'],function() {


    Route::group(['prefix'=>'dashboard'],function(){
        Route::get('/', 'AxtonController@dashboard')->name('dashboard');
    });
    //  Route::get('admin', 'AxtonController@index')->name('index');
    Route::get('login','AxtonUserController@index')->name('login');
    Route::post('login','AxtonUserController@post_form')->name('login.post');



});