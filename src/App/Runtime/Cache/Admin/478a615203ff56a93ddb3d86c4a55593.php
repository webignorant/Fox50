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
<div class="title"> 友情链接排序  [ <a href="__URL__">返回列表</a>]</div>
<script language="JavaScript">
<!--
function saveSort(){
    sl.ok();
    ThinkAjax.sendForm('form1','__URL__/saveSort/',addComplete);
    function addComplete(){
        timerObj  =setTimeout("window.parent.frames.main.location.reload();",2000);
    }
}
//-->
</script>

<script type="text/javascript" src="/fox50_synchronous/Public/Js/Form/SortSelect.js"></script>
<form method='post' name = 'form1' id="form1">
<div align="center">
<table class="order" cellpadding=0 cellspacing=0 width="350">
<tr><td height="5" colspan="2" class="topTd" ></td></tr>
<tr>
	<Th colspan=2 align="right"><div class="fLeft"><input name="search" type="text"></div>
<input type="button" value="查 询" onclick="sl.Search()" class="submit hMargin small " /></Th>
</tr>
<tr >
	<td width="75%" align="right">
	<div class="solid">
	<SELECT class="multiSelect" name="sort" size="15">
<?php if(is_array($sortList)): $i = 0; $__LIST__ = $sortList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?><option value="<?php echo ($link["id"]); ?>"><?php echo ($i); ?>.<?php echo ($link["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</SELECT></div></td>
	<td width="20" valign="top">
	<div style="margin-top:20px">
	<input type="button" value="第 一" onclick="sl.fnFirst()" class="submit vMargin small " />
<input type="button" value="上 移" onclick="sl.sortUp()" class="submit vMargin small " />
<input type="button" value="下 移" onclick="sl.sortDown()" class="submit vMargin small " />
<input type="button" value="最 后" onclick="sl.fnEnd()" class="submit vMargin small " />
<div class="fLeft vMargin"><input type="text" name="jumpNum" size="4"></div>
<input type="button" value="跳 转" onclick="sl.jump()" class="submit vMargin small " />
</div>
</td>
</tr>
<tr>
	<td colspan=2 align="center">
	<div style="width:85%"><input type="hidden" name="seqNoList" value="">
	<input type="hidden" name="ajax" VALUE="1">
<input type="button" value="确 定" onclick="saveSort()" class="submit hMargin small " />
<input type="reset" value="取 消" onclick="history.back()" class="submit hMargin small " />
</div>
</td>
</tr>
<tr><td height="5" colspan="2" class="topTd" ></td></tr>
</table>
</div>
</form>
<script language="JavaScript">
<!--
var sl = new SortSelect('form1','sort','search','jumpNum');
//-->
</script>
</div>
</div>