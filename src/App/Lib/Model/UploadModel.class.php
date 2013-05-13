<?php
//视频模型
class UploadModel extends CommonModel {
    //自动验证
    public $_Validate = array(
        array('name', 'require', '站点名称'),
        array('typeid', 'require', '链接地址必须填写！'),
        array('regionid', 'require', 'LOGO地址必须填写')
        );
             
}
?>