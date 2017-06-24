<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="renderer" content="webkit">

	<title> GEauth- 主页</title>

	<meta name="keywords" content="">
	<meta name="description" content="">

	<!--[if lt IE 9]>
	<meta http-equiv="refresh" content="0;ie.html" />
	<![endif]-->

	<link rel="shortcut icon" href="favicon.ico"> <link href="/Github/GEauth/Public/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
	<link href="/Github/GEauth/Public/admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
	<link href="/Github/GEauth/Public/admin/css/animate.css" rel="stylesheet">
	<link href="/Github/GEauth/Public/admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
	<!--左侧导航开始-->
	<nav class="navbar-default navbar-static-side" role="navigation">
		<div class="nav-close"><i class="fa fa-times-circle"></i>
		</div>
		<div class="sidebar-collapse">
			<ul class="nav" id="side-menu">
				<li class="nav-header">
					<div class="dropdown profile-element">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <i class=""><img style="width:50px;height:50px;border-radius:50%;" src="/Github/GEauth/<?php echo ($users["avatar"]); ?>"/></i>
                                        <strong class="font-bold"><?php echo ($users["loginname"]); ?></strong>
                                    </span>
                                </span>
						</a>
					</div>
					<div class="logo-element">果果
					</div>
				</li>
				<li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
					<span class="ng-scope">分类</span>
				</li>
				<li>
					<a class="J_menuItem" href="index_v1.html">
						<i class="fa fa-home"></i>
						<span class="nav-label">主页</span>
					</a>
				</li>

				<!--动态加载菜单START-->
				<?php if(is_array($menus)): foreach($menus as $key=>$vo): ?><li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
						<span class="ng-scope"><?php echo ($vo['title']); ?></span>
					</li>
					<?php if($vo['_child'] != 0 ): $child=$vo['_child'] ?>
						<?php if(is_array($child)): foreach($child as $key=>$v): ?><li>
						<a href="#">

							<i class="fa fa fa-bar-chart-o"></i>
							<span class="nav-label"><?php echo ($v['title']); ?></span>
							<span class="fa arrow"></span>
						</a>
						<?php if($v['_child'] != 0 ): ?><ul class="nav nav-second-level">
							<?php $child=$v['_child'] ?>
							<?php if(is_array($child)): foreach($child as $key=>$vv): ?><li>
									<a class="J_menuItem" href=/Github/GEauth/admin.php/<?php echo ($vv['name']); ?>><?php echo ($vv['title']); ?></a>
								</li><?php endforeach; endif; ?>
						</ul><?php endif; ?>
				</li><?php endforeach; endif; endif; endforeach; endif; ?>
				<!--动态加载菜单END-->


				<!--<li class="line dk"></li>-->

				<!--<li class="hidden-folded padder m-t m-b-sm text-muted text-xs">-->
					<!--<span class="ng-scope">用户模块</span>-->
				<!--</li>-->
				<!--<li>-->
					<!--<a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">用户组</span><span class="fa arrow"></span></a>-->
					<!--<ul class="nav nav-second-level">-->
						<!--<li><a class="J_menuItem" href="/Github/GEauth/admin.php/Home/role/index">用户列表</a></li>-->
					<!--</ul>-->
				<!--</li>-->
				<!--<li>-->
					<!--<a href="#"><i class="fa fa-edit"></i> <span class="nav-label">管理组</span><span class="fa arrow"></span></a>-->
					<!--<ul class="nav nav-second-level">-->
						<!--<li><a class="J_menuItem" href="/Github/GEauth/admin.php/Home/role/index">角色管理</a></li>-->
						<!--<li><a class="J_menuItem" href="/Github/GEauth/admin.php/Home/user/index">管理员</a></li>-->
					<!--</ul>-->
				<!--</li>-->
				<!--<li class="hidden-folded padder m-t m-b-sm text-muted text-xs">-->
					<!--<span class="ng-scope">菜单模块</span>-->
				<!--</li>-->
				<!--<li>-->
					<!--<a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">后台菜单</span><span class="fa arrow"></span></a>-->
					<!--<ul class="nav nav-second-level">-->
						<!--<li><a class="J_menuItem" href="/Github/GEauth/admin.php/Home/Menu/index">菜单列表</a></li>-->
					<!--</ul>-->
				<!--</li>-->
			</ul>
		</div>
	</nav>
	<!--左侧导航结束-->
	<!--右侧部分开始-->
	<div id="page-wrapper" class="gray-bg dashbard-1">
		<div class="row border-bottom">
			<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
				<!--<div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#"><i class="fa fa-bars"></i> </a>-->
					<!--<form role="search" class="navbar-form-custom" method="post" action="search_results.html">-->
						<!--<div class="form-group">-->
							<!--<input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">-->
						<!--</div>-->
					<!--</form>-->
				<!--</div>-->
				<ul class="nav navbar-top-links navbar-right">
				<!--<ul style="float:right;margin-top:14px;">-->
					<!--<span><font style="font-family:-webkit-body;font-size:medium;"><?php echo ($users["loginname"]); ?></font>,欢迎您登录果果的权限管理平台</span>-->
					<li class="dropdown">
						<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
							<i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
						</a>
						<ul class="dropdown-menu dropdown-messages">
							<li class="m-t-xs">
								<div class="dropdown-messages-box">
									<a href="profile.html" class="pull-left">
										<img alt="image" class="img-circle" src="/Github/GEauth/Public/admin/img/a7.jpg">
									</a>
									<div class="media-body">
										<small class="pull-right">46小时前</small>
										<strong>小四</strong> 是不是只有我死了,你们才不骂爵迹
										<br>
										<small class="text-muted">3天前 2014.11.8</small>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="dropdown-messages-box">
									<a href="profile.html" class="pull-left">
										<img alt="image" class="img-circle" src="/Github/GEauth/Public/admin/img/a4.jpg">
									</a>
									<div class="media-body ">
										<small class="pull-right text-navy">25小时前</small>
										<strong>二愣子</strong> 呵呵
										<br>
										<small class="text-muted">昨天</small>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="text-center link-block">
									<a class="J_menuItem" href="mailbox.html">
										<i class="fa fa-envelope"></i> <strong> 查看所有消息</strong>
									</a>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
							<i class="fa fa-bell"></i> <span class="label label-primary">8</span>
						</a>
						<ul class="dropdown-menu dropdown-alerts">
							<li>
								<a href="mailbox.html">
									<div>
										<i class="fa fa-envelope fa-fw"></i> 您有16条未读消息
										<span class="pull-right text-muted small">4分钟前</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="profile.html">
									<div>
										<i class="fa fa-qq fa-fw"></i> 3条新回复
										<span class="pull-right text-muted small">12分钟钱</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<div class="text-center link-block">
									<a class="J_menuItem" href="notifications.html">
										<strong>查看所有 </strong>
										<i class="fa fa-angle-right"></i>
									</a>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
							<i class="fa fa-circle-o-notch"></i>
							<!--<span class="label label-primary">8</span>-->
						</a>
						<ul class="dropdown-menu dropdown-alerts" style="width:150px;">
							<li id="cache">
								<a href="#">
									<div>
										<i class="fa fa-minus-circle fa-fw"></i>清除缓存
									</div>
								</a>
							</li>
							<li>
								<a href="/Github/GEauth/admin.php/Home/Public/logout">
									<div>
										<i class="fa fa-minus-circle fa-fw"></i>退出
									</div>
								</a>
							</li>
						</ul>
					</li>
					</li>

				</ul>
			</nav>
		</div>
		<div class="row J_mainContent" id="content-main">
			<iframe id="J_iframe" width="100%" height="100%" src="index_v1.html?v=4.0" frameborder="0" data-id="index_v1.html" seamless></iframe>
		</div>
	</div>
	<!--右侧部分结束-->
</div>

<!-- 全局js -->
<script src="/Github/GEauth/Public/admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/Github/GEauth/Public/admin/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/Github/GEauth/Public/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/Github/GEauth/Public/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/Github/GEauth/Public/admin/js/plugins/layer/layer.js"></script>

<!-- 自定义js -->
<script src="/Github/GEauth/Public/admin/js/hAdmin.js?v=4.1.0"></script>
<script type="text/javascript" src="/Github/GEauth/Public/admin/js/index.js"></script>

<!-- 第三方插件 -->
<script src="/Github/GEauth/Public/admin/js/plugins/pace/pace.min.js"></script>

</body>

</html>
<script type="text/javascript">
	$(document).ready(function(){
        $("#cache").on('click',function(){
            $.ajax({
                type:'post',
                data:'',
                dateType:'json',
                url:"/Github/GEauth/admin.php/Home/public/clear_cache",
                success:function(msg){
                    layer.closeAll();
                    if(msg){
                        layer.msg('清除成功!');
                    }else{
                        layer.msg('哎呀，失败了');
					}
                },
                error:function(msg){
                    layer.closeAll();
                    layer.msg('哎呀，网络错误');
                },
                beforeSend:function(){
                    layer.load(1);
                }
            })
        });
	})
</script>