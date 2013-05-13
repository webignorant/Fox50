<?php
//设置模块
class SettingAction extends CommonAction {
    
    //验证码
    Public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
    
    //设置首页
    public function index() {
        $this->assign('webpagetitle',"用户设置 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this -> display();
    }
    
}

?>