<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
	 * 学员登录  get/post
     * Create By: linzhangzhen
     * Create Times: 2017/8/29  12:58
     */
	public function login(Request $request)
	{
		if($request->isMethod('post')){
			//用户名密码非空校验
			$rules = [
				'std_name'=>'required',
				'password'=>'required',
			];
			$notices = [
				'std_name.required' => '用户名必填',
				'password.required' => '密码必填',
			];
			$form_data = $request->input();  //收集form表单信息
			$validator = Validator::make($form_data,$rules,$notices);
			
			if($validator->passes()){
				//验证通过 继续校验用户名密码
				$name_pwd = $request->only(['std_name','password']);
				if(Auth::guard('front')->attempt($name_pwd)){
						//帐密正确 跳转到登录后页面
					return redirect('/');
				}else{
					//账号密码错误
					return redirect('home/student/login')
						->withErrors(['errorinfo'=>'账号或密码错误'])
						->withInput();
				}
			}else{
				//验证未通过
				return redirect('home/student/login')
					->withErrors($validator)
					->withInput();
			}
			
		}
		return view('home.student.login');
    }
}
