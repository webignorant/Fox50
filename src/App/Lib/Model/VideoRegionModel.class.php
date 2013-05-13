<?php
//视频地区模型
class VideoRegionModel extends CommonModel {
    //自动验证
    protected $_Validate = array(
        array('regionname', 'require', '视频地区名称必须！'),
        );
    //自动完成
    protected $_auto = array(
        );
    
}

?>