<?php
class DatabaseAction extends CommonAction{
	
	public function index(){
		
	 $content=file_get_contents('./App/Conf/config.php');
	 $true=1;
	 if(!empty($_POST['database'])){
	   $content=$this->host($_POST['database'],$content);
	 } 
   if(!empty($_POST['user'])){
	   $content=$this->user($_POST['user'],$content);
	 }
	 $content=$this->pass($_POST['pass'],$content);
	 if(!empty($_POST['port'])){
	   $content=$this->port($_POST['port'],$content);
	 }
   file_put_contents('./App/Conf/config.php',$content);
   $this->display();
  }

  /**
  * 匹配主机
  *
  */
  private function host($string,$content){
	 $pat =  "/\'DB_HOST{1}\'\s*\w*\W*\w*\',/";
	 $rep= "'DB_HOST' => '".$string."',";
	 return preg_replace($pat,$rep,$content);	
  }
  /**
  * 匹配端口
  *
  */
  private function port($string,$content){
   $pat =  "/\'DB_PORT{1}\'\s*\w*\W*\w*\',/";
	 $rep= "'DB_PORT' => '".$string."',";
	 return preg_replace($pat,$rep,$content);	
  }
  
  /**
  * 匹配用户名
  *
  */
  private function user($string,$content){
   $pat =  "/\'DB_USER{1}\'\s*\w*\W*\w*\',/";
	 $rep= "'DB_USER' => '".$string."',";
	 return preg_replace($pat,$rep,$content);	
  }
  
  /**
  * 匹配密码
  *
  */
  private function pass($string,$content){
   $pat =  "/\'DB_PWD{1}\'\s*\w*\W*\w*\',/";
	 $rep= "'DB_PWD' => '".$string."',";
	 return preg_replace($pat,$rep,$content);	
  }
  
}
?>