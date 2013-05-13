<?php
//视频连播模块
class VideoFlowAction extends CommonAction {

    function _filter(&$map){
        if(!empty($_POST['name'])) {
            $map['name'] = array('like',"%".$_POST['name']."%");
        }
        if(!empty($_POST['title'])) {
            $map['title'] = array('like',"%".$_POST['title']."%");
        }
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
    protected function _list($model, $map, $sortBy = '', $asc = false, $pk='id') {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        $data['uid'] = $_SESSION['id'];
        //取得满足条件的记录数
        $count = $model->where($map)->where($data)->count($pk);
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

            $voList = $model->where($map)->where($data)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
            //修改结果集
            foreach($voList as $key => $arr) {
                if(is_numeric($arr['uid'])) {
                    $voList[$key]['username'] = $_SESSION['username'];
                }
            }

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
    
    //视频连播首页
    function index() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = M('VideoFlow');
        if (!empty($model)) {
            //判断数据表主键是否为id ByFeng
            if($model->getPk()=='id') {
                $this->_list($model, $map);
            }else{
                $this->_list($model, $map, '', false,$model->getPk());
            }    
        }

        layout(true);
        $this->display();
    }
    
    //视频连播添加页面
    function add() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        
        //接收视频检索条件
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        //显示右侧视频
        $video = D('Video');
        $map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
        $map['status'] = 0;
        $videoList = $video -> where($map) -> select();
        if($videoList == null){
            $this -> assign('videoListCheck','还没有通过审核的视频');
        }else{
            $this -> assign('videoList',$videoList);
        }
        
        layout(true);
        $this->display();
    }
    
    //视频连播编辑页面
    function edit() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        
        $flow = M('VideoFlow');
        $video = D('Video');
        
        $map['id'] = $_GET['id'];
        $voList = $flow -> where($map) -> select();
        $this -> assign('flow',$voList[0]);
        $this -> assign('continuousVideoIdList',$voList[0]['vidlist']);
        //输出连播列表
        $continuousArray = explode(',',$voList[0]['vidlist']);
        $video_info = array();
        foreach($continuousArray as $key => $value) {
            $continuous_data['vid'] = $value;
            $continuous_data['status'] = 0;
            $info = $video -> where($continuous_data) -> field('vid,title') -> select();
            $video_info[$key] = $info[0];
        }
        
        $this -> assign('continuousList',$video_info);
        
        //输出视频列表
        $video_data['uid'] = $_SESSION['id'];
        $video_data['vid'] = array('not in',$voList[0]['vidlist']);
        $videoresult = $video -> where($video_data) -> select();
        $this -> assign('videoList',$videoresult);
        
        layout(true);
        $this->display();
    }
    
    //插入
    function insert(){
        $name = $_POST['name'];
        $continuousVideoId = $_POST['continuousVideoId'];
        if($name == null && $continuousVideoId == null){
            $this -> error('连播信息不能为空！');
        }
        $videoId = implode(',',$continuousVideoId);
        $model = M('VideoFlow');
        $data['uid'] = $_SESSION['id'];
        $data['name'] = $name;
        //检查是否存在重复
        $datacheck = $model -> where($data) -> count();
        if($datacheck != 0) {
            $this -> error('连播列表名称存在重复');
        }
        
        $data['vidlist'] = $videoId;
        $result = $model -> add($data);
        if(!$result){
            $this -> error('连播列表插入错误');
        }else{
            //获取连播ID，并且设置视频表
            $map['uid'] = $_SESSION['id'];
            $map['name'] = $name;
            $continuousId = $model -> where($map) -> getField('id');
            $setVideoResult = $this -> setVideoContinuousID($continuousVideoId, $continuousId);
            if(!$setVideoResult) {
                $this -> error('修改视频连播ID错误');
            }else{
                $this -> success('连播列表插入成功',U('Home/VideoFlow'));
            }
        }
    }
    
    //更新
    function update() {
        $flow = D('VideoFlow');
        $id = $_POST['id'];
        $continuousVideoIdList = $_POST['continuousVideoIdList']; //旧的视频连播
        $oldvideoId = explode(',',$continuousVideoIdList);
        $continuousVideoId = $_POST['continuousVideoId'];  //新的视频连播
        $newvideoId = implode(',',$continuousVideoId);
        if($continuousVideoId == null){
            $this -> error('连播信息不能为空！');
        }
        //修改联播表数据
        $data['id'] = $id;
        //修改连播表名称
        if(isset($_POST['name'])) {
            $update_name = $flow -> where($data) -> setField('name',$_POST['name']);
            if(!update_name){
                $this -> error('修改连播表名称失败');
            }
        }
        $update_check = $flow -> where($data) -> setField('vidlist',$newvideoId);
        if(!$update_check) {
            if($continuousVideoIdList != $newvideoId) {
                $this -> error('修改连播表数据错误');
            }else{
                $this -> error('连播表数据没有改变');
            }
        }else{
            $setOld = $this -> setVideoContinuousID($oldvideoId, 0);
            if(!$setOld) {
                $this -> error('更新前清空连播表出错');
            }else{
                $setNew = $this -> setVideoContinuousID($continuousVideoId, $id);
                if(!$setNew) {
                    $this -> error('更新连播表出错');
                }else{
                    $this -> success('更新连播表成功');
                }
            }
        }
    }
    
    //删除
    public function delete() {
        //删除指定记录
        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
        }else{
            $this -> error('非法访问');
        }
        $model = D('VideoFlow');
        if (!empty($model)) {
            $map['id'] = $id;
            $result = $model -> where($map) -> delete();
            if(!$result) {
                $this -> error('连播列表记录删除失败');
            }else{
                $this -> success('连播列表记录删除成功');
            }
        }
    }
    
    //根据数组批量设置视频的连播ID
    public function setVideoContinuousID($videoArray, $continuousID) {
        $video = D('Video');
        //$data['uid'] = $_SESSION['uid'];
        foreach($videoArray as $key => $videoID) {
            $data['vid'] = $videoID;
            $oldcontinuousID= $video -> where($data) -> getField('relevanceid');
            if($continuousID == $oldcontinuousID) {
                $result = true;
            }else{
                $result = $video -> where($data) -> setField('relevanceid',$continuousID);
                
            }
            if($result == false){
                return false;
            }
        }
        return true;
    }
    
    /*如果删除某视频，检索连播表，删除其值 -- 弃用，转到模型
    public function delVideoIOnContinuous($flowid, $videoid){
        $flow = D('VideoFlow');
        $map['id'] = $flowid;
        $vidlist = $flow -> where($map) -> getField('vidlist'); 
        $vidlist = strtr($vidlist, ','.$videoid, '');
        $data['vidlist'] = $vidlist;
        $result = $flow -> where($map) -> sava($data);
        if(!$result) {
            return false;
        }else{
            return true;
        }
    }
    */
    
}

?>