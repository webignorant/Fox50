<?php

 class Page{
  private $total;//数据表中总记录数；
	private $listRows;//每页显示行数;
	private $limit;//数据库从哪取出
	private $uri;//地址
	private $pageNum;//总页数
	private $config=array('header'=>"个记录","prev"=>"上一页","next"=>"下一页","first"=>"首 页","last"=>"尾 页");
	private $listNum=6;//列表显示的个数
	private $su_article;//特定用途
	
	
  /*
   *初始化，传入总数记录数与分页数
   *注意：$p预留参数，就是说当那个页不单单传页面参数，还传其它参数时，这时跳下一页时可能会没有这个参数，所以带这个参数;
   *
  */
	public function __construct($total,$listRows=10,$p=""){
	    $this->total=$total;
		$this->listRows=$listRows;
		$this->uri=$this->getUri($p);
		$this->page=!empty($_GET["page"])?$_GET["page"]:1;//首次进来没有page的情况
	    $this->pageNum=ceil($this->total/$this->listRows);
		$this->limit=$this->setLimit();
		$this->su_article=1;	//特殊用途	
	}
	
	
	private function __get($args){
	  if($args=="limit"){
	    return $this->limit;
	  }else{
	    return null;
	  }
	}
	
  /*
  * 设置从数据库从哪条开始取，取多少条；
  * 
  */
	private function setLimit(){
	  return ($this->page-1)*$this->listRows.",{$this->listRows}";
	}
	
  /*
  *
  *  获取地址；
  *  这个原理是在地址后面加上page，这样你可以带其它参数。。
  */
	private function getUri($p){
	   //获取地址并判断后面是否带有?号，没有则加上
	   $url=$_SERVER["REQUEST_URI"].(strpos($_SESSION["REQUEST_URI"],'?')?'':"?").$p;
	   //获取地址跟?后面的东西
	   $parse=parse_url($url);
	   
	   //判断地址后面是否带有参数并且如果带有page的参数，则将page去掉再组合成一个不带page的地址；
	   if(isset($parse["query"])){
	     parse_str($parse["query"],$params);
	     unset($params["page"]);
		 $url=$parse['path'].'?'.http_build_query($params);
	   } 
	   return $url;
	}
	
	
    /*
	 *从数据库取出最开始的那条数据
	*/
	private function start(){
		if($this->total==0)
			return 0;
		else
			return ($this->page-1)*$this->listRows+1;
	}
	
    /*
	*
	*从数据库取出最后的那条数据是第几条，有两种情况，最后那页没有指定每页显示的条数多时，显示数据库最大的。
	*/
	private function end(){
		return min($this->page*$this->listRows,$this->total);
	}
	
	/*
	 * 首页
	 *
	*/
	private function first(){
		if($this->page==1)
			$html.='';
		else
			$html.="&nbsp;&nbsp;<a href='javascript:setPage(\"{$this->uri}&page=1\",$this->su_article)'>{$this->config["first"]}</a>&nbsp;&nbsp;";

		return $html;
	}
	
	
    /*
	*
	*上一页
	*/
	private function prev(){
		if($this->page==1)
			$html.='';
		else
			$html.="&nbsp;&nbsp;<a href='javascript:setPage(\"{$this->uri}&page=".($this->page-1)."\",$this->su_article)'>{$this->config["prev"]}</a>&nbsp;&nbsp;";
			
			return $html;
	}
		
		
	/*
	* 下一页
	*/	
	private function next(){
		if($this->page==$this->pageNum)
			$html.='';
		else
		    $html.="&nbsp;&nbsp;<a href='javascript:setPage(\"{$this->uri}&page=".($this->page+1)."\",$this->su_article)'>{$this->config["next"]}</a>&nbsp;&nbsp;";

			return $html;
	}	
	
	/*
	*　尾页
	*/
	private function last(){
		if($this->page==$this->pageNum)
			$html.='';
		else
			$html.="&nbsp;&nbsp;<a href='javascript:setPage(\"{$this->uri}&page=".($this->pageNum)."\",$this->su_article)'>{$this->config["last"]}</a>&nbsp;&nbsp;";

			return $html;
	}
	 
	/*
	*
	* 页数的列表
	*/
	private function pageList(){
	  $linkPage="";	  
	  $inum=floor($this->listNum/2);
	  
	  //列表的前边显示
	  for($i=$inum;$i>=1;$i--){
	    $page=$this->page-$i;
		
		if($page<1)//显示负数时除掉
		     continue;
			 
		$linkPage.="&nbsp;<a href='javascript:setPage(\"{$this->uri}&page={$page}\",$this->su_article)'>{$page}</a>&nbsp;";
	  }
	  
	  //显示当前页数，不加链接
	  $linkPage.="&nbsp;{$this->page}&nbsp;";
	  
	  
	  //列表的后边显示
	  for($i=1;$i<$this->listNum;$i++){
	    $page=$this->page+$i;
		if($page<=$this->pageNum)
		$linkPage.="&nbsp;<a href='javascript:setPage(\"{$this->uri}&page={$page}\",$this->su_article)'>{$page}</a>&nbsp;";
		else
		    break;
	  }
	  
	  return $linkPage;
	}
	
	/*
	* go列表
	*
	*/
	
	private function goPage(){
			return '&nbsp;&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'&page=\'+page+\'\'}" value="'.$this->page.'" style="width:25px"><input type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'&page=\'+page+\'\'">&nbsp;&nbsp;';
	}
	
	function fpage($display=array(0,1,2,3,4,5,6,7,8)){
     $html[0]="共有<b>{$this->total}</b>{$this->config["header"]}";
	 $html[1]="&nbsp;&nbsp;每页显示<b>".($this->end()-$this->start()+1)."</b>条，本页<b>{$this->start()}-{$this->end()}</b>条&nbsp;&nbsp;";
	 $html[2]="&nbsp;&nbsp;<b>{$this->page}/{$this->pageNum}</b>页&nbsp;&nbsp;";
	 $html[3]=$this->first();
	 $html[4]=$this->prev();
	 $html[5]=$this->pageList();
	 $html[6]=$this->next();
	 $html[7]=$this->last();	 
	 $html[8]=$this->goPage();
     $fpage='';
   
     foreach($display as $index){
	   $fpage.=$html[$index];
	 }

     return $fpage;
	}
  
  }
  
  
  

?>