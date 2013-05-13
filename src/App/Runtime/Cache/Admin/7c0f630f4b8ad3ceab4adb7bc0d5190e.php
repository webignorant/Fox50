<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<div id="main" class="main" >
<script language="JavaScript">
<!--
function checkName(){
	ThinkAjax.send('__URL__/checkName/','ajax=1&catname='+$F('catname'));
}
//-->
</script>
<div class="content">
<div class="title">添加公告 [ <a href="__URL__">返回列表</a> ]</div>
<table cellpadding=3 cellspacing=3>
<form method='post' id="form1" action="__URL__/insert/" >
<tr>
	<td class="tRight tTop">公  告：</td>
	<td class="tLeft"><TEXTAREA class="large bLeft"  name="content" rows="5" cols="57"></textarea></td>
</tr>
<tr>
	<td class="tRight tTop">是否启用：</td>
	<td class="tLeft"><SELECT class="small bLeft"  name="status">
	<option value="1">允许</option>
	<option value="0">禁止</option>
	</SELECT></td>
</tr>
<tr>
	<td></td>
	<td class="center">
	<input type="submit" value="保 存" class="small submit">
	<input type="reset" class="submit  small" value="清 空" >
	</td>
</tr>
</table>
</form>
</div>
</div>