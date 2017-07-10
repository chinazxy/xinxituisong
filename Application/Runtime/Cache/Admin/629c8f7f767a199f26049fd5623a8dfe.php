<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>诚享东方公告信息通知系统- 角色添加</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/Public/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
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
                            <label class="col-sm-3 control-label">角色：</label>
                            <div class="col-sm-4">
                                <input id="role_name"  name="role_name" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">角色描述：</label>
                            <div class="col-sm-6">
                                <input id="role_desc"  name="role_desc" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">设置权限：</label>
                            <div class="col-sm-8">
                                <?php if(is_array($menu_list)): foreach($menu_list as $key=>$v): ?><div class="checkbox checkbox-success ">
                                        <input id="mid_<?php echo ($v["m_id"]); ?>" value="<?php echo ($v["m_id"]); ?>" type="checkbox" onclick="selectAll(mid_<?php echo ($v["m_id"]); ?>)">
                                        <label for="mid_<?php echo ($v["m_id"]); ?>"> <?php echo ($v["m_name"]); ?> </label>
                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php if(is_array($v["kid_list"])): foreach($v["kid_list"] as $key=>$vv): ?><div class="checkbox checkbox-success checkbox-inline">
                                        <input  id="mid_<?php echo ($vv["m_id"]); ?>" class="mid_<?php echo ($v["m_id"]); ?>" value="<?php echo ($vv["m_id"]); ?>" name="act_list[]" type="checkbox">
                                            <label  for="mid_<?php echo ($vv["m_id"]); ?>" > <?php echo ($vv["m_name"]); ?> </label>
                                        </div><?php endforeach; endif; endforeach; endif; ?>
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
    function selectAll(mid){
        alert(1)
    }


    function submit(){
        var menu_name =$('input[name="menu_name"]').val();
        var father_c_name = $('select[name=father_c_name] option:selected').val();
        var controller_name = $('input[name="controller_name"]').val();
        var method_name = $('input[name="method_name"]').val();
        var is_show = $('input[name=is_show]:checked').val();
        $.ajax({
            url:"<?php echo U('Index/doAddMenu');?>",
            type:"POST",
            data : {menu_name : menu_name , father_c_name : father_c_name , controller_name : controller_name , method_name : method_name , is_show : is_show},
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