<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
			$n = $request->input('order.0.column');  //获得排序字段的序号		1
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
				->get();   		//数据本身是一个集合，里面每个单元都是一个小的lesson对象
			
            //datatable要求我们给客户端返回的数据为如下格式
            $info = [
              'draw'=>$request->get('draw'),       //客户端传递过来的调用次数标识,直接再传递回去即可
                'recordsTotal'=>$cnt,
                'recordsFiltered'=>$cnt,
                'data'=>$shuju,
            ];
            return $info;           //返回的数据自动转化为json格式
        }
        //显示课时列表模板效果
        return view('admin/lesson/index');
    }
	
    
}
