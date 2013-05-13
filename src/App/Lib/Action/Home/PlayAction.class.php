<?php
class PlayAction extends CommonAction{
  
    public function index(){
        Load('extend');
        $category = A('Home/VideoCategory');
        
        $this->assign('vid',$_GET['vid']);
        
        $this->assign('webpagetitle',$this->getVideoName()." - ".$category->getVideoInCategoryName($_GET['vid'])."栏目 - 在线视频播放 - Fox50视频网");
        
        $this->assign('videotitle','正在播放:'.$this->getVideoName());
        
        if(isset($_SESSION['id'])){
            $this->assign('userid',$_SESSION['id']);
            $this->assign('login',1);
            $this->assign('user_name','欢迎你，'.$_SESSION['username']);
        }
        //视频连播列表 - 插件
        if(($list = $this->continuous($_GET['vid'])) != false) {
            $this->assign('sqlitcheck',true);
            $this->assign('SplitList',$this->continuous($_GET['vid']));
        }else{
            $this->assign('sqlitcheck',false);
        }
        
        //视频连播列表
        $this->assign('lianlook',$this->lianlook($_GET['vid']));
        
        //视频简介输出
        $vid = $_GET['vid'];
        $video = A('Home/Video');
        $videoinfo = $video->getVideoInfo($vid );
        $regionname = $video->getVideoRegion($videoinfo[0]['regionid']);
        $this->assign('videos',$videoinfo[0]);
        $this->assign('video_region',$regionname[0]['regionname']);
        
        //视频发布信息输出
        $User = D('User');
        $this -> assign('uploadUser', $User->getUserField($videoinfo[0]['uid'], 'account'));
        $Count = D('VideoCount');
        $this -> assign('count', $Count->getVideoCount($videoinfo[0]['vid']));
        
        //视频收藏
        $favorite = A('Home/VideoFavorite');
        $fstatus = $favorite -> getVideoFavoriteStatus();
        if($fstatus == false) {
            $this -> assign('favoriteStatus',false);
        }else if($fstatus == true){
            $this -> assign('favoriteStatus',true);
        }
        
        //下载地址
        $this->assign('downupload',$this->download());
   
        
         //分享相关地址
        $this->assign('swfobject','http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/App/Tpl/Home/Public/play/swfobject.js');
        $this->assign('CuPlayerMiniV3_Black_S','http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/App/Tpl/Home/Public/play/CuPlayerMiniV3_Black_S.swf');
        $this->assign('video_fenxiang','http://'.$_SERVER['HTTP_HOST'].__ROOT__.$videoinfo[0]['filepath'].$videoinfo[0]['filename']);
        $this->display();
        
        //播放记录
        $recently = A('Home/VideoRecently');
        $recently -> setVideoHistory($vid);
        
        //观看数
        if($this->pplook()){
          $this->pviewnum($_GET['vid']);
        }
        
    }
  
    
    
    
    
    public function index_two(){
    	Load('extend');
    	$category = A('Home/VideoCategory');
    
    	$this->assign('vid',$_GET['vid']);
    
    	$this->assign('webpagetitle',$this->getVideoName()." - ".$category->getVideoInCategoryName($_GET['vid'])."栏目 - 在线视频播放 - Fox50视频网");
    
    	$this->assign('videotitle','正在播放:'.$this->getVideoName());
    
    	if(isset($_SESSION['id'])){
    		$this->assign('userid',$_SESSION['id']);
    		$this->assign('login',1);
    		$this->assign('user_name','欢迎你，'.$_SESSION['username']);
    	}
    	//视频连播列表 - 插件
    	if(($list = $this->continuous($_GET['vid'])) != false) {
    		$this->assign('sqlitcheck',true);
    		$this->assign('SplitList',$this->continuous($_GET['vid']));
    	}else{
    		$this->assign('sqlitcheck',false);
    	}
    
    	//视频连播列表
    	$this->assign('lianlook',$this->lianlook($_GET['vid']));
    
    	//视频简介输出
    	$vid = $_GET['vid'];
    	$video = A('Home/Video');
    	$videoinfo = $video->getVideoInfo($vid );
    	$regionname = $video->getVideoRegion($videoinfo[0]['regionid']);
    	$this->assign('videos',$videoinfo);
    	$this->assign('video_region',$regionname[0]['regionname']);
    
    
    	//分享相关地址
    	$this->assign('swfobject','http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/App/Tpl/Home/Public/play/swfobject.js');
    	$this->assign('CuPlayerMiniV3_Black_S','http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/App/Tpl/Home/Public/play/CuPlayerMiniV3_Black_S.swf');
    	$this->assign('video_fenxiang','http://'.$_SERVER['HTTP_HOST'].__ROOT__.$videoinfo[0]['filepath'].$videoinfo[0]['filename']);
    	$this->display();
    
    	//观看数
    	if($this->pplook()){
    		$this->pviewnum($_GET['vid']);
    	}
    }
 
    /**
     * 连播
     * $id 连播表的ID
     */
    private function relevancevideo($id){
    	$flow = M('VideoFlow');
    	$video = M('Video');
    	$flowlist = $flow->where('id='.$id)->limit(1)->field('vidlist')->select();
    	$flowlist = $flowlist[0]['vidlist'];
    	$where['vid'] = array('in',"$flowlist");
    	$where['status'] = 0;
    	return $video->where($where)->field('vid,title')->limit(9)->select();
    }
    
    
    //相似视频
    private function like_video(){
    	Load('extend');
    	$video = M('Video');
    	$where['vid'] = $_REQUEST['vid']; 
    	$temp = $video->where($where)->getField('title');
        $temp = msubstr($temp,0,3,"utf-8",'');
    	$data['title'] = array('like','%'.$temp);
    	$data['status'] = 0;
    	$videolist = $video->where($data)->limit(9)->order('dateline desc')->select();
    	if(!$videolist){
    		$videolist = $video->where('status=0')->order('dateline desc')->limit(9)->select();
    	}
    	return $videolist;
    }
    
  /**
  * 评论内容
  *
  */
  public function comment(){
 	  import('@.ORG.Util.APage');
 	  date_default_timezone_set('Asia/Shanghai');
 	  $id['vid']=$_GET['vid'];//获取视频ID，用于求出该视频的评论数
 	  $comment = M('VideoComment');
 	  $_a_num=$comment->where($id)->count();//该视频评论总记录数
 	  $_b_num=8;//分页数
 	  $page=new Page($_a_num,$_b_num);
 	  $list=$comment->where($id)->limit($page->limit)->select();
 	  if(empty($list)){
 	  	return '没有相关评论！';
 	  }
 	  echo '　'.$page->fpage(array(0,1,2,3,4,5,6,7));
 	  foreach($list as $k=>$v){
 	  	echo  '<div class="discusscontent_list">
      	         <ul>
      	          <li>'.$list[$k]['username'].'</li>
      	          <li>'.$list[$k]['message'].'</li>
      	          <li class="discusscontent_list_li">'.date('m/d H:i:s',$list[$k]['dateline']).'<span class="discussontent_list_span"><a href="javascript:setretun('."'".$list[$k]['username']."'".');">回复</a></span><hr /></li>
      	         </ul>
      	      </div>';		
 	  } 
  }
  
  
  /**
   * 评论
   */
  public function addcomment(){
  	if(isset($_SESSION['username'])){
  		$comment = M('VideoComment');
  		$date['uid']=$_POST['uid'];
  		$date['vid']=$_POST['vid'];
  		$date['message']=$_POST['comnemt'];
  		$date['idtype']=0;
  		$date['status']=0;
  		$date['dateline']=time();
  		$date['postip']=get_client_ip();
  		$date['username']=$_SESSION['username'];
  		if($comment->add($date)){
  			echo '1';
  		}else{
  			echo'0';
  		}
  	}else{
  		echo '请先登录！';
  	}
  }
  
    
    //获取视频名称
    public function getVideoName() {
        $data['vid']=$_GET['vid'];
        $video= M('Video');
        $title = $video->where($data)->field('title')->find();
        return $title['title'];
    }
  
    
    /**
     * 当前视频简介
     * 
     */
    
    public function newvideoinfo(){
    	$vid = $_POST['vid'];
    	if(empty($_POST['vid']) || !isset($_POST['vid'])){
    		echo '获取相关信息失败!';
    	}else{
    	$video = A('Home/Video');
    	$videoinfo = $video->getVideoInfo($vid );
    	$regionname = $video->getVideoRegion($videoinfo[0]['regionid']);
	    	echo '<div class="info">
	    	<span class="mv-title" title="'.$videoinfo[0]['title'].'"> <a href="__GROUP__/Play/index?vid='.$videoinfo[0]['vid'].'" title="'.$videoinfo[0]['title'].'">'.$videoinfo[0]['title'].'</a></span>
	    	<p>主演：'.$videoinfo[0]['actor'].'</p>
	    	<p>导演：'.$videoinfo[0]['director'].'</p>
	    	<p>地区：'.$regionname[0]['regionname'].' </p>
	    	<p>上映年份：'.$videoinfo[0]['year'].' </p>
	    	<p>更新日期：'.date('Y-m-d',$videoinfo[0]['dateline']).'</p>
	    	</div>
	    	<div class="intro">
	    			<p class="title">剧情介绍：</p>
                    <div class="intro_cont">'.$videoinfo[0]['about'].'</div>
                </div>';
    	}
    }
    
  /**
  * 获取视频url
  *
  */
  public function geturl(){
  	$data['vid']=$_GET['vid'];
  	$video= M('Video');
  	$videoname=$video->where($data)->select();
  	$string=str_replace('./','/',$videoname[0]['filepath']);
  	echo __ROOT__.$string.$videoname[0]['filename'];
  }
  
  /**
  * 视频观看次数
  * 
  */
  public function pviewnum($vid){
  	$this->viewnum($vid);
  }
  
  /**
  * 评论数
  *
  */
  public function pcommentnum($vid){
    $this->commentnum($vid);
  }
  
  /**
  * 收藏数
  *
  */
  public function pfavimes($vid){
  $this->favimes($vid);
  }
  
  /**
  * 分享数
  *
  */
  public function psharetimes($vid){
  	$this->sharetimes($vid);
  }
  
  /**
  * 顶数
  *
  */
  public function ppraise(){
  	
  	 $vid=$_GET['vid'];
  	 if(isset($_COOKIE['video']) && in_array($vid,explode('|',$_COOKIE['video']))){
  	 	 echo '已评论过';
  	 }else{
  	 	 $this->praise($vid);
  	 	 $this->setcookies('video',$_COOKIE['video'].$vid.'|',2);
  	 }
  }
  
  /**
   * 观看数
   *
   */
  private function pplook(){
  	 
  	$vid=$_GET['vid'];
  	if(isset($_COOKIE['lookvideo']) && in_array($vid,explode('|',$_COOKIE['lookvideo']))){
  		return false;
  	}else{
  		$this->setcookies('lookvideo',$_COOKIE['video'].$vid.'|',2);
  		return true;
  	}
  }
  
  
  /**
  * 踩数
  *
  */
  public function pcriticism(){
  	 $vid=$_GET['vid'];
  	 if(isset($_COOKIE['video']) && in_array($vid,explode('|',$_COOKIE['video']))){
  	 	 echo '已评论过';
  	 }else{
  	 	 $this->criticism($vid);
  	 	 $this->setcookies('video',$_COOKIE['video'].$vid.'|',2);
  	 }
  }
  
 
  
  //------------------------------------------------------------------------------------------------------
  
  /**
  * 视频观看次数
  * 
  */
  private function viewnum($vid,$select){
  	$count = M('VideoCount');

  	if($select==1){
  		return $count->where('id='.$vid)->getField('viewnum');
  	}elseif($count->where('id='.$vid)->select()){
  		$count->where('id='.$vid)->setInc('viewnum',1);
  	}
  }
  
  /**
  * 评论数
  *
  */
  private function commentnum($vid,$select){
  $count = M('VideoCount');
  	
  	if($select==1){
  		return $count->where('id='.$vid)->getField('commentnum');
  	}elseif($count->where('id='.$vid)->select()){
  		$count->where('id='.$vid)->setInc('commentnum',1);
  	}
  }
  
  /**
  * 收藏数
  *
  */
  private function favimes($vid,$select){
  $count = M('VideoCount');
  	
  	if($select==1){
  		return $count->where('id='.$vid)->getField('favtimes');
  	}elseif($count->where('id='.$vid)->select()){
  		$count->where('id='.$vid)->setInc('favtimes',1);
  	}
  }
  
  /**
  * 分享数
  *
  */
  private function sharetimes($vid,$select){
  	$count = M('VideoCount');
  	if($select==1){
  		return $count->where('id='.$vid)->getField('sharetimes');
  	}elseif($count->where('id='.$vid)->select()){
  		$count->where('id='.$vid)->setInc('sharetimes',1);
  	}
  }
  
  /**
  * 顶数
  *
  */
  private function praise($vid,$select){
  	$count = M('VideoCount');
  	if($select==1){
  		return $count->where('id='.$vid)->getField('praise');
  	}elseif($count->where('id='.$vid)->select()){
  		$count->where('id='.$vid)->setInc('praise',1);
  	}
  }
  
  /**
  * 踩数
  *
  */
  private function criticism($vid,$select){
  	$count = M('VideoCount');
  	if($select==1){
  		return $count->where('id='.$vid)->getField('criticism');
  	}elseif($count->where('id='.$vid)->select()){
  		$count->where('id='.$vid)->setInc('criticism',1);
  	}
  }
  
    /**
   * 连播放列表
   * $vid 视频ID
   * 
   */  
    private function lianlook($vid){
    	$videolian = M('Video');
    	$data['vid'] = $vid;
    	$data['status'] = 0;
    	$videocontent = $videolian->where($data)->field("title,relevanceid")->select();
    	if($videocontent[0]['relevanceid']){
    		if(!$list = $this->relevancevideo($videocontent[0]['relevanceid'])){
               $list=$videolian->join('fox50_video_count ON fox50_video_count.id = fox50_video.vid')->order('fox50_video_count.viewnum desc')->limit(8)->field('vid,title,img')->select();
    		}
    	}else{
    		$list=$videolian->join('fox50_video_count ON fox50_video_count.id = fox50_video.vid')->order('fox50_video_count.viewnum desc')->limit(8)->field('vid,title,img')->select();
    	}
    	foreach($list as $dumplist){
    		 $look.=$dumplist['vid'].'||'.$dumplist['title'].'--';
    	}
    	return $look;
    }
    
    //连播 - 插件使用
    public function continuous($vid){
        $video = M('Video');
        $flow = M('VideoFlow');
        //找出连播ID
        $videodata['vid'] = $vid;
        $videodata['status'] = 0;
        $relevanceid = $video -> where($videodata) -> getField('relevanceid');
        //找出连播表的内容
        $flowdata['id'] = $relevanceid;
        $vidlist = $flow -> where($flowdata) -> getField('vidlist');
        //找出连播的视频信息
        $continuous_array = explode(',',$vidlist);
        $voList = array();
        foreach($continuous_array as $key => $arr){
            /*
            if($arr == $vid){
                continue;
            }
            */
            $data['vid'] = $arr;
            $data['status'] = 0;
            $video_info_array = $video -> where($data) -> field('vid,title,img') ->select();
            if($video_info_array == null){
                continue;
            }else{
                //转换为一位数组
                $video_info = array();
                foreach($video_info_array as $i => $value){
                    $video_info['vid'] = $value['vid'];
                    $video_info['title'] = $value['title'];
                    $video_info['img'] = $value['img'];
                }
                $voList[$key] = $video_info;
            }
        }
        return $voList;
    }
  
  /**
   * 视频下载
   *
   */
   
  public function download(){
  	$downvideo = M('Video');
  	$data['vid'] = $_GET['vid'];
  	if($video=$downvideo->where($data)->field('filepath,filename,title')->select()){
  		return $this->download_url('http://'.$_SERVER['HTTP_HOST'].__ROOT__.$video[0]['filepath'].$video[0]['filename']);
  	}
  }
  
  /**
   * 本地下载
   */
  public function locationdownload(){
  	@set_time_limit(0);
  	ini_set('max_execution_time', '0');
  	$downvideo = M('Video');
  	$data['vid'] = $_GET['vid'];
  	if($video=$downvideo->where($data)->field('filepath,filename,title')->select()){
  		import('@.ORG.Util.Http');
  		Http::download($video[0]['filepath'].$video[0]['filename']);
  	}else{
  		echo '<script type="text/javascript">alert("没有相关视频下载！");location.href="index.php";</script>';
  	}
  }
  
  /**
   * 生成相关下载链接
   */
  public function download_url($_geturl){
  	$urlord=explode('//',$_geturl,2);
  	$head=strtolower($urlord[0]);//统一转换成小写，不然出现HtTp:或者ThUNDER:这种怪异的写法不好处理
  	$behind=$urlord[1];
  	if($head=="thunder:"){
  		$url=substr(base64_decode($behind), 2, -2);//base64解密，去掉前面的AA和后面ZZ
  	}elseif($head=="flashget:"){
  		$url1=explode('&',$behind,2);
  		$url=substr(base64_decode($url1[0]), 10, -10);//base64解密，去掉前面后的[FLASHGET]
  	}elseif($head=="qqdl:"){
  		$url=base64_decode($behind);//base64解密
  	}elseif($head=="http:"||$head=="ftp:"||$head=="mms:"||$head=="rtsp:"||$head=="https:"){
  		$url=$_geturl;//仅支持http,https,ftp,mms,rtsp传输协议
  	}else{
  		echo "本页面暂时不支持此协议";
  		return;
  	}
  	//return $url;
  	$urlarr = array();
  	if($_geturl!=NULL){
  		$urlarr['url_thunder']="thunder://".base64_encode("AA".$url."ZZ");//迅雷
  		$urlarr['url_flashget']="Flashget://".base64_encode("[FLASHGET]".$url."[FLASHGET]")."&aiyh";
  		$urlarr['url_qqdl']="qqdl://".base64_encode($url);
  	}
  	return $urlarr;
  }
  
  
  
  /**
  * 保存登录用户的cookies
  *
  */
  private function setcookies($_src_cookies,$_cookies,$_time){
  switch($_time){
             case 0: setcookie("$_src_cookies","$_cookies");
						             break;
			       case 1: setcookie("$_src_cookies","$_cookies",time()+86400); //一天,数字是以秒记的，所以60*60*24
				                 break;
		         case 2: setcookie("$_src_cookies","$_cookies",time()+604800); //一周
						             break;
				     case 3: setcookie("$_src_cookies","$_cookies",time()+704800);		 
                         break;
  } 
 }
 
 /**
  * 专辑信息
  * 返回:文件名、播放次数、创建者
  */
  private function special(){
  	$array=array();
 	$special = M ('Video');
 	$date['vid'] = $_GET['vid'];
    $array1=$special->where('vid=1')->select();
 	$datea['id'] = $_GET['vid'];
 	$count = M('VideoCount');
 	$array2=$count->where($datea)->select();
 	$array['username']=$array1[0]['username'];
 	$array['title']=$array1[0]['title'];
 	$array['viewnum']=$array2[0]['viewnum'];
 	$array['favtimes']=$array2[0]['favtimes'];
 	return $array;
  }
  
  /**
   * 大家都在看列表
   * 
   
    private function alllook(){
        $video = M();
        return $video->query('select * from fox50_video,fox50_video_count where fox50_video.status = 0 order by fox50_video_count.viewnum desc limit 8');

    }*/
  
  /**
   * 相似视频
   * 
   */
    private function atlook(){
        $atlook = M('Video');
        $date['title'] = array('like','%'.$atlook->where('vid='.$_GET['vid'])->getField('title').'%');
        $date['vid'] = array('neq',$_GET['vid']);
        return $atlook->where($date)->limit(8)->select();
    }
    /**
     * 截取字符
     */
    private  function getstr($string, $length, $encoding  = 'utf-8') {
    	$string = trim($string);
    	if($length && strlen($string) > $length) {
    		//截断字符
    		$wordscut = '';
    		if(strtolower($encoding) == 'utf-8') {
    			//utf8编码
    			$n = 0;
    			$tn = 0;
    			$noc = 0;
    			while ($n < strlen($string)) {
    				$t = ord($string[$n]);
    				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
    					$tn = 1;
    					$n++;
    					$noc++;
    				} elseif(194 <= $t && $t <= 223) {
    					$tn = 2;
    					$n += 2;
    					$noc += 2;
    				} elseif(224 <= $t && $t < 239) {
    					$tn = 3;
    					$n += 3;
    					$noc += 2;
    				} elseif(240 <= $t && $t <= 247) {
    					$tn = 4;
    					$n += 4;
    					$noc += 2;
    				} elseif(248 <= $t && $t <= 251) {
    					$tn = 5;
    					$n += 5;
    					$noc += 2;
    				} elseif($t == 252 || $t == 253) {
    					$tn = 6;
    					$n += 6;
    					$noc += 2;
    				} else {
    					$n++;
    				}
    				if ($noc >= $length) {
    					break;
    				}
    			}
    			if ($noc > $length) {
    				$n -= $tn;
    			}
    			$wordscut = substr($string, 0, $n);
    		} else {
    			for($i = 0; $i < $length - 1; $i++) {
    				if(ord($string[$i]) > 127) {
    					$wordscut .= $string[$i].$string[$i + 1];
    					$i++;
    				} else {
    					$wordscut .= $string[$i];
    				}
    			}
    		}
    		$string = $wordscut;
    	}
    	return trim($string);
    }
   /**
    * 同类型热播
    */ 
    private function _recommended($typeid){
    	if(!is_numeric($typeid)) return;
    	$video = M('Video');
    	$where['typeid'] = $typeid;
    	$where['status'] = 0;
    	$temp_table = C('COOKIE_PREFIX');
    	$temp_date_one = $video->join($temp_table.'video_count ON '.$temp_table.'video.vid='.$temp_table.'video_count.id')->where($where)->order($temp_table.'video_count.viewnum desc')->field('username,viewnum,vid,title,img')->limit(20)->select();
    	$temp_num = count($temp_date_one);
    	if(!$temp_num){
    		return $video->join($temp_table.'video_count ON '.$temp_table.'video.vid='.$temp_table.'video_count.id')->where('status=0')->order($temp_table.'video_count.viewnum desc')->field('username,viewnum,vid,title,img')->limit(8)->select();
    	}
    	if($temp_num > 8){
    		$temp_array = array_rand($temp_date_one,8);
    		$temp_date_two = array();
    		foreach($temp_array as $var){
    			$temp_date_two[$var] = $temp_date_one[$var];
    		}
    		return $temp_date_two;
    	}else{
    		return $temp_date_one;
    	}
    }
    
    
    
    
    /**
     * 相关续集
     * 
     */
    public function relevance(){
    	$video = M('Video');
    	$data['vid'] = $_GET['vid'];
    	$data['status'] = 0;
    	$videocontent = $video->where($data)->field("title,relevanceid")->select();
    	if($videocontent[0]['relevanceid']){
    		$flowlist = $this->relevancevideo($videocontent[0]['relevanceid']);
    		foreach($flowlist as $temp){
    			$videolist .= '<li title="'.$temp['title'].'" name="'.$temp['vid'].'">'.$temp['title'].'</li>';
    		}
    		echo '<ul onmouseover="videostart();">'.$videolist.'</ul>';
    	}else{
    		//随机视频
    		$videolisttemp = $video->where('status=0')->order('dateline asc')->limit(9)->select();
    		foreach($videolisttemp as $temp){
    			$videolist .= '<li title="'.$temp['title'].'" name="'.$temp['vid'].'">'.$temp['title'].'</li>';
    		}
    		echo '<ul onmouseover="videostart();">'.$videolist.'</ul>';
    	}
    }
    
    /**
     * 相似影片
     * 
     */
    public function likevideo(){
    	foreach($this->like_video() as $temp){
    		$videolist .= '<li title="'.$temp['title'].'" name="'.$temp['vid'].'">'.$temp['title'].'</li>';
    	}
    	echo '<ul onmouseover="videostart();">'.$videolist.'</ul>';
    }
    
    
    /**
     * 推荐影片
     * 
     */
    public function recommended(){
      if(!is_numeric($_GET['vid'])) return;
      $typeid = M('Video')->where('vid='.$_GET['vid'])->getField('typeid');
      echo '<div id="content-one"><ul>';
      foreach($this->_recommended($typeid) as $temp){
      	echo '<li class="con-li">
      	      <div id="content-two">
      	      <ul>
      	       <li><a href="javascript:t_url('.$temp['vid'].');"><img src="'.$temp['img'].'" style="width:140px; height:98px;"/><a></li>
      	       <li><a href="javascript:t_url('.$temp['vid'].');" title="'.$temp['title'].'">标题:'.$this->getstr($temp['title'],14).'...'.'</a></li>
      	       <li>上传者:'.$temp['username'].'</li>
      	       <li>点击数:'.$temp['viewnum'].'</li>
      	      </ul>
      	      </div>
      	   </li>';	
      }
      echo '</ul></div>';
    }
    
    /**
     * 剧集列表
     */
    public function video_list(){
    	$temp_video = M('Video');
    	$temp = M('VideoFlow');
    	if(!is_numeric($_GET['vid'])) return;
    	$flowid = $temp_video->where('vid='.$_GET['vid'])->getField('relevanceid');
    	$where['vid'] = array('in',$temp->where('id='.$flowid)->getField('vidlist'));
    	$where['status'] = 0;
        $temp_date = $temp_video->where($where)->field('vid')->order('relevancesort asc')->select();
    	if($temp_date){
    		echo '<div id="content-one-02"><ul>';
    		$i=1;
    		foreach($temp_date as $temp_var){
    			if($_GET['vid'] != $temp_var['vid'])
    			  echo '<li onclick="t_url('.$temp_var['vid'].')">'.$i.'</li>';
    			else
    			  echo '<li onclick="t_url('.$temp_var['vid'].')" style="background:#CCC">'.$i.'</li>';
    			$i++;
    		}
    		echo '</ul></div>';
    	}else{
    		echo '没有相关续集..';
    	}
    }
    
    /**
     * 大家都在看
     * 
     */
    public function alllook(){
    	if(!is_numeric($_GET['vid'])) return;
    	$typeid = M('Video')->where('vid='.$_GET['vid'])->getField('typeid');
    	echo '<div id="content-one"><ul>';
    	foreach($this->_recommended($typeid) as $temp){
    		echo '<li class="con-li">
      	      <div id="content-two">
      	      <ul>
      	       <li><a href="javascript:t_url('.$temp['vid'].');"><img src="'.$temp['img'].'" style="width:140px; height:98px;"/><a></li>
      	       <li><a href="javascript:t_url('.$temp['vid'].');" title="'.$temp['title'].'">标题:'.$this->getstr($temp['title'],14).'...'.'</a></li>
      	       <li>上传者:'.$temp['username'].'</li>
      	       <li>点击数:'.$temp['viewnum'].'</li>
      	      </ul>
      	      </div>
      	   </li>';
    	}
    	echo '</ul></div>';
    }
    
}
?>