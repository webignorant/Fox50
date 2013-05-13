<?php
//视频专辑动作
class VideoSpecialAction extends CommonAction {

    function _filter(&$map){
        if(!empty($_POST['specialname'])) {
            $map['specialname'] = array('like',"%".$_POST['specialname']."%");
        }
    }
    
    //视频专辑首页
    function index() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        $model = M('VideoSpecial');
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
    
    
    //视频专辑添加页面
    function add() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        //显示右侧视频
        $video = D('Video');
        $map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
        $videoList = $video -> where($map) -> select();
        $this -> assign('videoList',$videoList);
        layout(true);
        $this->display();
    }
    
    //视频专辑编辑页面
    function edit() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        $videospecial = M('VideoSpecial');
        $video = D('Video');
        $map['specialid'] = $_GET['id'];
        $map['uid'] = $_SESSION['id'];
        $voList = $video->where($map)->field('vid')->select();
        $VS = $videospecial->where('id='.$_GET['id'])->limit(1)->select();
        
        $this -> assign('VS',$VS[0]);//分配相关信息
        //$this -> assign('continuousVideoIdList',$voList[0]['vidlist']);
        //输出专辑列表
        $video_info = array();
        $temp_vid = '';
        foreach($voList as $key => $tempvalue) {
            $continuous_data['vid'] = $tempvalue['vid'];
            $continuous_data['status'] = 0;
            $info = $video->where($continuous_data)->field('vid,title')->select();
            $video_info[$key] = $info;
            $temp_vid .= $tempvalue['vid'].',';
        }
        $this -> assign('continuousList',$video_info);
        
       
        
        
        //输出视频列表
        $video_data['uid'] = $_SESSION['id'];
        $video_data['vid'] = array('not in',rtrim($temp_vid,','));
        $videoresult = $video -> where($video_data) -> select();
        $this -> assign('videoList',$videoresult);
        layout(true);
        $this->display();
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

    
    
    //插入
    function insert(){
        $name = $_POST['name'];
        $continuousVideoId = $_POST['continuousVideoId'];
        if($name == null){
            $this -> error('专辑名不能为空！');
        }
        $videoId = implode(',',$continuousVideoId);
        $model = M('VideoSpecial');
        $data = array();
        $data['uid'] = $_SESSION['id'];
        $data['specialname'] = htmlspecialchars($name);
        //检查是否存在重复
        $datacheck = $model -> where($data) -> count();
        if($datacheck != 0) {
        	$this -> error('专辑列表名称存在重复');
        }
        	$data['depict'] = htmlspecialchars($_POST['depict']);
        	$data['username'] = $_SESSION['username'];
        	$data['dateline'] = time();
        	$data['updatetime'] = time();
        	$data['videonum'] = count($continuousVideoId);
        	$data['pic'] = '';
        	$data['password'] = '';
        	$data['target_ids'] = '';
        	$data['favtimes'] = '';
        	$data['sharetimes'] = '';
        	if($VS = $model->add($data)){
        		//$this->success('专辑添加成功!',U('Home/User/index'));
        		$video = M('video');
        		$where['uid'] = $_SESSION['id'];
        		$where['vid'] = array('in',$videoId);
        		$tempvs = $video->where($where)->setField('specialid',$VS);
        		if($tempvs){
        			$this->success('专辑添加成功!',U('Home/User/index'));
        		}else{
        			$model->where('id='.$VS)->delete();
        			$this->error('专辑添加失败!',U('Home/User/index'));
        		}
        	}else{
        		$this->error('专辑添加失败!',U('Home/User/index'));
        	}
    }
    
    //更新
    function update() {
        $id = $_POST['id'];
        $video = M('Video');
        $continuousVideoId = $_POST['continuousVideoId'];  //新的视频连播
        $newvideoId = implode(',',$continuousVideoId);
        
        $map['specialid'] = $id;
        $map['uid'] = $_SESSION['id'];
        
        //更新原来的值
        if($video->where($map)->setField('specialid',0)){
        	$where['vid'] = array('in',$newvideoId);
        	$data['specialid'] = $id;
        	if($video->where($where)->save($data)){
        		M('VideoSpecial')->where('id='.$id)->setField('videonum',count($continuousVideoId));
        		$this->success('专辑更新成功!',U('Home/User/index'));
        	}else{
        		$this -> error('更新失败！');
        	}
        }else{
        	$this -> error('更新失败！');
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
        $video = M('Video');
        $model = M('VideoSpecial');
        if (!empty($model)) {
            $map['id'] = $id;
            $result = $model -> where($map) -> delete();
            $where['uid'] = $_SESSION['id'];
            $where['specialid'] = $id;
            $video->where($map)->setField('specialid',0);
            if(!$result) {
                $this -> error('专辑列表记录删除失败');
            }else{
                $this -> success('专辑列表记录删除成功');
            }
        }
    }
    
    //根据数组批量设置视频的连播ID
    public function setVideoContinuousID($videoArray, $continuousID) {
        $video = D('Video');
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
    
}

?>