<?php
//视频搜索模块
class VideoSearchAction extends CommonAction {
    //搜索首页
    public function index() {
        C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
        C ( 'SHOW_PAGE_TRACE', false );
        Load('extend');
        
        $title = $this->_post("title");
        $catid = $_REQUEST['catid'];
        $top = A('Home/VideoTop');
        
        $this->assign('webpagetitle',"海量的视频库 - Fox50视频网 - 最好的视频网站");
        
        //显示搜索结果栏
        if(!isset($catid)) {
            $this -> assign('searchType', '全站');
            $list = $this->showVideoToPage('','','','8',$title);
        }else{
            $catgory = D('VideoCategory');
            $catname = $catgory->getVideoCategoryField($catid, 'catname');
            $this -> assign('searchType', $catname.'栏目');
            $list = $this->showVideoToPage($catid,'','','8',$title);
        }
        $this->assign('page',$list[1]);
        if($list [0]==false) {
			$this->assign('VideoSearchError','没有搜索到该视频！');
        }else{
			$this->assign('VideoSearchList',$list[0]);
        }
        
        //显示热播栏视频排行榜
        $this->assign('hitList',$top->showHitVideo());
        
        layout(true);
        $this->display('index');
    }

    //查询视频数据
    public function showVideoSearch($title) {
        $model = D('Video');
        $map['status'] = array('eq', 1);
        $map['title'] = array('like', '%'.$title.'%');
        //$where="title like '%".$title."%'";
        $result = $model->where($map)->order('dateline desc')->select();
        return $result;
    }
     
    //查询视频数据并分页
    public function showVideoToPage($category='', $type='', $region='',$page='20',$title='') {
        import("ORG.Util.Page");
        $Video = D('Video');
        //数据过滤开始
        $start = $_GET['p'];
        if($start <= 0 ) {
            $start =0;
        }
        if($category != '') {
            $map['catid']=array('eq',$category);
        }
        if($type != '') {
            $map['typeid']=array('eq',$type);
        }
        if($region != '') {
            $map['regionid']=array('eq',$region);
        }
        if($title != '') {
            $map['title']=array('like','%'.$title.'%');
        }
        //数据过滤结束
        $map['status'] = array('eq', 0);
        $list = $Video->where($map)->order('dateline desc')->page($start.','.$page)->select();
        $count = $Video->where($map)->count();
        $Page = new Page($count,$page);
        $show = $Page->show();
        return array($list,$show);
    }
     
}

?>