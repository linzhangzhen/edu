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

Route::get('/', function () {
    return view('welcome');
});

//后台首页面
Route::get('admin/index/index','Admin\IndexController@index');

//后台首页右侧iform欢迎页
Route::get('admin/index/welcome','Admin\IndexController@welcome');

//后台课时管理 --列表
Route::match(['get','post'],'admin/lesson/index','Admin\LessonController@index');

//后台课时管理--添加
Route::match(['get','post'],'admin/lesson/tianjia','Admin\LessonController@tianjia');

//后台上传附件--视频
Route::post('admin/upload/up_video','Admin\UploadController@up_video');

//后台上传附件--图片
Route::post('admin/upload/up_pic','Admin\UploadController@up_pic');

//管理员登录系统
Route::get('admin/manager/login','Admin\ManagerController@login');

