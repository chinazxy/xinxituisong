<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>诚享东方公告信息通知系统- 管理员添加</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/js/jquery-form.js"></script>
    <script src="/Public/js/plugins/sweetalert/sweetalert.min.js"></script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="signupForm">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">菜单名称：</label>
                            <div class="col-sm-4">
                                <input id="menu_name" value="<?php echo ($menuInfo["m_name"]); ?>" name="menu_name" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">父级控制器名：</label>
                            <div class="col-sm-4">
                                <select class="form-control m-b kow" name="father_c_name">
                                    <option value="0">顶级菜单</option>
                                    <?php if(is_array($menu_list)): foreach($menu_list as $key=>$vo): ?><option value="<?php echo ($vo["m_id"]); ?>" <?php if(($menuInfo["m_parent_id"]) == $vo["m_id"]): ?>selected<?php endif; ?> ><?php echo ($vo["m_name"]); ?></option>
                                        <?php if($vo["kid_list"] != null): if(is_array($vo["kid_list"])): foreach($vo["kid_list"] as $key=>$v): ?><option value="<?php echo ($v["m_id"]); ?>" <?php if(($menuInfo["m_parent_id"]) == $v["m_id"]): ?>selected<?php endif; ?> > |—— <?php echo ($v["m_name"]); ?></option><?php endforeach; endif; endif; endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">控制器名：</label>
                            <div class="col-sm-4">
                                <input id="controller_name" value="<?php echo ($menuInfo["m_controller"]); ?>" name="controller_name" class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">方法名：</label>
                            <div class="col-sm-4">
                                <input id="method_name" name="method_name" value="<?php echo ($menuInfo["m_action"]); ?>" class="form-control" type="text" />
                            </div>
                        </div>
                        <input type="hidden" name="m_id" value="<?php echo ($menuInfo["m_id"]); ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否显示菜单：</label>
                            <div class="col-sm-6">
                                是 <input type="radio" <?php if(($menuInfo["m_dis"]) == "1"): ?>checked<?php endif; ?> value="1" name="is_show">&nbsp; 否 <input <?php if(($menuInfo["m_dis"]) == "0"): ?>checked<?php endif; ?> type="radio" value="0" name="is_show">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">选择图标：</label>
                            <div class="col-sm-6">
                                <input type="radio" name="icon" value="glyphicon glyphicon-cog"> <i class="glyphicon glyphicon-cog"></i>
                                <input type="radio" name="icon" value=" glyphicon glyphicon-home"> <i class=" glyphicon glyphicon-home"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-user"> <i class="glyphicon glyphicon-user"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-bell"> <i class="glyphicon glyphicon-bell"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-tasks"> <i class="glyphicon glyphicon-tasks"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-calendar"> <i class="glyphicon glyphicon-calendar"></i>
                                <br>
                                <input type="radio" name="icon" value="glyphicon glyphicon-list"> <i class="glyphicon glyphicon-list"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-camera"> <i class="glyphicon glyphicon-camera"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-pencil"> <i class="glyphicon glyphicon-pencil"></i>
                                <input type="radio" name="icon" value="glyphicon glyphicon-cloud"> <i class="glyphicon glyphicon-cloud"></i>
                                <input type="radio" name="icon" value="fa fa-desktop"> <i class="fa fa-desktop"></i>
                                <input type="radio" name="icon" value="fa fa-star"> <i class="fa fa-star"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <a class="btn btn-primary" onclick="submit()">提交</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    //$('input[name="username"]').val();

    //var username=$('input[name="username"]').val();



    function submit(){
        var menu_name =$('input[name="menu_name"]').val();
        var m_id =$('input[name="m_id"]').val();
        var father_c_name = $('select[name=father_c_name] option:selected').val();
        var controller_name = $('input[name="controller_name"]').val();
        var method_name = $('input[name="method_name"]').val();
        var is_show = $('input[name=is_show]:checked').val();
        var icon = $('input[name=icon]:checked').val();
        $.ajax({
            url:"<?php echo U('Index/updateMenu');?>",
            type:"POST",
            data : {menu_name : menu_name , father_c_name : father_c_name , controller_name : controller_name , method_name : method_name , is_show : is_show , m_id : m_id , icon : icon},
            dataType : "JSON",

            //date:$('#form1').serialize(),
            success:function(e){
                if (e.res == 1) {
                    swal({title:e.msg,text:"",type:"success"})
                }else{
                    swal({title:e.msg,text:"",type:"error"})
                }
            },
            error:function(msg){
                swal({title:"出错了",text:"",type:"warning"})
            }
        })
    }
</script>
<script src="/Public/js/jquery.min.js?v=2.1.4"></script>
<script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/Public/js/content.min.js?v=1.0.0"></script>
<script src="/Public/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/Public/js/plugins/validate/messages_zh.min.js"></script>
<script src="/Public/js/demo/form-validate-demo.min.js"></script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
</body>

</html>