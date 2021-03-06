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

    // 急诊救护车出诊列表
    $router->resource('/emergency_ambulance_list', EmergencyController::class);

    // 后台上传图片
    $router->post('/uploader/upload','CkeditorUploadController@uploadImage')->name('uploader.upload');

    // 手术列表
    $router->resource('/surgical_patient_list', SurgicalPatientListController::class);
});
