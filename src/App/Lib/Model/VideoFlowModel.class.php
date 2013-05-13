<?php
//视频连播模型
class VideoFlowModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('catname', 'require', '视频类型名称必须！'),
        );
    //自动完成
    protected $_auto = array(
        );
        
    public function getVideoFlowOnField($id, $field) {
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
     * 删除某视频时，检索连播表，删除其值
     */
    function delVideoFlowOnVidList($id, $vid) {
        $map['id'] = $id;
        $vidlist = $this -> where($map) -> getField('vidlist');
        $vidlist = strtr($vidlist, ','.$vid, '');
        $data['vidlist'] = $vidlist;
        $result = $this -> where($map) -> sava($data);
        if(!$result) {
            return false;
        }else{
            return true;
        }
    }
    
}

?>