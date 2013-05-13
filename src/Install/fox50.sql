/*
使用项目：Fox50
使用域名：www.fox50.cn
*/

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `fox50_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `fox50_form` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `fox50_friendlink` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '站点名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '站点URL',
  `description` mediumtext NOT NULL COMMENT '文字说明',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo地址',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0为禁用，1为允许',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='友情链接数据表' AUTO_INCREMENT=1 ;


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

INSERT INTO `fox50_group` (`id`, `name`, `title`, `create_time`, `update_time`, `status`, `sort`, `show`) VALUES
(1, 'system', '系统设置', 1222841259, 0, 1, 0, 0),
(2, 'setting', '网站管理', 1222841259, 0, 1, 0, 0),
(3, 'user', '用户管理', 1222841259, 0, 1, 0, 0),
(4, 'video', '视频管理', 1222841259, 0, 1, 0, 0);


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

(1001, 'index', '管理首页默认方法', 1, '属于网站基本信息模块的方法', 1, 10, 3, 0, 0),

(1101, 'index', '网站基本设置默认权限', 1, '属于网站基本信息模块的方法', 1, 11, 3, 0, 0),
(1102, 'insert', '网站基本设置添加权限', 1, '属于网站基本信息模块的方法', 2, 11, 3, 0, 0),
(1103, 'delete', '网站基本设置删除权限', 1, '属于网站基本信息模块的方法', 3, 11, 3, 0, 0),
(1104, 'update', '网站基本设置更新权限', 1, '属于网站基本信息模块的方法', 4, 11, 3, 0, 0),
(1105, 'edit', '网站基本设置编辑权限', 1, '属于网站基本信息模块的方法', 5, 11, 3, 0, 0),
(1106, 'read', '网站基本设置读取权限', 1, '属于网站基本信息模块的方法', 6, 11, 3, 0, 0),
(1107, 'foreverdelete', '网站基本设置永远删除权限', 1, '属于网站基本信息模块的方法', 7, 11, 3, 0, 0),
(1108, 'clear', '网站基本设置批量清除权限', 1, '属于网站基本信息模块的方法', 8, 11, 3, 0, 0),
(1109, 'sort', '网站基本设置查看排序权限', 1, '属于网站基本信息模块的方法', 9, 11, 3, 0, 0),
(1110, 'saveSort', '网站基本设置保存排序权限', 1, '属于网站基本信息模块的方法', 10, 11, 3, 0, 0),
(1111, 'resume', '网站基本设置状态恢复权限', 1, '属于网站基本信息模块的方法', 11, 11, 3, 0, 0),
(1112, 'forbid', '网站基本设置状态禁用权限', 1, '属于网站基本信息模块的方法', 12, 11, 3, 0, 0),
(1113, 'checkPass', '网站基本设置状态批准权限', 1, '属于网站基本信息模块的方法', 13, 11, 3, 0, 0),
(1114, 'recycle', '网站基本设置状态还原权限', 1, '属于网站基本信息模块的方法', 14, 11, 3, 0, 0),
(1115, 'recycleBin', '网站基本设置显示回收站权限', 1, '属于网站基本信息模块的方法', 15, 11, 3, 0, 0),


(1201, 'index', '数据库设置默认权限', 1, '属于数据库设置模块的方法', 1, 12, 3, 0, 0),

(1301, 'index', '数据库设置默认权限', 1, '属于数据库设置模块的方法', 1, 13, 3, 0, 0),
(1302, 'bakdata', '数据库设置备份权限', 1, '属于数据库设置模块的方法', 2, 13, 3, 0, 0),
(1303, 'recoverdata', '数据库设置恢复权限', 1, '属于数据库设置模块的方法', 3, 13, 3, 0, 0),

(1401, 'index', '节点设置默认权限', 1, '属于节点设置模块的方法', 1, 14, 3, 0, 0),
(1402, 'insert', '节点设置添加权限', 1, '属于节点设置模块的方法', 2, 14, 3, 0, 0),
(1403, 'delete', '节点设置删除权限', 1, '属于节点设置模块的方法', 3, 14, 3, 0, 0),
(1404, 'update', '节点设置更新权限', 1, '属于节点设置模块的方法', 4, 14, 3, 0, 0),
(1405, 'edit', '节点设置编辑权限', 1, '属于节点设置模块的方法', 5, 14, 3, 0, 0),
(1406, 'read', '节点设置读取权限', 1, '属于节点设置模块的方法', 6, 14, 3, 0, 0),
(1407, 'foreverdelete', '节点设置永远删除权限', 1, '属于节点设置模块的方法', 7, 14, 3, 0, 0),
(1408, 'clear', '节点设置批量清除权限', 1, '属于节点设置模块的方法', 8, 14, 3, 0, 0),
(1409, 'sort', '节点设置查看排序权限', 1, '属于节点设置模块的方法', 9, 14, 3, 0, 0),
(1410, 'saveSort', '节点设置保存排序权限', 1, '属于节点设置模块的方法', 10, 14, 3, 0, 0),
(1411, 'resume', '节点设置状态恢复权限', 1, '属于节点设置模块的方法', 11, 14, 3, 0, 0),
(1412, 'forbid', '节点设置状态禁用权限', 1, '属于节点设置模块的方法', 12, 14, 3, 0, 0),
(1413, 'checkPass', '节点设置状态批准权限', 1, '属于节点设置模块的方法', 13, 14, 3, 0, 0),
(1414, 'recycle', '节点设置状态还原权限', 1, '属于节点设置模块的方法', 14, 14, 3, 0, 0),
(1415, 'recycleBin', '节点设置显示回收站权限', 1, '属于节点设置模块的方法', 15, 14, 3, 0, 0),

(1501, 'index', '系统日记默认权限', 1, '属于系统日记模块的方法', 1, 15, 3, 0, 0),
(1502, 'insert', '系统日记添加权限', 1, '属于系统日记模块的方法', 2, 15, 3, 0, 0),
(1503, 'delete', '系统日记删除权限', 1, '属于系统日记模块的方法', 3, 15, 3, 0, 0),
(1504, 'update', '系统日记更新权限', 1, '属于系统日记模块的方法', 4, 15, 3, 0, 0),
(1505, 'edit', '系统日记编辑权限', 1, '属于系统日记模块的方法', 5, 15, 3, 0, 0),
(1506, 'read', '系统日记读取权限', 1, '属于节点设置模块的方法', 6, 15, 3, 0, 0),
(1507, 'foreverdelete', '系统日记永远删除权限', 1, '属于系统日记模块的方法', 7, 15, 3, 0, 0),
(1508, 'clear', '系统日记批量清除权限', 1, '属于系统日记模块的方法', 8, 15, 3, 0, 0),
(1509, 'sort', '系统日记查看排序权限', 1, '属于系统日记模块的方法', 9, 15, 3, 0, 0),
(1510, 'saveSort', '系统日记保存排序权限', 1, '属于系统日记模块的方法', 10, 15, 3, 0, 0),
(1511, 'resume', '系统日记状态恢复权限', 1, '属于系统日记模块的方法', 11, 15, 3, 0, 0),
(1512, 'forbid', '系统日记状态禁用权限', 1, '属于系统日记模块的方法', 12, 15, 3, 0, 0),
(1513, 'checkPass', '系统日记状态批准权限', 1, '属于系统日记模块的方法', 13, 15, 3, 0, 0),
(1514, 'recycle', '系统日记状态还原权限', 1, '属于系统日记模块的方法', 14, 15, 3, 0, 0),
(1515, 'recycleBin', '系统日记显示回收站权限', 1, '属于系统日记模块的方法', 15, 15, 3, 0, 0),

(2101, 'index', '广告设置默认权限', 1, '属于广告设置模块的方法', 1, 21, 3, 0, 0),
(2102, 'insert', '广告设置添加权限', 1, '属于广告设置模块的方法', 2, 21, 3, 0, 0),
(2103, 'delete', '广告设置删除权限', 1, '属于广告设置模块的方法', 3, 21, 3, 0, 0),
(2104, 'update', '广告设置更新权限', 1, '属于广告设置模块的方法', 4, 21, 3, 0, 0),
(2105, 'edit', '广告设置编辑权限', 1, '属于广告设置模块的方法', 5, 21, 3, 0, 0),
(2106, 'read', '广告设置读取权限', 1, '属于广告设置模块的方法', 6, 21, 3, 0, 0),
(2107, 'foreverdelete', '广告设置永远删除权限', 1, '属于广告设置模块的方法', 7, 21, 3, 0, 0),
(2108, 'clear', '广告设置批量清除权限', 1, '属于广告设置模块的方法', 8, 21, 3, 0, 0),
(2109, 'sort', '广告设置查看排序权限', 1, '属于广告设置模块的方法', 9, 21, 3, 0, 0),
(2110, 'saveSort', '广告设置保存排序权限', 1, '属于广告设置模块的方法', 10, 21, 3, 0, 0),
(2111, 'resume', '广告设置状态恢复权限', 1, '属于广告设置模块的方法', 11, 21, 3, 0, 0),
(2112, 'forbid', '广告设置状态禁用权限', 1, '属于广告设置模块的方法', 12, 21, 3, 0, 0),
(2113, 'checkPass', '广告设置状态批准权限', 1, '属于广告设置模块的方法', 13, 21, 3, 0, 0),
(2114, 'recycle', '广告设置状态还原权限', 1, '属于广告设置模块的方法', 14, 21, 3, 0, 0),
(2115, 'recycleBin', '广告设置显示回收站权限', 1, '属于广告设置模块的方法', 15, 21, 3, 0, 0),

(2201, 'index', '友情链接设置默认权限', 1, '属于友情链接设置模块的方法', 1, 22, 3, 0, 0),
(2202, 'insert', '友情链接设置添加权限', 1, '属于友情链接设置模块的方法', 2, 22, 3, 0, 0),
(2203, 'delete', '友情链接设置删除权限', 1, '属于友情链接设置模块的方法', 3, 22, 3, 0, 0),
(2204, 'update', '友情链接设置更新权限', 1, '属于友情链接设置模块的方法', 4, 22, 3, 0, 0),
(2205, 'edit', '友情链接设置编辑权限', 1, '属于友情链接设置模块的方法', 5, 22, 3, 0, 0),
(2206, 'read', '友情链接读取权限', 1, '属于友情链接设置模块的方法', 6, 22, 3, 0, 0),
(2207, 'foreverdelete', '友情链接永远删除权限', 1, '属于友情链接设置模块的方法', 7, 22, 3, 0, 0),
(2208, 'clear', '友情链接批量清除权限', 1, '属于友情链接设置模块的方法', 8, 22, 3, 0, 0),
(2209, 'sort', '友情链接查看排序权限', 1, '属于友情链接设置模块的方法', 9, 22, 3, 0, 0),
(2210, 'saveSort', '友情链接保存排序权限', 1, '属于友情链接设置模块的方法', 10, 22, 3, 0, 0),
(2211, 'resume', '友情链接状态恢复权限', 1, '属于友情链接设置模块的方法', 11, 22, 3, 0, 0),
(2212, 'forbid', '友情链接状态禁用权限', 1, '属于友情链接设置模块的方法', 12, 22, 3, 0, 0),
(2213, 'checkPass', '友情链接状态批准权限', 1, '属于友情链接设置模块的方法', 13, 22, 3, 0, 0),
(2214, 'recycle', '友情链接状态还原权限', 1, '属于友情链接设置模块的方法', 14, 22, 3, 0, 0),
(2215, 'recycleBin', '友情链接显示回收站权限', 1, '属于友情链接设置模块的方法', 15, 22, 3, 0, 0),
 
(2301, 'index', '评论设置默认权限', 1, '属于评论设置模块的方法', 1, 23, 3, 0, 0),
(2302, 'insert', '评论设置添加权限', 1, '属于评论设置模块的方法', 2, 23, 3, 0, 0),
(2303, 'delete', '评论设置删除权限', 1, '属于评论设置模块的方法', 3, 23, 3, 0, 0),
(2304, 'update', '评论设置更新权限', 1, '属于评论设置模块的方法', 4, 23, 3, 0, 0),
(2305, 'edit', '评论设置编辑权限', 1, '属于评论设置模块的方法', 5, 23, 3, 0, 0),
(2306, 'read', '评论设置读取权限', 1, '属于评论设置模块的方法', 6, 23, 3, 0, 0),
(2307, 'foreverdelete', '评论设置永远删除权限', 1, '属于评论设置模块的方法', 7, 23, 3, 0, 0),
(2308, 'clear', '评论设置批量清除权限', 1, '属于评论设置模块的方法', 8, 23, 3, 0, 0),
(2309, 'sort', '评论设置查看排序权限', 1, '属于评论设置模块的方法', 9, 23, 3, 0, 0),
(2310, 'saveSort', '评论设置保存排序权限', 1, '属于评论设置模块的方法', 10, 23, 3, 0, 0),
(2311, 'resume', '评论设置状态恢复权限', 1, '属于评论设置模块的方法', 11, 23, 3, 0, 0),
(2312, 'forbid', '评论设置状态禁用权限', 1, '属于评论设置模块的方法', 12, 23, 3, 0, 0),
(2313, 'checkPass', '评论设置状态批准权限', 1, '属于评论设置模块的方法', 13, 23, 3, 0, 0),
(2314, 'recycle', '评论设置状态还原权限', 1, '属于评论设置模块的方法', 14, 23, 3, 0, 0),
(2315, 'recycleBin', '评论设置显示回收站权限', 1, '属于评论设置模块的方法', 15, 23, 3, 0, 0),

(2401, 'index', '公告设置默认权限', 1, '属于公告设置模块的方法', 1, 24, 3, 0, 0),
(2402, 'insert', '公告设置添加权限', 1, '属于公告设置模块的方法', 2, 24, 3, 0, 0),
(2403, 'delete', '公告设置删除权限', 1, '属于公告设置模块的方法', 3, 24, 3, 0, 0),
(2404, 'update', '公告设置更新权限', 1, '属于公告设置模块的方法', 4, 24, 3, 0, 0),
(2405, 'edit', '公告设置编辑权限', 1, '属于公告设置模块的方法', 5, 24, 3, 0, 0),
(2406, 'read', '公告设置读取权限', 1, '属于公告设置模块的方法', 6, 24, 3, 0, 0),
(2407, 'foreverdelete', '公告设置永远删除权限', 1, '属于公告设置模块的方法', 7, 24, 3, 0, 0),
(2408, 'clear', '公告设置批量清除权限', 1, '属于公告设置模块的方法', 8, 24, 3, 0, 0),
(2409, 'sort', '公告设置查看排序权限', 1, '属于公告设置模块的方法', 9, 24, 3, 0, 0),
(2410, 'saveSort', '公告设置保存排序权限', 1, '属于公告设置模块的方法', 10, 24, 3, 0, 0),
(2411, 'resume', '公告设置状态恢复权限', 1, '属于公告设置模块的方法', 11, 24, 3, 0, 0),
(2412, 'forbid', '公告设置状态禁用权限', 1, '属于公告设置模块的方法', 12, 24, 3, 0, 0),
(2413, 'checkPass', '公告设置状态批准权限', 1, '属于公告设置模块的方法', 13, 24, 3, 0, 0),
(2414, 'recycle', '公告设置状态还原权限', 1, '属于公告设置模块的方法', 14, 24, 3, 0, 0),
(2415, 'recycleBin', '公告设置显示回收站权限', 1, '属于公告设置模块的方法', 15, 24, 3, 0, 0),

(3101, 'index', '用户管理默认权限', 1, '属于用户管理模块的方法', 1, 31, 3, 0, 0),
(3102, 'insert', '用户管理添加权限', 1, '属于用户管理模块的方法', 2, 31, 3, 0, 0),
(3103, 'delete', '用户管理删除权限', 1, '属于用户管理模块的方法', 3, 31, 3, 0, 0),
(3104, 'update', '用户管理更新权限', 1, '属于用户管理模块的方法', 4, 31, 3, 0, 0),
(3105, 'edit', '用户管理编辑权限', 1, '属于用户管理模块的方法', 5, 31, 3, 0, 0),
(3106, 'read', '用户管理读取权限', 1, '属于用户管理模块的方法', 6, 31, 3, 0, 0),
(3107, 'foreverdelete', '用户管理永远删除权限', 1, '属于用户管理模块的方法', 7, 31, 3, 0, 0),
(3108, 'clear', '用户管理批量清除权限', 1, '属于用户管理模块的方法', 8, 31, 3, 0, 0),
(3109, 'sort', '用户管理查看排序权限', 1, '属于用户管理模块的方法', 9, 31, 3, 0, 0),
(3110, 'saveSort', '用户管理保存排序权限', 1, '属于用户管理模块的方法', 10, 31, 3, 0, 0),
(3111, 'resume', '用户管理状态恢复权限', 1, '属于用户管理模块的方法', 11, 31, 3, 0, 0),
(3112, 'forbid', '用户管理状态禁用权限', 1, '属于用户管理模块的方法', 12, 31, 3, 0, 0),
(3113, 'checkPass', '用户管理状态批准权限', 1, '属于用户管理模块的方法', 13, 31, 3, 0, 0),
(3114, 'recycle', '用户管理状态还原权限', 1, '属于用户管理模块的方法', 14, 31, 3, 0, 0),
(3115, 'recycleBin', '用户管理显示回收站权限', 1, '属于用户管理模块的方法', 15, 31, 3, 0, 0),

(3201, 'index', '角色组管理默认权限', 1, '属于角色组管理模块的方法', 1, 32, 3, 0, 0),
(3202, 'insert', '角色组管理添加权限', 1, '属于角色组管理模块的方法', 2, 32, 3, 0, 0),
(3203, 'delete', '角色组管理删除权限', 1, '属于角色组管理模块的方法', 3, 32, 3, 0, 0),
(3204, 'update', '角色组管理更新权限', 1, '属于角色组管理模块的方法', 4, 32, 3, 0, 0),
(3205, 'edit', '角色组管理编辑权限', 1, '属于角色组管理模块的方法', 5, 32, 3, 0, 0),
(3206, 'read', '角色组管理读取权限', 1, '属于角色组管理模块的方法', 6, 32, 3, 0, 0),
(3207, 'foreverdelete', '角色组管理永远删除权限', 1, '属于角色组管理模块的方法', 7, 32, 3, 0, 0),
(3208, 'clear', '角色组管理批量清除权限', 1, '属于角色组管理模块的方法', 8, 32, 3, 0, 0),
(3209, 'sort', '角色组管理查看排序权限', 1, '属于角色组管理模块的方法', 9, 32, 3, 0, 0),
(3210, 'saveSort', '角色组管理保存排序权限', 1, '属于角色组管理模块的方法', 10, 32, 3, 0, 0),
(3211, 'resume', '角色组管理状态恢复权限', 1, '属于角色组管理模块的方法', 11, 32, 3, 0, 0),
(3212, 'forbid', '角色组管理状态禁用权限', 1, '属于角色组管理模块的方法', 12, 32, 3, 0, 0),
(3213, 'checkPass', '角色组管理状态批准权限', 1, '属于角色组管理模块的方法', 13, 32, 3, 0, 0),
(3214, 'recycle', '角色组管理状态还原权限', 1, '属于角色组管理模块的方法', 14, 32, 3, 0, 0),
(3215, 'recycleBin', '角色组管理显示回收站权限', 1, '属于角色组管理模块的方法', 15, 32, 3, 0, 0),

(3301, 'index', '管理员组管理默认权限', 1, '属于管理员组管理模块的方法', 1, 33, 3, 0, 0),
(3302, 'insert', '管理员组管理添加权限', 1, '属于管理员组管理模块的方法', 2, 33, 3, 0, 0),
(3303, 'delete', '管理员组管理删除权限', 1, '属于管理员组管理模块的方法', 3, 33, 3, 0, 0),
(3304, 'update', '管理员组管理更新权限', 1, '属于管理员组管理模块的方法', 4, 33, 3, 0, 0),
(3305, 'edit', '管理员组管理编辑权限', 1, '属于管理员组管理模块的方法', 5, 33, 3, 0, 0),
(3306, 'read', '管理员组管理读取权限', 1, '属于管理员组管理模块的方法', 6, 33, 3, 0, 0),
(3307, 'foreverdelete', '管理员组管理永远删除权限', 1, '属于管理员组管理模块的方法', 7, 33, 3, 0, 0),
(3308, 'clear', '管理员组管理批量清除权限', 1, '属于管理员组管理模块的方法', 8, 33, 3, 0, 0),
(3309, 'sort', '管理员组管理查看排序权限', 1, '属于管理员组管理模块的方法', 9, 33, 3, 0, 0),
(3310, 'saveSort', '管理员组管理保存排序权限', 1, '属于管理员组管理模块的方法', 10, 33, 3, 0, 0),
(3311, 'resume', '管理员组管理状态恢复权限', 1, '属于管理员组管理模块的方法', 11, 33, 3, 0, 0),
(3312, 'forbid', '管理员组管理状态禁用权限', 1, '属于管理员组管理模块的方法', 12, 33, 3, 0, 0),
(3313, 'checkPass', '管理员组管理状态批准权限', 1, '属于管理员组管理模块的方法', 13, 33, 3, 0, 0),
(3314, 'recycle', '管理员组管理状态还原权限', 1, '属于管理员组管理模块的方法', 14, 33, 3, 0, 0),
(3315, 'recycleBin', '管理员组管理显示回收站权限', 1, '属于管理员组管理模块的方法', 15, 33, 3, 0, 0),

(4101, 'index', '视频管理默认权限', 1, '属于视频管理模块的方法', 1, 41, 3, 0, 0),
(4102, 'insert', '视频管理添加权限', 1, '属于视频管理模块的方法', 2, 41, 3, 0, 0),
(4103, 'delete', '视频管理删除权限', 1, '属于视频管理模块的方法', 3, 41, 3, 0, 0),
(4104, 'update', '视频管理更新权限', 1, '属于视频管理模块的方法', 4, 41, 3, 0, 0),
(4105, 'edit', '视频管理编辑权限', 1, '属于视频管理模块的方法', 5, 41, 3, 0, 0),
(4106, 'read', '视频管理读取权限', 1, '属于视频管理模块的方法', 6, 41, 3, 0, 0),
(4107, 'foreverdelete', '视频管理永远删除权限', 1, '属于视频管理模块的方法', 7, 41, 3, 0, 0),
(4108, 'clear', '视频管理批量清除权限', 1, '属于视频管理模块的方法', 8, 41, 3, 0, 0),
(4109, 'sort', '视频管理查看排序权限', 1, '属于视频管理模块的方法', 9, 41, 3, 0, 0),
(4110, 'saveSort', '视频管理保存排序权限', 1, '属于视频管理模块的方法', 10, 41, 3, 0, 0),
(4111, 'resume', '视频管理状态恢复权限', 1, '属于视频管理模块的方法', 11, 41, 3, 0, 0),
(4112, 'forbid', '视频管理状态禁用权限', 1, '属于视频管理模块的方法', 12, 41, 3, 0, 0),
(4113, 'checkPass', '视频管理状态批准权限', 1, '属于视频管理模块的方法', 13, 41, 3, 0, 0),
(4114, 'recycle', '视频管理状态还原权限', 1, '属于视频管理模块的方法', 14, 41, 3, 0, 0),
(4115, 'recycleBin', '视频管理显示回收站权限', 1, '属于视频管理模块的方法', 15, 41, 3, 0, 0),
(4116, 'setVideodata', '视频管理截图入库权限', 1, '属于视频管理模块的方法', 16, 41, 3, 0, 0),
(4117, 'setVideoStatus', '视频管理设置状态权限', 1, '属于视频管理模块的方法', 17, 41, 3, 0, 0),
(4118, 'transcoding', '视频管理转码权限', 1, '属于视频管理模块的方法', 18, 41, 3, 0, 0),
/*
(4520, 'dir', '视频管理创建视频目录权限', 1, '属于视频管理模块的方法', 20, 41, 3, 0, 0),
(4521, 'transition', '视频管理转换视频格式权限', 1, '属于视频管理模块的方法', 21, 41, 3, 0, 0),
(4522, 'screenshot', '视频管理截取图片权限', 1, '属于视频管理模块的方法', 22, 41, 3, 0, 0),
(4523, 'info', '视频管理获取相关信息权限', 1, '属于视频管理模块的方法', 23, 41, 3, 0, 0),
*/

(4201, 'index', '视频栏目管理默认权限', 1, '属于视频栏目管理模块的方法', 1, 42, 3, 0, 0),
(4202, 'insert', '视频栏目管理添加权限', 1, '属于视频栏目管理模块的方法', 2, 42, 3, 0, 0),
(4203, 'delete', '视频栏目管理删除权限', 1, '属于视频栏目管理模块的方法', 3, 42, 3, 0, 0),
(4204, 'update', '视频栏目管理更新权限', 1, '属于视频栏目管理模块的方法', 4, 42, 3, 0, 0),
(4205, 'edit', '视频栏目管理编辑权限', 1, '属于视频栏目管理模块的方法', 5, 42, 3, 0, 0),
(4206, 'read', '视频栏目管理读取权限', 1, '属于视频栏目管理模块的方法', 6, 42, 3, 0, 0),
(4207, 'foreverdelete', '视频栏目管理永远删除权限', 1, '属于视频栏目管理模块的方法', 7, 42, 3, 0, 0),
(4208, 'clear', '视频栏目管理批量清除权限', 1, '属于视频栏目管理模块的方法', 8, 42, 3, 0, 0),
(4209, 'sort', '视频栏目管理查看排序权限', 1, '属于视频栏目管理模块的方法', 9, 42, 3, 0, 0),
(4210, 'saveSort', '视频栏目管理保存排序权限', 1, '属于视频栏目管理模块的方法', 10, 42, 3, 0, 0),
(4211, 'resume', '视频栏目管理状态恢复权限', 1, '属于视频栏目管理模块的方法', 11, 42, 3, 0, 0),
(4212, 'forbid', '视频栏目管理状态禁用权限', 1, '属于视频栏目管理模块的方法', 12, 42, 3, 0, 0),
(4213, 'checkPass', '视频栏目管理状态批准权限', 1, '属于视频栏目管理模块的方法', 13, 42, 3, 0, 0),
(4214, 'recycle', '视频栏目管理状态还原权限', 1, '属于视频栏目管理模块的方法', 14, 42, 3, 0, 0),
(4215, 'recycleBin', '视频栏目管理显示回收站权限', 1, '属于视频栏目管理模块的方法', 15, 42, 3, 0, 0),

(4301, 'index', '视频类型管理默认权限', 1, '属于视频类型管理模块的方法', 1, 43, 3, 0, 0),
(4302, 'insert', '视频类型管理添加权限', 1, '属于视频类型管理模块的方法', 2, 43, 3, 0, 0),
(4303, 'delete', '视频类型管理删除权限', 1, '属于视频类型管理模块的方法', 3, 43, 3, 0, 0),
(4304, 'update', '视频类型管理更新权限', 1, '属于视频类型管理模块的方法', 4, 43, 3, 0, 0),
(4305, 'edit', '视频类型管理编辑权限', 1, '属于视频类型管理模块的方法', 5, 43, 3, 0, 0),
(4306, 'read', '视频栏目管理读取权限', 1, '属于视频类型管理模块的方法', 6, 43, 3, 0, 0),
(4307, 'foreverdelete', '视频栏目管理永远删除权限', 1, '属于视频类型管理模块的方法', 7, 43, 3, 0, 0),
(4308, 'clear', '视频栏目管理批量清除权限', 1, '属于视频类型管理模块的方法', 8, 43, 3, 0, 0),
(4309, 'sort', '视频栏目管理查看排序权限', 1, '属于视频类型管理模块的方法', 9, 43, 3, 0, 0),
(4310, 'saveSort', '视频栏目管理保存排序权限', 1, '属于视频类型管理模块的方法', 10, 43, 3, 0, 0),
(4311, 'resume', '视频栏目管理状态恢复权限', 1, '属于视频类型管理模块的方法', 11, 43, 3, 0, 0),
(4312, 'forbid', '视频栏目管理状态禁用权限', 1, '属于视频类型管理模块的方法', 12, 43, 3, 0, 0),
(4313, 'checkPass', '视频栏目管理状态批准权限', 1, '属于视频类型管理模块的方法', 13, 43, 3, 0, 0),
(4314, 'recycle', '视频栏目管理状态还原权限', 1, '属于视频类型管理模块的方法', 14, 43, 3, 0, 0),
(4315, 'recycleBin', '视频栏目管理显示回收站权限', 1, '属于视频类型管理模块的方法', 15, 43, 3, 0, 0),

(4401, 'index', '视频地区管理默认权限', 1, '属于视频地区管理模块的方法', 1, 44, 3, 0, 0),
(4402, 'insert', '视频地区管理添加权限', 1, '属于视频地区管理模块的方法', 2, 44, 3, 0, 0),
(4403, 'delete', '视频地区管理删除权限', 1, '属于视频地区管理模块的方法', 3, 44, 3, 0, 0),
(4404, 'update', '视频地区管理更新权限', 1, '属于视频地区管理模块的方法', 4, 44, 3, 0, 0),
(4405, 'edit', '视频地区管理编辑权限', 1, '属于视频地区管理模块的方法', 5, 44, 3, 0, 0),
(4406, 'read', '视频地区管理读取权限', 1, '属于视频地区管理模块的方法', 6, 44, 3, 0, 0),
(4407, 'foreverdelete', '视频地区管理永远删除权限', 1, '属于视频地区管理模块的方法', 7, 44, 3, 0, 0),
(4408, 'clear', '视频地区管理批量清除权限', 1, '属于视频地区管理模块的方法', 8, 44, 3, 0, 0),
(4409, 'sort', '视频地区管理查看排序权限', 1, '属于视频地区管理模块的方法', 9, 44, 3, 0, 0),
(4410, 'saveSort', '视频地区管理保存排序权限', 1, '属于视频地区管理模块的方法', 10, 44, 3, 0, 0),
(4411, 'resume', '视频地区管理状态恢复权限', 1, '属于视频地区管理模块的方法', 11, 44, 3, 0, 0),
(4412, 'forbid', '视频地区管理状态禁用权限', 1, '属于视频地区管理模块的方法', 12, 44, 3, 0, 0),
(4413, 'checkPass', '视频地区管理状态批准权限', 1, '属于视频地区管理模块的方法', 13, 44, 3, 0, 0),
(4414, 'recycle', '视频地区管理状态还原权限', 1, '属于视频地区管理模块的方法', 14, 44, 3, 0, 0),
(4415, 'recycleBin', '视频地区管理显示回收站权限', 1, '属于视频地区管理模块的方法', 15, 44, 3, 0, 0),

(4501, 'index', '视频推荐管理默认权限', 1, '属于视频推荐管理模块的方法', 1, 45, 3, 0, 0),
(4502, 'insert', '视频推荐管理添加权限', 1, '属于视频推荐管理模块的方法', 2, 45, 3, 0, 0),
(4503, 'delete', '视频推荐管理删除权限', 1, '属于视频推荐管理模块的方法', 3, 45, 3, 0, 0),
(4504, 'update', '视频推荐管理更新权限', 1, '属于视频推荐管理模块的方法', 4, 45, 3, 0, 0),
(4505, 'edit', '视频推荐管理编辑权限', 1, '属于视频推荐管理模块的方法', 5, 45, 3, 0, 0),
(4506, 'read', '视频推荐管理读取权限', 1, '属于视频推荐管理模块的方法', 6, 45, 3, 0, 0),
(4507, 'foreverdelete', '视频推荐管理永远删除权限', 1, '属于视频推荐管理模块的方法', 7, 45, 3, 0, 0),
(4508, 'clear', '视频推荐管理批量清除权限', 1, '属于视频推荐管理模块的方法', 8, 45, 3, 0, 0),
(4509, 'sort', '视频推荐管理查看排序权限', 1, '属于视频推荐管理模块的方法', 9, 45, 3, 0, 0),
(4510, 'saveSort', '视频推荐管理保存排序权限', 1, '属于视频推荐管理模块的方法', 10, 45, 3, 0, 0),
(4511, 'resume', '视频推荐管理状态恢复权限', 1, '属于视频推荐管理模块的方法', 11, 45, 3, 0, 0),
(4512, 'forbid', '视频推荐管理状态禁用权限', 1, '属于视频推荐管理模块的方法', 12, 45, 3, 0, 0),
(4513, 'checkPass', '视频推荐管理状态批准权限', 1, '属于视频推荐管理模块的方法', 13, 45, 3, 0, 0),
(4514, 'recycle', '视频推荐管理状态还原权限', 1, '属于视频推荐管理模块的方法', 14, 45, 3, 0, 0),
(4515, 'recycleBin', '视频推荐管理显示回收站权限', 1, '属于视频推荐管理模块的方法', 15, 45, 3, 0, 0),
(4516, 'addVideoRecommended', '视频推荐管理推荐设置权限', 1, '属于视频推荐管理模块的方法', 16, 45, 3, 0, 0),
(4517, 'setVideoRecommended', '视频推荐管理推荐批量设置权限', 1, '属于视频推荐管理模块的方法', 17, 45, 3, 0, 0),
(4518, 'delVideoRecommended', '视频推荐管理推荐删除权限', 1, '属于视频推荐管理模块的方法', 18, 45, 3, 0, 0),
(4519, 'add', '视频推荐管理下拉选择权限', 1, '属于视频推荐管理模块的方法', 19, 45, 3, 0, 0);


CREATE TABLE IF NOT EXISTS `fox50_notice` (
  `id` smallint(8) NOT NULL AUTO_INCREMENT COMMENT '公告ID',
  `uid` smallint(8) NOT NULL COMMENT '发布者ID',
  `dateline` int(10) NOT NULL COMMENT '发布时间',
  `content` varchar(250) NOT NULL COMMENT '公告内容',
  `who` smallint(5) NOT NULL COMMENT '放置位置',
  `status` tinyint(1) NOT NULL COMMENT '状态(1为启用，2为禁用)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公告表' AUTO_INCREMENT=1 ;


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

INSERT INTO `fox50_role` (`id`, `name`, `pid`, `status`, `remark`, `ename`, `create_time`, `update_time`) VALUES
(1, '管理组', 0, 1, '', '', 1208784792, 1254325558),
(2, '用户组', 0, 1, '', '', 1215496283, 1254325566),
(3, '游客组', 0, 1, '', NULL, 1254325787, 0);


CREATE TABLE IF NOT EXISTS `fox50_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `fox50_setting` (
  `skey` varchar(255) NOT NULL DEFAULT '' COMMENT '设置名',
  `svalue` text NOT NULL COMMENT '设置值',
  PRIMARY KEY (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点设置数据表';


CREATE TABLE IF NOT EXISTS `fox50_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` varchar(64) NOT NULL COMMENT '账号名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `password` char(32) NOT NULL COMMENT '密码',
  `bind_account` varchar(50) NOT NULL COMMENT '绑定账号',
  `last_login_time` int(11) unsigned DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(40) DEFAULT NULL COMMENT '上次登录IP',
  `login_count` mediumint(8) unsigned DEFAULT '0' COMMENT '登录次数',
  `verify` varchar(32) DEFAULT NULL COMMENT '验证信息',
  `avatar` varchar(80) NULL COMMENT '头像',
  `email` varchar(50) NOT NULL COMMENT '电子邮件',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `type_id` tinyint(2) unsigned DEFAULT '0' COMMENT '编号类型',
  `info` text NOT NULL COMMENT '用户信息',
  `question` VARCHAR(30) NOT NULL COMMENT '密保问题',
  `answer` VARCHAR(60) NOT NULL COMMENT '密保答案',
  `integral` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


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
  `about` varchar(420) NOT NULL COMMENT '内容简介',
  `img` varchar(255) NOT NULL COMMENT '视频封面图片',
  `definition` varchar(10) NOT NULL DEFAULT '0' COMMENT '清晰度',
  `playtime` varchar(10) NOT NULL COMMENT '播放时长',
  `relevanceid` int(10) NOT NULL DEFAULT '0' COMMENT '连播表ID',
  `relevancesort` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '连播排序号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '视频状态\r\n     0=已通过\r\n     1=待审核\r\n     2=已忽略',
  PRIMARY KEY (`vid`),
  KEY `uid` (`uid`),
  KEY `specialid` (`specialid`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频信息表' AUTO_INCREMENT=1 ;


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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0为关闭 1为启用',
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

INSERT INTO `fox50_video_category` (`id`, `upid`, `catname`, `num`, `allowcomment`, `displayorder`, `notinheritedarticle`, `notinheritedblock`, `domain`, `url`, `uid`, `username`, `dateline`, `status`, `shownav`, `description`, `seotitle`, `keyword`, `primaltplname`, `disallowpublish`, `foldername`, `perpage`, `maxpages`) VALUES
(1, 0, '电影', 0, 1, 1, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频电影频道-最好的享受', 'Fox50视频电影频道', 'Fox50', '', 0, '', 0, 0),
(2, 0, '电视剧', 0, 1, 2, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频连续剧频道-最好的享受', 'Fox50视频电视剧频道', 'Fox50', '', 0, '', 0, 0),
(3, 0, '动漫', 0, 1, 4, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频动漫频道-最好的享受', 'Fox50视频动漫频道', 'Fox50', '', 0, '', 0, 0),
(4, 0, '娱乐', 0, 1, 9, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频娱乐频道-最好的享受', 'Fox50视频娱乐频道', 'Fox50', '', 0, '', 0, 0),
(5, 0, '资讯', 0, 1, 8, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频资讯频道-最好的享受', 'Fox50视频资讯频道', 'Fox50', '', 0, '', 0, 0),
(6, 0, '生活', 0, 1, 15, 0, 0, '', '', 0, 'system', 20130113, 0, 1, 'Fox50视频生活频道-最好的享受', 'Fox50视频生活频道', 'Fox50', '', 0, '', 0, 0);


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


CREATE TABLE IF NOT EXISTS `fox50_video_region` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区编号',
  `regionname` varchar(255) NOT NULL DEFAULT '' COMMENT '地区名称',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频数',
  `displayorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频地区表' AUTO_INCREMENT=10 ;

INSERT INTO `fox50_video_region` (`id`, `regionname`, `num`, `displayorder`, `status`) VALUES
(1, '大陆', 0, 1, 1),
(2, '香港', 0, 2, 1),
(3, '台湾', 0, 3, 1),
(4, '韩国', 0, 4, 1),
(5, '美国', 0, 5, 1),
(6, '欧洲', 0, 6, 1),
(7, '日本', 0, 7, 1),
(8, '印度', 0, 8, 1),
(9, '新加坡', 0, 9, 1);


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


CREATE TABLE IF NOT EXISTS `fox50_video_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `upid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类编号/栏目编号',
  `typename` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '视频数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频类型表' AUTO_INCREMENT=260 ;

INSERT INTO `fox50_video_type` (`id`, `upid`, `typename`, `num`, `status`, `displayorder`) VALUES
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
(49, 1, '其他', 0, 1, 49),

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
(99, 2, '其他', 0, 1, 49),

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
(149, 3, '其他', 0, 1, 49),

(151, 4, '明星八卦', 0, 1, 1),
(152, 4, '影视快讯', 0, 1, 2),
(153, 4, '综艺节目', 0, 1, 3),
(154, 4, '音乐资讯', 0, 1, 4),
(155, 4, '娱乐深喉', 0, 1, 5),
(156, 4, '精彩专题', 0, 1, 6),
(199, 4, '其他', 0, 1, 49),

(201, 5, '大陆', 0, 1, 1),
(202, 5, '国际', 0, 1, 2),
(203, 5, '台海', 0, 1, 3),
(204, 5, '社会', 0, 1, 4),
(205, 5, '拍客', 0, 1, 5),
(206, 5, '财经', 0, 1, 6),
(207, 5, '体育', 0, 1, 7),
(208, 5, '评论', 0, 1, 8),
(249, 5, '其他', 0, 1, 49),

(251, 6, '时尚', 0, 1, 1),
(252, 6, '旅游', 0, 1, 2),
(253, 6, '公开课堂', 0, 1, 3),
(299, 6, '其他', 0, 1, 49);


CREATE TABLE IF NOT EXISTS `fox50_video_recommended` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '推荐ID',
  `vid` mediumint(8) NOT NULL COMMENT '视频ID',
  `img` varchar(255) NOT NULL COMMENT '视频封面图片',
  `title` varchar(255) NOT NULL COMMENT '视频标题',
  `displayorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  PRIMARY KEY(`id`),
  KEY(`vid`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频推荐表' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `fox50_video_flow` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '连播ID',
  `uid` mediumint(10) NOT NULL COMMENT '用户ID',
  `name` varchar(50) NOT NULL COMMENT '连播名称',
  `vidlist` varchar(250) NOT NULL COMMENT '连播视频ID',
  `status` tinyint(1) NOT NULL COMMENT '状态(完结？否则在上传界面显示)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='视频连播表' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `fox50_video_recently` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '最近ID',
  `uid` mediumint(10) NOT NULL COMMENT '用户ID',
  `vid` mediumint(8) NOT NULL COMMENT '视频ID',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '播放时间',
  `device` varchar(15) NOT NULL COMMENT '播放设备',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='最近播放表' AUTO_INCREMENT=1 ;

