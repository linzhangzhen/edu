<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
	 * 视频附加上传
     * Create By: linzhangzhen
     * Create Times: 2017/8/20  14:25
     */
	public function up_video(Request $request)
	{
		$file = $request->file('Filedata');
		
		if($file->isValid()){
			//附件上传 		$file->store(附件存储的二级目录，磁盘驱动)
			//  	实际物理地址/storage/app/public/video/文件名
			//   $rst = video/文件名
			$rst =  $file->store('video','public');
			//echo    "/storage/".$rst  /storage/video/文件名
			echo json_encode(['success'=>true,'filename'=>'/storage/'.$rst]);
		}else{
			echo json_encode(['success'=>false]);
		}
		//如果没有这个，debug的信息也一并当成json返回了
		exit;
	}
	
	/**
	 * 图片附件上传--封面图
	 * Create By: linzhangzhen
	 * Create Times: 2017/8/20  15:43
	 */
	public function up_pic(Request $request)
	{
		$file = $request->file('Filedata');
		
	if($file->isValid()){
		//附件上传   public在config/filesystems.php 里 可以找到其配置 disks=>public=> 。。。
		//如果不设public会走默认的local 那样文件地址会跑到 storage/app/下 无法通过软连接link到/public去
		$rst = $file->store('lesson','public');
		
		echo json_encode(['success'=>true,'filename'=>'/storage/'.$rst]);
	}else{
		echo json_encode(['success'=>false]);
	}
	exit;
	}
}
