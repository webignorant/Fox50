<?php
//视频栏目模块
class VideoCategoryAction extends CommonAction {
    function _filter(&$map) {
        if(!empty($_POST['catname'])) {
            $map['catname'] = array('like',"%".$_POST['catname']."%");
        }
        $map['status'] = array('neq','-1');
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
            //修改显示结果
            foreach($voList as $key => $arr) {
                if(is_numeric($arr['shownav']) && $arr['status'] == 1 ){
                    switch($arr['shownav']) {
                        case 0:$voList[$key]['navdisplay'] = '已隐藏';break;
                        case 1:$voList[$key]['navdisplay'] = '已显示';break;
                    }
                }else{
                    $voList[$key]['navdisplay'] = '未启用';
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
    
    /*
    //插入数据
    public function insert() {
        $Video = D("VideoCategory");
        if(!$Video->create()) {
            $this->error($Video->getError());
        }else{
            if($result = $Video->add()) {
                $this->success('视频栏目添加成功！');
            }else{
                $this->error('视频栏目添加失败！');
            }
        }
    }
    
    //删除数据
    public function delete() {
        //删除指定记录
        $name = $this->getActionName();
        $model = M($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $list = $model->where($condition)->delete();
                if ($list !== false) {
                    $this->success('删除成功！');
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }
    */
    
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
        $Friendlink = M('VideoCategory');
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
    
    //检查栏目名称
    public function checkName() {
        if($_POST['catname'] == null ){
            $this->error( '视频栏目名称不能为空！');
        }
        ///[^\u4e00-\u9fa5]/
        if(!preg_match('/^[\x7f-\xff]+$/',$_POST['catname'])) {
            $this->error( '视频栏目名称必须是中文！ ');
        }
        if($_POST['mode'] == 'update'){
            $this->success('该名称可以使用！');
        }
        $Category = M("VideoCategory");
        // 检测用户名是否冲突
        $name  =  $_REQUEST['catname'];
        $result  =  $Category->getByCatname($name);
        if($result) {
            $this->error('该名称已经存在！');
        }else {
            $this->success('该名称可以使用！');
        }
    }
   
}

?>