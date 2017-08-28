<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Livecourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
	/**
	 * 直播
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/24  17:20
	 */
	public function course()
	{
		$data = Livecourse::get();
		return view('home.person.course',compact('data'));
	}
}
