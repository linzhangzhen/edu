<?php

namespace App\Http\Middleware;

use App\Http\Models\Manager;
use Closure;

class Fanqiang
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//获得用户的会话id
		$mg_id = \Auth::guard('back')->user()->mg_id;
		
		//如果id = 1就是超级管理员 无需翻墙访问限制
		if($mg_id != 1){
			//翻墙访问限制
			//获取用户的角色，根据角色获取其拥有的权限
			$ps_ca = Manager::find($mg_id)->role->ps_ca;
			//获取当前的控制器和方法
			$nowCA = getCurrentControllerName()."-".getCurrentMethodName();
			//判断当前的控制器和方法是否在角色的权限列表里出现过
			//出现即是合法 米有就是非法访问
			
			if(strpos($ps_ca,$nowCA) === false){
				exit('没有权限访问！');
			}
		}
		return $next($request);
		
	}
}
