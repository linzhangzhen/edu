<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
	
	/**
	 * 管理员登录系统
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function login(Request $request)
	{
		//用户处于登录状态，如果在此请求该地址，则直接进入系统
		if(Auth::guard('back')->check()){
			return redirect('admin/index/index');
		}
		//当提交方式是post验证账号密码
		if($request->isMethod('post')){
			//校验规则
			$rules = [
				'mg_name' => 'required',
				'password' => 'required',
				'verify_code' => 'required|captcha'
			];
			$notices = [
				'mg_name.required' => '账号必须填写',
				'password.required' => '密码必须填写',
				'verify_code.required'  => '验证码必填',
				'verify_code.captcha'  => '验证码不正确',
			];
			$validator = Validator::make($request->all(),$rules,$notices);
			
			if($validator->passes()){
				//校验成功
				$name_pwd = $request->only('mg_name','password');    #only挑选
				if(Auth::guard('back')->attempt($name_pwd,$request->input('online'))){
					//用户名和密码正确
					//dd(Auth::guard('back')->user());
					return redirect('admin/index/index');
				}else{
					//
					return redirect('admin/manager/login')
						->withErrors(['errorinfo'=>'用户名或密码错误'])
						->withInput();
				}
				
			}else{
				//校验失败,跳转回登录页，同时把错误信息和已经输入的信息回传
				return redirect('admin/manager/login')
					->withErrors($validator)
					->withInput();
			}
			
		}
		return view('admin/manager/login');
	}
	
	/**
	 * 管理员登录退出
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/27  16:06
	 */
	public function logout(Request $request)
	{
		Auth::guard('back')->logout();		#清除session
		return redirect('admin/manager/login');
	}
}
