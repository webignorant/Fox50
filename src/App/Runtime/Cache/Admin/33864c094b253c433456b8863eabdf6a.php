<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『Fox50管理平台』By ThinkPHP <?php echo (THINK_VERSION); ?></title>
<link rel='stylesheet' type='text/css' href='__PUBLIC__/Css/style.css'>
<base target="main" />
</head>
<body>
<!-- 头部区域 -->
<div id="header" class="header">
<div class="headTitle" style="margin:8pt 10pt"> Fox50管理平台 </div>
	<!-- 功能导航区 -->
	<div class="topmenu">
<ul>

<?php if(is_array($nodeGroupList)): $i = 0; $__LIST__ = $nodeGroupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><li><span><a href="#" onClick="sethighlight(<?php echo ($i); ?>); parent.menu.location='__URL__/menu/tag/<?php echo ($key); ?>/title/<?php echo ($tag); ?>';return false;"><?php echo ($tag); ?></a></span></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>
</div>
	<div class="nav">
		欢迎你！<?php echo (session('loginUserName')); ?>
		<a href="<?php echo U('Admin/Public/password/');?>"><img src="__PUBLIC__/Images/checked_out.png" width="16" height="16" border="0" alt="" align="absmiddle"> 修改密码</a> 
		<a href="<?php echo U('Admin/Public/profile/');?>"><img SRC="__PUBLIC__/Images/write.gif" WIDTH="17" HEIGHT="16" BORDER="0" ALT="" align="absmiddle"> 修改资料</a> 
		<a href="<?php echo U('Admin/Public/logout/');?>" target="_top"><img SRC="__PUBLIC__/Images/error.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="" align="absmiddle"> 退 出</a>
	</div>
</div>
<script>
function goHome() {
	parent.location = APP+"/Index/Index/index";
}
function sethighlight(n) {
	var lis = document.getElementsByTagName('span');
	for(var i = 0; i < lis.length; i++) {
		lis[i].className = '';
	}
	n = n - 1;
	lis[n].className = 'current';
}
sethighlight(0);

</script>
</body>
</html>