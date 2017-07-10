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

                    <a href="<?php echo U('Index/addMenu');?>" class=" btn btn-w-m btn-info" target="iframe3"><i class="glyphicon glyphicon-plus"></i>
                        添加菜单</a>
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

                            <th data-toggle="true">图标</th>
                            <th>菜单名</th>
                            <th>控制器</th>
                            <th>方法</th>
                            <th>是否显示</th>
                            <th>操作管理</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($menu_list)): foreach($menu_list as $k=>$vo): ?><tr>
                                <?php if($vo["icon"] != null): ?><td><i class="<?php echo ($vo["icon"]); ?>"></i></td>
                                    <?php else: ?>
                                    <td>11</td><?php endif; ?>
                                <td><?php echo ($vo["m_name"]); ?></td>
                                <td><?php echo ($vo["m_controller"]); ?></td>
                                <td><?php echo ($vo["m_action"]); ?></td>
                                <td>
                                    <?php if(($vo["m_dis"]) == "1"): ?>显示
                                        <?php else: ?>
                                        不显示<?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo U('Index/editMenu' , array('m_id' => $vo['m_id']));?>"  target="iframe3"><i class="glyphicon glyphicon-asterisk"></i> 编辑</a>
                                    <a onclick="del(<?php echo ($vo["m_id"]); ?>)" class="menu_<?php echo ($vo["m_id"]); ?>"> <i class="glyphicon glyphicon-remove"></i> 删除</a>
                                </td>
                            </tr>
                            <?php if(vo.kid_list != null): if(is_array($vo["kid_list"])): foreach($vo["kid_list"] as $kk=>$v): ?><tr>
                                        <td></td>
                                        <td> |—— <?php echo ($v["m_name"]); ?></td>
                                        <td><?php echo ($v["m_controller"]); ?></td>
                                        <td><?php echo ($v["m_action"]); ?></td>
                                        <td>
                                            <?php if(($v["m_dis"]) == "1"): ?>显示
                                                <?php else: ?>
                                                不显示<?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo U('Index/editMenu' , array('m_id' => $v['m_id']));?>" target="iframe3"><i class="glyphicon glyphicon-asterisk"></i> 编辑</a>
                                            <a onclick="del(<?php echo ($v["m_id"]); ?>)" class="menu_<?php echo ($v["m_id"]); ?>"> <i class="glyphicon glyphicon-remove"></i> 删除</a>
                                        </td>
                                    </tr><?php endforeach; endif; endif; endforeach; endif; ?>
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
                url : "<?php echo U('Index/delMenu');?>",
                data : {m_id : id},
                dataType : "JSON",
                type : "POST",
                success : function (e) {
                    if (e.res == 1) {
                        $('.menu_'+id).parent().parent().remove();
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