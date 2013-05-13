<?php
//视频统计模型
class VideoCountModel extends CommonModel {
    /*自动验证
    protected $_Validate = array(
        array('catid', 'require', '视频统计栏目必须！'),
        array('typeid', 'require', '视频统计类型必须！'),
        array('regionid', 'require', '视频统计地区必须！'),
        array('title', 'require', '视频统计名称必须！'),
        array('actor', 'require', '视频统计演员必须！'),
        array('year', 'require', '视频统计年份必须！'),
        array('about', 'require', '视频统计简介必须！')
        ); */
    /*自动完成
    protected $_auto = array(
        array('dateline','time',self::MODEL_INSERT,'function')
        ); */
    
     //关联查询的完整定义方式
     protected $_link = array(
        'VideoCount'=>array(
            'mapping_type'=>HAS_ONE,    //关联类型
            'class_name'=>'VideoCount',      //关联的模型类名
            'foreign_key'=>'id',        //要关联的外键
            'mapping_name'=>'VideoCount',    //关联的映射名称
        ),
     );
    
    /**
     * 插入视频统计
     * @access public
     * @return boolean
     */
    public function addVideoCount() {
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
     * 删除指定视频统计
     * @access public
     * param integer $id 视频统计编号
     * @return boolean
     */
    public function delVideoCount($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        if($this->where($map)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定视频统计
     * @access public
     * param integer $id 视频统计编号
     * @return boolean
     */
    public function setVideoCount($id) {
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
     * 查询指定视频统计 列 信息
     * @access public
     * param integer $id 视频统计编号
     * @return boolean
     */
    public function getVideoCount($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getVideoCountField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getVideoCountOnField($id, $field) {
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
     * 查看所有视频统计
     * @access public
     * @return boolean
     */
    public function getAllVideoCount() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }

    public function hello(){
        return 'hello';
    }
}
