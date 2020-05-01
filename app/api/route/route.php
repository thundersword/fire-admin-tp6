<?php
use think\facade\Route;
Route::group('',function(){
    Route::group('admin',function (){
        Route::group('user',function (){
            Route::post('login','admin.user/login')->name('admin_login');
            Route::get('auth','admin.user/auth');
        });

    });
})->allowCrossDomain();
