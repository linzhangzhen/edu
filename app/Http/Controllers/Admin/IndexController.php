<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Manager;
use App\Http\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
	/**
	 * 后台首页面
	 * update:2017年8月18日 20:02:21
	 */
	public function index()
	{
		//根据管理员角色获取对应的操作权限
		$mg_id = Auth::guard('back')->user()->mg_id;		#管理员登录会话的存在session的id信息
		
		try{
			//有正常分配角色的普通管理员(根据角色分配权限)
			
			//通过manager与role的关系获得role表的ps_ids
			$ps_ids = Manager::find($mg_id)->role->ps_ids;
			$ps_ids = explode(',',$ps_ids);
			//根据ps_ids获取权限信息  一二级权限分别获取
			$permission_A = Permission::where('ps_level','0')
				->whereIn('ps_id',$ps_ids)
				->get();
			$permission_B = Permission::where('ps_level','1')
				->whereIn('ps_id',$ps_ids)
				->get();
			//dd($permission_A);
		}catch(\Exception $e){
			//异常报错
			if($mg_id == 1){
				//超级管理员root  获得所有权限
				$permission_A = Permission::where('ps_level','0')->get();
				$permission_B = Permission::where('ps_level','1')->get();
			}else{
				//一个权限也没有的
				$permission_A = [];
				$permission_B = [];
			}
			
		}
		
		return view('admin/index/index',compact('permission_A','permission_B'));
	}
	
	/**
	 * 首页右侧欢迎页
	 * ifrom需要单独的路由
	 */
	public function welcome()
	{
		return view('admin/index/welcome');
	}
}
