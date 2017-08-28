<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Stream;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StreamController extends Controller
{
	/**
	 * 直播流列表
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/23  21:44
	 */
	public function index(Request $request)
	{
		if($request->isMethod('post')){
			//获得直播流信息列表
			$cnt = Stream::count();
			
			//A.数据分页（显示条数）
			$offset = $request->input('start');
			$len = $request->input('length');
			
			
			//B.排序
			$n = $request->input('order.0.column');  //获得排序字段的序号，这就是视图里td的下标
			$duan = $request->input('columns.'.$n.'.data');  //获得排序的字段
			$xu = $request->input('order.0.dir');  //排序的顺序 asc/desc
			
			//C.模糊检索，（直播流名称和直播名字）
			$search = $request->input('search.value');  //获得检索的条件值
			
			
			//数据库查找数据
			$shuju = Stream::offset($offset)
				->limit($len)
				->orderBy($duan,$xu)
				->where('stream_name','like',"%$search%")    //双引号才能解析变量
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
		//获得直播流信息
		return  view('admin/stream/index');
	}
	
	/**
	 * 添加直播流
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/24  8:45
	 */
	public function tianjia(Request $request)
	{
		if($request->isMethod('post')){
			//制作校验
			$rules = [
				'stream_name'=>'required|unique:stream,stream_name'
			];
			$notices = [
				'stream_name.required'=>'直播流名字必填',
				'stream_name.unique'=>'直播流名字已经存在'
			];
			$shuju = $request->all();
			$validator = Validator::make($shuju,$rules,$notices);
			
			if($validator ->passes()){
				//成功
				//通过curl把直播流添加到七牛云
				
				
				Stream::create($request->all());
				return ['success'=>true];   //为什么不是json呢？ 我复制模板的时候忘了引入jquer啦
				//echo json_encode(['success'=>true]);
			}else{
				//失败
				//制作错误信息
				$errorinfo = collect($validator->messages())->implode('0','，');    //制作校验错误信息  implode 以xx分割字符串
				return ['success'=>false,'errorinfo'=>$errorinfo];
			}
		}
		return view('admin/stream/tianjia');
		
	}
}
