<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>诚享东方公告信息通知系统 - 头像上传</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>


    <script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
    <script src="/Public/js/content.min.js?v=1.0.0"></script>
    <script src="/Public/js/jquery-form.js"></script>
    <script src="/Public/js/plugins/sweetalert/sweetalert.min.js"></script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>富头像上传编辑器</h5>
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
                    <ul class="nav nav-tabs" id="avatar-tab">
                        <li class="active" id="upload"><a href="">本地上传</a>
                        </li>
                        <!--<li id="webcam"><a href="">视频拍照</a>
                        </li>
                        <li id="albums"><a href="">相册选取</a>
                        </li>-->
                    </ul>
                    <div class="m-t m-b">

                        <div id="editorPanelButtons">

                            <p>
                            <div id="addCommodityIndex">

                            <form action="" id="form1">
                                <!--input-group start-->
                                <div class="input-group row">

                                    <div class="col-sm-9 big-photo">
                                        <div id="preview">
                                            <img id="imghead" border="0" src="/Public/img/photo_icon.png" width="90" height="90" onclick="$('#previewImg').click();">
                                        </div>
                                        <input name="img1" type="file" onchange="previewImage(this)" style="display: none;" id="previewImg">
                                        <!--<input id="uploaderInput" class="uploader__input" style="display: none;" type="file" accept="" multiple="">-->
                                    </div>
                                </div>
                                <!--input-group end-->
                            </form>

                            </div>

                                <br>

                                <div id="add"></div>
                                <button class="btn btn-primary " type="submit" onclick="upload_img()">
                                    <i class="fa fa-check"></i>
                                    提交
                                </button>
                                <button type="reset" class="btn btn-w-m btn-white button_cancel">取消</button>

                            </p>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function upload_img(){
        var img = $('input[name="pic1"]').val();
        $.ajax({
            url : "<?php echo U('Index/upHeadIcon');?>",
            type : "POST",
            data : {img : img},
            dataType : "JSON",
            success : function (e,a) {
                if (e.res == 1){
                    swal({title:"修改成功",text:"",type:"success"})
                    setTimeout("tiaozhuan()", 3000);
                }else{
                    swal({title:"修改失败",text:"",type:"error"})
                }
            }
        })
    }

    function previewImage(file)
    {
        var MAXWIDTH  = 90;
        var MAXHEIGHT = 90;
        var div = document.getElementById('preview');
        if (file.files && file.files[0])
        {
            div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
            var img = document.getElementById('imghead');
            img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
            }
            var reader = new FileReader();
            reader.onload = function(evt){img.src = evt.target.result;}
            reader.readAsDataURL(file.files[0]);
        }
        else //兼容IE
        {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead>';
            var img = document.getElementById('imghead');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
        }
        $('#form1').ajaxSubmit({
            url:"<?php echo U('Upload/uploadimg');?>",
            type:"POST",
            dateType : "JSON",
            //date:$('#form1').serialize(),
            success:function(e){
                console.log(e)
                var json = eval( '(' + e + ')' );
                if (json.ret == 1) {
                    $('#add').html($("#add").html()+"<input type='hidden' name='pic1' value='head_icon"+json.msg+"'/>");

                }else{

                    alert(json.msg);
                }
            },
            error:function(msg){
                alert("出错了");
            }
        });
    }
    function tiaozhuan(){
        window.location.href = "<?php echo U('Index/index_v1');?>";
    }
    function clacImgZoomParam( maxWidth, maxHeight, width, height ){
        var param = {top:0, left:0, width:width, height:height};
        if( width>maxWidth || height>maxHeight ){
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;

            if( rateWidth > rateHeight ){
                param.width =  maxWidth;
                param.height = Math.round(height / rateWidth);
            }else{
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }
        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>

<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
</body>

</html>