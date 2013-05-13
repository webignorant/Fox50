<?php
class SqlbakAction extends CommonAction{
	
	public function index(){
		import('@.ORG.Util.Mysqlbak');
		$new =  new Mysqlbak(C('DB_HOST'),C('DB_USER'),C('DB_PWD'),C('DB_NAME'),'utf8');
		
		
		$this->assign('tablelist',$new->returntablecount());
		$this->assign('redata',$new->tablelist());
		$this->assign('retable',$new->datalist());
		$this->display();
	}
  /**	
  public function bakdata(){
		import('@.ORG.Util.Sqlbak');
		
		$bak = new Sqlbak;
		
		$bak->backup($_GET["tableid"],$_GET["startid"],$_GET["pageid"]);
		
		$this->display();
	}
  
  public function recoverdata(){
  	import('@.ORG.Util.Sqlbak');
  	
  	$recover = new Sqlbak;
  	$recover->recover();
    $recover->recoverdata($_GET["tableid"],$_GET["pageid"]);
  	$this->display();
  }
  */

  
  /**
   * 恢复数据表
   */
  public function redata(){
  	import('@.ORG.Util.Mysqlbak');
  	$new =  new Mysqlbak(C('DB_HOST'),C('DB_USER'),C('DB_PWD'),C('DB_NAME'),'utf8');
  	if(is_array($_POST['rech'])){
  		$new->recoverdata($_POST['rech']);
  		$this->success('恢复成功!');
  	}else{
  		$this->success('恢复失败!');
  	}
  }
  
  /**
   * 恢复数据表结构
   */
  public function retable(){
  	import('@.ORG.Util.Mysqlbak');
  	$new =  new Mysqlbak(C('DB_HOST'),C('DB_USER'),C('DB_PWD'),C('DB_NAME'),'utf8');
  	dump($_POST['recht']);
  	if(is_array($_POST['recht'])){
  		$new->recovertable($_POST['recht']);
  		$this->success('恢复成功!');
  	}else{
  		$this->success('恢复失败!');
  	}
  }
  
  
  
  /**
   * 备份表结构列表
   */
  public function backtable(){
  	import('@.ORG.Util.Mysqlbak');
  	$new =  new Mysqlbak(C('DB_HOST'),C('DB_USER'),C('DB_PWD'),C('DB_NAME'),'utf8');
  	if(is_array($_POST['cht'])){
  		$new->tablebak(1,$_POST['cht']);
  		$this->success('备份成功!');
  	}else{
  		$this->success('备份失败!');
  	}
  }
  
  
  /**
   * 备份数据
   */
  public function backdata(){
  	import('@.ORG.Util.Mysqlbak');
  	$new =  new Mysqlbak(C('DB_HOST'),C('DB_USER'),C('DB_PWD'),C('DB_NAME'),'utf8');
  	if(is_array($_POST['ch'])){
  		$new->bakdatatwo($_POST['ch']);
  		$this->success('备份成功!');
  	}else{
  		$this->success('备份失败!');
  	}
  }
}



?>