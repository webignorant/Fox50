<?php
//日志模型
class LogModel extends CommonModel {
    //日志级别 1:系统日志;2:用户日志;3:视频日志;
    /**
     *自动验证
     * uid,ip,updatetime,succeed,content
     **/
    public $_validate	=	array(
        array('uid','require','用户名必须'),
        array('ip','001.001.001.001,255,255,255,255','IP地址必须',1,'ip_allow',1),
        array('updatetime','require','操作时间必须'),
        array('succeed','require','状态必须'),
        array('content','require','日志内容必须'),
        );
        
    /**
     *自动完成
     * @param updatetime time()自动填充
     **/
    public $_auto		=	array(
        array('updatetime','time',self::MODEL_INSERT,'function'),
        );
        
    //判断日志是否允许记录
    protected function checkLogType($type) {
        switch ($type){
            case 1:  return C('SYSTEM_LOG');break;
            case 2:  return C('USER_LOG');break;
            case 3:  return C('VIDEO_LOG');break;
            default :return false;
        }
    }

    /**
     * 插入日志
     * @access public
     * param integer $type 日志级别 1:系统日志;2:用户日志;3:视频日志;
     * param integer $status 日志状态 1 成功 2失败
     * param string $content 日志内容
     * @return boolean
     */
    public function addLog($type, $status, $content) {
        //判断是否需要记录
        if(!$this->checkLogType($type)){
            return false;
        }
        $date['uid'] = $_SESSION[C('USER_AUTH_KEY')];
        $date['ip'] = get_client_ip();
        $date['type'] = $type;
        $date['updatetime'] = time();
        $date['succeed'] = $status;
        $date['content'] = $content;
        if($this->add($date)) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 删除指定日志
     * @access public
     * param integer $id 日志编号
     * @return boolean
     */
    public function delLog($id) {
        $pk = $this->getPk();
        $where = $pk.'='.$id;
        if($this->where($where)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定日志
     * @access public
     * param integer $id 日志编号
     * @return boolean
     */
    public function setLog($id) {
        $pk = $this->getPk();
        $date[$pk ] = $id;
        $date['uid'] = $_SESSION[C('USER_AUTH_KEY')];
        $this->create();
        if($this->where($date)->save()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 查看指定日志
     * @access public
     * param integer $uid 用户编号
     * @return boolean
     */
    public function getLog($uid) {
        $map['uid'] = $uid;
        $result = $this->where($map)->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
    /**
     * 查看所有日志
     * @access public
     * @return boolean
     */
    public function getAllLog($field) {
        $result = $this->where($field)->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}

?>