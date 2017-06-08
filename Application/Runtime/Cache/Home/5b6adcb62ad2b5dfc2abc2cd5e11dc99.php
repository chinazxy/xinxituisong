<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>后台 - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet"><base target="_blank">
    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
    <script src="/Public/js/plugins/layer/layer.min.js"></script>
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

<div id="Height_a" class="middle-box text-center loginscreen  animated fadeInDown" style="width: 30%;max-width: 100%;position:absolute;top: 10%;left: 35%; ">
    <div>
        <div>

            <h1 class="logo-name" style="font-size: 70px;letter-spacing:2px;">诚享东方</h1>
            <h1 class="logo-name" style="font-size: 70px;margin-bottom: 40px;letter-spacing:2px;">公告信息通知系统</h1>

        </div>
        <h3>欢迎使用</h3>


            <div class="form-group" style="width: 300px;margin: 0 auto;margin-bottom: 20px;">
                <input type="text" class="form-control" placeholder="用户名" required="" name="name">
            </div>
        <div class="form-group" style="width: 300px;margin: 0 auto;margin-bottom: 20px;">
                <input type="password" class="form-control" placeholder="密码" required="" name="password">
            </div>
            <button class="btn btn-primary block full-width m-b" onclick="login()" style="width: 300px !important;margin: 0 auto;">登 录</button>



    </div>
</div>
<script>
    function login(){
        var username = $('input[name="name"]').val();
        var password = $('input[name="password"]').val();
        if( username == '' || password ==''){
            layer.alert('用户名或密码不能为空', {icon: 2}); //alert('用户名或密码不能为空');
            return;
        }


        $.ajax({
            url:'/index.php/Home/Login/login',
            type:'post',
            dataType:'json',
            data:{username:username,password:password},
            success:function(res){
                if(res.status==1){
                    top.location.href = res.url;
                }else{
                    layer.alert(res.msg, {icon: 2});
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
            }
        })
    }

</script>

<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

</body>

</html>