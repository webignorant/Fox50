<?php
//视频模型
class VideoModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('catid', 'require', '视频栏目必须！'),
        array('typeid', 'require', '视频类型必须！'),
        array('regionid', 'require', '视频地区必须！'),
        array('title', 'require', '视频名称必须！'),
        /*
        array('actor', 'require', '视频演员必须！'),
        array('year', 'require', '视频年份必须！'),
        array('about', 'require', '视频简介必须！')
        */
        );
    //自动完成
    protected $_auto = array(
        array('dateline','time',self::MODEL_INSERT,'function')
        );
        
    //关联定义
     protected $_link = array(
        'VideoCount'=>array(
            'mapping_type'=>HAS_ONE,        //关联类型
            'class_name'=>'VideoCount',     //关联的模型类名
            'mapping_name'=>'Count',        //关联的映射名称
        ),
     );
    
    /**
     * 插入视频
     * @access public
     * @return boolean
     */
    public function addVideo() {
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
     * 删除指定视频
     * @access public
     * param integer $id 视频编号
     * @return boolean
     */
    public function delVideo($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        if($this->where($map)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定视频
     * @access public
     * param integer $id 视频编号
     * @return boolean
     */
    public function setVideo($id) {
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
     * 查询指定视频 列 信息
     * @access public
     * param integer $id 视频编号
     * @return boolean
     */
    public function getVideo($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getVideoField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getVideoOnField($id, $field) {
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
     * 查看所有视频
     * @access public
     * @return boolean
     */
    public function getAllVideo() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}

?>