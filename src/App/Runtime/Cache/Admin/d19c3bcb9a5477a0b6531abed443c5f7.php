<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『Fox50管理平台』By ThinkPHP <?php echo (THINK_VERSION); ?></title>
<frameset frameborder=0 framespacing=0 border=0 rows="50, *,32">
  <frame src="<?php echo U('Admin/Public/top');?>" name="top" frameborder=0 noresize scrolling='no' marginwidth=0 marginheight=0>
  <frameset frameborder=0  framespacing=0 border=0 cols="200,7, *" id="frame-body">
    <frame src="<?php echo U('Admin/Public/menu');?>" frameborder=0 id="menu-frame" name="menu">
    <frame src="<?php echo U('Admin/Public/drag');?>" id="drag-frame" name="drag-frame" frameborder="no" scrolling="no">
    <frame src="<?php echo U('Admin/Public/main');?>" frameborder=0 id="main-frame" name="main">
  </frameset>
  <frame src="<?php echo U('Admin/Public/footer');?>" name="footer" frameborder=0 noresize scrolling='no' marginwidth=0 marginheight=0>
</frameset>
<noframes></noframes>
</html>