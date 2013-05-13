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
    
    //推荐编辑页面
    function edit() {
        $model = M('VideoRecommended');
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getByVid($id);
        $this->assign('vo', $vo);
        $this->display();
    }
    
    /**
     +----------------------------------------------------------
     * 默认排序操作
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public function sort()
    {
        $Friendlink = M('VideoRecommended');
        $map['status'] = array('neq','-1');
        $sortList   =   $Friendlink->where($map)->order('displayorder asc')->select();
        $this->assign("sortList",$sortList);
        $this->display();
        return ;
    }
    
    function saveSort() {
        $seqNoList = $_POST ['seqNoList'];
        if (!empty($seqNoList)) {
            //更新数据对象
            $name = $this->getActionName();
            $model = D($name);
            $col = explode(',', $seqNoList);
            //启动事务
            $model->startTrans();
            foreach ($col as $val) {
                $val = explode(':', $val);
                $model->id = $val [0];
                $model->displayorder = $val [1];
                $result = $model->save();
                if (!$result) {
                    continue;
                }
            }
            //提交事务
            $model->commit();
            if ($result !== false) {
                //采用普通方式跳转刷新页面
                $this->success('更新成功');
            } else {
                $this->error($model->getError());
            }
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
    
    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
     * @param TablePk $pk 主键名称
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _list($model, $map, $sortBy = '', $asc = false, $pk='vid') {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        $order = 'vid';
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        //取得满足条件的记录数
        $count = $model->where($map)->count($pk);
        if ($count > 0) {
            import("@.ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $p = new Page($count, $listRows);
            //分页查询数据

            $voList = $model->where($map)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
            /*
            //修改显示结果集
            foreach($voList as $key =>$value) {
                if(is_numeric($value['vid'])) {
                    $Video = D('Video');
                    $map['vid'] = $value['vid'];
                    $name = $Video ->where($map)->getField('title');
                    $voList[$key]['title'] = $name;
                }
            }
            */
            //echo $model->getlastsql();
            //分页跳转的时候保证查询条件
            foreach ($map as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= "$key=" . urlencode($val) . "&";
                }
            }
            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        cookie('_currentUrl_', __SELF__);
        return;
    }
    
    //添加推荐视频
    public function addVideoRecommended() {
        $videlIdList = $_REQUEST['videoIdList'];
        $videoId = array();
        $videoId = $_REQUEST['videoId'];
        //$this -> error($videoId);exit;
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
                $map['title'] = $Video->where('vid='.$videoId[$key])->getField('title');
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
        $situation = $_REQUEST['situation'];
        $videoId = $_REQUEST['vid'];
        $Video = D('Video');
        $VideoRecommended = D('VideoRecommended');
        $map['vid'] = $videoId;
        if($situation == 0){
            $map['title'] = $Video->where('vid='.$videoId)->getField('title');
            $map['img'] = $Video->where('vid='.$videoId)->getField('img');
            $result = $VideoRecommended -> add($map);
            if($result == false) {
                $this->error('推荐视频添加失败');
            }else{
                $this->success('推荐视频添加成功');
            }
        }else if($situation == 1){
            $result = $VideoRecommended -> where($map) -> delete();
            if($result == false) {
                $this->error('移除推荐视频失败');
            }else{
                $this->success('移除推荐视频成功');
            }
        }
    }
    
    //删除推荐视频
    public function delVideoRecommended() {
        if(!isset($_REQUEST['id'])) {
            $this -> error('非法操作');
        }
        $id = $_REQUEST['id'];
        $id_array = explode(',', $id);
        $condition = array(vid => array('in', $id_array));
        $model = D('VideoRecommended');
        $img_array = $model -> where($condition) -> field('img') -> select();
        //判断图像是否在推荐文件夹，存在则删除
        foreach($img_array as $key => $oldimg){
            $oldimg_array = explode('/',$oldimg['img']);
            if($oldimg_array[2] == 'recommended') {
                @unlink($oldimg['img']);
            }
        }
        $result = $model -> where($condition) -> delete();
        if(!$result){
            $this -> error('移除推荐视频失败');
        }else{
            $this -> success('移除推荐视频成功');
        }
    }
    
}

?>