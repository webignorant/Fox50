<?php
//最近播放视频动作
class VideoRecentlyAction extends CommonAction {

    function _filter(&$map){
        if(!empty($_POST['title'])) {
        $map['title'] = array('like',"%".$_POST['title']."%");
        }
        $map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
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

            $voList = $model->where($map)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
            //修改查询结果
            $Video = D('Video');
            foreach($voList as $key => $arr) {
                if(is_numeric($arr['vid'])) {
                    $data['vid'] = $arr['vid'];
                    $info = $Video -> where($data) -> field('title,img') -> select();
                    $voList[$key]['videotitle'] = $info[0]['title'];
                    $voList[$key]['videoimg'] = $info[0]['img'];
                }
                switch($arr['device']) {
                    case 'Computer':
                        $voList[$key]['device'] = '个人电脑';
                        break;
                    case 'Mobile':
                        $voList[$key]['device'] = '移动手机';
                        break;
                    default :
                        $voList[$key]['device'] = '位置设备';
                        break;
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
    
    //显示用户最近播放首页
    public function index() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        
        //列表过滤器，生成查询Map对象
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        //$userID = $_SESSION[C('USER_AUTH_KEY')];
        $model = D('VideoRecently');
        if (!empty($model)) {
            //判断数据表主键是否为id ByFeng
            if($model->getPk()=='id') {
                $this->_list($model, $map);
            }else{
                $this->_list($model, $map, '', false,$model->getPk());
            }    
        }
        $this->assign('webpagetitle',"用户 - 最近播放 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this -> display();
        return;
    }
    
    //在播放历史层显示记录
    public function showRecentlyOnHistoryDiv() {
        $recently = D('VideoRecently');
        $video = D('Video');
        $map['uid'] = $_SESSION['id'];
        $recentlyList = $recently -> where($map) -> order('id asc') -> field('vid,dateline,device') -> limit(10) -> select();
        foreach($recentlyList as $key => $arr) {
            $recentlyList[$key]['title'] = $video -> getVideoField($arr['vid'], 'title');
        }
        return $recentlyList;
    }
    
    //插入记录
    public function insert($vid) {
        $UserAction = A('Home/User');
        $UserAction -> checkUserLogin();
        
        if(isset($vid)) {
            $model = D('VideoRecently');
            $result = $model -> addRecently();
            if (!$result) {
                $this->error('插入播放记录删除失败！');
                //$this -> AjaxReturn(0,'插入播放记录删除失败！',0);
            } else {
                $this->success('插入播放记录成功！');
                //$this -> AjaxReturn(1,'插入播放记录成功！',1);
            }
        }else{
            $this->error('非法操作');
        }
    }
    
    //删除指定记录
    public function delete() {
        $model = D('VideoRecently');
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $list = $model->where($condition)->delete();
                if ($list !== false) {
                    $this->success('移除播放记录成功！');
                } else {
                    $this->error('移除播放记录删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }
    
    //删除全部记录
    public function clearAllHistory() {
        $UserAction = A('Home/User');
        $UserAction -> checkUserLogin();
        
        $model = D('VideoRecently');
        $map['uid'] = $_SESSION['id'];
        $result = $model -> where($map) -> delete();
        if(!$result) {
            $this->error('清除全部播放记录失败！');
        }else{
            $this->success('清除全部播放记录成功！');
        }
    }
    
    //更新记录
    
    //插入播放记录 - 提供直接调用
    public function setVideoHistory($vid) {
        if(!isset($_SESSION['id'])) {
            return false;
        }
        $model = D('VideoRecently');
        //如果存在记录，则修改播放时间
        if($this->getVideoHistoryExist($vid)) {
            $map['vid'] = $vid;
            $map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
            $history = array('dateline'=>time());
            $result = $model -> setRecentlyOnField($map, $history);
            return false;
        }
        if(isset($vid)) {
            $history['vid'] = $vid;
            $history['uid'] = $_SESSION[C('USER_AUTH_KEY')];
            $history['dateline'] = time();
            $history['device'] = 'Computer';
            $result = $model -> addRecently($history);
            if (!$result) {
                //$this->error('插入播放记录删除失败！');
                //$this -> AjaxReturn(0,'插入播放记录删除失败！',0);
            } else {
                //$this->success('插入播放记录成功！');
                //$this -> AjaxReturn(1,'插入播放记录成功！',1);
            }
        }else{
            $this->error('非法操作');
        }
    }
    
    //查询视频是否存在历史记录
    public function getVideoHistoryExist($vid) {
        $UserAction = A('Home/User');
        $UserAction -> checkUserLogin();
        
        if(isset($vid)) {
            $map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
            $map['vid'] = $vid;
            $recently = D('VideoRecently');
            $count = $recently -> where($map) -> count();
            if($count == 0) {
                return false;
            }else{
                return true;
            }
        }else{
            $this -> error('非法访问');
        }
    }
    
    
}
