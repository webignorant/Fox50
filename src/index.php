<?php
//网站数据库安装检查
if(is_dir('Install/') && !file_exists('Install/install.lock')){
	header("Content-type: text/html; charset=utf-8");
	die ("<div style='border:2px solid green; background:#f1f1f1; padding:20px; margin:0 auto; margin-top:20px;width:800px;font-weight:bold;color:green;text-align:center;'>"
		."<h1>系统检测到您尚未安装视频网站数据库，<br /> 
		<a href='Install/install.php'>请点击进入安装页面</a></h1>"
		."</div> <br /><br />");
}
//初始化检查结束

//开启调试模式
define('APP_DEBUG',true);
define( 'fox50_ROOT', dirname( __FILE__ ).'/' );
//HTML路径
define('HTML_PATH','./Public/statics/Html/');
//ThinkPHP路径
define('THINK_PATH','./ThinkPHP/');
//定义项目名称和路径
define('APP_NAME', 'App');
define('APP_PATH', './App/');
// 加载框架入口文件
require( THINK_PATH.'ThinkPHP.php');
