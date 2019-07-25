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

Route::group(['namespace' => 'Frontend'], function () {

    Route::get('login', 'LoginController@login')->name('site.login');
    Route::post('login-store', 'LoginController@loginStore')->name('site.login-store');
    Route::get('register', 'LoginController@register')->name('site.register');
    Route::post('register-store', 'LoginController@registerStore')->name('site.register-store');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', 'LoginController@logout')->name('site.logout');
        Route::get('/', 'MainController@index')->name('index');
        Route::get('profile', 'ProfileController@index')->name('profile.index');
        Route::get('chat', 'ChatController@index')->name('chat.index');
        Route::post('main/like', 'MainController@like')->name('main.like');
        Route::get('comment/index', 'CommentController@index')->name('comment.index');
        Route::post('comment/store', 'CommentController@store')->name('comment.store');
        Route::get('publish', 'PublishController@index')->name('publish.index');
        Route::get('seckill', 'SeckillController@index')->name('seckill.index');
        Route::post('seckill/start', 'SeckillController@start')->name('seckill.start');
        Route::get('seckill/buy', 'SeckillController@buy')->name('seckill.buy');
        Route::get('seckill/result', 'SeckillController@result')->name('seckill.result');
    });
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('login', 'LoginController@login')->name('admin.login');
    Route::post('login-store', 'LoginController@loginStore');
    Route::get('getCaptcha', 'LoginController@getCaptcha')->name('admin.getCaptcha');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'IndexController@index')->name('admin.index');
    });
});