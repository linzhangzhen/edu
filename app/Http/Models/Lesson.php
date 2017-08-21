<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //表配置
    protected $table = 'lesson';    //表名
    protected  $primaryKey = 'lesson_id';  //主键
	//fillable 写错导致后面出了一个大BUG，存入数据的同时把_token字段往数据库里放，肯定报错啊
    protected  $fillable = ['course_id','lesson_name','cover_img','video_address','lesson_desc','lesson_duration','teacher_ids'];  //允许维护的字段
	
	/**
	 * 与course的对应关系
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/19/19:26
	 */
	public function course()
	{
		return $this->hasOne('App\Http\Models\Course','course_id','course_id');
	}
	
	
}
