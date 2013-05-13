<?php
class LogAction extends CommonAction{
	
	public function index(){
		
	  $this->assign('log',$this->traverse('./App/Runtime/Logs'));
 		
		
		
		$this->display();
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
  
  /**
 	* 读取日志文件
 	*
 	*/
 	public function readlog(){
 		 echo file_get_contents('./App/Runtime/Logs/'.$_POST['send_content']);
 	}
  
}



?>