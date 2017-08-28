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

//前台个人中心 -- 课程列表展示，购买的，直播的
Route::get('home/person/course','Home\PersonController@course');


/**************以下是后台业务*****************/

//后台首页面
Route::get('admin/index/index','Admin\IndexController@index');

//后台首页右侧iform欢迎页
Route::get('admin/index/welcome','Admin\IndexController@welcome');

//后台课时管理 --列表
Route::match(['get','post'],'admin/lesson/index','Admin\LessonController@index');

//后台课时管理--添加
Route::match(['get','post'],'admin/lesson/tianjia','Admin\LessonController@tianjia');

//后台课时管理 -- 修改
Route::match(['get','post'],'admin/lesson/xiugai/{lesson}','Admin\LessonController@xiugai');

//后台课时管理 -- 删除
Route::post('admin/lesson/del/{lesson}','Admin\LessonController@del');

//后台上传附件--视频
Route::post('admin/upload/up_video','Admin\UploadController@up_video');

//后台 --视频播放
Route::get('admin/lesson/video_play/{lesson}','Admin\LessonController@video_play');

//后台上传附件--图片
Route::post('admin/upload/up_pic','Admin\UploadController@up_pic');

//后台直播流管理 -- 列表
Route::match(['get','post'],'admin/stream/index','Admin\StreamController@index');

//后台直播流管理 -- 添加
Route::match(['get','post'],'admin/stream/tianjia','Admin\StreamController@tianjia');

//后台直播课程管理 -- 列表显示
Route::match(['get','post'],'admin/livecourse/index','Admin\LivecourseController@index');

//后台直播课程管理 -- 添加
Route::match(['get','post'],'admin/livecourse/tianjia','Admin\LivecourseController@tianjia');

//后台管理员系统  --  登录
Route::match(['get','post'],'admin/manager/login','Admin\ManagerController@login');

//后台管理员系统  --  退出登录
Route::match(['get','post'],'admin/manager/logout','Admin\ManagerController@logout');

/*************RBAC***************/
//后台角色维护  --  角色列表展示
Route::match(['get','post'],'admin/role/index','Admin\RoleController@index');

//后台角色维护  --  角色权限修改
Route::match(['get','post'],'admin/role/xiugai/{role}','Admin\RoleController@xiugai');
