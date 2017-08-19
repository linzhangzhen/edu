<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 后台首页面
     * update:2017年8月18日 20:02:21
     */
    public function index()
    {
        return view('admin/index/index');
    }


    /**
     * 首页右侧欢迎页
     * ifrom需要单独的路由
     */
    public function welcome()
    {
        return view('admin/index/welcome');
    }
}
