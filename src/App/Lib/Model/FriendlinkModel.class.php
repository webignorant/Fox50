<?php
//视频模型
class FriendlinkModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('name', 'require', '站点名称'),
        array('typeid', 'require', '链接地址必须填写！'),
        array('regionid', 'require', 'LOGO地址必须填写')
        );   
}
?>