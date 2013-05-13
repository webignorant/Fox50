<?php

class Mysqlbak{
   var $DBHOST = "localhost";
   var $DBUSER = "root";
   var $DBPASS = "";
   var $DBNAME = "fox50";
   var $TABLEPATH = "./data";//表数据存放路径后面不加斜杠
   var $LANG = "gbk";//该功能是数据库要导入时，如果MYSQL高于4.0.x版本时，需要设置的语言编码格式！
   VAR $ERROR;
   
   
   /**
    * 初始化
    * 
    */
   public function __construct($DBHOST='localhost',$DBUSER='root',$DBPASS='',$DBNAME='fox50',$LANG='gbk'){
   	error_reporting(E_ALL & ~E_NOTICE);//报告错误
   	ob_start();//开启数据缓冲流
   	@set_time_limit(0);//设置脚本运行时间（无限制）
   	$this->DBHOST=$DBHOST;
   	$this->DBUSER=$DBUSER;
   	$this->DBPASS=$DBPASS;
   	$this->DBNAME=$DBNAME;
   	$this->LANG=$LANG;
   	$this->_content();
   }
   
   
  /**
   * 销毁方法
   * 
   */
   public function __destruct(){
   	ob_end_flush();	
   }
   
   
   
   /**
    * 连接服务器
    * 
    */
   public function _content(){
   	if(empty($this->DBHOST) || empty($this->DBUSER) || empty($this->DBNAME)) echo '数据库服务器、账号及数据库名称是不能为空';
   	if(!@mysql_connect($this->DBHOST,$this->DBUSER,$this->DBPASS)) echo  '连接服务器失败';
   	if(!@mysql_select_db($this->DBNAME)) echo '无法连接到数据库！请检查';
   	@mysql_close();//关闭数据库连接
   	return true;
   }
   
   
   
   /**
    * 查看数据库版本以及设置相关编码
    *
    */
   private function sql_connect(){
   	//连接信息
   	if(!mysql_connect($this->DBHOST,$this->DBUSER,$this->DBPASS)){
   		echo '连接服务器失败!';
   	};
   	if(mysql_get_server_info()>"4.1")
   		mysql_query("SET NAMES '".$this->LANG."'");
   	if(mysql_get_server_info()>"5.0.1")
   		mysql_query("SET sql_mode=''");
   	if(!mysql_select_db($this->DBNAME))
   		echo '连接数据库失败';
   	return true;
   }
   
   
   
   
   
   /**
    * 检测与创建设文件夹
    * @param string 类型BAK:创建文件夹;REV：检测文件夹
    * @param string 文件夹路径
    * @return 成功:true;恢复数据库文件夹不存在:-1;
    */
   public function dir($type,$dir_path=''){
   	
   	if($dir_path == '') $dir_path = $this->DBNAME;
   	
   	//创建数据库名称文件夹
   	if($type == 'BAK' && !file_exists($dir_path)) mkdir($dir_path,0700);
   		
   	 
   	if($type == "REV" && !file_exists($dir_path))
   		return '-1';
   	
   	return true;
   }
   
   
   
   /**
    * 查看数据库版本以及设置相关编码
    * 
    */
   public function _mysqlversion(){
   	if(!mysql_connect($this->DBHOST,$this->DBUSER,$this->DBPASS)) echo '连接服务器失败!';
   		
   	if(mysql_get_server_info()>"4.1")
   		mysql_query("SET NAMES '".$this->LANG."'");
   	if(mysql_get_server_info()>"5.0.1")
   		mysql_query("SET sql_mode=''");
   	
   	if(!mysql_select_db($this->DBNAME)) echo '连接数据库失败';
   	return true;
   }
   
   /**
    * 
    * 执行SQL语句
    * @param unknown_type $sql
    * @return boolean|resource
    */
   private function sql_query($sql=""){
   	if(empty($sql)) return false;
   	$query = mysql_query($sql);
   	return $query;
   }
   
   /**
    * 取得一行数据
    * @param unknown_type $query
    * @return boolean|multitype:
    */
   private function sql_fetch_array($query){
   	if(empty($query)) return false;
   	$rows = mysql_fetch_array($query);
   	return $rows;
   }
   
   
   /**
    * 取得表结构
    * @param unknown_type $table
    * @return string 创建表编码
    */
   private function table_sql($table){
   	$tabledump = "DROP TABLE IF EXISTS ".$table.";\n";
   	$query = $this->sql_query("SHOW CREATE TABLE ".$table);//拿了表结构
   	$rows = $this->sql_fetch_array($query);
   	$tabledump .= $rows[1].";\n\n";
   	return $tabledump;
   }
   
   
   /**
    * 读取文件
    * @param unknown_type $file
    * @return string 文件数据
    */
   private function read_file($file){
   	if($handle=@fopen($file,"rb"))
   	{
   		$file_data=fread($handle,filesize($file));
   		fclose($handle);
   	}
   	return $file_data;
   }
   
   
   
   /**
    * 恢复数据
    * @param $sql SQL语句
    */
   private function recover_data($sql){
   	$sql=str_replace("\r","\n",$sql);
   	$sql_array=explode(";\n",$sql);
   	foreach($sql_array as $key=>$value)
   	{
   		$value = trim($value);
   		if($value == "#" || $value == "--")
   		{
   			$queryy = explode("\n",$value);
   			$value = '';
   			foreach($queryy as $v2){
   				if($v2[0]!='#') $value.=$v2;
   			}
   		}
   		if($value){
   			$value=trim(str_replace("\n","",$value));
   			if(get_cfg_var("magic_quotes_gpc")) stripslashes($value);
   			$this->sql_query($value);
   		}
   	}
   	return true;
   }
   
   
   
   
   
   /**
    * 
    * 
    * @param unknown_type $model;备份全部表(默认)
    * @param unknown_type $array;备份指定表
    * @param string $all 分多个文件备份(默认)
    */
   public function tablebak($model = '',$array = '',$all=''){
   	
   	$this->sql_connect();
   	$table_list = mysql_list_tables($this->DBNAME);//列出所有表
   	$table_count = mysql_num_rows($table_list);//获取表格总数
   	if($model == ''){
   		if($all == ''){
   				for($i=0;$i < mysql_num_rows($table_list);$i++){
   					$table = mysql_tablename($table_list,$i);
   					$tb = $this->table_sql($table);
   					$handle = fopen($this->TABLEPATH."/".$table.".sql","wb");
   					if(!get_cfg_var("magic_quotes_gpc")) addslashes($tb);
   					fputs($handle,$tb);
   					fclose($handle);
   				}
   				return true;
   		
   		}else{
   			if(!file_exists($this->TABLEPATH."/".$this->DBNAME.".sql")){
   				$array = array();
   				for($i=0;$i < mysql_num_rows($table_list);$i++){
   					$table = mysql_tablename($table_list,$i);
   					$array[$i] = $this->table_sql($table);
   				}
   				$msg = implode("\n",$array);
   				$handle = fopen($this->dbdata."/".$this->dbdata.".sql","wb");
   				if(!get_cfg_var("magic_quotes_gpc")) addslashes($msg);
   				fputs($handle,$msg);
   				fclose($handle);
   				unset($msg);
   				return true;
   			}
   		}
   	}else{
   		if(is_array($array)){
   			foreach($array as $arr){
   				$tb = $this->table_sql($arr);
   				$handle = fopen($this->TABLEPATH."/".$arr.".sql","wb");
   				if(!get_cfg_var("magic_quotes_gpc")) addslashes($tb);
   				fputs($handle,$tb);
   				fclose($handle);
   			}
   			return true;
   		}else{
   			return false;
   		}
   	}
   }
   
   
   /**
    * 备份数据
    * @param $array array 数据表数组
    */
   public function bakdatatwo($array){
   	$this->sql_connect();
        $ini = 0;
        @$tableid =  0;
        @$startid =  0;
        @$pageid =  0;
       
   		for($is=0;$is<count($array);){
   			if($ini == $is){
   				@$tableid =  0;
   				@$startid =  0;
   				@$pageid =  0;
   			}	
   		$query = $this->sql_query("select count(*) as count from `".$array[$is]."`");
   		$num = $this->sql_fetch_array($query);
   		$count = $num["count"];//获取个数
   		$per_size = 1000;//最大数不超过1000
   		if($count<$per_size) $per_size = $count;
   		//数据为空情况
   		if($count && $startid < $count){
   			$query = $this->sql_query("select * from `".$array[$is]."` limit ".$startid.",".$per_size);
   			$numfields = mysql_num_fields($query);
   			$tabledump = "";
   			//-------------取了数据
   			while($rows = mysql_fetch_row($query)){
   				$tabledump .= "INSERT INTO $array[$is] VALUES (";
   				$comma = '';
   				for($i = 0; $i < $numfields; $i++){
   					$tabledump .= $comma.('\''.mysql_escape_string($rows[$i]).'\'');
   					$comma = ',';
   				}
   				$tabledump .= ");\n";
   				//---------------取出一条数据结束
   				$startid++;
   				//---分文件写入(数据大于2M的情况)
   				if(strlen($tabledump)>(2048*1024)){
   					$handle = fopen($this->TABLEPATH."/".$array[$is]."_".$pageid.".sql.","wb");
   					if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
   					fputs($handle,$tabledump);
   					fclose($handle);
   					unset($tabledump);//清空内容
   					//$this->errmsg(__URL__."bakdata/tableid/".$tableid."/startid/".($startid)."/pageid/".($pageid+1));
   					$pageid=$pageid+1;
   					$ini++;
   					continue;
   				}
   				//---分文件写入结束
   			}
   			 
   			//----数据表数据不为空的情况下
   			if($tabledump){
   				//第二个分页文件可能还不够2M的情况
   				if($pageid>0){
   					@$msg = file_get_contents($this->TABLEPATH."/".$array[$is]."_".($pageid-1).".sql");
   					if(strlen($msg) < (2048*1024)){
   						$handle = fopen($this->TABLEPATH."/".$array[$is]."_".($pageid-1).".sql","ab");
   						if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
   						fputs($handle,$tabledump);
   						fclose($handle);
   						unset($tabledump,$msg);
   						$newpageid = $pageid;
   					}else{
   						$handle = fopen($this->TABLEPATH."/".$array[$is]."_".$pageid.".sql","wb");
   						if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
   						fputs($handle,$tabledump);
   						fclose($handle);
   						unset($tabledump);
   						$newpageid = $pageid + 1;
   					}
   				}else{
   					$handle = fopen($this->TABLEPATH."/".$array[$is]."_".$pageid.".sql","wb");
   					if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
   					fputs($handle,$tabledump);
   					fclose($handle);
   					unset($tabledump);
   					$newpageid = $pageid + 1;
   				}
   			}
   			//数据为空情况
   		}else{
   			$ais = ++$is;
   			$ini = $ais;
   			continue;
   		}	
   		//数据未备份完的情况
   		if($startid < $count){
   			//$this->errmsg("正在备份数据表 ".$table."信息。",__URL__."/bakdata/tableid/".$tableid."/startid/".($startid)."/pageid/".$newpageid);
   			$pageid = $newpageid;
   			$ini++;
   		}else{
   		    $ais = ++$is;
   		    $ini = $ais;
   		    continue;
   			//$this->errmsg("数据表".$table." 信息已经备份完毕，将开始备份下一个数据表",__URL__."/bakdata/tableid/".($tableid+1));
   		}
   	}//for结束
   }
   
   
   
   /**
    * 恢复表结构
    * @param $array 表数组
    * 
    */
   public function recovertable($array=''){
   	if(is_array($array)){
   		$this->sql_connect();
   	  foreach($array as $arr){
   	  	if(file_exists($this->TABLEPATH."/".$arr)){
   	  		$sql = $this->read_file($this->TABLEPATH."/".$arr);
   	  		$this->recover_data($sql);
   	  	}else{
   	  		$this->ERROR .= $arr.'不存在!';
   	  	}
   	  }
   	}
   }
   
   /**
    * 恢复数据
    * 参数:要恢复的表
    */
   public function recoverdata($array=''){
   	  if(is_array($array)){
   	  	$this->sql_connect();
   	  	foreach($array as $arr){
   	  		if(file_exists($this->TABLEPATH."/".$arr)){
   	  			$sql = $this->read_file($this->TABLEPATH."/".$arr);
   	  			$this->recover_data($sql);
   	  		}else{
   	  			$this->ERROR .= $arr.'不存在!';
   	  		}
   	  	}
   	  } 
   }
   
   /**
    * 返回数据表全部表名
    */     
   public function returntablecount(){
   	$this->sql_connect();
   	$table_list = mysql_list_tables($this->DBNAME);//列出所有表
   	$array = array();
   	for($i=0;$i < mysql_num_rows($table_list);$i++){
   		$table = mysql_tablename($table_list,$i);
   		$array[$i] = $table;
   	}
   	return $array;
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
    * 返回文件夹数据表结构表
    */
   public function datalist(){
   	$temp_list = array();
   	$i=0;
   	 foreach($this->traverse($this->TABLEPATH) as $temp){
   	 		$temp_array01 = explode('.sq',$temp);
   	 		$temp_array02 = explode('_',$temp_array01[0]);
   	 		$tempnum02 = count($temp_array02);
   	 		$tem = $temp_array02[$tempnum02 - 1];
   	 		if(!is_numeric($tem)){
   	 			$temp_list[$i]=$temp;
   	 			$i++;
   	 		}
   	 }
   	 return $temp_list; 
   }
   
   /**
    * 返回文件夹备份数据表
    */
   public function tablelist(){
   	$temp_list = array();
   	$i=0;
   	foreach($this->traverse($this->TABLEPATH) as $temp){
   		$temp_array01 = explode('.sq',$temp);
   		$temp_array02 = explode('_',$temp_array01[0]);
   		$tempnum02 = count($temp_array02);
   		$tem = $temp_array02[$tempnum02 - 1];
   		if(is_numeric($tem)){
   			$temp_list[$i]=$temp;
   			$i++;
   		}
   	}
   	return $temp_list;
   }

}