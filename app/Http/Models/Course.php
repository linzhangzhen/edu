<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //配置
	protected $table = "course";  //表名
	protected  $primaryKey = "course_id";  //主键名字
	protected  $fillable = ['pro_id','course_name','course_price','course_desc','cover_img'];   //允许维护的字段
	
	/**
	 * 与专业表的关系
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/19  19:49
	 */
	public function profession()
	{
		return $this->hasOne('App\Http\Models\Profession','pro_id','pro_id');
	}
}
