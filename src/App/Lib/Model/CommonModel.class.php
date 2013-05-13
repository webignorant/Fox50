<?php
class CommonModel extends Model {

    /**
     * 插入数据
     * @access public
     * @param array $data 数据数组
     * param integer $id 数据编号
     * @retrun boolean/pk
     */
    //插入数据 - 根据方法参数
    public function addData($data, $id) {
        if(!isset($data)) {
            return false;
        }else{
            if(!isset($id)) {
                if(!$result = $this->add()) {
                    return false;
                }else{
                    return $result;
                }
            }else{
                $pk = $this->getPk();
                $map[$pk] = $id;
                if(!$result = $this->where($map)->add()) {
                    return false;
                }else{
                    return $result;
                }
            }
        }
    }
    //插入数据 - 根据POST表单创建对象
    public function addDataOnPost() {
        if(!$this->create()) {
            return false;
        }else{
            if($this->add()) {
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
     //删除数据 - 根据指定主键
     public function delData($id) {
        if(!isset($id)) {
            return false;
        }else{
            $pk = $this->getPk();
            $map[$pk] = $id;
            if(!$result = $this->where($map)->delete()) {
                return false;
            }else{
                return $result;
            }
        }
     }
     //删除数据 - 根据指定条件
     public function delDataOnCondtion($condition, $value) {
        if(!isset($condition) && !isset($value)) {
            return false;
        }else{
            $map[$condition] = $value;
            if($result = $this->where($map)->delete()) {
                return false;
            }else{
                return $result;
            }
        }
     }
     
    /**
     * 修改指定数据
     * @access public
     * param integer $id 数据编号
     * @return boolean
     */
    //修改数据 - 根据指定主键
    public function setDataOnCondtion($data, $id) {
        if(!$this->create()) {
            return false;
        }else{
            if(!isset($id)) {
                return false;
            }else{
                if(!$this->where($id)->save($data)) {
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
    //修改数据 - 根据POST表单创建对象
    public function setDataOnPost() {
        if(!$this->create()) {
            return false;
        }else{
            if(!$this->where($data)->save()) {
                return false;
            }else{
                return true;
            }
        }
    }
   
    /**
     * 查询数据
     * @access public
     * param integer $id 编号
     * @return boolean
     */
    //查询数据 - 根据指定编号
    public function getFindVideo($id) {
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->find();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    //查询数据 - 指定行的指定一列
    public function getDataField($id, $field) {
        if(!isset($id)) {
            return false;
        }else{
        }
        $pk = $this->getPk();
        $map[$pk] = $id;
        $result = $this->where($map)->getField($field);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }
    //查询数据 - 指定行的指定一列 select方式
    public function getDataOnField($id, $field) {
        if(!isset($id)) {
            return false;
        }else{
            if(!isset($field)) {
                return false;
            }else{
                $pk = $this->getPk();
                $map[$pk] = $id;
                $result = $this->where($map)->field($field)->select();
                if(!$result) {
                    return false;
                }else{
                    return $result;
                }
            }
        }
    }
    //查询数据表所有值
    public function getAllDataOnTable() {
        $result = $this->where()->select();
        if($result) {
            return $result;
        }else{
            return false;
        }
    }

	// 获取当前用户的ID
    public function getMemberId() {
        return isset($_SESSION[C('USER_AUTH_KEY')])?$_SESSION[C('USER_AUTH_KEY')]:0;
    }

   /**
     +----------------------------------------------------------
     * 根据条件禁用表数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $options 条件
     +----------------------------------------------------------
     * @return boolen
     +----------------------------------------------------------
     */
    public function forbid($options,$field='status'){

        if(FALSE === $this->where($options)->setField($field,0)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }

	 /**
     +----------------------------------------------------------
     * 根据条件批准表数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $options 条件
     +----------------------------------------------------------
     * @return boolen
     +----------------------------------------------------------
     */

    public function checkPass($options,$field='status'){
        if(FALSE === $this->where($options)->setField($field,1)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }


    /**
     +----------------------------------------------------------
     * 根据条件恢复表数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $options 条件
     +----------------------------------------------------------
     * @return boolen
     +----------------------------------------------------------
     */
    public function resume($options,$field='status'){
        if(FALSE === $this->where($options)->setField($field,1)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }

    /**
     +----------------------------------------------------------
     * 根据条件恢复表数据
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $options 条件
     +----------------------------------------------------------
     * @return boolen
     +----------------------------------------------------------
     */
    public function recycle($options,$field='status'){
        if(FALSE === $this->where($options)->setField($field,0)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }

    public function recommend($options,$field='is_recommend'){
        if(FALSE === $this->where($options)->setField($field,1)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }

    public function unrecommend($options,$field='is_recommend'){
        if(FALSE === $this->where($options)->setField($field,0)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }
}
?>