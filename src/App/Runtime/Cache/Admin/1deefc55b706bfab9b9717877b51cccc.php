<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fox50管理系统登录</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
<script type="text/javascript" src="__PUBLIC__/Js/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Think/ThinkAjax.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
 <script language="JavaScript">
<!--
var PUBLIC	 =	 '__PUBLIC__';
function keydown(e){
	var e = e || event;
	if (e.keyCode==13)
	{
	ThinkAjax.sendForm('form1','__URL__/checkLogin/',loginHandle,'result');
	}
}
function fleshVerify(){ 
	//重载验证码
	var timenow = new Date().getTime();
	$('verifyImg').src= '__URL__/verify/'+timenow;
}
//-->
</script>
</head>
<body onLoad="document.login.account.focus()" >
<form method='post' name="login" id="form1" ACTION="<?php echo U('Admin/Public/checkLogin');?>">
<div class="tCenter hMargin">
<table id="checkList" class="login shadow" cellpadding=0 cellspacing=0 >
<tr><td height="3" colspan="2" class="topTd" ></td></tr>
<tr class="row" ><Th colspan="2" class="tCenter space" ><img src="__PUBLIC__/Images/preview_f2.png" width="32" height="32" border="0" alt="" align="absmiddle"> Fox50管理系统登录</th></tr>
<tr><td height="3" colspan="2" class="topTd" ></td></tr>
<tr class="row" ><td class="tRight" width="25%">帐 号：</td><td><input type="text" class="medium bLeftRequire" check="Require" warning="请输入帐号" name="account"></td></tr>
<tr class="row" ><td class="tRight">密 码：</td><td><input type="password" class="medium bLeftRequire" check="Require" warning="请输入密码" name="password"></td></tr>
<tr class="row" ><td class="tRight">验证码：</td><td><input type="text" onKeyDown="keydown(event)" class="small bLeftRequire" check="Require" warning="请输入验证码" name="verify"> <img id="verifyImg" SRC="__URL__/verify/" onClick="fleshVerify()" BORDER="0" ALT="点击刷新验证码" style="cursor:pointer" align="absmiddle"></td></tr>
<tr class="row" ><td class="tCenter" align="justify" colspan="2">
<input type="submit" value="登 录" class="submit medium hMargin">
</td></tr>
<tr><td height="3" colspan="2" class="bottomTd" ></td></tr>
</table>
<div class="result">欢迎访问Fox50视频网站后台管理系统。仅提供管理员使用，普通用户请不要访问此页面！</div>
</div>
</form>
</body>
</html>