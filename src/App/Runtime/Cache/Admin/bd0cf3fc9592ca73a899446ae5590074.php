<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
 <ul>
<form action="__URL__/index" method="post">
	  <li>主机:<input type="text" name="database" /></li>
    <li>用户:<input type="text" name="user" /></li>
    <li>密码:<input type="password" name="pass" /></li>
    <li>确认密码:<input type="password" name="nopass" /></li>
    <li>端口:<input type="text" name="port" /></li>
    <li><input type="submit" name="确认修改" />
</form>
</ul>
</body>
</html>