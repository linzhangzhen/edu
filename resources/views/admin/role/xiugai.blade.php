<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link rel="Bookmark" href="/favicon.ico" >
	<link rel="Shortcut Icon" href="/favicon.ico" />
	<!--[if lt IE 9]>
	<script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
	<script type="text/javascript" src="/admin/lib/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui./admin/css/H-ui./admin.css" />
	<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui./admin/skin/default/skin.css" id="skin" />
	<link rel="stylesheet" type="text/css" href="/admin/static/h-ui./admin/css/style.css" />
	<!--[if IE 6]>
	<script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
	<script>DD_belatedPNG.fix('*');</script>
	<![endif]-->
	<!--/meta 作为公共模版分离出去-->

	<title>新建网站角色 - 管理员管理 - H-ui./admin v3.1</title>
	<meta name="keywords" content="H-ui./admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
	<meta name="description" content="H-ui./admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-role-add">
		{{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->role_name}}" placeholder="" id="roleName" name="{{$role->role_id}}">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网站角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<?php
				//把该角色拥有的权限转化成array 方便下面用in_array来判断
				$ps_ids_arr = explode(',',$role->ps_ids);
				?>
				@foreach($permission_A as $v)
					<hr>
					<dl class="permission-list">
						<dt>
							<label>
								<input type="checkbox" value="{{$v->ps_id}}" name="quanxian[]" id="user-Character-1"
									   @if(in_array($v->ps_id,$ps_ids_arr))
									   checked="checked"
										@endif
								>
								{{$v->ps_name}}</label>
						</dt>
						<dd>
							@foreach($permission_B as $vv)
								@if($vv->ps_pid == $v->ps_id)
									<dl class="cl permission-list2">
										<dt>
											<label class="">
												<input type="checkbox" value="{{$vv->ps_id}}" name="quanxian[]" id="user-Character-1-0"
													   @if(in_array($vv->ps_id,$ps_ids_arr))
													   checked="checked"
														@endif
												>
												{{$vv->ps_name}}</label>
											<br>
										</dt>
										<dd>
											@foreach($permission_C as $vvv)
												@if($vvv->ps_pid == $vv->ps_id)
													<label class="">
														<input type="checkbox" value="{{$v->ps_id}}" name="quanxian[]" id="user-Character-1-0-0"
															   @if(in_array($vvv->ps_id,$ps_ids_arr))
															   checked="checked"
																@endif
														>
														{{$vvv->ps_name}}</label>
												@endif
											@endforeach
										</dd>
									</dl>
								@endif
							@endforeach
						</dd>
					</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button type="submit" class="btn btn-success radius" id="/admin-role-save" name="/admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui./admin/js/H-ui./admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">

    //给form表单设置submit提交事件
    $('#form-role-add').submit(function(evt){
        evt.preventDefault();  //阻止浏览器form本身的提交

        //判断至少要有一个复选框被选中
        if($(':checkbox:checked').length<1){
            layer.alert('请至少分配一个权限',{icon:5});
            return false;
        }

        //收集form表单信息
        var shuju =$(this).serialize();			//将表单信息收集并转化为序列化后的字符串

        //通过ajax提交给服务器
        $.ajax({
            url:"{{url('admin/role/xiugai',['role'=>$role->role_id])}}",
            data:shuju,
            dataType:'json',
            type:'post',
            success:function(msg){
                if(msg.success === true){
                    //成功
                    layer.alert('角色权限修改成功！')
                    parent.window.location.href=parent.window.location.href;		//更新父页面
                    layer_close();
                }else{
                    //失败
                    layer.alert('角色权限修改失败！')
                }
            }
        })
    });


    $(function(){
        $(".permission-list dt input:checkbox").click(function(){
            $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
        });
        $(".permission-list2 dd input:checkbox").click(function(){
            var l =$(this).parent().parent().find("input:checked").length;
            var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
            if($(this).prop("checked")){
                $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
            }
            else{
                if(l==0){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                }
                if(l2==0){
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                }
            }
        });

        $("#form-/admin-role-add").validate({
            rules:{
                roleName:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit();
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>