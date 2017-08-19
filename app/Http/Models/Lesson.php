<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //表配置
    protected $table = 'lesson';    //表名
    protected  $primaryKey = 'lesson_id';  //主键
    protected  $fillabel = ['course_id','lesson_name','cover_img','video_address','lesson_desc','lesson_duration','teacher_ids'];  //允许维护的字段
}
