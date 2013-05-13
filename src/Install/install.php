<?php
/*
 * 借用tThinkSNS 安装文件,修改自pbdigg.
 */

error_reporting(0);
session_start();
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo 'This is a server using Windows!';
} else {
    session_id("fox50");
}

define('THINKSNS_INSTALL', TRUE);
define('THINKSNS_ROOT', str_replace('\\', '/', substr(dirname(__FILE__), 0, -7)));

$_TSVERSION = 'Beta';

include 'install_function.php';
include 'install_lang.php';

$timestamp				=	time();
$ip						=	getip();
$installfile			=	'fox50.sql';
$thinksns_config_file	=	'/App/Conf/config.php';
$fox_admin_config_file	=	'/App/Conf/Admin/config.php';

//判断是否安装过数据库
header('Content-Type: text/html; charset=utf-8');
if (file_exists('install.lock'))
{
	exit($i_message['install_lock']);
}
if (!is_readable($installfile))
{
	exit($i_message['install_dbFile_error']);
}
$quit = false;
$msg = $alert = $link = $sql = $allownext = '';

$PHP_SELF = addslashes(htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']));
set_magic_quotes_runtime(0);
if (!get_magic_quotes_gpc())
{
	addS($_POST);
	addS($_GET);
}
@extract($_POST);
@extract($_GET);
?>
<html>
<head>
<title><?php echo $i_message['install_title']; ?></title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="images/style.css" rel="stylesheet" type="text/css" />
<body>
<div id='content'>
<div id='pageheader'>
	<div id="logo"><img src="images/fox50.png" width="260" height="50" border="0" alt="ChipCore" /></div>
	<div id="version" class="rightheader">Version <?php echo $_TSVERSION; ?></div>
</div>
<div id='innercontent'>
	<h1>Fox50 <?php echo $_TSVERSION, ' ', $i_message['install_wizard']; ?></h1>
<?php
if (!$v)
{
?>
<div class="botBorder">
<p><span class='red'><?php echo $i_message['install_warning'];?></span></p>
</div>
<div class="botBorder">
<?php echo $i_message['install_intro'];?>
</div>
<form method="post" action="install.php?v=1">
<p class="center"><input type="submit" class="submit" value="<?php echo $i_message['install_start'];?>" /></p>
</form>
<?php
}
elseif ($v == '1')
{
?>
    <h2><?php echo $i_message['install_license_title'];?></h2>
    <p>
    <textarea class="textarea" readonly="readonly" cols="50">
    <?php echo $i_message['install_license'];?>
    </textarea>
    </p>
    <form action="install.php?v=2" method="post">
    <p><label><input type="checkbox" name="agree" value="1" onClick="if(this.checked==true){this.form.next.disabled=''}else{this.form.next.disabled='true'}" checked="checked" /><?php echo $i_message['install_agree'];?></label></p>
    <p class="center"><input type="submit" style="width:200px;" class="submit" name="next" value="<?php echo $i_message['install_next'];?>" /></p>
    </form>
    <?php
}
elseif ($v == '2')
{
	if ($agree == 'no')
	{
		echo '<script>alert('.$i_message['install_disagree_license'].');history.go(-1)</script>';
	}
	$dirarray = array (
		'./PhotoUploads',
		'./VideoUploads',
		'./Install',
		'./App/Runtime',
	);
	$writeable = array();
	foreach ($dirarray as $key => $dir)
	{
		if (writable($dir))
		{
			$writeable[$key] = $dir.result(1, 0);
		}
		else
		{
			$writeable[$key] = $dir.result(0, 0);
			$quit = TRUE;
		}
	}
	?>
	<div class="shade">
	<div class="settingHead"><?php echo $i_message['install_env'];?></div>
	<h5><?php echo $i_message['php_os'];?></h5>
	<p><?php echo PHP_OS;result(1, 1);?></p>
	<h5><?php echo $i_message['php_version'];?></h5>
	<p>
	<?php
	echo PHP_VERSION;
	if (PHP_VERSION < '5.1.2')
	{
		result(0, 1);
		$quit = TRUE;
	}
	else
	{
		result(1, 1);
	}
	?></p>
	<h5><?php echo $i_message['file_upload'];?></h5>
	<p>
	<?php
	if (@ini_get('file_uploads'))
	{
		echo $i_message['support'],'/',@ini_get('upload_max_filesize');
	}
	else
	{
		echo '<span class="red">'.$i_message['unsupport'].'</span>';
	}
	result(1, 1);
	?></p>
	<h5><?php echo $i_message['php_extention'];?></h5>
	<p>
	<?php
	if (extension_loaded('mysql'))
	{
		echo 'mysql:'.$i_message['support'];
		result(1, 1);
	}
	else
	{
		echo '<span class="red">'.$i_message['php_extention_unload_mysql'].'</span>';
		result(0, 1);
		$quit = TRUE;
	}
	?></p>
	<p>
	<?php
	if (extension_loaded('gd'))
	{
		echo 'gd:'.$i_message['support'];
		result(1, 1);
	}
	else
	{
		echo '<span class="red">'.$i_message['php_extention_unload_gd'].'</span>';
		result(0, 1);
		$quit = TRUE;
	}
	?></p>
	<p>
	<?php
	if (extension_loaded('curl'))
	{
		echo 'curl:'.$i_message['support'];
		result(1, 1);
	}
	else
	{
		echo '<span class="red">'.$i_message['php_extention_unload_curl'].'</span>';
		result(0, 1);
		$quit = TRUE;
	}
	?></p>
	<p>
	<?php
	if (extension_loaded('mbstring'))
	{
		echo 'mbstring:'.$i_message['support'];
		result(1, 1);
	}
	else
	{
		echo '<span class="red">'.$i_message['php_extention_unload_mbstring'].'</span>';
		result(0, 1);
		$quit = TRUE;
	}
	?></p>
	
	
	
	<h5><?php echo $i_message['mysql'];?></h5>
	<p>
	<?php
	if (function_exists('mysql_connect'))
	{
		echo $i_message['support'];
		result(1, 1);
	}
	else
	{
		echo '<span class="red">'.$i_message['mysql_unsupport'].'</span>';
		result(0, 1);
		$quit = TRUE;
	}
	?></p>
	
	
	</div>
	<div class="shade">
	<div class="settingHead"><?php echo $i_message['dirmod'];?></div>
	<?php
	foreach ($writeable as $value)
	{
		echo '<p>'.$value.'</p>';
	}
	//全局配置文件
	if (is_writable(THINKSNS_ROOT.$thinksns_config_file))
	{
		echo '<p>'.$thinksns_config_file.result(1, 0).'</p>';
	}
	else
	{
		echo '<p>'.$thinksns_config_file.result(0, 0).'</p>';
		$quit = TRUE;
	}
	//后台配置文件
	if (is_writable(THINKSNS_ROOT.$fox_admin_config_file))
	{
		echo '<p>'.$fox_admin_config_file.result(1, 0).'</p>';
	}
	else
	{
		echo '<p>'.$fox_admin_config_file.result(0, 0).'</p>';
		$quit = TRUE;
	}
	?>
	<!-- <span class='red'><?php echo $i_message['install_dirmod'];?></span> -->
	</div>
	<p class="center">
		<form method="post" action='install.php?v=3'>
		<input style="width:200px;" type="submit" class="submit" name="next" value="<?php echo $i_message['install_next'];?>" <?php if($quit) echo "disabled=\"disabled\"";?>>
		</form>
	</p>
	<?php
}
elseif ($v == '3')
{
?>
    <!-- <h2><?php echo $i_message['install_setting'];?></h2> -->
    <form method="post" action="install.php?v=4" id="install" onSubmit="return check(this);">
    <div class="shade">
    <div class="settingHead"><?php echo $i_message['install_mysql'];?></div>
    
    <h5><?php echo $i_message['install_mysql_host'];?></h5>
    <p><?php echo $i_message['install_mysql_host_intro'];?></p>
    <p><input type="text" name="db_host" value="localhost" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_mysql_username'];?></h5>
    <p><input type="text" name="db_username" value="root" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_mysql_password'];?></h5>
    <p><input type="password" name="db_password" value="" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_mysql_name'];?></h5>
    <p><input type="text" name="db_name" value="fox50" size="40" class='input' />
    </p>
    
    <h5><?php echo $i_message['install_mysql_prefix'];?></h5>
    <p><?php echo $i_message['install_mysql_prefix_intro'];?></p>
    <p><input type="text" name="db_prefix" value="fox50_" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['site_url'];?></h5>
    <p><?php echo $i_message['site_url_intro'];?></p>
    <p><input type="text" name="site_url" value="<?php echo "http://".$_SERVER['HTTP_HOST'].rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))),'/');?>" size="40" class='input' /></p>
    
    </div>
    
    <div class="shade">
    <div class="settingHead"><?php echo $i_message['founder'];?></div>
    
    <h5><?php echo $i_message['auto_increment'];?></h5>
    <p><input type="text" name="first_user_id" value="1" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_founder_name'];?></h5>
    <p><input type="text" name="account" value="" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_founder_email'];?></h5>
    <p><input type="text" name="email" value="admin@admin.com" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_founder_password'];?></h5>
    <p><input type="text" name="password" value="" size="40" class='input' /></p>
    
    <h5><?php echo $i_message['install_founder_rpassword'];?></h5>
    <p><input type="text" name="rpassword" value="" size="40" class='input' /></p>
    
    
    </div>
    <div class="center">
        <input type="button" class="submit" name="prev" value="<?php echo $i_message['install_prev'];?>" onClick="history.go(-1)">&nbsp;
        <input type="submit" class="submit" name="next" value="<?php echo $i_message['install_next'];?>">
    </form>
    </div>
    <script type="text/javascript" language="javascript">
    function check(obj)
    {
        if (!obj.db_host.value)
        {
            alert('<?php echo $i_message['install_mysql_host_empty'];?>');
            obj.db_host.focus();
            return false;
        }
        else if (!obj.db_username.value)
        {
            alert('<?php echo $i_message['install_mysql_username_empty'];?>');
            obj.db_username.focus();
            return false;
        }
        else if (!obj.db_name.value)
        {
            alert('<?php echo $i_message['install_mysql_name_empty'];?>');
            obj.db_name.focus();
            return false;
        }
        else if (obj.password.value.length < 6)
        {
            alert('<?php echo $i_message['install_founder_password_length'];?>');
            obj.password.focus();
            return false;
        }
        else if (obj.password.value != obj.rpassword.value)
        {
            alert('<?php echo $i_message['install_founder_rpassword_error'];?>');
            obj.rpassword.focus();
            return false;
        }
        else if(!obj.account.value)
        {
            alert('<?php echo $i_message['install_founder_name_empty'];?>');
            obj.account.focus();
            return false;
        }
        else if (!obj.email.value)
        {
            alert('<?php echo $i_message['install_founder_email_empty'];?>');
            obj.email.focus();
            return false;
        }
        return true;
    }
    </script>
<?php
}
elseif ($v == '4')
{
	if(empty($db_host) || empty($db_username) || empty($db_name) || empty($db_prefix))
	{
		$msg .= '<p>'.$i_message['mysql_invalid_configure'].'<p>';
		$quit = TRUE;
	}
	elseif (!@mysql_connect($db_host, $db_username, $db_password))
	{
		$msg .= '<p>'.mysql_error().'</p>';
		$quit = TRUE;
	}
	if(strstr($db_prefix, '.'))
	{
		$msg .= '<p>'.$i_message['mysql_invalid_prefix'].'</p>';
		$quit = TRUE;
	}

	if (strlen($password) < 6)
	{
		$msg .= '<p>'.$i_message['founder_invalid_password'].'</p>';
		$quit = TRUE;
	}
	elseif ($password != $rpassword)
	{
		$msg .= '<p>'.$i_message['founder_invalid_rpassword'].'</p>';
		$quit = TRUE;
	}
	elseif (!preg_match('/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}$/i', $email))
	{
		$msg .= '<p>'.$i_message['founder_invalid_email'].'</p>';
		$quit = TRUE;
	}
	else
	{
		$forbiddencharacter = array ("\\","&"," ","'","\"","/","*",",","<",">","\r","\t","\n","#","$","(",")","%","@","+","?",";","^");
		foreach ($forbiddencharacter as $value)
		{
			if (strpos($username, $value) !== FALSE)
			{
				$msg .= '<p>'.$i_message['forbidden_character'].'</p>';
				$quit = TRUE;
				break;
			}
		}
	}

	if ($quit)
	{
		$allownext = 'disabled="disabled"';
		?>
		<div class="error"><?php echo $i_message['error'];?></div>
		<?php
		echo $msg;
	}
	else
	{

		$config_file_content	=	array();
		$config_file_content['db_host']			=	$db_host;
		$config_file_content['db_name']			=	$db_name;
		$config_file_content['db_username']		=	$db_username;
		$config_file_content['db_password']		=	$db_password;
		$config_file_content['db_prefix']		=	$db_prefix;
		$config_file_content['db_pconnect']		=	0;
		$config_file_content['db_charset']		=	'utf8';
		$config_file_content['dbType']			=	'MySQL';

		$default_manager_account	=	array();
		$default_manager_account['account']		=	$account;
		$default_manager_account['email']		=	$email;
		$default_manager_account['password']	=	md5($password);

		$_SESSION['config_file_content']		=	$config_file_content;
		$_SESSION['default_manager_account']	=	$default_manager_account;
		$_SESSION['first_user_id']				=	$first_user_id;
		$_SESSION['site_url']					=	$site_url;
	}
?>
	<div class="botBorder">
		<p><?php echo $i_message['install_founder_name'], ': ', $account?></p>
		<p><?php echo $i_message['install_founder_email'], ': ', $email?></p>
		<p><?php echo $i_message['install_founder_password'], ': ', $password;?></p>
	</div>
	<div class="botBorder">

<?php
//写全局配置文件
$fp = fopen(THINKSNS_ROOT.$thinksns_config_file, 'wb');
$configfilecontent = <<<EOT
<?php
return array(
	//'配置项'=>'配置值'
	
	/********************惯例配置********************/
	/*[应用配置]*/
	//'APP_STATUS'            => 'debug',         //应用调试模式状态 调试模式开启后有效 默认为debug 可扩展 并自动加载对应的配置文件 
	'APP_FILE_CASE'         => 'true',         //是否检查文件的大小写 对Windows平台有效 
	//'APP_AUTOLOAD_PATH'     => '',              //自动加载机制的自动搜索路径,注意搜索顺序
	//'APP_TAGS_ON'           => true,            //系统标签扩展开关 
	//'APP_SUB_DOMAIN_DEPLOY' => false,           //是否开启子域名部署 
	//'APP_SUB_DOMAIN_RULES'  => array(),         //子域名部署规则 
	//'APP_SUB_DOMAIN_DENY'   => array(),         //子域名禁用列表
	'APP_GROUP_LIST'        => 'Admin,Home',              //项目分组
	//'ACTION_SUFFIX'         => '',              //操作方法后缀
	/*[默认值配置]*/
	//'DEFAULT_APP'           => '@',                 //默认项目名称，@表示当前项目 
	//'DEFAULT_LANG'          => 'zh-cn',             //默认语言 
	//'DEFAULT_THEME'         => '',                  //默认模板主题名称 
	'DEFAULT_GROUP'         => 'Home',              //默认分组名
	//'DEFAULT_MODULE'        => 'Index',             //默认模块名 
	//'DEFAULT_ACTION'        => 'index',             //默认操作名 
	//'DEFAULT_CHARSET'       => 'utf-8',             //默认输出编码 
	'DEFAULT_TIMEZONE'      => 'Asia/Shanghai',                //默认时区 
	//'DEFAULT_AJAX_RETURN'   => 'JSON',              //默认AJAX 数据返回格式,可选JSON XML
	//'DEFAULT_FILTER'        => 'htmlspecialchars',  //默认参数过滤方法 
	/*[Cookie设置]*/
	//'COOKIE_EXPIRE' => '3600',  //Coodie有效期（秒） 
	//'COOKIE_DOMAIN' => '',      //Cookie有效域名 
	//'COOKIE_PATH'   => '/',     //Cookie路径 
	'COOKIE_PREFIX' => '$db_prefix',      //Cookie前缀 避免冲突 
	/*[数据库配置]*/
	'DB_TYPE'               => 'mysql',           //数据库类型
	//'DB_DSN'                => '',                //数据库连接信息DSN串 
	'DB_HOST'               => '$db_host',       //数据库服务器地址
	'DB_NAME'               => '$db_name',       //数据库名称 
	'DB_USER'               => '$db_username',            //数据库用户名
	'DB_PWD'                => '$db_password',                //数据库密码
	'DB_PORT'               => '3306',            //数据库端口
	'DB_PREFIX'             => '$db_prefix',           //数据库表前缀（因为漫游的原因，数据库表前缀必须写在本文件）
	'DB_FIELDS_CACHE'       => 'true',            //是否开启数据表字段缓存 
	//'DB_FIELDTYPE_CHECK'    => 'false',           //是否开启字段类型检查 
	'DB_CHARSET'            => 'utf8',            //数据库编码
	//'DB_DEPLOY_TYPE'        => '0',               //数据库部署方式 0 集中式 1 分布式 
	//'DB_RW_SEPARATE'        => 'false',           //数据库是否需要读写分离 分布式部署下有效 
	//'DB_MASTER_NUM'         => '1',               //设置读写分离后 主服务器数量 
	//'DB_SLAVE_NO'           => '',                //设置读写分离后 指定从服务器序号（3.1新增）
	//'DB_SQL_BUILD_CACHE'    => 'false',           //数据库查询的SQL创建缓存 
	//'DB_SQL_BUILD_QUEUE'    => 'file',            //SQL缓存队列的缓存方式 
	//'DB_SQL_BUILD_LENGTH'   => '20',              //SQL缓存的队列长度 
	//'DB_SQL_LOG'            => 'false',           //是否开启SQL日志记录（3.1新增）
	/*[数据缓存设置]*/
	//'DATA_CACHE_TIME'         => '0',             //数据缓存有效期 0表示永久缓存
	//'DATA_CACHE_COMPRESS'     => 'false',         //数据缓存是否压缩缓存 
	//'DATA_CACHE_CHECK'        => 'false',         //数据缓存是否校验缓存 
	//'DATA_CACHE_TYPE'         => 'File',          //数据缓存类型 
	//'DATA_CACHE_PATH'         => 'TEMP_PATH',     //缓存路径设置 (仅对File方式缓存有效)
	//'DATA_CACHE_SUBDIR'       => 'alse',          //使用子目录缓存(仅对File方式缓存有效)
	//'DATA_PATH_LEVEL'         => '1',             //子目录缓存级别(仅对File方式缓存有效)
	/*[错误设置]*/
	//'ERROR_MESSAGE'           => '',              //错误显示信息，部署模式有效 
	//'ERROR_PAGE'              => '',              //错误定向页面，部署模式有效 
	//'SHOW_ERROR_MSG'          => 'False',         //是否显示错误信息 
	/*[日志设置]*/
	//'LOG_RECORD'              => 'false',                 //是否记录日志信息 
	//'LOG_TYPE'                => '3',                     //默认日志记录类型 0 系统 1 邮件 3 文件 4 SAPI
	//'LOG_DEST'                => '',                      //日志记录目标 
	//'LOG_EXTRA'               => '',                      //日志记录额外信息 
	//'LOG_LEVEL'               => 'EMERG,ALERT,CRIT,ERR',  //允许记录的日志级别 
	//'LOG_FILE_SIZE'           => '2097152',               //日志文件大小限制（字节 文件方式有效）
	//'LOG_EXCEPTION_RECORD'    => 'false',                 //是否记录异常信息日志 
	/*[SESSION设置]*/
	//'SESSION_AUTO_START'      => 'true',          //是否自动开启Session
	'SESSION_OPTIONS'         => array('path'=>'App/Runtime/Session','name'=>'session_id','expire'=>'1800'),       //session 配置数组 
	//'SESSION_TYPE'            => '',              //session hander类型 
	//'SESSION_PREFIX'          => '',              //session 前缀 
	//'VAR_SESSION_ID'          => 'session_id',    //sessionID的提交变量 
	/*[模板引擎设置]*/
	//'TMPL_CONTENT_TYPE'       => 'text/html',                             //默认模板输出类型 
	//'TMPL_ACTION_ERROR'       => '系统模板目录下的dispatch_jump.tpl',     //默认错误跳转对应的模板文件 
	//'TMPL_ACTION_SUCCESS'     => '同上',                                  //默认成功跳转对应的模板文件 
	//'TMPL_EXCEPTION_FILE'     => '系统模板目录下的think_exception.tpl',   //异常页面的模板文件 
	//'TMPL_DETECT_THEME'       => 'false',                                 //自动侦测模板主题 
	//'TMPL_TEMPLATE_SUFFIX'    => '.html',                                 //默认模板文件后缀 
	//'TMPL_FILE_DEPR'          => '/',                                     //模板文件模块与操作之间的分割符，只对项目分组部署有效
	/*[URL设置]*/
	//'URL_CASE_INSENSITIVE'    => '',                                                  //URL是否不区分大小写 
	'URL_MODEL'               => '3',                                                  //URL访问模式支持 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE 模式);3 (兼容模式)
	//'URL_PATHINFO_DEPR'       => '',                                                  //PATHINFO模式下的参数分割符 
	//'URL_PATHINFO_FETCH'      => 'ORIG_PATH_INFO REDIRECT_PATH_INFO REDIRECT_URL',    //用于兼容判断PATH_INFO 参数的SERVER替代变量列表 
	//'URL_HTML_SUFFIX'         => '',                                                  //URL伪静态后缀设置 
	//'URL_404_REDIRECT'        => '',                                                  //404跳转页面 部署模式有效
	//'URL_PARAMS_BIND'         => 'true',                                              //URL变量绑定到Action方法参数（3.1新增）
	/*系统变量名称设置*/
	//'VAR_GROUP'           => 'g',         //默认分组获取变量 
	//'VAR_MODULE'          => 'm',         //默认模块获取变量 
	//'VAR_ACTION'          => 'a',         //默认操作获取变量
	//'VAR_AJAX_SUBMIT'     => 'ajax',      //默认的AJAX提交变量 
	//'VAR_TEMPLATE'        => 't',         //默认模板主题切换变量 
	//'VAR_PATHINFO'        => 's',         //兼容模式获取变量 
	//'VAR_URL_PARAMS'      => '_URL_',     //PATHINFOURL参数变量 
	//'VAR_FILTERS'         => '',          //全局系统变量的默认过滤方法 多个用逗号分割（3.1新增）
	//'OUTPUT_ENCODE'       => 'true',      //是否开启页面压缩输出（3.1新增） 
	/********************惯例配置********************/
	
	/********************行为配置********************/
	/*[CheckRoute行为配置]*/
	//'URL_ROUTER_ON'       => 'false',     //是否开启URL路由 
	//'URL_ROUTE_RULES'     => 'array()',   //默认路由规则 
	/*[ContentReplace行为配置]*/
	//'TMPL_PARSE_STRING'   => 'array()',   //模板替换规则 
	/*[ParseTemplate行为配置]*/
	//'TMPL_ENGINE_TYPE'        => 'Think',         //默认模板引擎 
	//'TMPL_CACHFILE_SUFFIX'    => '.php',          //默认模板缓存后缀 
	//'TMPL_DENY_FUNC_LIST'     => 'echo,exit',     //模板引擎禁用函数 
	//'TMPL_DENY_PHP'           => 'false',         //是否禁用PHP原生代码 
	'TMPL_L_DELIM'            => '<{',             //模板引擎普通标签开始标记 
	'TMPL_R_DELIM'            => '}>',             //模板引擎普通标签结束标记 
	//'TAGLIB_BEGIN'            => '<',             //标签库标签开始标记 
	//'TAGLIB_END'              => '>',             //标签库标签结束标记 
	//'TAGLIB_LOAD'             => 'true',          // 是否使用内置标签库之外的其它标签库，默认自动检测 
	//'TAGLIB_BUILD_IN'         => 'cx',            //内置标签库名称 
	//'TAGLIB_PRE_LOAD'         => '',              //需要预先加载的标签库 
	//'TMPL_VAR_IDENTIFY'       => 'array',         //模板变量识别。留空自动判断 
	//'TMPL_STRIP_SPACE'        => 'true',          //是否去除模板文件里面的html空格与换行 
	//'TMPL_CACHE_ON'           => 'true',          //是否开启模板编译缓存 
	//'TMPL_CACHE_TIME'         => '0',             //模板缓存有效期 0为永久 
	//'LAYOUT_ON'               => 'false',         //是否启用布局
	//'LAYOUT_NAME'             => 'layout',        //当前布局名称 
	//'TMPL_LAYOUT_ITEM'        => '{__CONTENT__}', //布局模板的内容替换标识 
	/*[ReadHtmlCache行为配置]*/
	//'HTML_CACHE_ON'           => 'false',         //是否开启静态缓存 
	//'HTML_CACHE_RULES'        => 'array()',       //静态缓存规则 
	//'HTML_CACHE_TIME'         => '60',            //静态缓存有效期（秒）
	//'HTML_FILE_SUFFIX'        => '.html',         //静态缓存后缀 
	/*[ShowPageTrace行为配置]*/
	//'SHOW_PAGE_TRACE'         => 'false',         //显示页面Trace信息
	/*[ShowRuntime行为配置]*/
	//'SHOW_RUN_TIME'           => 'false',         //是否显示运行时间
	//'SHOW_ADV_TIME'           => 'false',         //是否显示详细的运行时间 
	//'SHOW_DB_TIMES'           => 'false',         //是否显示数据库查询和写入次数 
	//'SHOW_CACHE_TIMES'        => 'false',         //是否显示缓存操作次数 
	//'SHOW_USE_MEM'            => 'false',         //是否显示内存开销
	//'SHOW_LOAD_FILE'          => 'false',         //是否显示加载文件数 
	//'SHOW_FUN_TIMES'          => 'false',         //是否显示函数调用次数 
	/*[TokenBuild行为配置]*/
	//'TOKEN_ON'    => 'true',          //是否开启令牌验证 
	//'TOKEN_NAME'  => '__hash__',      //令牌验证的表单隐藏字段名称 
	//'TOKEN_TYPE'  => 'md5',           //令牌验证哈希规则
	//'TOKEN_RESET' => 'true',          //令牌错误后是否重置 
	/********************行为配置********************/
	
	/********************自定义配置********************/
	//分页变量
	'VAR_PAGE' => 'page',
	// 用户认证SESSION标记
	'USER_AUTH_KEY' => 'foxauthId',
	/********************自定义配置********************/
);

EOT;
$configfilecontent = str_replace('SECURE_TEST','SECURE'.rand(10000,20000),$configfilecontent);
chmod(THINKSNS_ROOT.$thinksns_config_file, 0777);
$result_1	=	fwrite($fp, trim($configfilecontent));
@fclose($fp);

if($result_1 && file_exists(THINKSNS_ROOT.$thinksns_config_file)){
?>
	<p><?php echo $i_message['config_log_success']; ?></p>
<?php
}else{
?>
	<p><?php echo $i_message['config_read_failed']; $quit = TRUE;?></p>
<?php
}
?>

<?php
//写后台配置文件
$role = $db_prefix.'role';
$role_user = $db_prefix.'role_user';
$access = $db_prefix.'access';
$node = $db_prefix.'node';
$fp = fopen(THINKSNS_ROOT.$fox_admin_config_file, 'wb');
$configfilecontent = <<<EOT
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
    'SUPER_ADMIN_NAME'          =>  '$account',            //超级管理员名字
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
    'RBAC_ROLE_TABLE'           =>  '$role',
    'RBAC_USER_TABLE'           =>  '$role_user',
    'RBAC_ACCESS_TABLE'         =>  '$access',
    'RBAC_NODE_TABLE'           =>  '$node',
    //模版界定符
    'TMPL_L_DELIM'=>'{',
    'TMPL_R_DELIM'=>'}',
);
EOT;
$configfilecontent = str_replace('SECURE_TEST','SECURE'.rand(10000,20000),$configfilecontent);
chmod(THINKSNS_ROOT.$fox_admin_config_file, 0777);
$result_1	=	fwrite($fp, trim($configfilecontent));
@fclose($fp);

if($result_1 && file_exists(THINKSNS_ROOT.$fox_admin_config_file)){
?>
	<p><?php echo $i_message['admin_config_log_success']; ?></p>
<?php
}else{
?>
	<p><?php echo $i_message['admin_config_read_failed']; $quit = TRUE;?></p>
<?php
}
?>

	</div>
	<div class="center">
		<form method="post" action="install.php?v=5">
		<input type="button" class="submit" name="prev" value="<?php echo $i_message['install_prev'];?>" onClick="history.go(-1)">&nbsp;
		<input type="submit" class="submit" name="next" value="<?php echo $i_message['install_next'];?>" <?php echo $allownext;?> >
		</form>
	</div>
<?php
}
elseif ($v == '5')
{
	$db_config	=	$_SESSION['config_file_content'];

	if (!$db_config['db_host'] && !$db_config['db_name'])
	{
		$msg .= '<p>'.$i_message['configure_read_failed'].'</p>';
		$quit = TRUE;
	}
	else
	{
		mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
		$sqlv = mysql_get_server_info();
		if($sqlv < '4.1')
		{
			$msg .= '<p>'.$i_message['mysql_version_402'].'</p>';
			$quit = TRUE;
		}
		else
		{
			$db_charset	=	$db_config['db_charset'];
			$db_charset = (strpos($db_charset, '-') === FALSE) ? $db_charset : str_replace('-', '', $db_charset);

			mysql_query(" CREATE DATABASE IF NOT EXISTS `{$db_config['db_name']}` DEFAULT CHARACTER SET $db_charset ");

			if (mysql_errno())
			{
				$errormsg = mysql_error();
				$msg .= '<p>'.($errormsg ? $errormsg : $i_message['database_errno']).'</p>';
				$quit = TRUE;
			}
			else
			{
				mysql_select_db($db_config['db_name']);
			}

			//判断是否有用同样的数据库前缀安装
			$re		=	mysql_query("SELECT COUNT(1) FROM {$db_config['db_prefix']}user");
			$link	=	@mysql_fetch_row($re);

			if( intval($link[0]) > 0 )
			{
				$thinksns_rebuild	=	true;
				$msg .= '<p>'.$i_message['thinksns_rebuild'].'</p>';
				$alert = ' onclick="return confirm(\''.$i_message['thinksns_rebuild'].'\');"';
			}
		}
	}

if ($quit)
{
		$allownext = 'disabled="disabled"';
?>
<div class="error"><?php echo $i_message['error'];?></div>
<?php
	echo $msg;
}
else
{
?>
<div class="botBorder">
<?php
if($thinksns_rebuild){
?>
<p style="color:red;font-size:16px;"><?php echo $i_message['thinksns_rebuild'];?></p>
<?php
}
?>
<p><?php echo $i_message['mysql_import_data'];?></p>
</div>
<?php
}
?>
<div class="center">
	<form method="post" action="install.php?v=6">
	<input type="button" class="submit" name="prev" value="<?php echo $i_message['install_prev'];?>" onClick="history.go(-1)">&nbsp;
	<input type="submit" class="submit" name="next" value="<?php echo $i_message['install_next'];?>" <?php echo $allownext,$alert?>>
	</form>
</div>
<?php
}
elseif ($v == '6')
{
$db_config	=	$_SESSION['config_file_content'];

mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
if (mysql_get_server_info() > '5.0')
{
	mysql_query("SET sql_mode = ''");
}
$db_config['db_charset'] = (strpos($db_config['db_charset'], '-') === FALSE) ? $db_config['db_charset'] : str_replace('-', '', $db_config['db_charset']);
mysql_query("SET character_set_connection={$db_config['db_charset']}, character_set_results={$db_config['db_charset']}, character_set_client=binary");
mysql_select_db($db_config['db_name']);
$tablenum = 0;

$fp = fopen($installfile, 'rb');
$sql = fread($fp, filesize($installfile));
fclose($fp);
?>
<div class="botBorder">
<h4><?php echo $i_message['import_processing'];?></h4>
<div style="overflow-y:scroll;height:200px;width:715px;padding:5px;border:1px solid #ccc;">
<?php
	$db_charset	=	$db_config['db_charset'];
	$db_prefix	=	$db_config['db_prefix'];
	$sql = str_replace("\r", "\n", str_replace('`'.'fox50_', '`'.$db_prefix, $sql));
	foreach(explode(";\n", trim($sql)) as $query)
	{
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 26) == 'CREATE TABLE IF NOT EXISTS')
			{
				$name = preg_replace("/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is", "\\2", $query);
				echo '<p>'.$i_message['create_table'].' '.$name.' ... <span class="blue">OK</span></p>';
				@mysql_query(createtable($query, $db_charset));
				$tablenum ++;
			}
			else
			{
				@mysql_query($query);
			}
		}
	}
?>
</div>
</div>
<div class="botBorder">
<h4><?php echo $i_message['create_founder'];?></h4>

<?php
	//设置网站用户起始ID
	if(intval($_SESSION['first_user_id'])>0){
		$admin_id	=	intval($_SESSION['first_user_id']);
		$sql0	=	"ALTER TABLE `{$db_config['db_prefix']}user` AUTO_INCREMENT=".$admin_id.";";
		if( mysql_query($sql0) ){
			echo '<p>'.$i_message['set_auto_increment_success'].'... <span class="blue">OK..'.$admin_id.'</span></p>';
		} else {
			echo '<p>'.$i_message['set_auto_increment_error'].'... <span class="red">ERROR</span></p>';
			$admin_id	=	1;
		}
	}else{
		$admin_id	=	1;
	}
	//添加最高管理员
	$siteFounder	=	$_SESSION['default_manager_account'];

	$sql1	=	"INSERT INTO `{$db_config['db_prefix']}user` (`id`, `account`, `nickname`, `password`, `bind_account`, `last_login_time`, `last_login_ip`, `login_count`, `verify`, `email`, `remark`, `create_time`, `update_time`, `status`, `type_id`, `info`) VALUES (".$admin_id.", '".$siteFounder['account']."', '最高管理员', 'e10adc3949ba59abbe56e057f20f883e', '', 1363307912, '127.0.0.1', 0, '8888', '".$siteFounder['email']."', '我是站长', 1222907803, 1361510274, 1, 0, ".time().");";
	/*
	$sql2	=	"INSERT INTO `{$db_config['db_prefix']}user` (`uid`, `email`, `password`, `uname`, `sex`, `province`, `city`, `location`, `admin_level`, `commend`, `is_active`, `is_init`, `is_synchronizing`, `cTime`, `identity`, `score`,`myop_menu_num`,`api_key`,`domain`) VALUES (".$admin_id.", '".$siteFounder['email']."', '".$siteFounder['password']."', '管理?, '0', '0', '0', NULL, '1', NULL, '1', '1', '0', ".time().", '1', '0', '10', NULL, '');";
	*/
	
	if( mysql_query($sql1) ){
		echo '<p>'.$i_message['create_founderpower_success'].'... <span class="blue">OK</span></p>';
	} else {
		echo '<p>'.$i_message['create_founderpower_error'].'... <span class="red">ERROR</span></p>';
		$quit	=	true;
	}

	/*将管理员添加到漫游的用户记录
	$sql_myop	=	"INSERT INTO `{$db_config['db_prefix']}myop_userlog` (`uid`, `action`, `type`, `dateline`) VALUES (".$admin_id.", 'add', '0', ".time().");";
	if( mysql_query($sql_myop) ){

	} else {
		$quit	=	true;
	}
	*/

	//将管理员加入"管理员"用户组
	$sql_user_group	=	"INSERT INTO `{$db_config['db_prefix']}role_user` (`role_id`, `user_id`) VALUES ('88', ".$admin_id.");";
	if( mysql_query($sql_user_group) ){

	} else {
		$quit	=	true;
	}

	/*将管理员设置为默认关注的用户
	$sql_auto_friend = "REPLACE INTO `{$db_config['db_prefix']}system_data` (`list`,`key`,`value`) VALUES ('register', 'register_auto_friend', '".serialize($admin_id)."');";
	if( mysql_query($sql_auto_friend) ){

	} else {
		$quit	=	true;
	}
	*/

	if(!$quit){
		//锁定安装
		fopen('install.lock', 'w');
		@unlink('../index.html');
	}else{
		echo '请重新安装';
	}
?>
</div>
<div class="botBorder">
<h4><?php echo $i_message['install_success'];?></h4>
<?php echo $i_message['install_success_intro'];?>
</div>
<iframe src="<?php echo $_SESSION['site_url'];?>/cleancache.php?all" height="0" width="0" style="display: none;"></iframe>
<?php
}
?>
</div>
<div class='copyright'>Fox50 <?php echo $_TSVERSION; ?> &#169; copyright 2010-<?php echo date('Y') ?> www.Fox50.com All Rights Reserved</div>
</div>
<div style="display:none;">
</div>
</body>
</html>