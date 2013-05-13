<?php
//视频排行榜模块
class VideoTopAction extends CommonAction {
    //栏目首页
    public function index() {
        C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
        C ( 'SHOW_PAGE_TRACE', false );
        
        $category = A('VideoCategory');
        
        //显示视频播放总排行榜
        $this->assign('VideoPlayTop',$this->showTopVideo());
        
        //显示栏目4视频播放总排行榜
        $this->assign('Category4PlayNumTop',$this->showHitVideoInCategory(4));
        
        //显示栏目5视频播放总排行榜
        $this->assign('Category5PlayNumTop',$this->showHitVideoInCategory(5));
        
        //显示栏目6视频播放总排行榜
        $this->assign('Category6PlayNumTop',$this->showHitVideoInCategory(6));
        
        
        layout(true);
        $this->display('index');
    }

    //查询栏目视频数量排行榜
    public function showCategoryTopToNum($limit) {
        $model = M('VideoCategory');
        $map['displayorder'] = array('eq',1);
        $result = $model->where($map)->order('num desc')->limit($limit)->select();
        return $result;
    }
    
    //查询栏目视频播放次数排行榜
    public function showCategoryTopToPlayNum($catid) {
        $model = M();
        //$table = C('DB_PREFIX').'video_category,'.C('DB_PREFIX').'video_count';
        $where = 'video_category.id = video_count.catid and video_category.id = '.$catid;
        $result = $model -> Table(array(C('DB_PREFIX').'video_category'=>'video_category',C('DB_PREFIX').'video_count'=>'video_count')) -> where($where) -> Sum('video_count.viewnum');
        //$result = $model->query('select sum('.C('DB_PREFIX').'video_count.viewnum) from '.C('DB_PREFIX').'video_category,'.C('DB_PREFIX').'video_count where '.C('DB_PREFIX').'video_category.id = '.C('DB_PREFIX').'video_count.catid and '.C('DB_PREFIX').'video_category.id = '.$catid);
        return $result;
    }
    
    //查询视频播放总排行榜
    public function showTopVideo() {
        $model = M();
        $result = $model->query('select * from '.C('DB_PREFIX').'video_count,'.C('DB_PREFIX').'video where '.C('DB_PREFIX').'video_count.id='.C('DB_PREFIX').'video.vid and '.C('DB_PREFIX').'video.status=0 order by '.C('DB_PREFIX').'video_count.viewnum desc limit 8');
        //$result = $model->query('select * from fox50_video_count,fox50_video where fox50_video_count.id=fox50_video.vid order by fox50_video_count.viewnum desc limit 10');
        return $result;
    }
    
    //查询视频播放周排行榜
    public function showWeekVideo() {
        $model = M();
        $result = $model->query('select * from '.C('DB_PREFIX').'video_count,'.C('DB_PREFIX').'video where '.C('DB_PREFIX').'video_count.id='.C('DB_PREFIX').'video.vid and '.C('DB_PREFIX').'video.status=0 order by '.C('DB_PREFIX').'video_count.viewnum desc limit 8');
        //$result = $model->query('select * from fox50_video_count,fox50_video where fox50_video_count.id=fox50_video.vid order by fox50_video_count.viewnum desc limit 10');
        return $result;
    }    
    
    //查询视频热播栏排行榜
    public function showHitVideo() {
        //$model = M();
        //$result = $model->query('select '.C('DB_PREFIX').'video.vid,'.C('DB_PREFIX').'video.title,'.C('DB_PREFIX').'video_count.viewnum from '.C('DB_PREFIX').'video_count,'.C('DB_PREFIX').'video where '.C('DB_PREFIX').'video_count.id='.C('DB_PREFIX').'video.vid and '.C('DB_PREFIX').'video.status=0 order by '.C('DB_PREFIX').'video_count.viewnum desc limit 10');
        //$result = $model->query('select * from fox50_video_count,fox50_video where fox50_video_count.id=fox50_video.vid order by fox50_video_count.viewnum desc limit 10');
        $Video = M('Video');
        $map['status'] = 0;
        $field = C('DB_PREFIX').'video.vid, '.C('DB_PREFIX').'video.title, '.C('DB_PREFIX').'video.img, '.C('DB_PREFIX').'video_count.viewnum, '.C('DB_PREFIX').'video_count.commentnum, '.C('DB_PREFIX').'video_count.favtimes, '.C('DB_PREFIX').'video_count.sharetimes, '.C('DB_PREFIX').'video_count.praise, '.C('DB_PREFIX').'video_count.criticism';
        $result = $Video -> join(C('DB_PREFIX').'video_count On '.C('DB_PREFIX').'video.vid = '.C('DB_PREFIX').'video_count.id') -> where($map) -> order(C('DB_PREFIX').'video_count.viewnum DESC') -> field($field) -> limit(10) -> select();
        return $result;
    }
    
    //查询栏目视频热播栏排行榜
    public function showHitVideoInCategory($catid) {
        //$model = M();
        //$result = $model->query('select * from fox50_video_count,fox50_video where fox50_video_count.id=fox50_video.vid and fox50_video.catid='.$catid.' order by fox50_video_count.viewnum desc limit 10');
        //$result = $model->query('select * from '.C('DB_PREFIX').'video_count,'.C('DB_PREFIX').'video where '.C('DB_PREFIX').'video_count.id='.C('DB_PREFIX').'video.vid and '.C('DB_PREFIX').'video.catid='.$catid.' and '.C('DB_PREFIX').'video.status=0 order by '.C('DB_PREFIX').'video_count.viewnum desc limit 8');
        //左连接
        $video = M('Video');
        $map['status'] = 0;
        $where = C('DB_PREFIX').'video.catid = '.$catid;
        $field = C('DB_PREFIX').'video.vid, '.C('DB_PREFIX').'video.title, '.C('DB_PREFIX').'video.img, '.C('DB_PREFIX').'video.catid, '.C('DB_PREFIX').'video_count.viewnum, '.C('DB_PREFIX').'video_count.commentnum, '.C('DB_PREFIX').'video_count.favtimes, '.C('DB_PREFIX').'video_count.sharetimes, '.C('DB_PREFIX').'video_count.praise, '.C('DB_PREFIX').'video_count.criticism';
        $result = $video -> join(C('DB_PREFIX').'video_count On '.C('DB_PREFIX').'video.vid = '.C('DB_PREFIX').'video_count.id') -> where($map) -> where($where) -> order(C('DB_PREFIX').'video_count.viewnum DESC') -> field($field) -> limit(10) -> select();
        /* 右连接
        $count = M('VideoCount');
        $where = C('DB_PREFIX').'video.catid = '.$catid.' and '.C('DB_PREFIX').'video.status = 0';
        $field = C('DB_PREFIX').'video.vid, '.C('DB_PREFIX').'video.title, '.C('DB_PREFIX').'video.img, '.C('DB_PREFIX').'video.catid, '.C('DB_PREFIX').'video_count.viewnum, '.C('DB_PREFIX').'video_count.commentnum, '.C('DB_PREFIX').'video_count.favtimes, '.C('DB_PREFIX').'video_count.sharetimes, '.C('DB_PREFIX').'video_count.praise, '.C('DB_PREFIX').'video_count.criticism';
        $result = $count -> join('RIGHT JOIN '.C('DB_PREFIX').'video On '.C('DB_PREFIX').'video.vid = '.C('DB_PREFIX').'video_count.id') -> where($where) -> order(C('DB_PREFIX').'video_count.viewnum desc') -> field($field) -> limit(10) -> select();
        */
        return $result;
    }
    
    //小分类排行
    public function showvideopaixin($catid,$array){
    //	if(is_array($array)){
    	// $model = new Model();
    	// return $model->query('select * from fox50_video_count,fox50_video where fox50_video_count.id=fox50_video.vid and fox50_video.catid='.$catid.' and fox50_video.'.$array[0].'='.$array[1].' order by fox50_video_count.viewnum desc limit 10');
    	//}
    	 
    	$model = M('Video');
    	$where[C('DB_PREFIX').'video.catid'] = $catid;
    	if($array[0] == 'year' && $array[1] == '90h'){
    	  $where['year'] = array('between','1990,2000');
    	}elseif($array[0] == 'year' && $array[1] == '80h'){
    	  $where['year'] = array('between','1980,1990');
    	}else{
    	  $where[C('DB_PREFIX').'video.'.$array[0]] = $array[1];
    	}
        $where[C('DB_PREFIX').'video.status'] = 0;
        $result = $model->join(C('DB_PREFIX').'video_count ON '.C('DB_PREFIX').'video_count.id='.C('DB_PREFIX').'video.vid')->where($where)->order(C('DB_PREFIX').'video_count.viewnum desc')->limit(8)->select();
    	return $result;
    	
    }

    //查询最新视频排行榜
    public function showLatestVideo()
    {
        $model = M('Video');
        $data['status'] = 0;
        $result = $model->where($data)->order('dateline desc')->limit('0,8')->select();
        return $result;
    }
     
}

?>