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

/**********前台业务***********/

//群组  前台
Route::group(['prefix'=>'home','namespace'=>'Home'],function(){

//前台个人中心 -- 课程列表展示，购买的，直播的
Route::get('person/course','PersonController@course');

//前台学员登录
Route::match(['get','post'],'student/login','StudentController@login');
});


/**************以下是后台业务*****************/
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
	//后台管理员系统  --  登录
	//通过name方法给路由设置名称
	Route::match(['get','post'],'manager/login','ManagerController@login');
	
	//后台管理员系统  --  退出登录
	Route::match(['get','post'],'manager/logout','ManagerController@logout');
	
	/*******用户需要登录才可以继续操作************/
	Route::group(['middleware'=>'auth:back'],function (){
		//后台首页面
		Route::get('index/index','IndexController@index');
		
		//后台首页右侧iform欢迎页
		Route::get('index/welcome','IndexController@welcome');
		
		/*********与业务有关的需要有翻墙限制********/
		Route::group(['middleware'=>'fanqiang'],function (){
			
			//后台课时管理 --列表
			Route::match(['get','post'],'lesson/index','LessonController@index');
			
			//后台课时管理--添加
			Route::match(['get','post'],'lesson/tianjia','LessonController@tianjia');
			
			//后台课时管理 -- 修改
			Route::match(['get','post'],'lesson/xiugai/{lesson}','LessonController@xiugai');
			
			//后台课时管理 -- 删除
			Route::post('lesson/del/{lesson}','LessonController@del');
			
			//后台上传附件--视频
			Route::post('upload/up_video','UploadController@up_video');
			
			//后台 --视频播放
			Route::get('lesson/video_play/{lesson}','LessonController@video_play');
			
			//后台上传附件--图片
			Route::post('upload/up_pic','UploadController@up_pic');
			
			//后台直播流管理 -- 列表
			Route::match(['get','post'],'stream/index','StreamController@index');
			
			//后台直播流管理 -- 添加
			Route::match(['get','post'],'stream/tianjia','StreamController@tianjia')->middleware('fanqiang');
			
			//后台直播课程管理 -- 列表显示
			Route::match(['get','post'],'livecourse/index','LivecourseController@index');
			
			//后台直播课程管理 -- 添加
			Route::match(['get','post'],'livecourse/tianjia','LivecourseController@tianjia');
			
			/*************RBAC***************/
			//后台角色维护  --  角色列表展示
			Route::match(['get','post'],'role/index','RoleController@index');
			
			//后台角色维护  --  角色权限修改
			Route::match(['get','post'],'role/xiugai/{role}','RoleController@xiugai');
			
			//后台权限维护 -- 权限列表
			Route::match(['get','post'],'permission/index','PermissionController@index');
			
			//后台权限维护 -- 权限添加
			Route::match(['get','post'],'permission/tianjia','PermissionController@tianjia');
		});
	});
});



