<?php
// 前台
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showIndex'));
Route::controller('account','AccountController');

// 工单
Route::controller('ticket','TicketController');

// 后台登陆
Route::get('admin/login', 'Controllers\Admin\AccountController@getLogin');
Route::post('admin/login', 'Controllers\Admin\AccountController@postLogin');
Route::get('admin/logout', 'Controllers\Admin\AccountController@getLogout');

Route::group(array('prefix' => 'admin'), function()
{
    // 首页
    Route::get('/', array('as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));

    // 个人资料
    Route::get('account', 'Controllers\Admin\AccountController@getIndex');
    Route::post('account', 'Controllers\Admin\AccountController@postIndex');

    // 系统配置
    Route::get('configuration', 'Controllers\Admin\ConfigurationController@getIndex');
    Route::post('configuration', 'Controllers\Admin\ConfigurationController@postIndex');

    // 工单管理
    Route::get('ticket', array('as' => 'ticket', 'uses' => 'Controllers\Admin\TicketController@getIndex'));
    Route::get('ticket/{jobId}/view', array('as' => 'view/ticket', 'uses' => 'Controllers\Admin\TicketController@getView'));
    Route::post('ticket/{jobId}/view', 'Controllers\Admin\TicketController@postView');
    Route::get('ticket/{jobId}/assign', array('as' => 'view/assign', 'uses' => 'Controllers\Admin\TicketController@getAssign'));
    Route::post('ticket/{jobId}/assign', 'Controllers\Admin\TicketController@postAssign');
    Route::get('ticket/{jobId}/close', array('as' => 'view/close', 'uses' => 'Controllers\Admin\TicketController@getClose'));
    Route::get('ticket/{jobId}/apply', array('as' => 'view/apply', 'uses' => 'Controllers\Admin\TicketController@getApply'));
    Route::get('ticket/{memberId}/member', array('as' => 'member/ticket', 'uses' => 'Controllers\Admin\TicketController@getMember'));

    // 问题类型
    Route::get('type', array('as' => 'type', 'uses' => 'Controllers\Admin\TypeController@getIndex'));
    Route::get('type/create', array('as' => 'type/add', 'uses' => 'Controllers\Admin\TypeController@getCreate'));
    Route::post('type/create', 'Controllers\Admin\TypeController@postCreate');
    Route::get('type/{typeId}/edit', array('as' => 'update/type', 'uses' => 'Controllers\Admin\TypeController@getEdit'));
    Route::post('type/{typeId}/edit', 'Controllers\Admin\TypeController@postEdit');
    Route::get('type/{typeId}/delete', array('as' => 'delete/type', 'uses' => 'Controllers\Admin\TypeController@getDelete'));

    // 客户管理
    Route::get('member', array('as' => 'member', 'uses' => 'Controllers\Admin\MemberController@getIndex'));
    Route::get('member/create', array('as' => 'member/add', 'uses' => 'Controllers\Admin\MemberController@getCreate'));
    Route::post('member/create', 'Controllers\Admin\MemberController@postCreate');
    Route::get('member/{memberId}/edit', array('as' => 'update/member', 'uses' => 'Controllers\Admin\MemberController@getEdit'));
    Route::post('member/{operatorId}/edit', 'Controllers\Admin\MemberController@postEdit');
    Route::get('member/{operatorId}/delete', array('as' => 'delete/member', 'uses' => 'Controllers\Admin\MemberController@getDelete'));

    // 用户管理
    Route::get('operator', array('as' => 'operator', 'uses' => 'Controllers\Admin\OperatorController@getIndex'));
    Route::get('operator/create', array('as' => 'operator/add', 'uses' => 'Controllers\Admin\OperatorController@getCreate'));
    Route::post('operator/create', 'Controllers\Admin\OperatorController@postCreate');
    Route::get('operator/{operatorId}/edit', array('as' => 'update/operator', 'uses' => 'Controllers\Admin\OperatorController@getEdit'));
    Route::post('operator/{operatorId}/edit', 'Controllers\Admin\OperatorController@postEdit');
    Route::get('operator/{operatorId}/delete', array('as' => 'delete/operator', 'uses' => 'Controllers\Admin\OperatorController@getDelete'));

    // 客服组
    Route::get('customergroup', array('as' => 'customergroup', 'uses' => 'Controllers\Admin\CustomerGroupController@getIndex'));
    Route::get('customergroup/create', array('as' => 'customergroup/add', 'uses' => 'Controllers\Admin\CustomerGroupController@getCreate'));
    Route::post('customergroup/create', 'Controllers\Admin\CustomerGroupController@postCreate');
    Route::get('customergroup/{operatorId}/edit', array('as' => 'update/customergroup', 'uses' => 'Controllers\Admin\CustomerGroupController@getEdit'));
    Route::post('customergroup/{operatorId}/edit', 'Controllers\Admin\CustomerGroupController@postEdit');
    Route::get('customergroup/{operatorId}/delete', array('as' => 'delete/customergroup', 'uses' => 'Controllers\Admin\CustomerGroupController@getDelete'));
    Route::get('customergroup/{operatorId}/bound', array('as' => 'bound/customergroup', 'uses' => 'Controllers\Admin\CustomerGroupController@getBound'));
    Route::post('customergroup/{operatorId}/bound', 'Controllers\Admin\CustomerGroupController@postBound');

    // 产品管理
    Route::get('product', array('as' => 'product', 'uses' => 'Controllers\Admin\ProductController@getIndex'));
    Route::get('product/create', array('as' => 'product/add', 'uses' => 'Controllers\Admin\ProductController@getCreate'));
    Route::post('product/create', 'Controllers\Admin\ProductController@postCreate');
    Route::get('product/{productId}/edit', array('as' => 'update/product', 'uses' => 'Controllers\Admin\ProductController@getEdit'));
    Route::post('product/{productId}/edit', 'Controllers\Admin\ProductController@postEdit');
    Route::get('product/{productId}/delete', array('as' => 'delete/product', 'uses' => 'Controllers\Admin\ProductController@getDelete'));

});

