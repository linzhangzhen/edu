<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

//因为当前的模型需要用于校验账号和密码，所以要继承Authenticatable
//这个Authenticatable有去继承Model，因此数据库的元素一个都不少
class Manager extends Authenticatable
{
    //配置
	protected $table = 'manager';
	protected $primaryKey = 'mg_id';
	protected $fillable = ['mg_name','password','role_id','mg_sex','mg_remark'];
	
	//软删除
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	
	/**
	 * 与role一对一关系
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/27  19:10
	 */
	public function role()
	{
		return $this->hasOne('App\Http\Models\Role','role_id','role_id');
	}
}

