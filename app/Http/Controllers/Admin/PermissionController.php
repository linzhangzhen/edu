<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
	/**
	 * 列表展示
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/28  13:59
	 */
	public function index(Request $request)
	{
		$shuju = Permission::all();		//获得权限列表信息
		$shuju = $shuju->toArray();
		$info = generateTree($shuju);
		//dd($info);
		return view('admin.permission.index',compact('info'));
	}
	
	/**
	 * 添加 get/post
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/28  15:45
	 */
	public function tianjia(Request $request)
	{
		if($request->isMethod('post')){
			//表单验证
			$rules = ['ps_name'=>'required'];
			$notices = ['ps_name.required'=>'权限名称必须设置'];
			$form_data = $request->all();
			$validator = Validator::make($form_data,$rules,$notices);
			
			if($validator->passes()){
				//通过验证
				//存储权限入库(名称，上级，控制器，方法，路由，等级)
				
				//制作权限的等级
				if($form_data['ps_pid']!=0){			//如果不是顶级权限
					$pinfo = Permission::find($form_data['ps_pid']);   //就去获取它的上级权限
					$form_data['ps_level'] = (string)($pinfo['ps_level']+1);
				}else{
					$form_data['ps_level'] = '0';
				}
				$newobj = Permission::create($form_data);		//会返回新记录的model模型对象
				if($newobj){
					return ['success'=>true];
				}
			}else{
				//未通过验证
				$errorinfo = collect($validator->messages())->implode('0',',');
				return ['success'=>false,'errorinfo'=>$errorinfo];
			}
		}
		//获得可供选取的一二级权限给模板使用
		$permission = generateTree(Permission::whereIn('ps_level',['0','1'])->get()->toArray());
		return view('admin.permission.tianjia',compact('permission'));
	}
}
