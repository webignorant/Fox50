<?php
 class SystemAction extends CommonAction{
 	
 	/**
 	* 显示网站运行环境
 	*
 	*/
 	public function index(){
 		
 		$system=array();

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
 		$system['MysqlVersion']=$this->GetMysqlVersion($import['db_host'],$import['db_user'],$import['db_pwd']);
 	  
 	  $system=array_merge($system,$import);

 		$this->assign('system',$system);
 		
 		$this->display();
 	}
 	
 	/**
 	*  系统设置
 	*
 	*/
 	public function set(){
   
 		
 	 // $this->display();
 	}
 	
 	
 	/**
 	* 数据库备份
 	*
 	*/
 	public function sqlbak(){
 		
 		
 		
 		
 		$this->display();
 	}
 	
 	
 	/**
 	* 系统日志
 	*
 	*/
 	public function log(){
 		  
 		$this->assign('log',$this->traverse('./App/Runtime/Logs'));
 		
 	  $this->display();
 	}
 	
 	
 	
 	
 	
 	/**
 	* 读取日志文件
 	*
 	*/
 	public function readlog(){
 		 echo file_get_contents('./App/Runtime/Logs/'.$_POST['send_content']);
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
  
  /**
  * 遍历文件夹
  *
  */ 
  private function traverse($path='./'){
  	 $foreachpath=array();
  	 if($current_dir=opendir($path)){
  	 	 $i=0;
  	 	 while(($file=readdir($current_dir)) !== false){
  	 	 	if($file == '.' || $file == '..'){
  	 	 		continue;
  	 	 	}else{
  	 	 		$foreachpath[$i]=$file;
  	 	 		$i++;
  	 	 	}
  	 	 }
  	 	return $foreachpath;
  	 }else{
  	 	$foreachpath='目录不正确或不存在相关目录!';
  	  return $foreachpath;
  	}
  	 	
  }
  
  
}
?>