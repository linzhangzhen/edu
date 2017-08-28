<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stream extends Model
{
    //配置
	protected $table = 'stream';
	protected $primaryKey = 'stream_id';
	protected $fillable = ['stream_name'];
	
	//软删除
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
