<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livecourse extends Model
{
	//数据库配置
	protected  $table = 'live_course';		//表名
	protected $primarykey = 'id';		//主键
	protected $fillable = ['name','stream_id','start_at','end_at','cover_img','desc','course_id'];		//允许维护的字段
	
	//软删除
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	
	/**
	 * 建立与直播流的一对一关系
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/24  9:18
	 */
	public function stream()
	{
		return $this->hasOne('App\Http\Models\Stream','stream_id','stream_id');
	}
	
	/**建立与课程多对一的关系
	 * 我多它一
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/24  10:28
	 */
	public function course()
	{
		return $this->belongsTo('App\Http\Models\Course','course_id','course_id');
	}
}
