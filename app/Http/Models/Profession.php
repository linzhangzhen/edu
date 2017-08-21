<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //配置
	protected $table = "profession";  //表名
	protected  $primaryKey = "pro_id";  //主键名字
	protected  $fillable =  ['pro_name','teacher_ids','pro_desc','cover_img','carousel_image'];   //允许维护的字段
	
	/**
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/19  19:49
	 */
	
}
