<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	//配置
	protected $table = "role";
	protected $primaryKey = "role_id";
	protected $fillable = ['role_name','ps_ids','ps_ca'];
	
	//软删除
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
