<?php
 class Sqlbak{
   var $dbhost = "localhost";
   var $dbuser = "root";
   var $dbpass = "";
   var $dbdata = "test";	
 	 var $lang = "gbk";//该功能是数据库要导入时，如果MYSQL高于4.0.x版本时，需要设置的语言编码格式！
 	//error_reporting(E_ALL & ~E_NOTICE);报告错误
 	//ob_start();开启数据缓冲流
  //@set_time_limit(0);//设置脚本运行时间（无限制）
 	
 	
 	
 	
 	public function __construct($dbhost='localhost',$dbuser='root',$dbpass='',$dbdata='test',$lang='gbk'){
 		error_reporting(E_ALL & ~E_NOTICE);
 		ob_start();
 		@set_time_limit(0);
 		$this->dbhost=$dbhost;
 		$this->dbuser=$dbuser;
 		$this->dbpass=$dbpass;
 		$this->dbdata=$dbdata;
 		$this->lang=$lang;
 		$this->chk_get_set();
 	}
 	
 	public function __destruct(){
 		ob_end_flush();
 	}
 	
/**
* 验证服务器与数据库；如果是恢复，则验证相关文件夹是否存在，如果是备份，则创建文件夹
* 参数:备份这是恢复
*/
private function chk_get_set($act="backup"){

       $db_host = $this->dbhost;
       $db_user = $this->dbuser;
       $db_pass = $this->dbpass;
       $db_data = $this->dbdata;
      if(empty($db_host) || empty($db_user) || empty($db_data))
         echo '数据库服务器、账号及数据库名称是不能为空';
        
       if(!@mysql_connect($db_host,$db_user,$db_pass)){ 
       	echo  '连接服务器失败';
       	}
        if(!@mysql_select_db($db_data)){
        	 echo '无法连接到数据库！请检查';
        }
        $msg = $act == "recover" ? "恢复" : "备份";
       if($act == "backup" && !file_exists($db_data)) 
         mkdir($db_data);//创建数据库名称文件夹
       
      if($act == "recover" && !file_exists($db_data)) 
        return '恢复数据库文件夹不存在!';
      
       @mysql_close();//关闭数据库连接
       
       //error("数据库信息已经配置完成，将进行下一步操作：\\n\\n\\t\\t".$msg."数据！","index.php?act=".$act);
      return true;
}
 	
 	
/**
* 查看数据库版本以及设置相关编码
*
*/
private function sql_connect(){
	     //连接信息
       if(!mysql_connect($this->dbhost,$this->dbuser,$this->dbpass)){
       	 echo '连接服务器失败!';
       	};
        if(mysql_get_server_info()>"4.1") 
         mysql_query("SET NAMES '".$this->lang."'");
         if(mysql_get_server_info()>"5.0.1") 
          mysql_query("SET sql_mode=''");
        if(!mysql_select_db($this->dbdata))
        echo '连接数据库失败';
      return true;
}
 	
 	
 	
private function sql_query($sql=""){
       if(empty($sql)) return false;
       $query = mysql_query($sql);
       return $query;
}

private function sql_fetch_array($query){
       if(empty($query)) return false;
        $rows = mysql_fetch_array($query);
       return $rows;
}	

private function errmsg($msg="",$url2="index.php"){
      
       echo "<script language=\"JavaScript\">\nfunction moveNew(){\nlocation.href=\"".$url2."\";\n}\nwindow.setTimeout('moveNew()','2000');\n</script>";
       echo $msg;
       echo "<br /><br />";
       echo "如果您的系统不支持跳转或系统长时间未跳转，请手动点击操作";
       echo "<input type='button' onclick=\"window.location='".$url.$url2."'\" value='手动点击跳转'>";
       die();
       return true;
} 	
 	
/**
*  返回表结构
*
*/
private function table2sql($table){
        $tabledump = "DROP TABLE IF EXISTS ".$table.";\n";
        $query = $this->sql_query("SHOW CREATE TABLE ".$table);//拿了表结构
       $rows = $this->sql_fetch_array($query);
       $tabledump .= $rows[1].";\n\n";
       return $tabledump;
}
 	

 	/**
 	* 报告错误
 	*
 	*/
private function error($msg="",$url2="index.php"){
     
      die("<script language=javascript>alert('提示：\\n\\n\\t".$msg."\\n');location.href='".$url2."'</script>");
        return true;
  }
 	
/**
* 读取文件
*
*/
private function read_msg($file){
       if($handle=@fopen($file,"rb"))
        {
               $file_data=fread($handle,filesize($file));
               fclose($handle);
        }
       return $file_data;
} 	
 	 	
/**
* 恢复数据
*
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
 	
 	
 	
//---------------------------------------------------公开方法---------------------------------------------------------------------------------- 	
 	
 	
 	
 /**
 * 备份函数
 *
 */
 public function backup($_tableid,$_startid,$_pageid){
  
  $this->sql_connect();	
 	   $table_list = mysql_list_tables($this->dbdata);//列出所有表
     $table_count = mysql_num_rows($table_list);//获取表格总数
     
     if(!file_exists($this->dbdata."/".$this->dbdata.".sql")){
                //-----备份数据表信息
               $array = array();
               for($i=0;$i < mysql_num_rows($table_list);$i++)
               {
                        $table = mysql_tablename($table_list,$i);//
                        $array[$i] = $this->table2sql($table);
               }
                $msg = implode("\n",$array);
                $handle = fopen($this->dbdata."/".$this->dbdata.".sql","wb");
               if(!get_cfg_var("magic_quotes_gpc")) addslashes($msg);
                fputs($handle,$msg);
                fclose($handle);
               unset($msg);
       }
       
       @$tableid = $_tableid ? intval($_tableid) : 0;
       @$startid = $_startid ? intval($_startid) : 0;
       @$pageid = $_pageid ? intval($_pageid) : 0;
       
        //-----开始内容备份
       if(($tableid+1)<$table_count){
               $table = mysql_tablename($table_list,$tableid);
               $query = $this->sql_query("select count(*) as count from `".$table."`");
               $num = $this->sql_fetch_array($query);
                $count = $num["count"];//获取个数
               $per_size = 1000;//最大数不超过1000
                if($count<$per_size) $per_size = $count;
               if($count && $startid < $count){
                       $query = $this->sql_query("select * from `".$table."` limit ".$startid.",".$per_size);
                      $numfields = mysql_num_fields($query);
                       $tabledump = "";
                       while($rows = mysql_fetch_row($query)){
                               $tabledump .= "INSERT INTO $table VALUES (";
                               $comma = '';
                               for($i = 0; $i < $numfields; $i++){
                                       $tabledump .= $comma.('\''.mysql_escape_string($rows[$i]).'\'');
                                        $comma = ',';
                               }
                                $tabledump .= ");\n";
                               //---------------

                                $startid++;
                               if(strlen($tabledump)>(2048*1024)){
                                       $handle = fopen($dbarray[3]."/".$table."_".$pageid.".sql.","wb");
                                        if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
                                       fputs($handle,$tabledump);
                                       fclose($handle);
                                       unset($tabledump);//清空内容
                                       
                                       
                                       
                                       
                                       
                                       $this->errmsg("正在备份数据表".$table." 信息，当前已经写入第".($pageid+1)." 页，即将写入第".($pageid+2)." 页信息",__URL__."bakdata/tableid/".$tableid."/startid/".($startid)."/pageid/".($pageid+1));
                                      
                                }
                       }
                        //----
                       if($tabledump){
                                if($pageid>0){
                                       @$msg = file_get_contents($this->dbdata."/".$table."_".($pageid-1).".sql");
                                       if(strlen($msg) < (2048*1024)){
                                             $handle = fopen($this->dbdata."/".$table."_".($pageid-1).".sql","ab");
                                               if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
                                                fputs($handle,$tabledump);
                                               fclose($handle);
                                               unset($tabledump,$msg);
                                               $newpageid = $pageid;
                                     }
                                      else{
                                               $handle = fopen($this->dbdata."/".$table."_".$pageid.".sql","wb");
                                               if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
                                              fputs($handle,$tabledump);
                                               fclose($handle);
                                                unset($tabledump);
                                               $newpageid = $pageid + 1;
                                        }
                               }else{
                                      $handle = fopen($this->dbdata."/".$table."_".$pageid.".sql","wb");
                                     if(!get_cfg_var("magic_quotes_gpc")) addslashes($tabledump);
                                       fputs($handle,$tabledump);
                                      fclose($handle);
                                     unset($tabledump);
                                      $newpageid = $pageid + 1;
                               }
                       }
                       
                       if($startid < $count){
                               $this->errmsg("正在备份数据表 ".$table."信息。",__URL__."/bakdata/tableid/".$tableid."/startid/".($startid)."/pageid/".$newpageid);
                      }else{
                              
                              $this->errmsg("数据表".$table." 信息已经备份完毕，将开始备份下一个数据表",__URL__."/bakdata/tableid/".($tableid+1));
                      }
               }else{
                      $this->errmsg("数据表".$table."信息为空，将开始下一个数据表信息备份",__URL__."/bakdata/tableid/".($tableid+1));
               }
        }else{
             $this->error("数据已经备份完毕！",__URL__."/index");
       }
}
 	
 	
/**
* 恢复数据
*
*/ 	
public function recover(){
       $this->sql_connect($cookie_db);////该功能是数据库要导入时，如果MYSQL高于4.0.x版本时，需要设置的语言编码格式！
       $sql = $this->read_msg($this->dbdata."/".$this->dbdata.".sql");
        $this->recover_data($sql);
       

}


/**
* 恢复数据表结构
*
*/
public function recoverdata($_tableid,$_pageid){
	

       $this->sql_connect();//连接数据库
       $table_list = mysql_list_tables($this->dbdata);//列出所有表
       $table_count = mysql_num_rows($table_list);//获取表总数


      
       $tableid = $_tableid ? intval($_tableid) : 0;
       $pageid = $_pageid ? intval($_pageid) : 0;
       $table = mysql_tablename($table_list,$tableid);
        if(($tableid+1)<$table_count){
               if(!file_exists($this->dbdata."/".$table."_".$pageid.".sql")){
                    
                       $this->errmsg("数据表".$table."信息不存在或未曾备份!",__URL__."/recoverdata/tableid/".($tableid+1));
                        //添加链接
               }
                $sql = $this->read_msg($this->dbdata."/".$table."_".$pageid.".sql");
                if($sql) $this->recover_data($sql);
                
                if(file_exists($this->dbdata."/".$table."_".($pageid+1).".sql")){
                     $this->errmsg("正在恢复数据表 ".$table." 信息",__URL__."/recoverdata/tableid/".$tableid."/pageid/".($pageid+1));
                 }else{
                     $this->errmsg("已经恢复数据表".$table." 信息，将恢复下一个数据表信息!",__URL__."/recoverdata/tableid/".($tableid+1));
                }
        }else{

               $this->error("数据信息均已经恢复完毕！",__URL__."/index");
       }
}
}
?>