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
<div class="title">视频列表</div>
<!--  功能操作区域  -->
<div class="operate" >
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="新增" onclick="upload();" class="add imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="edit" value="编辑" onclick="edit()" class="edit imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="delete" value="删除" onclick="del()" class="delete imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="刷新" onclick="javascript:location.reload();" class="add imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="入库" onclick="addDb();" class="add imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="开启" onclick="batchOpen();" class="add imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="关闭" onclick="batchClose();" class="add imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="sort" value="回收站" onclick="recycleBin()" class="sort imgButton"></div>
<!-- 查询区域 -->
<div class="fRig">
<form method='post' action="__URL__">
<div class="fLeft"><span id="key"><input type="text" name="title" title="视频查询" class="medium" ></span></div>
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
<table id="checkList" class="list" cellpadding=0 cellspacing=0 ><tr><td height="5" colspan="10" class="topTd" ></td></tr><tr class="row" ><th width="8"><input type="checkbox" id="check" onclick="CheckAll('checkList')"></th><th width="4%"><a href="javascript:sortBy('vid','<?php echo ($sort); ?>','index')" title="按照编号<?php echo ($sortType); ?> ">编号<?php if(($order) == "vid"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="12%"><a href="javascript:sortBy('title','<?php echo ($sort); ?>','index')" title="按照标题<?php echo ($sortType); ?> ">标题<?php if(($order) == "title"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('username','<?php echo ($sort); ?>','index')" title="按照发布人<?php echo ($sortType); ?> ">发布人<?php if(($order) == "username"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="10%"><a href="javascript:sortBy('dateline','<?php echo ($sort); ?>','index')" title="按照添加时间<?php echo ($sortType); ?> ">添加时间<?php if(($order) == "dateline"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="6%"><a href="javascript:sortBy('actor','<?php echo ($sort); ?>','index')" title="按照主演<?php echo ($sortType); ?> ">主演<?php if(($order) == "actor"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="toDate='Y-m-d'"><a href="javascript:sortBy('year','<?php echo ($sort); ?>','index')" title="按照4%<?php echo ($sortType); ?> ">发行年份<?php if(($order) == "year"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="44%"><a href="javascript:sortBy('about','<?php echo ($sort); ?>','index')" title="按照内容简介<?php echo ($sortType); ?> ">内容简介<?php if(($order) == "about"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="2%"><a href="javascript:sortBy('status','<?php echo ($sort); ?>','index')" title="按照状态<?php echo ($sortType); ?> ">状态<?php if(($order) == "status"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th >操作</th></tr><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><tr class="row" onmouseover="over(event)" onmouseout="out(event)" onclick="change(event)" ><td><input type="checkbox" name="key"	value="<?php echo ($video["vid"]); ?>"></td><td><?php echo ($video["vid"]); ?></td><td><a href="javascript:edit('<?php echo (addslashes($video["vid"])); ?>')"><?php echo ($video["title"]); ?></a></td><td><?php echo ($video["username"]); ?></td><td><?php echo (todate($video["dateline"],'Y-m-d H#i#s')); ?></td><td><?php echo ($video["actor"]); ?></td><td><?php echo ($video["year"]); ?></td><td><?php echo ($video["about"]); ?></td><td><?php echo ($video["status"]); ?></td><td> <?php echo (showrecommended($video["setRecommended"],$video['recommended'],$video['vid'],$video['status'])); ?>&nbsp; <?php echo (showvideostatus($video["setVideoinfo"],$video['status'],$video['vid'])); ?>&nbsp; <?php echo (lookvideos($video["lookvideo"],$video['status'],$video['vid'])); ?>&nbsp;</td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td height="5" colspan="10" class="bottomTd"></td></tr></table>
<!-- Think 系统列表组件结束 -->

</div>
<!--  分页显示区域 -->
<div class="page"><?php echo ($page); ?></div>
<!-- 列表显示区域结束 -->
</div>
<!-- 主体内容结束 -->
</div>
<!-- 主页面结束 -->

<!--处理提示层-->
<div id="processInfo" class="none" style="width:600px;height:160px;position:absolute;left:0px;top:0px;margin:auto;font-size:72px;text-align:center;border:1px solid #3FF;">
    <img src="__PUBLIC__/Images/fox/process.png" />
    任务处理中...
</div>

<script language="JavaScript">
function upload(id){
	if (id)
	{
		 location.href  = '<?php echo U('Admin/Video/uploadindex');?>';
	}else{
		 location.href  = '<?php echo U('Admin/Video/uploadindex');?>';
	}
}
function setRecommended(situation,vid,status){
    if(status == 0){
        //location.href = '<?php echo U('Admin/VideoRecommended/setVideoRecommended');?>/situation/'+situation+'/vid/'+vid;
        ThinkAjax.send("<?php echo U('Admin/VideoRecommended/setVideoRecommended');?>",'ajax=1&situation='+situation+'&vid=' + vid, reloadWebPage);
    }else{
        alert('视频没有审核通过！');
    }
}

function setVideoinfo(status,vid){
    showProcessInfo();
	if(status == 1){
		ThinkAjax.send("<?php echo U('Admin/Video/setVideoStatus');?>",'ajax=1&vid=' + vid, reloadWebPage);
	}else if(status == 2){
	  //ThinkAjax.send("<?php echo U('Admin/Video/transcoding');?>",'ajax=1&vid=' + vid);
	  location.href = '<?php echo U('Admin/Video/transcoding');?>/vid/'+vid, reloadWebPage;
	}else if(status == 0){
		ThinkAjax.send("<?php echo U('Admin/Video/setVideoStatus');?>",'ajax=1&type=tg&vid=' + vid, reloadWebPage);
	}else if(status == 3){
	  //  ThinkAjax.send("<?php echo U('Admin/Video/setVideodata');?>",'ajax=1&vid=' + vid);
		location.href = '<?php echo U('Admin/Video/setVideodata');?>/vid/'+vid;
	}
}
//ajax处理完成后2秒钟重刷
function reloadWebPage(){
    timerObj  =setTimeout("window.parent.frames.main.location.reload();",2000);
}

function lookvideo(status,vid){
   	location.href = '<?php echo U('Home/Play/index');?>/vid/'+vid;
    window.parent.parent.menu.document.getElementById('menu-header').style.display = 'block';
   window.parent.parent.menu.changevid = vid;
}

function del(id){
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
        //location.href =  URL+"/delete/vid/"+keyValue;
		ThinkAjax.send(URL+"/delete/","vid="+keyValue+'&ajax=1',doDelete);
	}
}
function addDb(id){
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

	if (window.confirm('确实要入库选择项吗？'))
	{
        showProcessInfo();
        location.href =  URL+"/setVideodata/vid/"+keyValue;
		//ThinkAjax.send(URL+"/delete/","vid="+keyValue+'&ajax=1',doDelete);
	}
}
function batchOpen(id){
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

	if (window.confirm('确实要开启选择项吗？'))
	{
        location.href =  URL+"/setVideoStatus/vid/"+keyValue;
		//ThinkAjax.send("<?php echo U('Admin/Video/setVideoStatus');?>",'ajax=1&vid=' + id, reloadWebPage);
	}
}
function batchClose(id){
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

	if (window.confirm('确实要关闭选择项吗？'))
	{
        location.href =  URL+"/setVideoStatus/vid/"+keyValue+'/type/tg';
        //ThinkAjax.send("<?php echo U('Admin/Video/setVideoStatus');?>",'type=tg&ajax=1&vid=' + id, reloadWebPage);
	}
}
function recycleBin(){
    location.href = URL+'/recycleBin/';
}
</script>

<script>
//显示任务处理提示层
function showProcessInfo(){
    parentWidth = document.documentElement.clientWidth;
    parentHeight = document.documentElement.clientHeight;
    document.getElementById('processInfo').style.display = 'block';
    divWidth = document.getElementById('processInfo').offsetWidth;
    divHeight = document.getElementById('processInfo').offsetHeight;
    showLeft = (parentWidth - divWidth)/2;
    showTop = (parentHeight - divHeight)/2;
    document.getElementById('processInfo').style.pixelLeft  = showLeft;
    document.getElementById('processInfo').style.pixelTop  = showTop;
}
</script>