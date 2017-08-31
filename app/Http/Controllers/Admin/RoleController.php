<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Role;
use App\Http\Models\Permission;

class RoleController extends Controller
{
    /**
	 * 列表展示
     * Create By: linzhangzhen
     * Create Times: 2017/8/28  9:41
     */
	public function index(Request $request)
	{
		if($request->isMethod('post')){
			//获得信息列表
			$cnt = Role::count();
			
			//A.数据分页（显示条数）
			$offset = $request->input('start');
			$len = $request->input('length');
			
			
			//B.排序
			$n = $request->input('order.0.column');  //获得排序字段的序号，这就是视图里td的下标
			$duan = $request->input('columns.'.$n.'.data');  //获得排序的字段
			$xu = $request->input('order.0.dir');  //排序的顺序 asc/desc
			
			//C.模糊检索，
			$search = $request->input('search.value');  //获得检索的条件值
			
			
			//数据库查找数据
			$shuju = Role::offset($offset)
				->limit($len)
				->orderBy($duan,$xu)
				->where('role_name','like',"%$search%")    //双引号才能解析变量
				->get();   		//数据本身是一个集合，里面每个单元都是一个小的stream对象
			
			//datatable要求我们给客户端返回的数据为如下格式
			$info = [
				'draw'=>$request->get('draw'),       //客户端传递过来的调用次数标识,直接再传递回去即可
				'recordsTotal'=>$cnt,   		//总数据长度
				'recordsFiltered'=>count($shuju),			//当前数据长度
				'data'=>$shuju,
			];
			return $info;           //返回的数据自动转化为json格式
		}
		$info = Role::all();		//获得全部的角色信息
		return view('admin.role.index',compact('info'));
    }
    
    /**
	 * 修改 get/post
     * Create By: linzhangzhen
     * Create Times: 2017/8/28  9:51
     */
	public function xiugai(Request $request,Role $role)
	{
		if($request->isMethod('post')){
			//收集信息并存储
			//制作权限ids
			$ps_ids = implode(',',$request->input('quanxian'));		//把收集来的数组转化成用逗号隔开的字符串
			//权限对应的 控制器-操作方法 信息  根据$ps_ids获取
			$ps_ca = Permission::whereIn('ps_id',$request->input('quanxian'))
				->select(\DB::raw("concat(ps_c,'-',ps_a) as ca"))
				->whereIn('ps_level',['1','2'])
				->pluck('ca');
			//whereIn(id,数组) 拼装sql语句限制id(in)在某个范围内，第二个参数是数组
			//concat()是把指定的字段做连接查询获取
			//\DB:raw(原生表达式)是要执行原生表达式
			//pluck()是把查询出来的唯一jie字段的信息变为数组的格式
			//toArray() 可以把集合变为Array数组格式

			
			//把$ps_ca的数据提取出来并转化成逗号连接的字符串
			$ps_ca = implode(',',$ps_ca->toArray());
			
			//把数据进行维护
			$rst = $role->update([
				'ps_ids'=> $ps_ids,
				'ps_ca' => $ps_ca
			]);
			
			return json_encode(['success'=>true]);
		}
		//把给角色分配的1、2、3级权限都显示出来
		$permission_A = Permission::where('ps_level','0')->get();
		$permission_B = Permission::where('ps_level','1')->get();
		$permission_C = Permission::where('ps_level','2')->get();
		return view('admin.role.xiugai',compact('role','permission_A','permission_B','permission_C'));
    }
}
