<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Course;
use App\Http\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class LessonController extends Controller
{
    /**
     * 列表显示，显示课时列表（get）,获得课时列表信息（post）
	 * @param ajax
	 * @return json
     */
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            //获得课时列表信息
            $cnt = Lesson::count();		//记录总条数
			
			//$request->input    相当于TP里的I()，能获取到提交上来的数据
			
			//A.数据分页（显示条数）
			$offset = $request->input('start');		//0
			$len = $request->input('length');		//4
			
			
			//B.排序
			$n = $request->input('order.0.column');  //获得排序字段的序号，这个就是视图里td的下标		1
			$duan = $request->input('columns.'.$n.'.data');  //获得排序的字段		lesson_id
			$xu = $request->input('order.0.dir');  //排序的顺序 asc/desc			asc
			
			//C.模糊检索，（课时名称和课时描述）
			$search = $request->input('search.value');  //获得检索的条件值
			//dd($search);
	
			//数据库查找数据
			$shuju = Lesson::offset($offset)
				->limit($len)                 		//查出从0到4的四条数据
				->orderBy($duan,$xu)
				->where('lesson_name','like',"%$search%")    //双引号才能解析变量
				->orWhere('lesson_desc','like',"%$search%")
				->with(['course'=>function($c){			//不仅跟课程表产生关系
					$c->with('profession');		//跟专业表再次产生关系   同时与两个表都有关系
				}])
				->get();   		//数据本身是一个集合，里面每个单元都是一个小的lesson对象
			
            //datatable要求我们给客户端返回的数据为如下格式
            $info = [
              'draw'=>$request->get('draw'),       //客户端传递过来的调用次数标识,直接再传递回去即可
                'recordsTotal'=>$cnt,   		//总数据长度
                'recordsFiltered'=>count($shuju),			//当前数据长度
                'data'=>$shuju,
            ];
            return $info;           //返回的数据自动转化为json格式
        }
        //显示课时列表模板效果
        return view('admin/lesson/index');
    }
    
    /**
	 * 课时添加
	 * get 展示添加form表单
	 * post 处理数据并维护
     * Create By: linzhangzhen
     * Create Times: 2017/8/19  20:07
     */
	public function tianjia(Request $request)
	{
		if($request->isMethod('post')){
			
			//收集数据存储入库
			$form_data = $request->all();
			//A.数据校验
			$rules = [
				'lesson_name'=>'required',
				//时长，通过正则校验，要求是个位或者十位数字
				'lesson_duration'=>['required','regex:/^[1-9]|[1-9]\d$/']
			];
			$notices = [
				'lesson_name.required'=>'课时名称必须设置',
				'lesson_duration.required'=>'课时时长必须设置',
				'lesson_duration.regex'=>'课时时长是一个个位或者十位数字',
			];
			//制作校验
			 $validator = Validator::make($form_data,$rules,$notices);
			 
			 if($validator->passes()){
			 	//校验通过,维护数据
				 //模拟没有维护好的数据,避免数据库找麻烦
				 $form_data['teacher_ids'] = 10;
				 
				 Lesson::create($form_data);
				 
				 return ['success'=>true];
				 
			 }else{
			 	//校验不通过
				 //制作校验的错误信息
				 $errorinfo = collect($validator->messages())->implode('0','，');    //制作校验错误信息
				 return ['success'=>false,'errorinfo'=>$errorinfo];
			 }
			 
		}
		//展示添加课时form表单
		//获得被选区的课程信息
		$course = Course::pluck('course_name','course_id')->toArray();  #注意  这里的顺序是值，键  toArray把collection变成array
		
		return view('admin/lesson/tianjia',compact('course'));
    }
	
    
}
