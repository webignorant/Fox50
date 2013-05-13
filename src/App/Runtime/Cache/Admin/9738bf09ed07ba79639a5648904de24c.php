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
<div class="main" >
<div class="content">
<TABLE id="checkList" class="list" cellpadding=0 cellspacing=0 >
<tr><td height="3" colspan="2" class="topTd" ></td></tr>
<TR class="row" ><th colspan="2" class="space">系统信息</th></tr>

<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">您上次登录时间</TD><TD><?php echo ($system['userlastLoginTime']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">登录次数</TD><TD><?php echo ($system['userlogincount']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">登录IP</TD><TD><?php echo ($system['last_login_ip']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">当前PHP的版本号</TD><TD><?php echo ($system['PHP_VERSION']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">当前服务器的操作系统</TD><TD><?php echo ($system['PHP_OS']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">服务器解译引擎</TD><TD><?php echo ($system['SERVER_SOFTWARE']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">当前运行的PHP程序所在服务器主机的名称</TD><TD><?php echo ($system['SERVER_NAME']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">正在浏览当前页面用户的主机名</TD><TD><?php echo ($system['REMOTE_HOST']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">正在游览的用户连接到服务器时所使用的端口</TD><TD><?php echo ($system['REMOTE_PORT']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">客户端IP</TD><TD><?php echo ($system['ip']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">服务器所使用的端口</TD><TD><?php echo ($system['SERVER_PORT']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">上传的最大数</TD><TD><?php echo ($system['MaxFile']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">数据库版本号</TD><TD><?php echo ($system['MysqlVersion']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">数据库地址</TD><TD><?php echo ($system['db_host']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">数据库用户</TD><TD><?php echo ($system['db_user']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">数据库</TD><TD><?php echo ($system['db_name']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">数据库端口</TD><TD><?php echo ($system['db_port']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">数据库类型</TD><TD><?php echo ($system['db_type']); ?></TD></TR>
<TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()"><TD width="15%">本站名称</TD><TD><?php echo ($system['cms_name']); ?></TD></TR>
<tr><td height="3" colspan="2" class="bottomTd"></td></tr>
</TABLE>
</div>
</div>
<!-- 主页面结束 -->