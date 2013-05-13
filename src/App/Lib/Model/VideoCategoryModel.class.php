<?php
//视频栏目模型
class VideoCategoryModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('catname', 'require', '视频栏目栏目名称必须！')
        );
    //自动完成
    protected $_auto = array(
        array('dateline','time',self::MODEL_INSERT,'function'),
        array('perpage','25',self::MODEL_INSERT,'string')
        );
    
    /**
     * 插入视频栏目
     * @access public
     * @return boolean
     */
    public function addVideoCategory() {
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
     * 删除指定视频栏目
     * @access public
     * param integer $id 视频栏目编号
     * @return boolean
     */
    public function delVideoCategory($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        if($this->where($map)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定视频栏目
     * @access public
     * param integer $id 视频栏目编号
     * @return boolean
     */
    public function setVideoCategory($id) {
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
    
    /**
     * 查询指定视频栏目 列 信息
     * @access public
     * param integer $id 视频栏目编号
     * @return boolean
     */
    public function getVideoCategory($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getVideoCategoryField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getVideoCategoryOnField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->field($field)->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
    /**
     * 查看所有视频栏目
     * @access public
     * @return boolean
     */
    public function getAllVideoCategory() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}

?>