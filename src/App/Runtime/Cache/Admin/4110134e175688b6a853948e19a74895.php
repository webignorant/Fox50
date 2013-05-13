<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『ThinkPHP管理平台』By ThinkPHP <?php echo (THINK_VERSION); ?></title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/blue.css" />
<script type="text/javascript" src="__PUBLIC__/Js/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Think/ThinkAjax.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Form/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Form/CheckForm.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script language="JavaScript">
<!--
//指定当前组模块URL地址 
var URL = '__URL__';
var APP	 =	 '__APP__';
var GROUP	 =	 '__GROUP__';
var PUBLIC = '__PUBLIC__';
//-->
</script>
</head>

<body>

<div id="main" class="main" >
<div class="content">
<div class="title">编辑帐号 [ <a href="__URL__">返回列表</a> ]</div>
<table cellpadding=3 cellspacing=3>
<tr>
	<td class="tRight">重置密码：</td>
	<td class="tLeft" ><input type="text" name="resetPwd" > <INPUT type="button" value="重置密码" onclick="resetPwd()" class="submit" style="height:25px"></td>
</tr>
<tr>
	<td class="tRight" colspan="2"><hr></td>
</tr>
<tr>
	<td class="tRight" >用户名：</td>
	<td class="tLeft" ><input type="text" class="medium bLeftRequire"  check='^\S+$' warning="用户名不能为空,且不能含有空格" name="account" value="<?php echo ($vo["account"]); ?>" readonly></td>
</tr>
<form method='post' id="form1" name="form1" >
<tr>
	<td class="tRight" >昵称：</td>
	<td class="tLeft" ><input type="text" class="medium bLeft" name="nickname" value="<?php echo ($vo["nickname"]); ?>"></td>
</tr>

<tr>
	<td class="tRight">状态：</td>
	<td class="tLeft"><SELECT class="small bLeft"  name="status">
	<option <?php if(($vo["status"]) == "1"): ?>selected<?php endif; ?> value="1">启用</option>
	<option <?php if(($vo["status"]) == "0"): ?>selected<?php endif; ?> value="0">禁用</option>
	</SELECT></td>
</tr>
<tr>
	<td class="tRight tTop">备  注：</td>
	<td class="tLeft"><TEXTAREA class="large bLeft"  name="remark" rows="5" cols="57"><?php echo ($vo["remark"]); ?></textarea></td>
</tr>
<tr>
	<td></td>
	<td class="center"><input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>" >
	<input type="hidden" name="ajax" value="1">
	<input type="button" value="保 存" onclick="ThinkAjax.sendForm('form1','__URL__/update/')" class="small submit">
	<input type="reset" class="submit  small" value="清 空" >
	</td>
</tr>
</table>
</form>
</div>
</div>

<script language="JavaScript">
<!--
function resetPwd(){
var pass	 =	 $F('resetPwd');
ThinkAjax.send('__URL__/resetPwd/','ajax=1&id=<?php echo ($vo["id"]); ?>&password='+encodeURIComponent(pass));
}
//-->
</script>