<?php
//公告模块
class NoticeAction extends CommonAction {
    function _filter(&$map) {
        if(!empty($_POST['content'])) {
            $map['content'] = array('like',"%".$_POST['content']."%");
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
            //修改结果集
            foreach($voList as $key =>$value) {
                $User = D('User');
                $account = $User ->getFieldById($value['uid'], 'account');
                if(!$account ){
                    $voList[$key]['account'] = '发布用户丢失';
                }else{
                    $voList[$key]['account'] = $account;
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

    //插入数据
    public function insert() {
        $Notice = M("Notice");
            $date['uid']= $_SESSION[C('USER_AUTH_KEY')];
            $date['dateline'] = time();
            $date['who'] = 0;
            $date['content'] = $_POST['content'];
            $date['status'] = $_POST['status'];
            if($Notice->add($date)) {
                $this->success('公告添加成功！');
            }else{
                $this->error('公告添加失败！');
            }
    }
    
  /**
    * 删除
    *
    */
    public function delete(){
      $VideoComment=M('Notice');
    	$de['id']=array('in',$_GET['id']);
    	 if (false !== $VideoComment->where($de)->delete()) {
                $this->success('删除成功!');
            } else {
                $this->error('删除出错!');
            }
    }
    
    
}

?>