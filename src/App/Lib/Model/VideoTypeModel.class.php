<?php
//视频模型
class VideoTypeModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('catname', 'require', '视频类型名称必须！'),
        );
    //自动完成
    protected $_auto = array(
        );
        
    public function getVideoTypeOnField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}

?>