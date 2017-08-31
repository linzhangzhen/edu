<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    //配置
	protected $table = 'student';
	protected  $primaryKey = 'std_id';
	protected  $fillable = ['std_name','password','std_email','std_birthday','std_phone','std_sex','std_pic','std_desc'];
	
	//软删除
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
