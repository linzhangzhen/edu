
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>角色管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 角色中心 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜角色</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加角色','{{url('admin/stream/tianjia')}}','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a></span> <span class="r">共有数据：<strong>88</strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="2%"><input type="checkbox" name="" value=""></th>
                <th width="6%">ID</th>
                <th width="15%">角色名称</th>
                <th width="15%">权限ids</th>
                <th width="20%">权限ca</th>
                <th width="10%">创建时间</th>
                <th width="*">操作</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(function(){
        //mydatatable变量把dataTable接收起来，使得子页面可以获取并做操作
        //mydatatable前面没有val 说明其是全局变量，我们也要求为全局的
        mydatatable =  $('.table-sort').dataTable({
            "lengthMenu": [ 2, 4, 8, 16 ],    //代表你可以把表格设置为每页 2/4/8/16 条数据显示
            "paging": true,   //数据做分页显示设置，默认为true
            "info":     true,   //分页辅助信息，第几条到第几条，默认为true
            "searching": true,      //此选项用来开启、关闭Datatables的搜索功能
            "ordering": true,       //允许或禁止对各个数据列使用排序，如果开启此选项，那么数据库操作的时候就不能使用order by 条件了
            "order": [[ 1, "asc" ]],        //设置默认第2列正排序
            "stateSave": true,      //开启或者禁用状态储存
            "columnDefs": [{
                "targets": [0,2,3,4],
                "orderable": false
            }],             //指定列  不参与order排序
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{url('admin/role/index')}}",
                "type": "POST",
                'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            },              //ajax使用
            "columns": [
                {"defaultContent":"<input type='checkbox'>"},
                {'data':"role_id"},
                {'data':'role_name'},
                {'data':'ps_ids'},
                {'data':'ps_ca'},
                {'data':'created_at'},
                {"defaultContent":"","className":"td-manager"}
            ],          //对【td】的信息填充
            "createdRow":function(row,data,dataIndex){
                //创建tr/td时的回调函数，可以继续修改、优化tr/td的显示，里边有遍历效果，每个tr被绘制（创建）的时候会调用该函数
                // row:tr的dom对象
                //data:该tr对应的数据记录
                //dataIndex:该tr的下标索引号码
                //var anniu = '<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',\'4\',\'\',\'510\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="change_password(\'修改密码\',\'change-password.html\',\'10001\',\'600\',\'270\')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,\'1\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                var anniu = '\
				<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'/admin/role/xiugai/'+data.role_id+'\',4,\'\',510)" class="ml-5" style="text-decoration:none">\
					<i class="Hui-iconfont">&#xe6df;</i>\
				</a>\
				<a title="删除" href="javascript:;" onclick="member_del(this,'+data.role_id+')" class="ml-5" style="text-decoration:none">\
					<i class="Hui-iconfont">&#xe6e2;</i>\
				</a>';
                //把anniu填充给最后一个td
                $(row).find('td:eq(6)').html(anniu);

                //给每个tr一个text-c
                $(row).addClass('text-c');
            }


        });

    });
    /*角色-播放视频*/
    function show_video(stream_id){
        layer_show('播放视频','/admin/stream/video_play/'+stream_id,800,500);
    }

    /*角色-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*角色-查看*/
    function member_show(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*角色-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
                    $(obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*角色-启用*/
    function member_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!',{icon: 6,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
    /*角色-编辑*/
    function member_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*密码-修改*/
    function change_password(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*角色-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/admin/stream/del/'+id,		//地址把id带上
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'		//需要有个token验证码
                },
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }
</script>
</body>
</html>
