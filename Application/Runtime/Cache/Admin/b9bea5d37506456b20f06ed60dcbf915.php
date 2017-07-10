<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>诚享东方公告信息通知系统 - FooTable</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/plugins/footable/footable.core.css" rel="stylesheet">

    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet"><base target="_blank">
    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/js/plugins/sweetalert/sweetalert.min.js"></script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <a href="<?php echo U('Index/addRole');?>" class=" btn btn-w-m btn-info" target="iframe4"><i class="glyphicon glyphicon-plus"></i>
                        添加角色</a>
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

                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                        <thead>
                        <tr>

                            <th data-toggle="true">角色</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($role_list)): foreach($role_list as $k=>$vo): ?><tr>
                                <td><?php echo ($vo["role_name"]); ?></td>
                                <td><?php echo ($vo["role_desc"]); ?></td>
                                <td>
                                    <a href="<?php echo U('Index/editRole' , array('role_id' => $vo['role_id']));?>"  target="iframe4"><i class="glyphicon glyphicon-asterisk"></i> 编辑</a>
                                    <a onclick="del(<?php echo ($vo["role_id"]); ?>)" class="role_<?php echo ($vo["role_id"]); ?>"> <i class="glyphicon glyphicon-remove"></i> 删除</a>
                                </td>
                            </tr><?php endforeach; endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>
<script>

    function del(id){
        if (!confirm('确认删除?')) {
            return false;
        }else{
            $.ajax({
                url : "<?php echo U('Index/delRole');?>",
                data : {role_id : id},
                dataType : "JSON",
                type : "POST",
                success : function (e) {
                    if (e.res == 1) {
                        $('.role_'+id).parent().parent().remove();
                        swal({title:e.msg,text:"",type:"success"})

                    }else{
                        swal({title:e.msg,text:"",type:"error"})
                    }
                },
                error : function (e) {
                    swal({title:"出错了",text:"",type:"warning"})
                }
            })
        }
    }
</script>
<script src="/Public/js/jquery.min.js?v=2.1.4"></script>
<script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/Public/js/plugins/footable/footable.all.min.js"></script>
<script src="/Public/js/content.min.js?v=1.0.0"></script>
<script>
    $(document).ready(function(){$(".footable").footable();$(".footable2").footable()});
</script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
</body>

</html>