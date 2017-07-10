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
                            <label class="col-sm-3 control-label">用户名：</label>
                            <div class="col-sm-6">
                           <input id="username"  name="username" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">所属组：</label>
                            <div class="col-sm-6">
                                <select class="form-control m-b kow" name="role_id">
                                <?php if(is_array($role_list)): foreach($role_list as $key=>$vo): ?><option value="<?php echo ($vo["role_id"]); ?>"><?php echo ($vo["role_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">密码：</label>
                            <div class="col-sm-6">
                                <input id="password" name="password" class="form-control" type="password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">确认密码：</label>
                            <div class="col-sm-6">
                                <input id="confirm_password" name="confirm_password" class="form-control" type="password" />
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请再次输入您的密码</span>
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
    var username =$('input[name="username"]').val();
    var password = $('input[name="password"]').val();
    var role_id = $('select[name=role_id] option:selected').val();
  //var role_id=$(".kow").find("option:selected").val();
    $.ajax({
        url:"<?php echo U('Index/doAddAdmin');?>",
        type:"POST",
        data : {username : username , password : password , role_id : role_id},
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