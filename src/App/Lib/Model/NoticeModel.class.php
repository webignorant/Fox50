<?php
//公告模型
class NoticeModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('uid', 'require', '发布者id必须必须！'),
        array('content', 'require', '公告内容必须必须！')
        );
    //自动完成
    protected $_auto = array(
        array('dateline','time',self::MODEL_INSERT,'function')
        );
        
    /**
     * 查看指定公告 指定列 信息
     * @access public
     * param integer $id 公告编号
     * @return boolean
     */
    public function getNotice($id) {
        $map['id'] = $id;
        $result = $this->where($map)->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getNoticeOnField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getNoticeRandomOnField($field) {
        $map['status'] = 1;
        //$count = $this -> where($map) -> count();
        $noticelist= $this -> where($map) -> field('id') -> select();
        foreach($noticelist as $key => $value) {
            $noticearray[$key] = $noticelist[$key]['id'];
        }
        $count = count($noticearray);
        $randnum = rand(0,$count-1);
        $date['id'] = $noticearray[$randnum];
        $result = $this->where($date)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
    /**
     * 查看所有公告
     * @access public
     * @return boolean
     */
    public function getAllNotice() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }

}

?>