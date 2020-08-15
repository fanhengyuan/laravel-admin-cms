<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    // 测试 CURD
    $router->resource('/test', TestController::class);

    // 后台上传图片
    $router->post('/uploader/upload','CkeditorUploadController@uploadImage')->name('uploader.upload');
});
