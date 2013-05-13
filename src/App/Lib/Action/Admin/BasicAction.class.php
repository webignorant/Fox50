<?php
class BasicAction extends CommonAction{
	
	public function index(){
		
		$system=array();

		date_default_timezone_set('Asia/Shanghai');
		//用户上次登录时间
		$system['userlastLoginTime']=date('Y/m/d h:i:s',$_SESSION['lastLoginTime']);
		//登录次数
		$system['userlogincount']=$_SESSION['login_count'];
		//登录ip
		$system['last_login_ip']=$_SESSION['last_login_ip'];
		//当前PHP的版本号
		$system['PHP_VERSION'] = PHP_VERSION;
		//当前服务器的操作系统
		$system['PHP_OS'] = PHP_OS;
		//服务器解译引擎
		$system['SERVER_SOFTWARE']=$_SERVER['SERVER_SOFTWARE'];
		//当前运行的PHP程序所在服务器主机的名称
		$system['SERVER_NAME'] = $_SERVER['SERVER_NAME'];
		//正在浏览当前页面用户的主机名
		$system['REMOTE_HOST'] = $_SERVER['REMOTE_HOST'];
		//正在游览的用户连接到服务器时所使用的端口
		$system['REMOTE_PORT'] = $_SERVER['REMOTE_PORT'];
		//客户端IP
		$system['ip'] = get_client_ip();
		//服务器所使用的端口
		$system['SERVER_PORT'] = $_SERVER['SERVER_PORT'];
		//最大的上传数
		$system['MaxFile']=$this->GetServerFileUpload();
		$import=require './App/Conf/config.php';
		//数据库版本号
		$system['MysqlVersion']=$this->GetMysqlVersion(C('DB_HOST'),C('DB_USER'),C('DB_PWD'));
		$system=array_merge($system,$import);
		$system['db_host']=C('DB_HOST');
		$system['db_name']=C('DB_NAME');
		$system['db_user']=C('DB_USER');
		$system['db_port']=C('DB_PORT');
		$system['db_type']=C('DB_TYPE');
		$system['cms_name']=C('CMS_NAME');
		$this->assign('system',$system);
		
		
		
		/*
 		//当前PHP的版本号
 		$system['PHP_VERSION'] = PHP_VERSION;
 		
 		//当前服务器的操作系统
 		$system['PHP_OS'] = PHP_OS;
 		
 		//服务器解译引擎
 		$system['SERVER_SOFTWARE']=$_SERVER['SERVER_SOFTWARE'];
 		
 		//当前运行的PHP程序所在服务器主机的名称
 		$system['SERVER_NAME'] = $_SERVER['SERVER_NAME'];
 		
 		
 		//正在浏览当前页面用户的主机名
 		$system['REMOTE_HOST'] = $_SERVER['REMOTE_HOST'];
 		
 		//正在游览的用户连接到服务器时所使用的端口
 		$system['REMOTE_PORT'] = $_SERVER['REMOTE_PORT'];
 		
 		//客户端IP
 		$system['ip'] = get_client_ip();
 		
 		//服务器所使用的端口
 		$system['SERVER_PORT'] = $_SERVER['SERVER_PORT'];
 		
 		//最大的上传数
 		$system['MaxFile']=$this->GetServerFileUpload();
 		
    $import=require './App/Conf/config.php';
 	  
 	  //数据库版本号
 		$system['MysqlVersion']=$this->GetMysqlVersion($import['DB_HOST'],$import['DB_USER'],$import['DB_PWD']);
 	  
 	  $system=array_merge($system,$import);

 		$this->assign('system',$system);
 		*/
 		$this->display();
		
	}
	
	/**
 	* 获取数据库版本号
 	*
 	*/
 	private function GetMysqlVersion($host,$user,$pw){
        $con = @mysql_connect($host,$user,$pw);
        $ver=mysql_get_server_info($con);
        @mysql_close($con);
        return $ver;
    }

  /**
  * 获取上传的最大数
  *
  */
  private function GetServerFileUpload(){
        if (@ini_get('file_uploads')) {
            return ini_get('upload_max_filesize');
        } else {
            return '<font color="red">禁止</font>';
        }
    }
	
	
}




?>