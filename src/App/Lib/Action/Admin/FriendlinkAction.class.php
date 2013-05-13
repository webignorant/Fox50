<?php
class FriendlinkAction extends CommonAction {
     function _filter(&$map){
        if(!empty($_POST['name'])) {
            $map['name'] = array('like',"%".$_POST['name']."%");
        }
    }
    
    /**
    * 添加友情链接
    *
    */
    public function insert(){
    	$friendlink = D('friendlink');
    	if($friendlink->create()){
    		if($friendlink->add()){
    			 $this->success('友情链接添加成功!');
    		}else{
    			 $this->error('友情链接添加失败');
    		}
    	}else{
    		$this->error($User->getError());
    	}
    }
    
    /**
    *更新数据
    *
    */
    public function update() {
        $friendlink = D("friendlink");
        if ($friendlink->create()){
            $list = $friendlink->save();
            if ($list !== false) {
                $this->success('数据更新成功!',U('Admin/Friendlink/index'));
            } else {
                $this->error("没有更新任何数据!");
            }
        } else {
            $this->error($friendlink->getError());
        }
    }
    
    /**
    * 删除
    *
    */
    public function delete(){
    	
    	$friendlink=M('friendlink');
    	$de['id']=array('in',$_GET['id']);
    	 if (false !== $friendlink->where($de)->delete()) {
                $this->success('删除成功！');
            } else {
                $this->error('删除出错！');
            }
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
        $Friendlink = M('Friendlink');
        $sortList   =   $Friendlink->order('displayorder asc')->select();
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
    
}