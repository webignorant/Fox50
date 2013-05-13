<?php
//视频推荐动作
class VideoRecommendedAction extends CommonAction {

    function _filter(&$map) {
        if(!empty($_POST['title'])) {
            $model = D('Video');
            $map['title'] = array('like',"%".$_POST['title']."%");
            $vid = $model -> where($map) -> getField('vid');
            $map['vid'] = array('like',"%".$vid."%");
        }
    }
    
    public function add() {
        $categoryId  = $_GET['categoryId'];
        $typeId  = $_GET['typeId'];
        $regionId  = $_GET['regionId'];

        //读取视频栏目
        $this->assign("selectcategoryId",$categoryId);
        $Category   =  D("VideoCategory");
        $map['shownav'] = 1;
        $list =$Category->where($map)->field('id,catname')->select();
        foreach ($list as $vo){
            $categoryList[$vo['id']]	=	$vo['catname'];
        }
        $this->assign("categoryList",$categoryList);
            
        //读取视频类型
        if(!empty($categoryId)) {
            $this->assign("selecttypeId",$typeId);
            $Type  =  D("VideoType");
            $map['upid'] = $categoryId;
            $list	=	$Type->where($map)->field('id,typename')->select();
            foreach ($list as $vo){
                $typeList[$vo['id']]	=	$vo['typename'];
            }
            $this->assign("typeList",$typeList);
        }
        
        //读取视频地区
        if(!empty($categoryId) && !empty($typeId)) {
            $this->assign("selectregionId",$typeId);
            //读取当前项目的操作列表
            $Region = D('VideoRegion');
            $list	=	$Region->field('id,regionname')->select();
            if($list) {
                foreach ($list as $vo){
                    $regionList[$vo['id']]	=	$vo['regionname'];
                }
            }
            $this->assign("regionList",$regionList);
        }

        //获取相应的视频
        if(!empty($categoryId) && !empty($typeId) && !empty($regionId)) {
            $this->assign("selectregionId",$regionId);
            $Video = D('Video');
            $map['catid'] = $categoryId;
            $map['typeid'] = $typeId;
            $map['regionid'] = $regionId;
            $list	=	$Video->where($map)->field('vid,title')->select();
            if($list) {
                foreach ($list as $vo){
                    $videoList[$vo['vid']]	=	$vo['title'];
                }
            }
            $this->assign('videoList',$videoList);
            if($list) {
                foreach ($list as $vo){
                    $videoIdList[$vo['vid']]	=	$vo['vid'];
                }
            }
            $videoIdList = implode(',',$videoIdList);
            $this->assign('videoIdList',$videoIdList);
            
             //读取视频推荐表
             $VideoRecommended = D('VideoRecommended');
             $selectList  =  $VideoRecommended -> field('vid') ->select();
            if($selectList ) {
                foreach ($selectList  as $vo){
                    $selectvideoList[$vo['vid']]	=	$vo['vid'];
                }
            }
             $this ->assign('selectvideoList',$selectvideoList);
        }
        
        $this->display();
        return;        
    }
    
    //添加推荐视频
    public function addVideoRecommended() {
        $videlIdList = $_REQUEST['videoIdList'];
        $videoId = $_REQUEST['videoId'];
        $VideoRecommended = D('VideoRecommended');
        $Video = D('Video');

        //删除数据库内已存的数据
        $map['vid'] = array('in',$videlIdList);
        $delresult = $VideoRecommended -> where($map) -> delete();

        if($delresult == 0 && !isset($videoId)){
            $this->error('没有选择推荐视频');
        }else{
            foreach($videoId as $key => $value) {
                $map['vid'] = $videoId[$key];
                $map['img'] = $Video->where('vid='.$videoId[$key])->getField('img');
                $addresult = $VideoRecommended -> add($map);
                if($addresult == false) {
                    break;
                }
            }
            //信息提示
            if($addresult == true || $delresult != 0) {
                $this->success('推荐视频设置成功');
            }else{
                $this->error('推荐视频设置失败');
            }
        } 
    }
    
    //设置推荐视频-视频列表用
    public function setVideoRecommended() {
        $status = $_REQUEST['status'];
        $videoId = $_REQUEST['vid'];
        $Video = D('Video');
        $VideoRecommended = M('VideoRecommended');
        $map['vid'] = $videoId;
        if($status == 0){
            $map['img'] = $Video->where('vid='.$videoId[$key])->getField('img');
            $result = $VideoRecommended -> add($map);
            if($result == false) {
                $this->error('推荐视频添加失败');
            }else{
                $this->success('推荐视频添加成功');
            }
        }else if($status == 1){
            $result = $VideoRecommended -> where($map) -> delete();
            if($result == false) {
                $this->error('移除推荐视频失败');
            }else{
                $this->success('移除推荐视频成功');
            }
        }
    }
    
    //查询推荐视频-首页显示
    public function getVideoRecommended() {
        $VideoRecommended = M('VideoRecommended');
        $result = $VideoRecommended -> field('vid,title,img') -> order('displayorder') -> select();
        return $result;
    }
    
}

?>