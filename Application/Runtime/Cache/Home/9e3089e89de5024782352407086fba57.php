<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content=" initial-scale=1.0, minimum-scale = 1, maximum-scale = 1" />
    <title>韩菲诗-用户绑定</title>

    <link type="text/css" rel="stylesheet" href="/Public/css/yhbd.css" />
    <link href="/Public/assets/css/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="/Public/assets/js/jquery-2.0.3.min.js" ></script>
    <script src="/Public/assets/js/sweetalert/sweetalert.min.js"></script>
</head>


<body>
<div class="sy_page">


    <div class="w_zhong">

        <div class="yhbd">
    <div class="yhbd_1">
        <div class="yhbd_2"><img src="/Public/img/yhbd_1.png"/></div>
        <div class="yhbd_3"><img src="/Public/img/yhbd_2.png"/></div>
    </div>
</div>
        <div class="yhbd_1">

            <div class="yhbd_4">用户绑定</div>

            <div class="yhbd_5">
                <input class="yhbd_5_2" type="phone" placeholder="请输入11位手机号" name="mobile" maxlength="11" />
            </div>

            <div class="yhbd_5">
                <input class="yhbd_5_2" type="text" placeholder="请输入您的真实姓名" name="username"/>
            </div>

            <div class="yhbd_5">
                <input class="yhbd_5_2" type="text" placeholder="请输入18位身份证号" name="idcard"  maxlength="18" />
            </div>

            <div class="yhbd_6">
                <div class="yhbd_7" onclick="show()">
                    <div class="yhbd_7_1">请选择店铺等级</div>
                    <div class="yhbd_7_2"><img src="/Public/img/yhbd_3.png"/></div>
                </div>
                <input type="hidden" name="openid" value="<?php echo ($openid); ?>">
                <input type="hidden" name="id" value="<?php echo ($id); ?>">
                <!--添加dib显示下拉内容-->
                <div class="yhbd_8">
                    <?php if(is_array($seller_lev)): $k = 0; $__LIST__ = $seller_lev;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if(($mod) == "1"): ?><button class="yhbd_8_2" onclick="add(<?php echo ($k); ?>)"><?php echo ($vo); ?>店铺</button><?php endif; ?>
                        <?php if(($mod) == "0"): ?><button class="yhbd_8_1" onclick="add(<?php echo ($k); ?>)"><?php echo ($vo); ?>店铺</button><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        <div class="lev"></div>
        </div>
        <input class="yhbd_9" onclick="submit()" type="button" name="" value="提 交 绑 定" />

    </div>
</div>

</body>
</html>
<script>
    function show(){
        if ($(".yhbd_8").css('display') == 'none'){
            $(".yhbd_8").css('display' , 'block')
        }else{
            $(".yhbd_8").css('display' , 'none')
        }
    }

    function add(id){
        if (id == 1){
            $('.yhbd_8').css('display' , 'none');
            $('.yhbd_7_1').html("<?php echo $seller_lev[0];?>店铺");
            $('.lev').html("<input type='hidden' name='lev' value='"+id+"' />");
        }else if (id == 2){
            $('.yhbd_8').css('display' , 'none');
            $('.yhbd_7_1').html("<?php echo $seller_lev[1];?>店铺");
            $('.lev').html("<input type='hidden' name='lev' value='"+id+"' />");
        }else if (id == 3){
            $('.yhbd_8').css('display' , 'none');
            $('.yhbd_7_1').html("<?php echo $seller_lev[2];?>店铺");
            $('.lev').html("<input type='hidden' name='lev' value='"+id+"' />");
        }else if (id == 4){
            $('.yhbd_8').css('display' , 'none');
            $('.yhbd_7_1').html("<?php echo $seller_lev[3];?>店铺");
            $('.lev').html("<input type='hidden' name='lev' value='"+id+"' />");
        }
    }

    function submit(){
        var realname = $('input[name="username"]').val();
        var mobile = $('input[name="mobile"]').val();
        var idcard = $('input[name="idcard"]').val();
        var openid = $('input[name="openid"]').val();
        var id = $('input[name="id"]').val();
        var lev = $('input[name="lev"]').val();

        if( realname == '' || mobile =='' || idcard == '' || lev == ''){
            swal({title:"提示",text:"请填写完整信息",type:"error"}) //alert('用户名或密码不能为空');
            return;
        }
        var re = /^1\d{10}$/;
        if (!re.test(mobile)){
            swal({title:"提示",text:"请填写正确的电话号码",type:"error"}) //alert('用户名或密码不能为空');
            return;
        }
        var r = /(^\d{15}$)|(^\d{17}(\d|X)$)/;
        if (!r.test(idcard)){
            swal({title:"提示",text:"请填写正确的身份证号码",type:"error"}) //alert('用户名或密码不能为空');
            return;
        }
        $.ajax({
            url:'<?php echo U("Home/Index/bindInfo");?>',
            type:'post',
            dataType:'json',
            data:{realname:realname,mobile:mobile , idcard : idcard , openid : openid , id : id , lev : lev},
            success:function(res){
                if(res.status==1){
                    top.location.href = res.url;
                }else{
                    swal({title:"提示",text:res.msg,type:"error"})
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                swal({title:"提示",text:"网络失败，请刷新页面后重试",type:"error"})
            }
        })
    }
</script>