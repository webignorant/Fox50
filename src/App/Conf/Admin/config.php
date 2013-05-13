<?php
return array(
	// 后台权限控制配置
    'APP_AUTOLOAD_PATH'         =>  '@.TagLib',
    'SESSION_AUTO_START'        =>  true,
    //'TMPL_ACTION_ERROR'         =>  'Public:success', // 默认错误跳转对应的模板文件
    //'TMPL_ACTION_SUCCESS'       =>  'Public:success', // 默认成功跳转对应的模板文件
    'RBAC_ERROR_PAGE'           =>  '/Admin/Public/logout',      //权限错误跳转对应的模板文件
    'USER_AUTH_ON'              =>  true,
    'USER_AUTH_TYPE'			      =>  2,		            // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'             =>  'authId',	        // 用户认证SESSION标记
    'ADMIN_AUTH_KEY'			      =>  'administrator',
    'SUPER_ADMIN_NAME'          =>  'feng',            //超级管理员名字
    'USER_AUTH_MODEL'           =>  'User',	          // 默认验证数据表模型
    'AUTH_PWD_ENCODER'          =>  'md5',	          // 用户认证密码加密方式
    'USER_AUTH_GATEWAY'         =>  'Admin/Public/login',  // 默认认证网关
    'NOT_AUTH_MODULE'           =>  'Public',	        // 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>  '',		            // 默认需要认证模型
    'NOT_AUTH_ACTION'           =>  '',		            // 默认无需认证操作
    'REQUIRE_AUTH_ACTION'       =>  '',		            // 默认需要认证操作
    'GUEST_AUTH_ON'             =>  false,            // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>  0,                // 游客的用户ID
    'DB_LIKE_FIELDS'            =>  'title|remark',
    'RBAC_ROLE_TABLE'           =>  'fox50_role',
    'RBAC_USER_TABLE'           =>  'fox50_role_user',
    'RBAC_ACCESS_TABLE'         =>  'fox50_access',
    'RBAC_NODE_TABLE'           =>  'fox50_node',
    //模版界定符
    'TMPL_L_DELIM'=>'{',
    'TMPL_R_DELIM'=>'}',
);