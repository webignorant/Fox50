<?php
// 用户模型
class UserModel extends CommonModel {
    protected $_validate	=	array(
        array('account','/^[a-z]\w{3,}$/i','帐号格式错误'),
        array('password','require','密码必须'),
        array('nickname','require','昵称必须'),
        array('repassword','require','确认密码必须'),
        array('repassword','password','确认密码不一致',self::EXISTS_VALIDATE,'confirm'),
        array('account','','帐号已经存在',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
        );

    protected $_auto		=	array(
        array('password','pwdHash',self::MODEL_BOTH,'callback'),
        array('create_time','time',self::MODEL_INSERT,'function'),
        array('update_time','time',self::MODEL_UPDATE,'function'),
        );

    protected function pwdHash() {
        if(isset($_POST['password'])) {
            return pwdHash($_POST['password']);
        }else{
            return false;
        }
    }
    
    /**
     * 插入用户
     * @access public
     * @return boolean
     */
    public function addUser() {
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
     * 删除指定用户
     * @access public
     * param integer $id 用户编号
     * @return boolean
     */
    public function delUser($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        if($this->where($map)->delete()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 修改指定用户
     * @access public
     * param integer $id 用户编号
     * @return boolean
     */
    public function setUser($id) {
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
     * 查询指定用户 列 信息
     * @access public
     * param integer $id 用户编号
     * @return boolean
     */
    public function getUser($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getUserField($id, $field) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    public function getUserOnField($id, $field) {
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
     * 查看所有用户
     * @access public
     * @return boolean
     */
    public function getAllUser() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    
}