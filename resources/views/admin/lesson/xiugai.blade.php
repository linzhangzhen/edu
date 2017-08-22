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
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--/meta 作为公共模版分离出去-->

    <title>修改课时 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-member-add">
        {{csrf_field()}}
        {{--课程名 下拉框--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课程：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="course_id" id="">
                    <option value="0">-请选择-</option>
                    {{--选中的课程设置勾选--}}
                    @foreach($course as $k=>$v)
                        @if($lesson->course_id == $k)
                            <option selected="selected" value="{{$k}}">{{$v}}</option>
                        @else
                            <option value="{{$k}}">{{$v}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        {{--课时名  文字框--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课时名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$lesson->lesson_name}}" placeholder="" id="lesson_name" name="lesson_name">
            </div>
        </div>
        {{--视频  附件上传--}}
        <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
        <script src="/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/uploadify/uploadify.css">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>视频：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="" id="video">
            </div>
            {{--设置一个只读的文字域，用于接收服务器返回的文件地址--}}
            <label class="form-label col-xs-4 col-sm-3"></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text"   name="video_address" readonly="readonly" value="{{$lesson->video_address}}">
            </div>
        </div>
        <script type="text/javascript">
			<?php $timestamp = time();?>
            $(function() {
                $('#video').uploadify({
                    'formData'     : {
                        'timestamp' : '<?php echo $timestamp;?>',
                        //注意laravel的_token前面的带下划线的
                        '_token'     : '{{ csrf_token() }}'
                    },
                    'swf'      : '/uploadify/uploadify.swf',
                    //这里又把地址写错了，调试了很久才发现
                    'uploader' : '{{url('admin/upload/up_video')}}',
                    //上传附件后uploadify本身可以调用回调函数感知状态信息
                    'onUploadSuccess' : function(file, data, response) {
                        //file 被上传附件在客户端的名字
                        //data  服务器返回的信息,是一个json的string字符串
                        //response true/false  上传是否成功
                        // alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
                        //接收服务器端返回的数据并转化为对象格式
                        var obj = JSON.parse(data);
                        //把返回的附件路径名赋予给form表单域
                        $('[name=video_address]').val(obj.filename);
                    }
                });
            });
        </script>
        {{--封面图  文件上传--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>封面图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                {{--上传按钮--}}
                <input type="file" name="pic" id="pic">
            </div>
            {{--img标签，显示上传的图片效果--}}
            <label class="form-label col-xs-4 col-sm-3"></label>
            <div class="formControls col-xs-8 col-sm-9">
                <img id="show_pic"  src="{{$lesson->cover_img}}" width="220" height="110" alt="没有封面图">
            </div>
            {{--用于接收上传图片的路径名--}}
            <label class="form-label col-xs-4 col-sm-3"></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="cover_img" id="cover_img" class="input-text" value="{{$lesson->cover_img}}">
            </div>
        </div>
        <script type="text/javascript">
			<?php $timestamp = time();?>
            $(function() {
                $('#pic').uploadify({
                    'formData'     : {
                        'timestamp' : '<?php echo $timestamp;?>',
                        '_token'     : '{{ csrf_token() }}'
                    },
                    'swf'      : '/uploadify/uploadify.swf',
                    'uploader' : '{{url('admin/upload/up_pic')}}',
                    'onUploadSuccess' : function(file, data, response) {
                        //接收服务器端返回的数据并转化为对象格式
                        var obj = JSON.parse(data);
                        //把返回的附件路径名赋予给form表单域
                        //obj.filename =  /storage/lesson/xxxxxx.jpg
                        $('[name=cover_img]').val(obj.filename);
                        //把上传好的图片显示到当前页面中
                        $('#show_pic').attr('src',obj.filename);
                    }
                });
            });
        </script>

        {{--课时时长  number框--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课时时长：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="{{$lesson->lesson_duration}}" placeholder="" id="lesson_duration" name="lesson_duration">分钟
            </div>
        </div>

        {{--授课老师  复选框--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>授课老师：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <?php $teacher_arr = explode(',',$lesson->teacher_ids) ?>
                <select name="laoshi[]"  multiple="multiple" style="width: 130px;height: 190px">
                    <option value="0">-请选择-</option>
                    @foreach($teacher as $k => $v)
                        {{--勾选选择的老师--}}
                        @if(in_array($k,$teacher_arr))
                            <option selected="selected" value="{{$k}}">{{$v}}</option>
                        @else
                            <option value="{{$k}}">{{$v}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        {{--课时描述  文字域--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">课时描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="lesson_desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)">{{$lesson->lesson_desc}}</textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        //设置Ajax 提交form表单提交给服务器存储
        $('#form-member-add').submit(function(evt){

            //form表单设置submit提交事件
            evt.preventDefault();   	//阻止浏览器默认的submit提交事件
            //收集form表单信息为name=val&name=val&name=val
            //this: 代表form表单的dom对象
            // $(this)  dom对象变成jquery对象了
            var shuju = $(this).serialize();

            //设置ajax
            $.ajax({
                url:'{{url('admin/lesson/xiugai',['lesson'=>$lesson->lesson_id])}}',
                data:shuju,
                dataType:'json',
                type:'post',
                success:function(msg){
                    //要求服务器端返回一个success成员代表请求是否成功
                    if(msg.success === true){
                        //alert('数据修改成功');
                        //做提示，关闭当前层，课时列表刷新，显示新修改的课时
                        layer.alert('修改数据成功',function(){
                            //课时列表刷新，显示新修改的课时，
                            // 通过mydatatable全局变量接受了父级页面的dataTable内容
                            parent.mydatatable.api().ajax.reload();
                            //关闭当前层（先刷新课时列表,是为了防止弹回去那边还没刷新的尴尬）
                            layer_close();
                        });
                    }else{
                        layer.alert('数据修改失败【'+msg.errorinfo+'】',{icon:5});
                    }
                }

            })
        })


    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>