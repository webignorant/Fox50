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
<script type="text/javascript" src="/fox50_synchronous/Public/Js/Form/MultiSelect.js"></script>
<!-- 主体内容  -->
<div class="content" >
<div class="title">组用户列表 [ <a href="__URL__">返 回</a> ]</div>
<!--  功能组区域  -->
<script language="JavaScript">
<!--
function saveAccess(){
ThinkAjax.sendForm('form1','__URL__/setUser/');
}
function goType(type){
	window.location = '?type='+type;
}
//-->
</script>
<div id="result" class="result none"></div>
<form method=post id="form1">
<table class="select" style="width:265px" ALIGN='center'><tr><td height="3" colspan="3" class="topTd" ></td></tr><tr><th class="tRight">当前组：<select id="" name="groupId" onchange="location.href = '__URL__/user/id/'+this.options[this.selectedIndex].value;" ondblclick="" class="medium" ><option value="" >选择组</option><?php  foreach($groupList as $key=>$val) { if(!empty($selectGroupId) && ($selectGroupId == $key || in_array($key,$selectGroupId))) { ?><option selected="selected" value="<?php echo $key ?>"><?php echo $val ?></option><?php }else { ?><option value="<?php echo $key ?>"><?php echo $val ?></option><?php } } ?></select>
</th></tr>
<tr><td >
<select id="sourceS" name="groupUserId[]" ondblclick="" onchange="" multiple="multiple" class="multiSelect" size="15" ><?php  foreach($userList as $key=>$val) { if(!empty($groupUserList) && ($groupUserList == $key || in_array($key,$groupUserList))) { ?><option selected="selected" value="<?php echo $key ?>"><?php echo $val ?></option><?php }else { ?><option value="<?php echo $key ?>"><?php echo $val ?></option><?php } } ?></select>
</td>
</tr>
<tr>
<td  class="row tCenter" >
<input type="button" onclick="allSelect()" value="全 选" class="submit  ">&nbsp;
<input type="button" onclick="InverSelect()" value="反 选" class="submit  ">&nbsp;
<input type="button" onclick="allUnSelect()" value="全 否" class="submit ">&nbsp;
<input type="button" onclick="saveAccess()" value="保 存" class="submit ">&nbsp;
<input type="hidden" name="groupId" VALUE="<?php echo ($_GET['id']); ?>" >
<input type="hidden" name="ajax" VALUE="1">
</td>
</tr>
<tr>
<td height="3" class="bottomTd" >
</td>
</tr>
</table>
</form>
</div>
<!-- 主体内容结束 -->
</div>
<!-- 主页面结束 -->