<?php
//最近视频播放模型
class VideoRecentlyModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('uid', 'require', '用户编号必须！'),
        array('vid', 'require', '视频编号必须！'),
        );
    //自动完成
    protected $_auto = array(
        array('dateline','time',self::MODEL_INSERT,'function')
        );
        
    //关联定义
    
    /**
     * 插入最近播放
     * @access public
     * @return boolean
     */
    public function addRecently($map) {
        if(!isset($map)) {
            return false;
        }else{
            $result = $this -> data($map) -> add();
            if(!$result) {
                return false;
            }else{
                return true;
            }
        }
    }
    public function addRecentlyOnPost() {
        if(!$this->create()) {
            return false;
        }else{
            if($result = $this->add()) {
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * 删除指定最近播放
     * @access public
     * param integer $id 最近播放编号
     * @return boolean
     */
    public function delRecently($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        if($this->where($map)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定最近播放 指定列 信息
     * @access public
     * param integer $id 最近播放编号
     * @return boolean
     */
    public function setRecently($id) {
        $pk = $this->getPk();
        $data[$pk ] = $id;
        if(!$this->create()) {
            return false;
        }else{
            if($this->where($data)->save()) {
                return true;
            }else{
                return false;
            }
        }
    }
    public function setRecentlyOnField($where, $field) {
        $result = $this->where($where)->setField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
    /**
     * 查询指定最近播放 指定列 信息
     * @access public
     * param integer $id 最近播放编号
     * @return boolean
     */
    public function getRecently($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getRecentlyOnField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
    /**
     * 查看所有最近播放
     * @access public
     * @return boolean
     */
    public function getAllRecently() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}

?>