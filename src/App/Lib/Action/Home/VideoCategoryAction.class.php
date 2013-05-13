<?php
//视频栏目模块
class VideoCategoryAction extends CommonAction {
    //栏目首页
    public function index() {
        C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
        C ( 'SHOW_PAGE_TRACE', false );
        
        $catid = $this->_get("catid");
        $this -> checkVideoCategoryStatus($catid);
        $type = $this->_get("tid");
        $region = $this->_get("rid");
        $year = $this->_get("yid");
        
        $top = A('Home/VideoTop');
        
        $this->assign('webpagetitle',$this->showVideoCategoryName($catid)."栏目 - 在线视频播放 - Fox50视频网");
        
        //显示栏目名称
        $this->assign('CategoryName',$this->showVideoCategoryName($catid));
        $this->assign('catid',$catid);
        //显示检索列表
        $this->assign('TypeList',$this->showVideoType($catid ));
        $this->assign('RegionList',$this->showVideoRegion());
        $this->assign('VideoYearList',$this->showVideoYear());
        //显示视频列表
        if(!isset($_REQUEST['order'])) {
            $this -> assign('sort','desc');
            $list = $this->showVideoToPage($catid,$type,$region,$year);
        }else{
            //设置排序
            $order = $_REQUEST['order'];
            $sort = $_REQUEST['sort'];
            if($sort == 'desc') {
                $this -> assign('sort','asc');
                $sort = true;
            }else{
                $this -> assign('sort','desc');
                $sort = false;
            }
            $list = $this->showVideoToPage($catid,$type,$region,$year,$order,$sort);
        }
        $this->assign('page',$list[1]);
        if($list[0] == false) {
            $this->assign('videoerror',$list[2]);
        }else{
            $this->assign('videoList',$list[0]);
        }
        //显示热播栏视频排行榜
        $this->assign('catgoryList',$top->showHitVideoInCategory($catid));
        //小分类排行
        if($type != '' || $region != '' || $year != ''){
            $this->assign('paixin',1);
            
            if(!empty($type)){
                $paixin = array('typeid',$type);
            }elseif(!empty($region)){
                $paixin = array('regionid',$region);
            }elseif(!empty($year)){
                $paixin = array('year',$year);
            }else{
                $this->assign('paixin',0);
            }
            $VideoType = D('VideoType');
            $this->assign('TypeName',$VideoType -> getVideoTypeOnField($type,'typename'));
            $this->assign('paixinlist',$top->showvideopaixin($catid,$paixin));
        }
        else{
            $this->assign('paixin',0);
        }
        layout(true);
        $this->display('index');
    }
    
    //检测栏目是否允许访问
    public function checkVideoCategoryStatus($id) {
        $Video = D('VideoCategory');
        $result = $Video -> getVideoCategoryField($id, 'status');
        if(!$result){
            $this -> error('非法访问');
        }
    }
    
    //查询栏目视频数据并分页
    public function showVideoToPage($category='', $type='', $region='',$year='', $sortBy = '', $asc = false, $page=20) {
        $Video = D('Video');
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $Video->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        $errorinfo='没有找到视频';
        //数据过滤开始
        $start = $_GET['p'];
        if($start <= 0 ) {
            $start =0;
        }
        if($category != '') {
            $map['catid']=array('eq',$category);
            $errorinfo = "没有找到该栏目的视频！";
        }
        if($type != '') {
            $map['typeid']=array('eq',$type);
            $errorinfo = "没有找到该类型的视频！";
        }
        if($region != '') {
            $map['regionid']=array('eq',$region);
            $errorinfo = "没有找到该地区的视频！";
        }
        if($year != ''){
        	
        	if($year == '90h'){
        		$map['year'] = array('between','1990,2000');
        	}elseif($year == '80h'){
        		$map['year'] = array('between','1980,1990');
        	}else{
        		$map['year'] = array('eq',$year);
        		$errorinfo = '没有找到该年份的视频！';
        	}

        }
        $map['status'] = 0;
        //数据过滤结束
        
        //数据分页
        $count = $Video->where($map)->count();
        if ($count > 0) {
            import("ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = $page;
            }
            $Page = new Page($count,$listRows);
            $list = $Video->where($map)->order($order.' '.$sort)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            //$sql = $Video -> getLastSql();
            $show = $Page->show();
        }
        return array($list,$show,$errorinfo,$sql);
    }

    //查询在首页显示的栏目推荐排行信息
    public function showVideoCategoryToIndexBox() {
        $top = A('Home/VideoTop');
        $category = D('VideoCategory');
        $map['status'] = 1;
        //获取栏目数组
        $categoryList = $category -> where($map) -> order('displayorder') -> field('id,catname') -> select();
        //修改栏目数组信息
        foreach($categoryList as $key => $arr) {
            //推荐栏数据
            $recommendList = $this -> showRecommendVideoToCategory($arr['id']);
            $categoryList[$key]['recommend'] = $recommendList;
            //排行榜数据
            $topList = $top -> showHitVideoInCategory($arr['id']);
            $categoryList[$key]['top'] = $topList;
            //检索条件数据 - 默认以地区检索
            //dump($arr['catname']);
            if($arr['catname'] == "娱乐" || $arr['catname'] == "资讯" || $arr['catname'] == "生活") {
                $retrievalList = $this -> showVideoType($arr['id']);
                $categoryList[$key]['mode'] = 'type';
            }else{
                $retrievalList = $this -> showVideoRegion($arr['id']);
                $categoryList[$key]['mode'] = 'region';
            }
            $categoryList[$key]['retrieval'] = $retrievalList;
        }
        return $categoryList;
    }

    //查询栏目推荐栏数据
    public function showRecommendVideoToCategory($category='') {
        if($category=='') {
            return false;
        }
        $model = new Model();
        $video = D('Video');
        $count = D('VideoCount');
        $map['catid'] = $category;
        $res = $count->where($where)->count(id);
        if($res == 0) {
            return false;
        }else{
            //$result = $model->query('select * from fox50_video_count,fox50_video where fox50_video_count.id=fox50_video.vid and fox50_video_count.catid = '.$category.' order by fox50_video_count.viewnum desc limit 10');
            //$result = $model->query('select * from '.C('DB_PREFIX').'video_count,'.C('DB_PREFIX').'video where '.C('DB_PREFIX').'video_count.id='.C('DB_PREFIX').'video.vid and '.C('DB_PREFIX').'video_count.catid = '.$category.' and '.C('DB_PREFIX').'video.status =0 order by '.C('DB_PREFIX').'video_count.viewnum desc limit 8');
            //$field = C('DB_PREFIX').'video.vid, '.C('DB_PREFIX').'video.title, '.C('DB_PREFIX').'video.img';
            //$where = C('DB_PREFIX').'video_count.catid = '.$category.' and '.C('DB_PREFIX').'video.status = 0';
            $videoMap['status'] = 0;
            $result = $video -> join(C('DB_PREFIX').'video_count On '.C('DB_PREFIX').'video.vid = '.C('DB_PREFIX').'video_count.id') -> where($videoMap) -> where(C('DB_PREFIX').'video_count.catid = '.$category) -> order('dateline DESC') -> field('vid,title,img') -> limit(8) -> select();
            return $result;
        }
    }

    /*利用关系模式的栏目推荐视频
    public function showRecommendVideoToCategory($category='', $condition='viewnum', $num=8) {
        if($category=='') {
            return false;
        }
        $model = D('VideoCount');
        $map['catid']=array('eq',$category);
        $order = $condition." desc";
        $result = $model->relation('Video')->where($map)->order($order)->limit($num)->select();
        dump($result);
        return $result;
    }*/
    
    //查询栏目名称
    public function showVideoCategoryName($catid) {
        $model = D('VideoCategory');
        $where = 'id='.$catid;
        $result = $model->getFieldById($catid,'catname');
        return $result;
    }
    
    //获取视频所属的栏目名称
    public function getVideoInCategoryName($vid) {
        $category = M('VideoCategory');
        $video = A('Home/Video');
        $videoinfo = $video->getVideoInfo($vid,'catid');
        $catid = $videoinfo[0]['catid'];
        $where = C('DB_PREFIX').'video_category.id='.$catid;
        $result = $category->where($where)->field('catname')->select();
        return $result[0]['catname'];
    }
    
    //查询在导航栏显示的栏目
    public function showVideoCategoryToNav() {
        $model = D('VideoCategory');
        $result = $model->where('shownav=1')->order('id desc')->select();
        return $result;
    }
    
    //查询视频类型栏
    public function showVideoType($catid) {
        $model = D('VideoType');
        $map['upid'] = array('eq',$catid);
        $map['status'] = array('eq',1);
        $result = $model->where($map)->order('displayorder asc')->select();
        return $result;
    }
    
    //查询视频地区栏
    public function showVideoRegion() {
        $model = D('VideoRegion');
        $map['status'] = array('eq',1);
        $result = $model->where($map)->order('displayorder asc')->select();
        return $result;
    }
    
    //查询年份栏
    public function showVideoYear(){
    	return $this->year();
    	
    }
    
    private function year(){
        	return array(
    			'2013',
    			'2012',
    			'2011',
    			'2010',
    			'2009',
    			'2008',
    			'2007',
    			'2006',
    			'2005',
    			'2004',
    			'2003',
    			'2002',
    			'2001',
    			'2000');
    /*
    	return array(
    			'2013',
    			'2012',
    			'2011',
    			'2010',
    			'2009',
    			'2008',
    			'2007',
    			'2006',
    			'2005',
    			'2004',
    			'2003',
    			'2002',
    			'2001',
    			'2000',
    			'1999',
    			'1998',
    			'1997',
    			'1996',
    			'1995',
    			'1994',
    			'1993',
    			'1992',
    			'1991',
    			'1990',
    			'1989',
    			'1988');
    */
    }
    
     
}

?>