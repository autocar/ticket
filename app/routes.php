<?php

// 前台
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showIndex'));
Route::controller('account','AccountController' );

// 后台登陆
Route::get('admin/login', 'Controllers\Admin\AccountController@getLogin');
Route::post('admin/login', 'Controllers\Admin\AccountController@postLogin');
Route::get('admin/logout', 'Controllers\Admin\AccountController@getLogout');

Route::group(array('prefix' => 'admin'), function()
{
    # 首页
    Route::get('/', array('as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));
});

