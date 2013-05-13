<?php
header("Content-Type:text/html;   charset=utf-8"); 
$mode=$_GET['mode'];
$link=mysql_connect("129.1.3.3","fox50ch","chaihua123456") or die("数据库连接失败".mysql_error());
mysql_query("set names utf8");
/*弃用
if(mysql_create_db("chipcorecommunity",$link))
{
	echo "创建数据库成功"."<br>";
}else
{
	echo "创建数据库失败"."<br>";
	exit;
}
*/
/*备用
if(mysql_query("CREATE DATABASE if not exists `cluster` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;",$link))
{
	echo "创建数据库成功！"."<br>";
}else
{
	echo "创建数据库失败！".mysql_error();
	exit;
}
*/

if(mysql_query("use fox50;",$link))
{
	echo "选择数据库成功"."<br>";
}else
{
	echo "选择数据库失败".mysql_error();
  exit;
}
//

//显示所有数据库名称
if($mode!="setup")
{
	$result = mysql_query("SHOW TABLES FROM fox50",$link);
	echo "已存在数据库列表：";
	echo "<hr>";
	while($value=mysql_fetch_row($result))
	{
		echo "表名：$value[0]"."<br>";
	}
	echo "<hr>";
	if($result)
	{
		exit;
	}
}
//

//创建common_application表
if(mysql_query("drop table if exists fox50_access;"))
{
  echo "清除fox50_access表成功"."<br>";
}else
{
  echo "清除fox50_access表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
",$link))
{
	echo "创建fox50_access表成功"."<br>";
}else
{
	echo "创建fox50_access表失败".mysql_error()."<br>";
	exit;
}

//创建fox50_friendlink表
if(mysql_query("drop table if exists fox50_friendlink;"))
{
  echo "清除fox50_friendlink表成功"."<br>";
}else
{
  echo "清除fox50_friendlink表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_friendlink` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '站点名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '站点URL',
  `description` mediumtext NOT NULL COMMENT '文字说明',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo地址',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='友情链接数据表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_friendlink表成功"."<br>";
}else
{
  echo "创建fox50_friendlink表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_group表
if(mysql_query("drop table if exists fox50_group;"))
{
  echo "清除fox50_group表成功"."<br>";
}else
{
  echo "清除fox50_group表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
",$link))
{
  echo "创建fox50_group表成功"."<br>";
}else
{
  echo "创建fox50_group表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
INSERT INTO `fox50_group` (`id`, `name`, `title`, `create_time`, `update_time`, `status`, `sort`, `show`) VALUES
(1, 'system', '系统设置', 1222841259, 0, 1, 0, 0),
(2, 'setting', '网站管理', 1222841259, 0, 1, 0, 0),
(3, 'user', '用户管理', 1222841259, 0, 1, 0, 0),
(4, 'video', '视频管理', 1222841259, 0, 1, 0, 0);
",$link))
{
	echo "在fox50_group表插入数据成功"."<br>";
}else
{
	echo "在fox50_group表插入数据失败".mysql_error()."<br>";
	exit;
}

//创建fox50_node表
if(mysql_query("drop table if exists fox50_node;"))
{
  echo "清除fox50_node表成功"."<br>";
}else
{
  echo "清除fox50_node表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=500 ;
",$link))
{
  echo "创建friendgroup表成功"."<br>";
}else
{
  echo "创建friendgroup表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
INSERT INTO `fox50_node` (`id`, `name`, `title`, `status`, `remark`, `sort`, `pid`, `level`, `type`, `group_id`) VALUES
(1, 'Admin', '后台系统', 1, '属于项目应用', 0, 0, 1, 0, 0),
(2, 'Home', '前台网站', 1, '属于项目应用', 1, 0, 1, 0, 0),

(10, 'Index', '管理首页', 1, '属于系统设置组', 1, 1, 2, 0, 1),
(11, 'Basic', '基本设置', 1, '属于系统设置组', 2, 1, 2, 0, 1),
(12, 'Database', '数据库设置', 1, '属于系统设置组', 3, 1, 2, 0, 1),
(13, 'Sqlbak', '数据备份恢复', 1, '属于系统设置组', 4, 1, 2, 0, 1),
(14, 'Node', '节点设置', 1, '属于系统设置组', 5, 1, 2, 0, 1),
(15, 'Log', '系统日志', 1, '属于系统设置组', 6, 1, 2, 0, 1),
(21, 'Advertisement', '广告位管理', 0, '属于网站管理组', 0, 1, 2, 0, 2),
(22, 'Friendlink', '友情链接管理', 1, '属于网站管理组', 2, 1, 2, 0, 2),
(23, 'VideoComment', '评论管理', 1, '属于网站管理组', 3, 1, 2, 0, 2),
(24, 'Notice', '公告管理', 1, '属于网站管理组', 4, 1, 2, 0, 2),
(31, 'User', '用户列表', 1, '属于用户管理组', 1, 1, 2, 0, 3),
(32, 'Role', '用户角色', 1, '属于用户管理组', 2, 1, 2, 0, 3),
(33, 'Admin', '管理员列表', 1, '属于用户管理组', 3, 1, 2, 0, 3),
(41, 'Video', '视频列表', 1, '属于视频管理组', 1, 1, 2, 0, 4),
(42, 'VideoCategory', '视频栏目', 1, '属于视频管理组', 2, 1, 2, 0, 4),
(43, 'VideoType', '视频类型', 1, '属于视频管理组', 3, 1, 2, 0, 4),
(44, 'VideoRegion', '视频地区', 1, '属于视频管理组', 4, 1, 2, 0, 4),
(45, 'VideoRecommended', '视频推荐', 1, '属于视频管理组', 5, 1, 2, 0, 4),

(90, 'Public', '公共模块', 1, '属于公共组', 2, 1, 2, 0, 0),

(101, 'index', '管理首页默认方法', 1, '属于网站基本信息模块的方法', 1, 10, 3, 0, 0),

(111, 'index', '网站基本信息默认方法', 1, '属于网站基本信息模块的方法', 1, 11, 3, 0, 0),
(112, 'insert', '网站基本信息添加方法', 1, '属于网站基本信息模块的方法', 2, 11, 3, 0, 0),
(113, 'delete', '网站基本信息删除方法', 1, '属于网站基本信息模块的方法', 3, 11, 3, 0, 0),
(114, 'update', '网站基本信息更新方法', 1, '属于网站基本信息模块的方法', 4, 11, 3, 0, 0),

(121, 'index', '数据库设置默认方法', 1, '属于数据库设置模块的方法', 1, 12, 3, 0, 0),

(131, 'index', '数据备份恢复默认方法', 1, '属于数据备份恢复模块的方法', 1, 13, 3, 0, 0),

(141, 'index', '节点设置默认方法', 1, '属于节点设置模块的方法', 1, 14, 3, 0, 0),
(142, 'insert', '节点设置添加方法', 1, '属于节点设置模块的方法', 2, 14, 3, 0, 0),
(143, 'delete', '节点设置删除方法', 1, '属于节点设置模块的方法', 3, 14, 3, 0, 0),
(144, 'update', '节点设置更新方法', 1, '属于节点设置模块的方法', 4, 14, 3, 0, 0),

(151, 'index', '系统日记默认方法', 1, '属于系统日记模块的方法', 1, 15, 3, 0, 0),

(211, 'index', '广告设置默认方法', 0, '属于广告设置模块的方法', 1, 21, 3, 0, 0),
(212, 'insert', '广告设置添加方法', 0, '属于广告设置模块的方法', 2, 21, 3, 0, 0),
(213, 'delete', '广告设置删除方法', 0, '属于广告设置模块的方法', 3, 21, 3, 0, 0),
(214, 'update', '广告设置更新方法', 0, '属于广告设置模块的方法', 4, 21, 3, 0, 0),

(221, 'index', '友情链接设置默认方法', 1, '属于友情链接设置模块的方法', 1, 22, 3, 0, 0),
(222, 'insert', '友情链接设置添加方法', 1, '属于友情链接设置模块的方法', 2, 22, 3, 0, 0),
(223, 'delete', '友情链接设置删除方法', 1, '属于友情链接设置模块的方法', 3, 22, 3, 0, 0),
(224, 'update', '友情链接设置更新方法', 1, '属于友情链接设置模块的方法', 4, 22, 3, 0, 0),

(231, 'index', '评论设置默认方法', 1, '属于评论设置模块的方法', 1, 23, 3, 0, 0),
(232, 'insert', '评论设置添加方法', 1, '属于评论设置模块的方法', 2, 23, 3, 0, 0),
(233, 'delete', '评论设置删除方法', 1, '属于评论设置模块的方法', 3, 23, 3, 0, 0),
(234, 'update', '评论设置更新方法', 1, '属于评论设置模块的方法', 4, 23, 3, 0, 0),

(241, 'index', '公告设置默认方法', 1, '属于公告设置模块的方法', 1, 24, 3, 0, 0),
(242, 'insert', '公告设置添加方法', 1, '属于公告设置模块的方法', 2, 24, 3, 0, 0),
(243, 'delete', '公告设置删除方法', 1, '属于公告设置模块的方法', 3, 24, 3, 0, 0),
(244, 'update', '公告设置更新方法', 1, '属于公告设置模块的方法', 4, 24, 3, 0, 0),

(311, 'index', '用户管理默认方法', 1, '属于用户管理模块的方法', 1, 31, 3, 0, 0),
(312, 'insert', '用户管理添加方法', 1, '属于用户管理模块的方法', 2, 31, 3, 0, 0),
(313, 'delete', '用户管理删除方法', 1, '属于用户管理模块的方法', 3, 31, 3, 0, 0),
(314, 'update', '用户管理更新方法', 1, '属于用户管理模块的方法', 4, 31, 3, 0, 0),

(321, 'index', '角色组管理默认方法', 1, '属于角色组管理模块的方法', 1, 32, 3, 0, 0),
(322, 'insert', '角色组管理添加方法', 1, '属于角色组管理模块的方法', 2, 32, 3, 0, 0),
(323, 'delete', '角色组管理删除方法', 1, '属于角色组管理模块的方法', 3, 32, 3, 0, 0),
(324, 'update', '角色组管理更新方法', 1, '属于角色组管理模块的方法', 4, 32, 3, 0, 0),

(331, 'index', '管理员组管理默认方法', 1, '属于管理员组管理模块的方法', 1, 33, 3, 0, 0),
(332, 'insert', '管理员组管理添加方法', 1, '属于管理员组管理模块的方法', 2, 33, 3, 0, 0),
(333, 'delete', '管理员组管理删除方法', 1, '属于管理员组管理模块的方法', 3, 33, 3, 0, 0),
(334, 'update', '管理员组管理更新方法', 1, '属于管理员组管理模块的方法', 4, 33, 3, 0, 0),

(411, 'index', '视频管理默认方法', 1, '属于视频管理模块的方法', 1, 41, 3, 0, 0),
(412, 'insert', '视频管理添加方法', 1, '属于视频管理模块的方法', 2, 41, 3, 0, 0),
(413, 'delete', '视频管理删除方法', 1, '属于视频管理模块的方法', 3, 41, 3, 0, 0),
(414, 'update', '视频管理更新方法', 1, '属于视频管理模块的方法', 4, 41, 3, 0, 0),

(421, 'index', '视频栏目管理默认方法', 1, '属于视频栏目管理模块的方法', 1, 42, 3, 0, 0),
(422, 'insert', '视频栏目管理添加方法', 1, '属于视频栏目管理模块的方法', 2, 42, 3, 0, 0),
(423, 'delete', '视频栏目管理删除方法', 1, '属于视频栏目管理模块的方法', 3, 42, 3, 0, 0),
(424, 'update', '视频栏目管理更新方法', 1, '属于视频栏目管理模块的方法', 4, 42, 3, 0, 0),

(431, 'index', '视频类型管理默认方法', 1, '属于视频类型管理模块的方法', 1, 43, 3, 0, 0),
(432, 'insert', '视频类型管理添加方法', 1, '属于视频类型管理模块的方法', 2, 43, 3, 0, 0),
(433, 'delete', '视频类型管理删除方法', 1, '属于视频类型管理模块的方法', 3, 43, 3, 0, 0),
(434, 'update', '视频类型管理更新方法', 1, '属于视频类型管理模块的方法', 4, 43, 3, 0, 0),

(441, 'index', '视频地区管理默认方法', 1, '属于视频地区管理模块的方法', 1, 44, 3, 0, 0),
(442, 'insert', '视频地区管理添加方法', 1, '属于视频地区管理模块的方法', 2, 44, 3, 0, 0),
(443, 'delete', '视频地区管理删除方法', 1, '属于视频地区管理模块的方法', 3, 44, 3, 0, 0),
(444, 'update', '视频地区管理更新方法', 1, '属于视频地区管理模块的方法', 4, 44, 3, 0, 0),

(451, 'index', '视频推荐管理默认方法', 1, '属于视频推荐管理模块的方法', 1, 45, 3, 0, 0),
(452, 'insert', '视频推荐管理添加方法', 1, '属于视频推荐管理模块的方法', 2, 45, 3, 0, 0),
(453, 'delete', '视频推荐管理删除方法', 1, '属于视频推荐管理模块的方法', 3, 45, 3, 0, 0),
(454, 'update', '视频推荐管理更新方法', 1, '属于视频推荐管理模块的方法', 4, 45, 3, 0, 0);
",$link))
{
	echo "在fox50_node表插入数据成功"."<br>";
}else
{
	echo "在fox50_node表插入数据失败".mysql_error()."<br>";
	exit;
}

//创建fox50_notice表
if(mysql_query("drop table if exists fox50_notice;"))
{
  echo "清除fox50_notice表成功"."<br>";
}else
{
  echo "清除fox50_notice表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_notice` (
  `id` smallint(8) NOT NULL AUTO_INCREMENT COMMENT '公告ID',
  `uid` smallint(8) NOT NULL COMMENT '发布者ID',
  `dateline` int(10) NOT NULL COMMENT '发布时间',
  `content` varchar(250) NOT NULL COMMENT '公告内容',
  `who` smallint(5) NOT NULL COMMENT '放置位置',
  `status` tinyint(1) NOT NULL COMMENT '状态(1为启用，2为禁用)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公告表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_notice表成功"."<br>";
}else
{
  echo "创建fox50_notice表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_role表
if(mysql_query("drop table if exists fox50_role;"))
{
  echo "清除fox50_role表成功"."<br>";
}else
{
  echo "清除fox50_role表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ename` varchar(5) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `ename` (`ename`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
",$link))
{
  echo "创建fox50_role表成功"."<br>";
}else
{
  echo "创建fox50_role表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
INSERT INTO `fox50_role` (`id`, `name`, `pid`, `status`, `remark`, `ename`, `create_time`, `update_time`) VALUES
(1, '管理组', 0, 1, '', '', 1208784792, 1254325558),
(2, '用户组', 0, 1, '', '', 1215496283, 1254325566),
(3, '游客组', 0, 1, '', NULL, 1254325787, 0);
",$link))
{
	echo "在fox50_role表插入数据成功"."<br>";
}else
{
	echo "在fox50_role表插入数据失败".mysql_error()."<br>";
	exit;
}

//创建fox50_role_user表
if(mysql_query("drop table if exists fox50_role_user;"))
{
  echo "清除fox50_role_user表成功"."<br>";
}else
{
  echo "清除fox50_role_user表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
",$link))
{
  echo "创建fox50_role_user表成功"."<br>";
}else
{
  echo "创建fox50_role_user表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_setting表
if(mysql_query("drop table if exists fox50_setting;"))
{
  echo "清除fox50_setting表成功"."<br>";
}else
{
  echo "清除fox50_setting表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_setting` (
  `skey` varchar(255) NOT NULL DEFAULT '' COMMENT '设置名',
  `svalue` text NOT NULL COMMENT '设置值',
  PRIMARY KEY (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点设置数据表';
",$link))
{
  echo "创建fox50_setting表成功"."<br>";
}else
{
  echo "创建fox50_setting表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_user表
if(mysql_query("drop table if exists fox50_user;"))
{
  echo "清除fox50_user表成功"."<br>";
}else
{
  echo "清除fox50_user表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `bind_account` varchar(50) NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` mediumint(8) unsigned DEFAULT '0',
  `verify` varchar(32) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `type_id` tinyint(2) unsigned DEFAULT '0',
  `info` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_user表成功"."<br>";
}else
{
  echo "创建fox50_user表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_video表
if(mysql_query("drop table if exists fox50_video;"))
{
  echo "清除fox50_video表成功"."<br>";
}else
{
  echo "清除fox50_video表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video` (
  `vid` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '视频ID',
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属栏目ID',
  `typeid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属视频类型ID',
  `regionid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属地区ID',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户ID',
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '所属用户名',
  `specialid` mediumint(8) unsigned NOT NULL COMMENT '所属专辑ID',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '视频发布时间',
  `postip` varchar(255) NOT NULL DEFAULT '' COMMENT '视频发布IP',
  `filename` varchar(255) NOT NULL DEFAULT '' COMMENT '视频文件名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '视频标题',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '视频类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '视频大小',
  `filepath` varchar(255) NOT NULL DEFAULT '' COMMENT '视频路径',
  `thumb` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有缩略图',
  `remote` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为远程视频',
  `actor` varchar(50) NOT NULL COMMENT '主演/演员',
  `director` varchar(15) NOT NULL COMMENT '导演',
  `year` mediumint(5) NOT NULL COMMENT '发行年份',
  `about` varchar(200) NOT NULL COMMENT '内容简介',
  `img` varchar(255) NOT NULL COMMENT '视频封面图片',
  `definition` varchar(10) NOT NULL DEFAULT '0' COMMENT '清晰度',
  `playtime` varchar(10) NOT NULL COMMENT '播放时长',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '视频状态\r\n     0=已通过\r\n     1=待审核\r\n     2=已忽略',
  PRIMARY KEY (`vid`),
  KEY `uid` (`uid`),
  KEY `specialid` (`specialid`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频信息表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_video表成功"."<br>";
}else
{
  echo "创建fox50_video表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_video_category表
if(mysql_query("drop table if exists fox50_video_category;"))
{
  echo "清除fox50_video_category表成功"."<br>";
}else
{
  echo "清除fox50_video_category表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `upid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级栏目ID',
  `catname` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频数',
  `allowcomment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许评论',
  `displayorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `notinheritedarticle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否继承上级文章管理权限',
  `notinheritedblock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否继承上级模块管理权限',
  `domain` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目域名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '自定义链接地址',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加人用户ID',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '添加人用户名',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `closed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关闭',
  `shownav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在头部的导航中显示',
  `description` text NOT NULL COMMENT 'SEO 描述',
  `seotitle` text NOT NULL COMMENT 'SEO 标题',
  `keyword` text NOT NULL COMMENT 'SEO 关键字',
  `primaltplname` varchar(255) NOT NULL DEFAULT '' COMMENT '模板名',
  `disallowpublish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许发布视频',
  `foldername` varchar(255) NOT NULL DEFAULT '' COMMENT '生成的文件夹名称',
  `perpage` smallint(6) NOT NULL DEFAULT '0' COMMENT '每页显示视频数',
  `maxpages` smallint(6) NOT NULL DEFAULT '0' COMMENT '最大页数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频栏目表' AUTO_INCREMENT=21 ;
",$link))
{
  echo "创建fox50_video_category表成功"."<br>";
}else
{
  echo "创建fox50_video_category表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
INSERT INTO `fox50_video_category` (`id`, `upid`, `catname`, `num`, `allowcomment`, `displayorder`, `notinheritedarticle`, `notinheritedblock`, `domain`, `url`, `uid`, `username`, `dateline`, `closed`, `shownav`, `description`, `seotitle`, `keyword`, `primaltplname`, `disallowpublish`, `foldername`, `perpage`, `maxpages`) VALUES
(1, 0, '电影', 0, 1, 1, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频电影频道-最好的享受', 'Fox50视频电影频道', 'Fox50', '', 0, '', 0, 0),
(2, 0, '电视剧', 0, 1, 2, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频连续剧频道-最好的享受', 'Fox50视频电视剧频道', 'Fox50', '', 0, '', 0, 0),
(3, 0, '动漫', 0, 1, 4, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频动漫频道-最好的享受', 'Fox50视频动漫频道', 'Fox50', '', 0, '', 0, 0),
(4, 0, '娱乐', 0, 1, 9, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频娱乐频道-最好的享受', 'Fox50视频娱乐频道', 'Fox50', '', 0, '', 0, 0),
(5, 0, '资讯', 0, 1, 8, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频资讯频道-最好的享受', 'Fox50视频资讯频道', 'Fox50', '', 0, '', 0, 0),
(6, 0, '生活', 0, 1, 15, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频生活频道-最好的享受', 'Fox50视频生活频道', 'Fox50', '', 0, '', 0, 0);
",$link))
{
	echo "在fox50_video_category表插入数据成功"."<br>";
}else
{
	echo "在fox50_video_category表插入数据失败".mysql_error()."<br>";
	exit;
}

//创建fox50_video_comment表
if(mysql_query("drop table if exists fox50_video_comment;"))
{
  echo "清除fox50_video_comment表成功"."<br>";
}else
{
  echo "清除fox50_video_comment表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_comment` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `vid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频ID',
  `idtype` varchar(20) NOT NULL DEFAULT '' COMMENT 'ID类型',
  `postip` varchar(255) NOT NULL DEFAULT '' COMMENT '评论IP',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评论状态\r\n     0=已通过\r\n     1=待审核\r\n     2=已忽略',
  `message` text NOT NULL COMMENT '评论内容',
  PRIMARY KEY (`cid`),
  KEY `idtype` (`vid`,`idtype`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频评论表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_video_comment表成功"."<br>";
}else
{
  echo "创建fox50_video_comment表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_video_count表
if(mysql_query("drop table if exists fox50_video_count;"))
{
  echo "清除fox50_video_count表成功"."<br>";
}else
{
  echo "清除fox50_video_count表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_count` (
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频编号',
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '栏目编号',
  `viewnum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '查看数',
  `commentnum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `favtimes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  `sharetimes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '分享数',
  `praise` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '支持/顶',
  `criticism` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '批评/踩',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频统计表';
",$link))
{
  echo "创建fox50_video_count表成功"."<br>";
}else
{
  echo "创建fox50_video_count表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_video_favorite表
if(mysql_query("drop table if exists fox50_video_favorite;"))
{
  echo "清除fox50_video_favorite表成功"."<br>";
}else
{
  echo "清除fox50_video_favorite表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_favorite` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '收藏ID',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收藏人用户ID',
  `objid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收藏对象ID',
  `idtype` varchar(255) NOT NULL DEFAULT '' COMMENT '收藏对象ID类型',
  `spaceuid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '空间用户ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '收藏标题',
  `description` text NOT NULL COMMENT '收藏说明',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `idtype` (`objid`,`idtype`),
  KEY `uid` (`uid`,`idtype`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频收藏表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_video_favorite表成功"."<br>";
}else
{
  echo "创建fox50_video_favorite表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_video_region表
if(mysql_query("drop table if exists fox50_video_region;"))
{
  echo "清除fox50_video_region表成功"."<br>";
}else
{
  echo "清除fox50_video_region表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_region` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区编号',
  `regionname` varchar(255) NOT NULL DEFAULT '' COMMENT '地区名称',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频数',
  `displayorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频地区表' AUTO_INCREMENT=10 ;
",$link))
{
  echo "创建fox50_video_region表成功"."<br>";
}else
{
  echo "创建fox50_video_region表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
INSERT INTO `fox50_video_region` (`id`, `regionname`, `num`, `displayorder`) VALUES
(1, '大陆', 0, 1),
(2, '香港', 0, 2),
(3, '台湾', 0, 3),
(4, '韩国', 0, 4),
(5, '美国', 0, 5),
(6, '欧洲', 0, 6),
(7, '日本', 0, 7),
(8, '印度', 0, 8),
(9, '新加坡', 0, 9);
",$link))
{
	echo "在fox50_video_region表插入数据成功"."<br>";
}else
{
	echo "在fox50_video_region表插入数据失败".mysql_error()."<br>";
	exit;
}

//创建fox50_video_special表
if(mysql_query("drop table if exists fox50_video_special;"))
{
  echo "清除fox50_video_special表成功"."<br>";
}else
{
  echo "清除fox50_video_special表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_special` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '专辑编号',
  `specialname` varchar(50) NOT NULL DEFAULT '' COMMENT '专辑名',
  `catid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '专辑系统分类',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '专辑所有者编号',
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '专辑所有者名称',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `videonum` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '视频数量',
  `pic` varchar(60) NOT NULL DEFAULT '' COMMENT '专辑封面照片',
  `videoflag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '专辑是否有视频',
  `privacy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '视频隐私设置\r\n     0=全站用户可见\r\n     1=仅好友可见\r\n     2=指定好友可见\r\n     3=仅自己可见\r\n     4=凭密码可见',
  `password` varchar(10) NOT NULL DEFAULT '' COMMENT '专辑密码',
  `target_ids` text NOT NULL COMMENT '指定好友可见的用户ID集合',
  `favtimes` mediumint(8) unsigned NOT NULL COMMENT '收藏次数',
  `sharetimes` mediumint(8) unsigned NOT NULL COMMENT '分享次数',
  `depict` text NOT NULL COMMENT '专辑描述',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`updatetime`),
  KEY `updatetime` (`updatetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户视频专辑表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_video_special表成功"."<br>";
}else
{
  echo "创建fox50_video_special表失败".mysql_error()."<br>";
  exit;
}

//创建fox50_video_type表
if(mysql_query("drop table if exists fox50_video_type;"))
{
  echo "清除fox50_video_type表成功"."<br>";
}else
{
  echo "清除fox50_video_type表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `upid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类编号/栏目编号',
  `typename` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频数',
  `available` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频类型表' AUTO_INCREMENT=260 ;
",$link))
{
  echo "创建fox50_video_type表成功"."<br>";
}else
{
  echo "创建fox50_video_type表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
INSERT INTO `fox50_video_type` (`id`, `upid`, `typename`, `num`, `available`, `displayorder`) VALUES
(1, 1, '武侠', 0, 1, 1),
(2, 1, '警匪', 0, 1, 2),
(3, 1, '犯罪', 0, 1, 3),
(4, 1, '科幻', 0, 1, 4),
(5, 1, '战争', 0, 1, 5),
(6, 1, '恐怖', 0, 1, 6),
(7, 1, '惊悚', 0, 1, 7),
(8, 1, '纪录片', 0, 1, 8),
(9, 1, '西部', 0, 1, 9),
(10, 1, '戏曲', 0, 1, 10),
(11, 1, '歌舞', 0, 1, 11),
(12, 1, '奇幻', 0, 1, 12),
(13, 1, '冒险', 0, 1, 13),
(14, 1, '悬疑', 0, 1, 14),
(15, 1, '历史', 0, 1, 15),
(16, 1, '动作', 0, 1, 16),
(17, 1, '传纪', 0, 1, 17),
(18, 1, '动画', 0, 1, 18),
(19, 1, '儿童', 0, 1, 19),
(20, 1, '喜剧', 0, 1, 20),
(21, 1, '爱情', 0, 1, 21),
(22, 1, '剧情', 0, 1, 22),
(23, 1, '运动', 0, 1, 23),
(24, 1, '短片', 0, 1, 24),

(51, 2, '古装', 0, 1, 1),
(52, 2, '武侠', 0, 1, 2),
(53, 2, '警匪', 0, 1, 3),
(54, 2, '军事', 0, 1, 4),
(55, 2, '神话', 0, 1, 5),
(56, 2, '科幻', 0, 1, 6),
(57, 2, '悬疑', 0, 1, 7),
(58, 2, '历史', 0, 1, 8),
(59, 2, '儿童', 0, 1, 9),
(60, 2, '农村', 0, 1, 10),
(61, 2, '都市', 0, 1, 11),
(62, 2, '家庭', 0, 1, 12),
(63, 2, '搞笑', 0, 1, 13),
(64, 2, '偶像', 0, 1, 14),
(65, 2, '言情', 0, 1, 15),
(66, 2, '时装', 0, 1, 16),

(101, 3, '热血', 0, 1, 1),
(102, 3, '格斗', 0, 1, 2),
(103, 3, '恋爱', 0, 1, 3),
(104, 3, '美少女', 0, 1, 4),
(105, 3, '校园', 0, 1, 5),
(106, 3, '搞笑', 0, 1, 6),
(107, 3, '神魔', 0, 1, 7),
(108, 3, '机战', 0, 1, 8),
(109, 3, '科幻', 0, 1, 9),
(110, 3, '真人', 0, 1, 10),
(111, 3, '青春', 0, 1, 11),
(112, 3, '魔法', 0, 1, 12),
(113, 3, '神话', 0, 1, 13),
(114, 3, '冒险', 0, 1, 14),
(115, 3, '运动', 0, 1, 15),
(116, 3, '竞技', 0, 1, 16),
(117, 3, '童话', 0, 1, 17),
(118, 3, '亲子', 0, 1, 18),
(119, 3, '教育', 0, 1, 19),
(120, 3, '励志', 0, 1, 20),
(121, 3, '剧情', 0, 1, 21),
(122, 3, '社会', 0, 1, 22),
(123, 3, '历史', 0, 1, 23),
(124, 3, '战争', 0, 1, 24),

(151, 4, '明星八卦', 0, 1, 1),
(152, 4, '影视快讯', 0, 1, 2),
(153, 4, '综艺节目', 0, 1, 3),
(154, 4, '音乐资讯', 0, 1, 4),
(155, 4, '娱乐深喉', 0, 1, 5),
(156, 4, '精彩专题', 0, 1, 6),

(201, 5, '大陆', 0, 1, 1),
(202, 5, '国际', 0, 1, 2),
(203, 5, '台海', 0, 1, 3),
(204, 5, '社会', 0, 1, 4),
(205, 5, '拍客', 0, 1, 5),
(206, 5, '财经', 0, 1, 6),
(207, 5, '体育', 0, 1, 7),
(208, 5, '评论', 0, 1, 8),

(251, 6, '时尚', 0, 1, 1),
(252, 6, '旅游', 0, 1, 2),
(253, 6, '公开课堂', 0, 1, 3);
",$link))
{
	echo "在fox50_video_type表插入数据成功"."<br>";
}else
{
	echo "在fox50_video_type表插入数据失败".mysql_error()."<br>";
	exit;
}

//创建fox50_video_comment表
if(mysql_query("drop table if exists fox50_video_recommended;"))
{
  echo "清除fox50_video_recommended表成功"."<br>";
}else
{
  echo "清除fox50_video_recommended表失败".mysql_error()."<br>";
  exit;
}
if(mysql_query("
CREATE TABLE IF NOT EXISTS `fox50_video_recommended` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '推荐ID',
  `vid` mediumint(8) NOT NULL COMMENT '视频ID',
  `img` varchar(255) NOT NULL COMMENT '视频封面图片',
  `title` varchar(255) NOT NULL COMMENT '视频标题',
  PRIMARY KEY(`id`),
  KEY(`vid`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频推荐表' AUTO_INCREMENT=1 ;
",$link))
{
  echo "创建fox50_video_comment表成功"."<br>";
}else
{
  echo "创建fox50_video_comment表失败".mysql_error()."<br>";
  exit;
}

//插入管理员
if(mysql_query("
INSERT INTO `fox50_user` (`id`, `account`, `nickname`, `password`, `bind_account`, `last_login_time`, `last_login_ip`, `login_count`, `verify`, `email`, `remark`, `create_time`, `update_time`, `status`, `type_id`, `info`) VALUES (1, 'chaihua', '最高管理员', 'bfb5506f67e7903748a52034be42c972', '', 1363307912, '127.0.0.1', 0, '8888', 'webignorant@sina.com', '我是站长', 1222907803, 1361510274, 1, 0, ".time().");
",$link))
{
  echo "插入管理员信息成功"."<br>";
}else
{
  echo "插入管理员信息失败".mysql_error()."<br>";
  exit;
}

//将管理员加入 管理员 用户组
if(mysql_query("
INSERT INTO `fox50_role_user` (`role_id`, `user_id`) VALUES ('1', '1');
",$link))
{
  echo "将管理员加入管理员组成功"."<br>";
}else
{
  echo "将管理员加入管理员组失败".mysql_error()."<br>";
  exit;
}


?>