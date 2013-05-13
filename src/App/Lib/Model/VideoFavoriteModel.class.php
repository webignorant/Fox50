<?php
//视频收藏模型
class VideoFavoriteModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('objid', 'require', '收藏对象必须！'),
        array('idtype', 'require', '收藏类型必须！'),
        );
    //自动完成
    protected $_auto = array(
        array('dateline','time',self::MODEL_INSERT,'function')
        );
        
    //关联定义
         //完整的定义方式
         protected $_link = array(
            'VideoCount'=>array(
            'mapping_type'=>HAS_ONE,            //关联类型
                'class_name'=>'VideoCount',     //关联的模型类名
                'mapping_name'=>'Count',        //关联的映射名称
                'as_fields'=>'title,img'        //关联的字段值映射成数据对象中的某个字段
            ),
         );
    
    /**
     * 插入收藏
     * @access public
     * @return boolean
     */
    public function addFavorite() {
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
     * 删除指定收藏
     * @access public
     * param integer $id 收藏编号
     * @return boolean
     */
    public function delFavorite($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        if($this->where($map)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定收藏
     * @access public
     * param integer $id 收藏编号
     * @return boolean
     */
    public function setFavorite($id) {
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
     * 查询指定收藏 指定列 信息
     * @access public
     * param integer $id 收藏编号
     * @return boolean
     */
    public function getFavorite($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getFavoriteOnField($id, $field) {
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
     * 查看所有收藏
     * @access public
     * @return boolean
     */
    public function getAllFavorite() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}

?>