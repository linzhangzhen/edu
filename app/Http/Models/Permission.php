<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
	//配置
	protected $table = 'permission';			#表名
	protected $primaryKey = 'ps_id';		#主键id
	protected $fillable = ['ps_name','ps_pid','ps_c','ps_a','ps_route','ps_level'];		#允许维护的字段
	
	//软删除
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
