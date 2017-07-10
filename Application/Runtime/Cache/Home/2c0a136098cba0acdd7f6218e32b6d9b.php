<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content=" initial-scale=1.0, minimum-scale = 1, maximum-scale = 1" />
    <title>韩菲诗-意见反馈</title>
    <script src="/Public/assets/js/jquery-2.0.3.min.js" ></script>
    <link href="/Public/assets/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/Public/css/yhbd.css" />
    <script src="/Public/assets/js/sweetalert/sweetalert.min.js"></script>
</head>


<body>
<div class="sy_page gglb_bg">



    <div class="w_zhong">

        <div class="gglb">


            <div class="yjfk_1">
                意见与反馈
                <div class="yjfk_2"><img src="/Public/img/z_jt.png" /></div>
            </div>

            <div class="yjfk_3">
                <div class="yjfk_4">
                    <div class="yjfk_4_1"></div>
                    <div class="yjfk_4_2">选择您要反馈的问题类型<span>（必填）</span></div>
                </div>
                <div class="yjfk_5">
                    <div class="yjfk_6" >
                        <input type="button" name="" value="购物流程" class="yjfk_6_2 yjfk_6_3" />

                    </div>
                    <div class="yjfk_6" >
                        <input type="button" name="" value="物流问题" class="yjfk_6_2 " />

                    </div>
                    <div class="yjfk_6 yjfk_7" >
                        <input type="button" name="" value="售后服务" class="yjfk_6_2" />

                    </div>
                    <div class="yjfk_6" >
                        <input type="button" name="" value="新品提议" class="yjfk_6_2" />

                    </div>
                    <div class="yjfk_6" >
                        <input type="button" name="" value="其他建议" class="yjfk_6_2" />

                    </div>
                </div>
            </div>

            <div class="yjfk_3">
                <div class="yjfk_4">
                    <div class="yjfk_4_1"></div>
                    <div class="yjfk_4_2">您的建议<span>（必填）</span></div>
                </div>
                <textarea class="yjfk_8" rows="6" cols="1" maxlength="200" placeholder="感谢你对信购商城的支持！"></textarea>
            </div>

            <div class="yjfk_bot">
                <input onclick="submit()" type="button" name="" value="提交反馈" class="yjfk_btn" />
            </div>


        </div>









    </div>



</div>
<script>
 $(".yjfk_6").click(function(){
     $(this).find('.yjfk_6_2').addClass('yjfk_6_3');
     $(this).siblings().find('.yjfk_6_2').removeClass('yjfk_6_3');
   return false;
 });

function submit(){
    var type = $('.yjfk_6_3').val();
    var openid = "<?php echo ($openid); ?>";
    var content = $('.yjfk_8').val();
    if (type == '' || content == ''){
        swal({title:"提示",text:'请填写完整信息',type:"error"})
    }
    $.ajax({
        url : "<?php echo U('Index/delNews');?>",
        type : "POST",
        dataType : "JSON",
        data : {id : id },
        success : function (e) {
            if (e.res == 1){
                $('.ggxq_3').html('<a style="width: 100%" class="y1" href="'+url+'">返回</a>');
                swal({title:"提示",text:e.msg,type:"success"})
            }else{
                swal({title:"提示",text:e.msg,type:"error"})
            }
        },
        error : function (e) {
            alert(e)
            swal({title:"提示",text:"修改失败，网络错误，请重试",type:"error"})
        }
    })
}

</script>



</body>
</html>