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

    <title>添加课时 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<div id="play_shipin"></div>
<script type="text/javascript" src="/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript">
    var flashvars={
        f:'http://web.edu.com{{$lesson->video_address}}',
        c:0,
        b:1,
        i:'http://web.edu.com{{$lesson->cover_img}}',
        d:'/storage/lesson/6BZLQh7EuMjRWZpuBgbTFk0Xc1z2rldoOPZ3RqoO.png|/storage/lesson/LUh96vk3DxGf4byLGl9jQ1Jqf7ghpxC7pXctOF2Z.png|/storage/lesson/V3qcexkGWxpDB5z7pDUgno141RCHEfWEuX2dgNVa.png',//暂停时播放的广告
        u:'http://www.baidu.com|http://www.163.com|http://www.itcast.cn',//暂停时如果是图片的话，加个链接地址
        e:'1',//视频结束后的动作，0是调用js函数，1是循环播放，
        v:'10',//默认音量，0-100之间
        p:'1',//视频默认0是暂停，1是播放，2是不加载视频
        g:'30',//视频从开始跳过30秒后开始播放
        k:'32|63',//提示点时间，如 30|60鼠标经过进度栏30秒，60秒会提示n指定的相应的文字
        n:'很好|很强大',//提示点文字，跟k配合使用，如 提示点1|提示点2
    };
    var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always',wmode:'transparent'};
    CKobject.embedSWF('/ckplayer/ckplayer.swf','play_shipin','ckplayer_a1','600','400',flashvars,params);
    function closelights(){//关灯
        alert(' 本演示不支持开关灯');
    }
    function openlights(){//开灯
        alert(' 本演示不支持开关灯');
    }
</script>


</body>
</html>