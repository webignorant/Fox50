<?php
//视频专辑动作
class PlayLoadAction extends CommonAction{

    //视频专辑首页
    public function index(){
    	if(isset($_GET['vid'])){
    	  if(!$this->inVideo($_GET['vid']))
    		 $this->error('不存在该视频',U('Home/Index/index'));
    	}else{
    		 $this->error('不存在该视频',U('Home/Index/index'));
    	}
    	//检测是否登录
    	if(isset($_SESSION['id'])){
    		$this->assign('userid',$_SESSION['id']);
    		$this->assign('login',1);
    	}
    	
    	//视频详细信息
    	$temp_video = $this->getVideoInfo($_GET['vid']);
    	$this->assign('videoinfo',$temp_video);
    	//导航
    	$this->assign('getCate',$this->getCate($_GET['vid']));
    	//该视频的连播
    	if($temp_video[0]['relevanceid'] && is_numeric($temp_video[0]['relevanceid'])){
    		$temp_list=$this->getVideoRelevanceid($this->getVideoFlow($temp_video[0]['relevanceid']));
    		if($temp_list){
    			$this->assign('videorelevance',$temp_list);
    		}else{
    			$this->assign('videorelevance',0);
    		}
    	}
    	//同类热门视频
    	$temp_similar = $this->getSimilarVideo($temp_video[0]['typeid'],10);
    	if($temp_similar){
    		$this->assign('similarvideo',$temp_similar);
    	}else{
    		$this->assign('similarvideo',0);
    	}
    	
    	
        layout(true);
        $this->display();
    }
    
    
    /**
     * 判断该VID是否在视频表内
     * 
     */
    public function inVideo($vid){
    	$video = M('Video');
    	$where['vid'] = $vid;
    	$where['status'] = 0;
    	return $video->where($where)->getField('vid');
    }
    
    
    /**
     * 获取视频所属总栏
     */
    public function getCate($vid){
    	$video = M('Video');
    	$where['vid'] = $vid;
    	$temp['catid'] = $video->where($where)->getField('catid');
    	$category = M('VideoCategory');
    	$temp['catname'] = $category->where('id='.$temp['catid'])->getField('catname');
        return $temp;
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
    	$temp_table = C('COOKIE_PREFIX');
    	$list=$comment->join($temp_table.'user ON '.$temp_table.'video_comment.uid='.$temp_table.'user.id')->where($id)->order($temp_table.'video_comment.dateline desc')->field('avatar,username,message,dateline')->limit($page->limit)->select();
    	if(empty($list)){
    		return '没有相关评论！';
    	}
    	echo '　'.$page->fpage(array(0,1,2,3,4,5,6,7));
    	foreach($list as $k=>$v){
    		echo '<li>
    			   <div class="autoheight">
    				<img src="PhotoUploads/20130427/832956605517b486f230db.jpg" style="width:80px;height:80px;" />
                     <p><span class="time">'.date('m/d H:i:s',$list[$k]['dateline']).'</span>
                     	<span class="time s_span">
                     		<a href="javascript:setretun('."'".$list[$k]['username']."'".');">回复</a>
                     	</span>
                     	   <strong>'.$list[$k]['username'].'</strong><br>'.$list[$k]['message'].'</p>
                   </div>
                 </li>';
    	}
    	
    }
    
    /**
     * 添加评论
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
    		echo '-1';
    	}
    }
    
    
    /**
     * 根据观看数随机获取同类热门推荐
     * $typeid :类型ID
     * $num : 抽取数
     */
    public function getSimilarVideo($typeid,$num){
    	if(!is_numeric($typeid)) return;
    	$video = M('Video');
    	$where['typeid'] = $typeid;
    	$where['status'] = 0;
    	$temp_table = C('COOKIE_PREFIX');
    	$temp_date_one = $video->join($temp_table.'video_count ON '.$temp_table.'video.vid='.$temp_table.'video_count.id')->where($where)->order($temp_table.'video_count.viewnum desc')->field('vid,title,img')->limit(20)->select();
    	$temp_num = count($temp_date_one);
    	if($temp_num > $num){
    	  $temp_array = array_rand($temp_date_one,$num);
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
     * 获取连播视频
     * $flowid：连播表ID
     * return 连播相关视频
     */
    public function getVideoFlow($flowid){
    	if(!is_numeric($flowid)) return 1;
    	$temp = M('VideoFlow');
    	return $temp->where('id='.$flowid)->getField('vidlist');
    }
    
    /**
     * 获取排序连播视频VID
     * return 连播视频VID
     */
    public function getVideoRelevanceid($relevanceid){
    	$where['vid'] = array('in',$relevanceid);
    	$where['status'] = 0;
    	$temp_video = M('Video');
    	return $temp_video->where($where)->field('vid')->order('relevancesort asc')->select();
    }
    
    
    
    
    
    /**
     * 获取视频信息
     * $vid:视频ID
     */
    public function getVideoInfo($vid){
    	//欠语言
    	if(!is_numeric($vid)) exit;
    	$video = M('Video');
    	$where['status'] = '0';
    	$where['vid'] = $vid;
    	$temp = $video->where($where)->field('vid,title,typeid,regionid,relevanceid,actor,director,year,dateline,img,about')->limit(1)->select();
    	$temp[0]['typeid'] = $this->getVideoType($temp[0]['typeid']);
    	$temp[0]['regionid'] = $this->getVideoRegionid($temp[0]['regionid']);
    	return $temp;
    }
    
    /**
     * 获取视频所属类型
     * $typeid:类型ID
     */
    public function getVideoType($typeid){
    	if(!is_numeric($typeid))
    		return '未知';
    	$type = M('VideoType');
    	return $type->where('id='.$typeid)->getField('typename');
    }
    
    /**
     * 获取视频所属地区
     * $regionid:地区ID
     */
    public function getVideoRegionid($regionid){
    	if(!is_numeric($regionid))
    		return '未知';
    	$type = M('VideoRegion');
    	return $type->where('id='.$regionid)->getField('regionname');
    }
    
    
    
    
}
?>