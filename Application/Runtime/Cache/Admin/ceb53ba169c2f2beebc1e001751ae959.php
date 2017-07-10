<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--360浏览器优先以webkit内核解析-->


    <title>诚享东方公告信息通知系统 - 主页</title>

    <link rel="shortcut icon" href="favicon.ico"> <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
    <base target="_blank">

</head>

<body class="gray-bg">

<div id="Height_a" class="middle-box text-center loginscreen  animated fadeInDown" style="width: 70%;max-width: 100%;position:absolute;top: 10%;left: 15%; ">
    <div>
        <div>

            <h1 class="logo-name" style="font-size: 70px;letter-spacing:2px;">诚享东方</h1>
            <h1 class="logo-name" style="font-size: 70px;margin-bottom: 40px;letter-spacing:2px;">公告信息通知系统</h1>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-primary">
                    <div class="box-body">
                        <div class="info-box">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>服务器操作系统：</td>
                                    <td><?php echo ($sys_info["os"]); ?></td>
                                    <td>服务器域名/IP：</td>
                                    <td><?php echo ($sys_info["domain"]); ?> [ <?php echo ($sys_info["ip"]); ?> ]</td>
                                    <td>服务器环境：</td>
                                    <td><?php echo ($sys_info["web_server"]); ?></td>
                                </tr>
                                <tr>
                                    <td>PHP 版本：</td>
                                    <td><?php echo ($sys_info["phpv"]); ?></td>
                                    <td>Mysql 版本：</td>
                                    <td><?php echo ($sys_info["mysql_version"]); ?></td>
                                    <td>GD 版本</td>
                                    <td><?php echo ($sys_info["gdinfo"]); ?></td>
                                </tr>
                                <tr>
                                    <td>文件上传限制：</td>
                                    <td><?php echo ($sys_info["fileupload"]); ?></td>
                                    <td>最大占用内存：</td>
                                    <td><?php echo ($sys_info["memory_limit"]); ?></td>
                                    <td>最大执行时间：</td>
                                    <td><?php echo ($sys_info["max_ex_time"]); ?></td>
                                </tr>
                                <tr>
                                    <td>安全模式：</td>
                                    <td><?php echo ($sys_info["safe_mode"]); ?></td>
                                    <td>Zlib支持：</td>
                                    <td><?php echo ($sys_info["zlib"]); ?></td>
                                    <td>Curl支持：</td>
                                    <td><?php echo ($sys_info["curl"]); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    </div>
</div>

    <script src="/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/js/bootstrap.min.js?v=3.3.5"></script>
    <script src="/Public/js/plugins/layer/layer.min.js"></script>
    <script src="/Public/js/content.min.js"></script>
    <script src="/Public/js/welcome.min.js"></script>
</body>

</html>