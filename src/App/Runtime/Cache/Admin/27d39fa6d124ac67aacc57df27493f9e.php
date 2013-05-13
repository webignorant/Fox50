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
<div id="result" class="result none"></div>
<div class="title">编辑资料</div>
<div class="fLeft" style="width:90%;float:left">
<form method='post'  id="form1" action="<?php echo U('Admin/Public/change/');?>">
<table cellpadding=3 cellspacing=3>
<tr>
	<td class="tRight" >昵称：</td>
	<td class="tLeft" ><input type="text" class="medium bLeft"  name="nickname" value="<?php echo ($vo["nickname"]); ?>"></td>
</tr>
<tr>
	<td class="tRight">Email：</td>
	<td class="tLeft"><input type="text" class="large bLeft"  name="email" value="<?php echo ($vo["email"]); ?>"></td>
</tr>
<tr>
	<td class="tRight tTop">备  注：</td>
	<td class="tLeft"><TEXTAREA class="large bLeft"  name="remark" rows="5" cols="57"><?php echo ($vo["remark"]); ?></textarea></td>
</tr>
<tr>
	<td></td>
	<td class="center">
	<input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>">
	<input type="submit" value="保 存" class="submit small">
	<input type="reset" class="small submit hMargin" value="清 空" >
	</td>
</tr>
</table>
</form>
</div>
</div>
</div>