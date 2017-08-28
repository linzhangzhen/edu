<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Course;
use App\Http\Models\Livecourse;
use App\Http\Models\Stream;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LivecourseController extends Controller
{
	/**
	 * 列表展示
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/24  9:30
	 */
	public function index(Request $request)
	{
		if($request->isMethod('post')){
			//获得直播课程信息
			$cnt = Livecourse::count();  	//总条数
			
			//A。数据分页
			$offset = $request->input('start');
			$len = $request->input('length');
			
			//B。排序
			$n = $request->input('order.0.column');  //获得排序字段的序号，这个就是视图里td的下标
			$duan = $request->input('columns.'.$n.'.data');  //获得排序的字段
			$xu = $request->input('order.0.dir');  //排序的顺序 asc/desc
			
			//C.模糊检索，（课时名称和课时描述）
			$search = $request->input('search.value');  //获得检索的条件值
			
			
			//数据库查找数据   Collection
			$shuju = Livecourse::offset($offset)
				->limit($len)                 		//查出从0到4的四条数据
				->orderBy($duan,$xu)
				->where('name','like',"%$search%")    //双引号才能解析变量
				->with('stream')			//跟直播流产生关系
				->with('course')			//跟课程产生关系
				->get();   		//数据本身是一个集合，里面每个单元都是一个小的对象
			
			//dd($shuju);
			/*	foreach ($shuju->start_at as $k =>$v){
					$shuju->start[$k] = date('Y-m-d H:i:s',$v);
				}*/
			
			//datatable要求我们给客户端返回的数据为如下格式
			$info = [
				'draw'=>$request->get('draw'),       //客户端传递过来的调用次数标识,直接再传递回去即可
				'recordsTotal'=>$cnt,   		//总数据长度
				'recordsFiltered'=>count($shuju),			//当前数据长度
				'data'=>$shuju,
			];
			return $info;           //返回的数据自动转化为json格式
		}
		return view('admin/livecourse/index');
	}
	
	/**
	 * 添加
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/24  9:56
	 */
	public function tianjia(Request $request)
	{
		
		if($request->isMethod('post')){
			//数据校验
			$rules = [
				'name'=>'required',
				'stream_id'=>'required',
				'start_at'=>'required',
				'end_at'=>'required',
			];
			$notices = [
				'name.required' => '直播课程名必填',
				'stream_id.required' => '直播流必选',
				'start_at.required' => '开始时间必填',
				'end_at.required' => '结束时间必填',
			];
			$form_data = $request->all();
			$validator = Validator::make($form_data,$rules,$notices);
			
			if($validator->passes()){
				//成功
				//把时间格式修改为时间戳
				$start_at = strtotime($form_data['start_at']);
				$end_at = strtotime($form_data['end_at']);
				$form_data['start_at'] = $start_at;
				$form_data['end_at'] = $end_at;
				
				Livecourse::create($form_data);
				
				return ['success'=>true];
			}else{
				//失败
				$errorinfo =  collect($validator->messages())->implode('0',',');
				return ['success'=>false,'errorinfo'=>$errorinfo];
			}
			
		}
		//获得课程信息
		//pluck得到collection集合    toArray变成array数组
		$course = Course::pluck('course_name','course_id')->toArray();  #注意  这里的顺序是值，键  toArray把collection变成array
		//直播流信息
		$stream = Stream::pluck('stream_name','stream_id')->toArray();  #注意  这里的顺序是值，键  toArray把collection变成array
		return view ('admin/livecourse/tianjia',compact('course','stream'));
		
	}
}
