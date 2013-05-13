<?php
class IndexAction extends CommonAction {
    // 前台首页
    public function index() {
        C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
        C ( 'SHOW_PAGE_TRACE', false );
        
        $video = A('Home/Video');
        $category = A('Home/VideoCategory');
        $top = A('Home/VideoTop');
        $recommended = A('Home/VideoRecommended');
        
        $this->assign('webpagetitle',"Fox50视频网 - 在线播放,视频上传 - 最好的视频网站");
        
        //显示推荐表视频
        $this -> assign('RecommendedList',$recommended->getVideoRecommended());
        //最热视频
        $this -> assign('HotList',$top -> showHitVideo());
        
        //最新视频推荐
        if(($list = $top->showLatestVideo()) == false) {
            $this->assign('LatestVideoError','<br />网站还没有视频');
        }else{
            $this->assign('LatestVideo',$list);
        }
        
        //显示视频总数量
        $this->assign('VideoMaxNum',$video->getVideoMaxNum());
        
        //显示今天更新视频数量
        $this->assign('NewVideoNumInToday',$video->showNewVideoNumInToday());
        
        //输出栏目box 视频排行榜 推荐栏 输出
        $this -> assign('VideoCategory', $category -> showVideoCategoryToIndexBox());
        
        layout(true);
        $this->display('index');
    }
    

    
}