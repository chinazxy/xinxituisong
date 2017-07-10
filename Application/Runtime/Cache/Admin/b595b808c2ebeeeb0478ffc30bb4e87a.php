<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>诚享公告</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link href="/Public/assets/css/sweetalert/sweetalert.css" rel="stylesheet">
    <!-- page specific plugin styles -->

    <!-- fonts -->

    <link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <link rel="stylesheet" href="/Public/assets/css/select2.css" />

    <!-- fonts -->

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

    <!-- ace styles -->

    <link rel="stylesheet" href="/Public/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/Public/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/Public/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="/Public/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/Public/assets/js/html5shiv.js"></script>
    <script src="/Public/assets/js/respond.min.js"></script>

    <!-- ace styles -->

    <link rel="stylesheet" href="/Public/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/Public/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/Public/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="/Public/assets/js/sweetalert/sweetalert.min.js"></script>
    <script src="/Public/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/Public/assets/js/html5shiv.js"></script>
    <script src="/Public/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i>
                    诚享东方信息推送系统
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <?php $parent_role = $_SESSION['parent_role']; if($parent_role == 0){ $is_top = 1; } ?>


                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/Public/upload/<?php echo ($admin_img); ?>" alt="<?php echo ($admin_name); ?>'s Photo" />
                        <span class="user-info">
									<small>欢迎光临,</small>
									<?php echo ($admin_name); ?>
								</span>

                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">


                        <li class="active">
                            <a href="<?php echo U('Index/moPassword');?>">
                                <i class="icon-cog"></i>
                                修改密码
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo U('Index/logout');?>">
                                <i class="icon-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>

            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <button class="btn btn-success">
                        <i class="icon-signal"></i>
                    </button>

                    <button class="btn btn-info">
                        <i class="icon-pencil"></i>
                    </button>

                    <button class="btn btn-warning">
                        <i class="icon-group"></i>
                    </button>

                    <button class="btn btn-danger">
                        <i class="icon-cogs"></i>
                    </button>
                </div>

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div><!-- #sidebar-shortcuts -->

            <ul class="nav nav-list">
                <li class="active">
                    <a href="<?php echo U('Index/index');?>">
                        <i class="icon-dashboard"></i>
                        <span class="menu-text"> 主页 </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('News/index');?>">
                        <i class="icon-edit"></i>
                        <span class="menu-text"> 编辑新文章 </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-comments "></i>
                        <span class="menu-text"> 用户组管理 </span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo U('Group/index');?>">
                                <i class="icon-double-angle-right"></i>
                                用户组列表
                            </a>
                        </li>
                        <?php if($is_top){ ?>
                            <li>
                                <a href="<?php echo U('Group/add');?>">
                                    <i class="icon-double-angle-right"></i>
                                    新增用户组
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-user"></i>
                        <span class="menu-text"> 经销商管理 </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo U('Seller/index');?>">
                                <i class="icon-double-angle-right"></i>
                                用户列表
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Seller/opinion');?>">
                                <i class="icon-double-angle-right"></i>
                                用户反馈
                            </a>
                        </li>

                    </ul>

                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-user"></i>
                        <span class="menu-text"> 公司用户管理 </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="<?php echo U('Company/index');?>">
                                <i class="icon-double-angle-right"></i>
                                用户列表
                            </a>
                        </li>

                        <?php if($is_top){ ?>
                                <li>
                                    <a href="<?php echo U('Company/add');?>">
                                        <i class="icon-double-angle-right"></i>
                                        新增用户
                                    </a>
                                </li>
                          <?php } ?>

                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-envelope"></i>
                        <span class="menu-text"> 文章管理 </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="<?php echo U('News/newsList');?>">
                                <i class="icon-double-angle-right"></i>
                                文章列表
                            </a>
                        </li>


                    </ul>
                </li>


            </ul><!-- /.nav-list -->

            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>

            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>

<div class="main-content">
    <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="/index.php/Admin/Index/index">主页</a>
            </li>


            <li class="active">首页</li>
        </ul><!-- .breadcrumb -->


    </div>

    <div class="page-content">
        <div class="page-header">
            <h1>
                首页

            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->


                <div class="hr dotted"></div>

                <div>
                    <div id="user-profile-1" class="user-profile row">
                        <div class="col-xs-12 col-sm-3 center">
                            <div>
												<span class="profile-picture">
													<img width="180px" id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="/Public/upload/<?php echo ($admin_img); ?>" />
												</span>

                                <div class="space-4"></div>

                                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                    <div class="inline position-relative">
                                        <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-circle light-green middle"></i>
                                            &nbsp;
                                            <span class="white"><?php echo ($admin_name); ?></span>
                                        </a>


                                    </div>
                                </div>
                            </div>

                            <div class="space-6"></div>

                            <div class="profile-contact-info">
                                <div class="profile-contact-links align-left">
                                    <a class="btn btn-link">
                                        <i class="icon-plus-sign bigger-120 green"></i>
                                        所属组 ： <?php echo ($role_name); ?>
                                    </a>

                                </div>


                            </div>

                            <div class="hr hr12 dotted"></div>

                            <div class="clearfix">
                                <div class="grid2">
                                    <span class="bigger-175 blue"><?php echo ((isset($parent_role_name ) && ($parent_role_name !== ""))?($parent_role_name ):'顶级'); ?></span>

                                    <br />
                                    所属上级
                                </div>

                                <div class="grid2">
                                    <span class="bigger-175 blue"><?php echo ((isset($children ) && ($children !== ""))?($children ):"无"); ?></span>

                                    <br />
                                    下级
                                </div>
                            </div>

                            <div class="hr hr16 dotted"></div>
                        </div>

                        <div class="col-xs-12 col-sm-9">
                            <div class="center">
												<span class="btn btn-app btn-sm btn-light no-hover">
													<span class="line-height-1 bigger-170 blue"> <?php echo ($newsNum); ?> </span>

													<br />
													<span class="line-height-1 smaller-90" onclick='url("<?php echo U('News/newsList' , array('type' => 'pass'));?>")'> 已发布文章 </span>
												</span>
                                <span class="btn btn-app btn-pink btn-sm">
													<span class="line-height-1 bigger-170 "> <?php echo ($needCheck); ?> </span>

													<br />
													<span class="line-height-1 smaller-90" onclick='url("<?php echo U('News/newsList' , array('type' => 'needCheck'));?>")'> 需审核文章 </span>
                                </span>

                                <span class="btn btn-app btn-sm btn-yellow no-hover">

                                  <span class="line-height-1 bigger-170"> <?php echo ($noCheck); ?> </span>
													<br />
													<span class="line-height-1 smaller-90" onclick='url("<?php echo U('News/newsList' , array('type' => 'noCheck'));?>")'>待审核文章  </span>
												</span>


                                <span class="btn btn-app btn-sm btn-success no-hover">
													<span class="line-height-1 bigger-170"> <?php echo ($noPass); ?> </span>

													<br />
													<span class="line-height-1 smaller-90" onclick='url("<?php echo U('News/newsList' , array('type' => 'noPass'));?>")'>未通过文章 </span>
												</span>

                                <a class="btn btn-app btn-info btn-sm" href="<?php echo U('News/index');?>">
                                    <i class="icon-envelope bigger-200"></i>
                                    新增文章

                                </a>
                            </div>

                            <div class="space-12"></div>

                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 用户名 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="username"><?php echo ($userInfo["username"]); ?></span>
                                    </div>
                                </div>


                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 手机号 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="age"><?php echo ($userInfo["mobile"]); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 身份证号 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="idcard"><?php echo ($userInfo["idcard"]); ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 加入时间 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="signup"><?php echo ($add_time); ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 上次登录时间 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="login"><?php if($last_time != null): echo (date('Y-m-d H:i:s' , $last_time )); else: ?>&nbsp;<?php endif; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div class="space-6"></div>
                            <div class="center hidden">
                                <a href="<?php echo U('Index/modInfo');?>" class="btn btn-sm btn-primary">
                                    <span class="bigger-110">修改信息</span>

                                    <i class="icon-on-right icon-arrow-right"></i>
                                </a>
                            </div>
                            <div class="space-20"></div>

                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-small">
                                    <h4 class="blue smaller">
                                        <i class="icon-rss orange"></i>
                                        最近发布
                                    </h4>


                                </div>

                                <div class="widget-body">
                                    <div class="widget-main padding-8">
                                        <div id="profile-feed-1" class="profile-feed">
                                            <?php if(is_array($list)): foreach($list as $k=>$v): ?><div class="profile-activity clearfix">
                                                <div>
                                                    <img class="pull-left" alt="Alex Doe's avatar" src="/Public/upload/<?php echo ($v["headpic"]); ?>" />
                                                    <a class="user" href="#"> <?php echo ($v["name"]); ?> : </a>
                                                    <?php echo ($v["news_title"]); ?>.
                                                    <a href="<?php echo U('News/detail' , array('id' => $v['news_id']));?>"><i class="normal-icon icon-eye-open info bigger-130"></i></a>

                                                    <div class="time">
                                                        <i class="icon-time bigger-110"></i>
                                                        <?php echo ($v["issue_time"]); ?>
                                                    </div>
                                                </div>

                                            </div><?php endforeach; endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="space-6"></div>


                        </div>
                    </div>
                </div>





                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><!-- /.main-content -->

<div class="ace-settings-container" id="ace-settings-container">
    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
        <i class="icon-cog bigger-150"></i>
    </div>

    <div class="ace-settings-box" id="ace-settings-box">
        <div>
            <div class="pull-left">
                <select id="skin-colorpicker" class="hide">
                    <option data-skin="default" value="#438EB9">#438EB9</option>
                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                </select>
            </div>
            <span>&nbsp; Choose Skin</span>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
            <label class="lbl" for="ace-settings-add-container">
                Inside
                <b>.container</b>
            </label>
        </div>
    </div>
</div><!-- /#ace-settings-container -->
</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->



<!-- <![endif]-->

<!--[if IE]>

<![endif]-->
<script>
    function url(url){
        window.location.href = "<?php echo U('News/detail');?>?id="+url;
    }

</script>
<!--[if !IE]> -->
<script>
    function url(url){
        window.location.href = url;
    }
</script>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/Public/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="/Public/assets/js/bootstrap.min.js"></script>
<script src="/Public/assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="/Public/assets/js/excanvas.min.js"></script>
<![endif]-->

<script src="/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="/Public/assets/js/jquery.gritter.min.js"></script>
<script src="/Public/assets/js/bootbox.min.js"></script>
<script src="/Public/assets/js/jquery.slimscroll.min.js"></script>
<script src="/Public/assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="/Public/assets/js/jquery.hotkeys.min.js"></script>
<script src="/Public/assets/js/bootstrap-wysiwyg.min.js"></script>
<script src="/Public/assets/js/select2.min.js"></script>
<script src="/Public/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/Public/assets/js/fuelux/fuelux.spinner.min.js"></script>
<script src="/Public/assets/js/x-editable/bootstrap-editable.min.js"></script>
<script src="/Public/assets/js/x-editable/ace-editable.min.js"></script>
<script src="/Public/assets/js/jquery.maskedinput.min.js"></script>

<!-- ace scripts -->

<script src="/Public/assets/js/ace-elements.min.js"></script>
<script src="/Public/assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    jQuery(function($) {

        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>'+
            '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';

        //editables
        $('#username').editable({
            type: 'text',
            name: 'username'
        });


        var countries = [];
        $.each({ "CA": "Canada", "IN": "India", "NL": "Netherlands", "TR": "Turkey", "US": "United States"}, function(k, v) {
            countries.push({id: k, text: v});
        });

        var cities = [];
        cities["CA"] = [];
        $.each(["Toronto", "Ottawa", "Calgary", "Vancouver"] , function(k, v){
            cities["CA"].push({id: v, text: v});
        });
        cities["IN"] = [];
        $.each(["Delhi", "Mumbai", "Bangalore"] , function(k, v){
            cities["IN"].push({id: v, text: v});
        });
        cities["NL"] = [];
        $.each(["Amsterdam", "Rotterdam", "The Hague"] , function(k, v){
            cities["NL"].push({id: v, text: v});
        });
        cities["TR"] = [];
        $.each(["Ankara", "Istanbul", "Izmir"] , function(k, v){
            cities["TR"].push({id: v, text: v});
        });
        cities["US"] = [];
        $.each(["New York", "Miami", "Los Angeles", "Chicago", "Wysconsin"] , function(k, v){
            cities["US"].push({id: v, text: v});
        });

        var currentValue = "NL";
        $('#country').editable({
            type: 'select2',
            value : 'NL',
            source: countries,
            success: function(response, newValue) {
                if(currentValue == newValue) return;
                currentValue = newValue;

                var new_source = (!newValue || newValue == "") ? [] : cities[newValue];

                //the destroy method is causing errors in x-editable v1.4.6
                //it worked fine in v1.4.5
                /**
                 $('#city').editable('destroy').editable({
							type: 'select2',
							source: new_source
						}).editable('setValue', null);
                 */

                    //so we remove it altogether and create a new element
                var city = $('#city').removeAttr('id').get(0);
                $(city).clone().attr('id', 'city').text('Select City').editable({
                    type: 'select2',
                    value : null,
                    source: new_source
                }).insertAfter(city);//insert it after previous instance
                $(city).remove();//remove previous instance

            }
        });

        $('#city').editable({
            type: 'select2',
            value : 'Amsterdam',
            source: cities[currentValue]
        });



        $('#signup').editable({
            type: 'date',
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datepicker: {
                weekStart: 1
            }
        });

        $('#age').editable({
            type: 'spinner',
            name : 'age',
            spinner : {
                min : 16, max:99, step:1
            }
        });

        //var $range = document.createElement("INPUT");
        //$range.type = 'range';
        $('#login').editable({
            type: 'slider',//$range.type == 'range' ? 'range' : 'slider',
            name : 'login',
            slider : {
                min : 1, max:50, width:100
            },
            success: function(response, newValue) {
                if(parseInt(newValue) == 1)
                    $(this).html(newValue + " hour ago");
                else $(this).html(newValue + " hours ago");
            }
        });

        $('#about').editable({
            mode: 'inline',
            type: 'wysiwyg',
            name : 'about',
            wysiwyg : {
                //css : {'max-width':'300px'}
            },
            success: function(response, newValue) {
            }
        });



        // *** editable avatar *** //
        try 

            var last_gritter
            $('#avatar').editable({
                type: 'image',
                name: 'avatar',
                value: null,
                image: {
                    //specify ace file input plugin's options here
                    btn_choose: 'Change Avatar',
                    droppable: true,
                    /**
                     //this will override the default before_change that only accepts image files
                     before_change: function(files, dropped) {
								return true;
							},
                     */

                    //and a few extra ones here
                    name: 'avatar',//put the field name here as well, will be used inside the custom plugin
                    max_size: 110000,//~100Kb
                    on_error : function(code) );
                        } else if(code == 2) );
                        }
                        else 
                    },
                    on_success : function() {
                        $.gritter.removeAll();
                    }
                },
                url: function(params) {
                    // ***UPDATE AVATAR HERE*** //
                    //You can replace the contents of this function with examples/profile-avatar-update.js for actual upload


                    var deferred = new $.Deferred

                    //if value is empty, means no valid files were selected
                    //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
                    //so we return just here to prevent problems
                    var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
                    if(!value || value.length == 0) {
                        deferred.resolve();
                        return deferred.promise();
                    }


                    //dummy upload
                    setTimeout(function(){
                        if("FileReader" in window) {
                            //for browsers that have a thumbnail of selected image
                            var thumb = $('#avatar').next().find('img').data('thumb');
                            if(thumb) $('#avatar').get(0).src = thumb;
                        }

                        deferred.resolve({'status':'OK'});

                        if(last_gritter) $.gritter.remove(last_gritter);
                        last_gritter = $.gritter.add({
                            title: 'Avatar Updated!',
                            text: 'Uploading to server can be easily implemented. A working example is included with the template.',
                            class_name: 'gritter-info gritter-center'
                        });

                    } , parseInt(Math.random() * 800 + 800))

                    return deferred.promise();
                },

                success: function(response, newValue) {
                }
            })
        }catch(e) {}



        //another option is using modals
        $('#avatar2').on('click', function(){
            var modal =
                '<div class="modal hide fade">\
                    <div class="modal-header">\
                        <button type="button" class="close" data-dismiss="modal">&times;</button>\
                        <h4 class="blue">Change Avatar</h4>\
                    </div>\
                    \
                    <form class="no-margin">\
                    <div class="modal-body">\
                        <div class="space-4"></div>\
                        <div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
                    </div>\
                    \
                    <div class="modal-footer center">\
                        <button type="submit" class="btn btn-small btn-success"><i class="icon-ok"></i> Submit</button>\
                        <button type="button" class="btn btn-small" data-dismiss="modal"><i class="icon-remove"></i> Cancel</button>\
                    </div>\
                    </form>\
                </div>';


            var modal = $(modal);
            modal.modal("show").on("hidden", function(){
                modal.remove();
            });

            var working = false;

            var form = modal.find('form:eq(0)');
            var file = form.find('input[type=file]').eq(0);
            file.ace_file_input({
                style:'well',
                btn_choose:'Click to choose new avatar',
                btn_change:null,
                no_icon:'icon-picture',
                thumbnail:'small',
                before_remove: function() {
                    //don't remove/reset files while being uploaded
                    return !working;
                },
                before_change: function(files, dropped) {
                    var file = files[0];
                    if(typeof file === "string") {
                        //file is just a file name here (in browsers that don't support FileReader API)
                        if(! (/\.(jpe?g|png|gif)$/i).test(file) ) return false;
                    }
                    else 
                    }

                    return true;
                }
            });

            form.on('submit', function(){
                if(!file.data('ace_input_files')) return false;

                file.ace_file_input('disable');
                form.find('button').attr('disabled', 'disabled');
                form.find('.modal-body').append("<div class='center'><i class='icon-spinner icon-spin bigger-150 orange'></i></div>");

                var deferred = new $.Deferred;
                working = true;
                deferred.done(function() {
                    form.find('button').removeAttr('disabled');
                    form.find('input[type=file]').ace_file_input('enable');
                    form.find('.modal-body > :last-child').remove();

                    modal.modal("hide");

                    var thumb = file.next().find('img').data('thumb');
                    if(thumb) $('#avatar2').get(0).src = thumb;

                    working = false;
                });


                setTimeout(function(){
                    deferred.resolve();
                } , parseInt(Math.random() * 800 + 800));

                return false;
            });

        });



        //////////////////////////////
        $('#profile-feed-1').slimScroll({
            height: '250px',
            alwaysVisible : true
        });

        $('.profile-social-links > a').tooltip();

        $('.easy-pie-chart.percentage').each(function(){
            var barColor = $(this).data('color') || '#555';
            var trackColor = '#E2E2E2';
            var size = parseInt($(this).data('size')) || 72;
            $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size/10),
                animate:false,
                size: size
            }).css('color', barColor);
        });

        ///////////////////////////////////////////

        //show the user info on right or left depending on its position
        $('#user-profile-2 .memberdiv').on('mouseenter', function(){
            var $this = $(this);
            var $parent = $this.closest('.tab-pane');

            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $this.offset();
            var w2 = $this.width();

            var place = 'left';
            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';

            $this.find('.popover').removeClass('right left').addClass(place);
        }).on('click', function() {
            return false;
        });


        ///////////////////////////////////////////
        $('#user-profile-3')
            .find('input[type=file]').ace_file_input({
            style:'well',
            btn_choose:'Change avatar',
            btn_change:null,
            no_icon:'icon-picture',
            thumbnail:'large',
            droppable:true,
            before_change: function(files, dropped) {
                var file = files[0];
                if(typeof file === "string") 
                else 
                }

                return true;
            }
        })
            .end().find('button[type=reset]').on(ace.click_event, function(){
            $('#user-profile-3 input[type=file]').ace_file_input('reset_input');
        })
            .end().find('.date-picker').datepicker().next().on(ace.click_event, function(){
            $(this).prev().focus();
        })
        $('.input-mask-phone').mask('(999) 999-9999');



        ////////////////////
        //change profile
        $('[data-toggle="buttons"] .btn').on('click', function(e){
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            $('.user-profile').parent().addClass('hide');
            $('#user-profile-'+which).parent().removeClass('hide');
        });
    });
</script>
<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
</body>
</html>