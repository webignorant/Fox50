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
<!-- 菜单区域  -->
<!-- 主页面开始 -->
<div id="main" class="main" >

<!-- 主体内容  -->
<div class="content" >
<div class="title">视频栏目回收站</div>
<!--  功能操作区域  -->
<div class="operate" >
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="edit" value="返回" onclick="goBack();" class="edit imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id=""  name="" value="还原" onclick="recycle()" class="button"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id=""  name="" value="永远删除" onclick="foreverdelete()" class="button"></div>
<!-- 查询区域 -->
<div class="fRig">
<form method='post' action="__URL__/recycleBin/">
<div class="fLeft"><span id="key"><input type="text" name="catname" title="栏目查询" class="medium" ></span></div>
<input type="hidden" name="status" value="-1" />
<div class="impBtn hMargin fLeft shadow" ><input type="submit" id="" name="search" value="查询" onclick="" class="search imgButton"></div>
</div>
<!-- 高级查询区域 -->
<div  id="searchM" class=" none search cBoth" >
</div>
</form>
</div>
<!-- 功能操作区域结束 -->

<!-- 列表显示区域  -->
<div class="list" >
<!-- Think 系统列表组件开始 -->
<table id="checkList" class="list" cellpadding=0 cellspacing=0 ><tr><td height="5" colspan="9" class="topTd" ></td></tr><tr class="row" ><th width="8"><input type="checkbox" id="check" onclick="CheckAll('checkList')"></th><th width="5%"><a href="javascript:sortBy('id','<?php echo ($sort); ?>','recycleBin')" title="按照编号<?php echo ($sortType); ?> ">编号<?php if(($order) == "id"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('catname','<?php echo ($sort); ?>','recycleBin')" title="按照栏目名称<?php echo ($sortType); ?> ">栏目名称<?php if(($order) == "catname"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="16%"><a href="javascript:sortBy('dateline','<?php echo ($sort); ?>','recycleBin')" title="按照添加时间<?php echo ($sortType); ?> ">添加时间<?php if(($order) == "dateline"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="5%"><a href="javascript:sortBy('displayorder','<?php echo ($sort); ?>','recycleBin')" title="按照显示顺序<?php echo ($sortType); ?> ">显示顺序<?php if(($order) == "displayorder"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('domain','<?php echo ($sort); ?>','recycleBin')" title="按照栏目域名<?php echo ($sortType); ?> ">栏目域名<?php if(($order) == "domain"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="7%"><a href="javascript:sortBy('navdisplay','<?php echo ($sort); ?>','recycleBin')" title="按照导航栏显示<?php echo ($sortType); ?> ">导航栏显示<?php if(($order) == "navdisplay"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="5%"><a href="javascript:sortBy('status','<?php echo ($sort); ?>','recycleBin')" title="按照状态<?php echo ($sortType); ?> ">状态<?php if(($order) == "status"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th >操作</th></tr><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$videocategory): $mod = ($i % 2 );++$i;?><tr class="row" onmouseover="over(event)" onmouseout="out(event)" onclick="change(event)" ><td><input type="checkbox" name="key"	value="<?php echo ($videocategory["id"]); ?>"></td><td><?php echo ($videocategory["id"]); ?></td><td><a href="javascript:edit('<?php echo (addslashes($videocategory["id"])); ?>')"><?php echo ($videocategory["catname"]); ?></a></td><td><?php echo (todate($videocategory["dateline"],'Y-m-d H#i#s')); ?></td><td><?php echo ($videocategory["displayorder"]); ?></td><td><?php echo ($videocategory["domain"]); ?></td><td><?php echo ($videocategory["navdisplay"]); ?></td><td><?php echo (getstatus($videocategory["status"])); ?></td><td> <?php echo (showstatus($videocategory["status"],$videocategory['id'])); ?>&nbsp;</td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td height="5" colspan="9" class="bottomTd"></td></tr></table>
<!-- Think 系统列表组件结束 -->

</div>
<!--  分页显示区域 -->
<div class="page"><?php echo ($page); ?></div>
<!-- 列表显示区域结束 -->
</div>
<!-- 主体内容结束 -->
</div>
<!-- 主页面结束 -->

<script>
function foreverdelete(id){
	var keyValue;
	if (id)
	{
		keyValue = id;
	}else {
		keyValue = getSelectCheckboxValues();
	}
	if (!keyValue)
	{
		alert('请选择删除项！');
		return false;
	}
	if (window.confirm('确实要删除选择项吗？'))
	{
        location.href = URL+'/foreverdelete/id/'+keyValue;
	}
}
function recycle(id){
	var keyValue;
	if (id)
	{
		keyValue = id;
	}else {
		keyValue = getSelectCheckboxValues();
	}
	if (!keyValue)
	{
		alert('请选择要还原的项目！');
		return false;
	}
	location.href = URL+"/recycle/id/"+keyValue;
}
function goBack(){
    location.href = URL;
}
</script>