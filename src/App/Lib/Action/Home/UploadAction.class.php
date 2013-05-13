<?php
class UploadAction extends CommonAction {
  
    public function index(){
        if(!isset($_SESSION['username'])) {
            $this->error('非法访问',U('Home/Index/index'));
        }
        $this->assign('webpagetitle',"上传视频 - 精彩无限 - Fox50视频网 - 最好的视频网站");
        $this->assign('catid',$this->catid());
        if($this->catid() != null){
            $this->assign('vtype',$this->type());
            $this->assign('region',$this->region());
            $this->assign('year',$this->year());
        }
        layout(true);
        $this->display();
    }
    
    //插件 - 视频上传
    public function uploadify() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', 900000);
        @set_time_limit(0);
        
        import('@.ORG.Util.UploadFile');
        $Up= new UploadFile;
        //设置上传文件大小
        $Up->maxSize  = 32922000000;
        //设置上传文件类型
        $Up->allowExts = explode(',','flv,avi,mp4');
        //设置上传文件mime类型
        $Up->allowTypes=array('video/x-msvideo','application/octet-stream','video/avi');
        //创建未审核文件夹
        $Up->savePath = './VideoUploads/';
        $path=$Up->savePath.'Unaudited';
        if(!is_dir($path)){
            if(@mkdir($path,0777)){
                $Up->savePath = $path.'/';
            }else {
             $Up->savePath = './VideoUploads/';
            }
        }else {
            $Up->savePath = $path.'/';
        }
        //上传处理
        if(!$Up->upload()) {
            //捕获上传异常
            //$this->error($Up->getErrorMsg());
            $this -> ajaxReturn(0,$this->error($Up->getErrorMsg()),0);
        }else {
            //成功上传的文件信息
            $uploadInfo = $Up->getUploadFileInfo();

            $Info = json_encode($uploadInfo[0]);
            $this -> ajaxReturn(1,$Info,1);
        }
    }
    
    //保存视频信息
    public function savaVideoInfo() {
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', 900000);
        @set_time_limit(0);
        
        $model = D('Video');
        if(false === $model -> create()) {
            $this -> ajaxReturn(0,'Form Error',0);
        }
        //
        //视频信息数组
        $data['uid']=$_SESSION['id'];//用户的ID号
        $data['username']=$_SESSION['username'];//上传的用户名
        $data['specialid']=0;//所属专辑ID
        
        $catid = explode('|',$_POST['catid']); //栏目
        $data['catid'] = $catid[0];
        $typeid = explode('|',$_POST['typeid']); //类型
        $data['typeid'] = $typeid[0];
        $data['regionid']=$_POST['regionid']; //地区
        
        
        $data['dateline']=time();//视频发布时间
        $data['postip']=get_client_ip();//视频发布IP
        $data['filename'] = $_POST['filename'];//视频标题    
        $data['filepath']=$_POST['path'];//视频路径
        if($_POST['extension'] != 'flv'){
            $data['status']=2;//视频状态 0=已通过 1=待审核 2=已忽略
        }else{
            $data['status']=3;//视频状态 0=已通过 1=待审核 2=已忽略
        }
        if($_POST['title'] == null) {
            $this -> ajaxReturn(0,'视频标题不能为空',0);
        }
        $data['title']=htmlspecialchars($_POST['title']);//视频标题
        $data['actor']=htmlspecialchars($_POST['actor']);//主演
        $data['director']=htmlspecialchars($_POST['director']);//导演
        $data['year']=$_POST['year'];//发行年份
        $data['about']=htmlspecialchars($_POST['about']);//简介
        
        //$json_data = json_encode($data);
        //$this -> ajaxReturn(0,$json_data,0);
        
        $video_id = $model -> add($data);
        if($video_id) {
            $this -> ajaxReturn(1,'添加视频信息成功',1);
        }else{
            $this -> ajaxReturn(0,'添加视频信息失败',0);
        }
    }
  
    public function upload(){
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', 900000);
        @set_time_limit(0);
        //不登录不能上传
        if(!isset($_SESSION['id'])){
          $this->error('对不起，上传视频请先登录！',U('Home/Upload/index'));
        }
        $info=$this->_upload();
        $videoinfo=$this->info($info[0]['savepath'].$info[0]['savename']);
        $photodir='./PhotoUploads/'.date('Ymd');
        $uniqid=uniqid(rand());
        $filename=$info[0]['savename'];//原文件名
        if($info[0]['extension'] != 'flv'){
            //转换格式
            @set_time_limit(0);
            $newvideo=$uniqid.'.flv';
            if($this->dir($photodir)){
              $this->screenshot($info[0]['savepath'].$info[0]['savename'],$photodir.'/'.$uniqid.'.jpg');
          }
            $this->transition($info[0]['savepath'].$info[0]['savename'],'400x300',$info[0]['savepath'].$newvideo);
            //获取播放时长
            $playtime = new Videoinfo;
            $videoinfo['file_time']=$playtime->getTime($info[0]['savepath'].$newvideo);
            @unlink($info[0]['savepath'].$info[0]['savename']);
        }else{
          if($this->dir($photodir)){
              $this->screenshot($info[0]['savepath'].$info[0]['savename'],$photodir.'/'.$uniqid.'.jpg');
              $newvideo=$info[0]['savename'];
          }
        }
        $Upload = M('video');
        $type = explode('|',$_POST['type']);
        $catid = explode('|',$_POST['catid']);
        $data=array();
        $data['uid']=$_SESSION['id'];//用户的ID号
        $data['typeid']=$type[0];//视频类型ID
        $data['username']=$_SESSION['username'];//上传的用户
        $data['specialid']=0;//所属专辑ID
        $data['dateline']=time();//视频发布时间
        $data['postip']=get_client_ip();//视频发布IP
        $data['filename'] = $newvideo;//视频标题    
        $data['size']=$info[0]['size'];//视频大小
        $data['filepath']=$info[0]['savepath'];//视频路径
        //$data['thumb']='0';//是否有缩略图
       // $data['remote']='0';//是否为远程视频
        $data['img']=$photodir.'/'.$uniqid.'.jpg';//视频封面图片
        $data['definition']=$videoinfo['resolution'];//清晰度
        $data['playtime']=$videoinfo['file_time'];//播放时长
        $data['status']=0;//视频状态 0=已通过 1=待审核 2=已忽略
        $data['catid']=$catid[0];//栏目
        $data['type']=$type[1];//视频类型
        $data['regionid']=$_POST['diqu'];//地区
        $data['title']=htmlspecialchars($_POST['title']);//视频标题
        $data['actor']=htmlspecialchars($_POST['zhuyan']);//主演
        $data['director']=htmlspecialchars($_POST['daoyan']);//导演
        $data['year']=$_POST['nianfen'];//发行年份
        $data['about']=htmlspecialchars($_POST['content']);//简介
        $video_id=$Upload->add($data);
        //视频统计表
        if($video_id){
            $Videocount = M('VideoCount');
            $count['id']=$video_id;
            $count['catid']=$data['catid'];
            $Videocount->add($count);
            $this->success('上传成功!',U('Home/Upload/index'));
        }else{
            @unlink($info[0]['savepath'].$info[0]['savename']);
            $this->success('上传的文件类型不允许!',U('Home/Upload/index'));
        }
    }
    /**
    * 获取视频相关信息
    * 
    */
    private function info($file){
        import('@.ORG.Util.Videoinfo');
        $video = new Videoinfo;
        $video->video_info($file);
        $info = array();
        $info['resolution'] = $video->resolution;//分辨率
        $info['vformat'] = $video->vformat;//视频格式
        $info['vcodec'] = $video->vcodec;//编码格式
        $info['size'] = $video->size;//文件大小
        $info['file_time'] = $video->file_time;//文件播放时长
        return $info;
    }
  
    /**
    * 获取类型相关选项
    * 
    */
    public function typeselect(){
        $typeselect = M('VideoType');
        $data['upid']=$_POST['typeid'];
        $this->assign('typese',$typeselect->where($data)->field('id,typename')->select());
        $this->display();
    }
  
  
    /**
    * 转格式
    * 参数:视频文件，分辨率，转换后存放
    */
    private function transition($video_file,$resolution,$later_video){
        exec("ffmpeg -i $video_file -ab 56 -ar 22050 -b 500 -r 15 -s $resolution $later_video");
    }
  
    /**
    * 截图
    * 参数:视频文件，图片存放目录及图片名
    */
    private function screenshot($video_file,$photofile){
        $cmd="ffmpeg -i $video_file -f image2 -ss 1 -s 400*300 -vframes 1 $photofile";
        exec($cmd);
    }
  
    /**
    * 上传方法
    * 返回上传文件的信息
    */
    private function _upload(){
      import('@.ORG.Util.UploadFile');
      @set_time_limit(0);
      ini_set('max_execution_time', '0');
      ini_set('max_input_time', 900000);
      $Up= new UploadFile;
      //设置上传文件大小
      $Up->maxSize  = 32922000000;
      //设置上传文件类型
      $Up->allowExts = explode(',','flv,avi,mp4');
      //设置上传文件mime类型
      $Up->allowTypes=array('video/x-msvideo','application/octet-stream','video/avi');
      //以日期文件夹方式保存
      $Up->savePath = './VideoUploads/';
      $path=$Up->savePath.date('Ymd');
      if(!is_dir($path)){
        if(@mkdir($path,0777)){
         $Up->savePath = $path.'/';
        }else{
         $Up->savePath = './VideoUploads/';
        }
      }else{
        $Up->savePath = $path.'/';
      }
      if (!$Up->upload()) {
            //捕获上传异常
            $this->error($Up->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            return $uploadList = $Up->getUploadFileInfo(); 
        }  
    }
   
    /**
    * 自动检测创建目录
    *
    */
    private function dir($path){
        if(!is_dir($path)){
            if(@mkdir($path,0777)){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 1;
        }
    }
   
    /**
    * 地区
    *
    */
    public function region(){
        $region= M('VideoRegion');
        return $region->getField('id,regionname',null);
    }
   
    /**
    * 栏目
    */
    public function catid(){
        $catid = M('VideoCategory');
        $map['status'] = 1;
        $result = $catid->where($map)->field('id,catname')->select();
        return $result;
    }
   
    /**
    * 视频类型
    *
    */
    public function type($id=1){
        $type= M('VideoType');
        return $type->where('upid='.$id)->field('id,typename')->select();
    }
   
    public function year(){
        return array(
        '2013',
        '2012',
        '2011',
        '2010',
        '2009',
        '2008',
        '2007',
        '2006',
        '2005',
        '2004',
        '2003',
        '2002',
        '2001',
        '2000',
        '1999',
        '1998',
        '1997',
        '1996',
        '1995',
        '1994',
        '1993',
        '1992',
        '1991',
        '1990',
        '1989',
        '1988'
        );
    }
    
    //头像上传 - 插件
    public function uploadAvatar() {
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', 900000);
        @set_time_limit(0);
        
        import('@.ORG.Util.UploadFile');
        $Up= new UploadFile;
        //设置上传文件大小
        $Up->maxSize  = 2048000;
        //设置上传文件类型
        $Up->allowExts = explode(',','jpg,jpeg,png');
        //设置上传文件mime类型
        $Up->allowTypes=array('application/octet-stream','image/jpeg','image/x-png');
        //创建未审核文件夹
        $Up->savePath = './PhotoUploads/';
        $path=$Up->savePath.'avatar';
        if(!is_dir($path)){
            if(@mkdir($path,0777)){
                $Up->savePath = $path.'/';
            }else {
             $Up->savePath = './PhotoUploads/';
            }
        }else {
            $Up->savePath = $path.'/';
        }
        //设置略缩图处理
        $Up->thumb = true;
        $Up->thumbMaxHeight = '100';
        $Up->thumbMaxWidth = '400';
        $Up->thumbPrefix = 'fox_avatar_';
        $Up->thumbRemoveOrigin = true;
        //上传处理
        if(!$Up->upload()) {
            //捕获上传异常
            //$this->error($Up->getErrorMsg());
            $this -> ajaxReturn(0,$this->error($Up->getErrorMsg()),0);
        }else {
            //成功上传的文件信息
            $uploadInfo = $Up->getUploadFileInfo();
            $user = D('User');
            $map['id'] = $_SESSION['id'];
            //如果有，删除原来的头像
            $old_avatar = $user -> where($map) -> getField('avatar');
            if($old_avatar != null){
                @unlink($old_avatar);
            }
            $new_avatar = $uploadInfo[0]['savepath'].$Up->thumbPrefix.$uploadInfo[0]['savename'];
            $map['avatar'] = $new_avatar;
            $result = $user -> save($map);
            //$Info = json_encode($uploadInfo[0]);
            if(!$result) {
                $this -> ajaxReturn(0,$old_avatar,0);
            }else{
                $this -> ajaxReturn(1,$new_avatar,1);
            }
        }
    }
    
    //推荐视频封面上传 - 插件
    public function uploadVideoRecommendedImg() {
        if(!isset($_POST['rid'])){
            $this -> ajaxReturn(4,'没有正确信息',4);
            exit;
        }else{
            $rid = $_POST['rid'];
        }
        ini_set('max_execution_time', '0');
        ini_set('max_input_time', 900000);
        @set_time_limit(0);
        
        import('@.ORG.Util.UploadFile');
        $Up= new UploadFile;
        //设置上传文件大小
        $Up->maxSize  = 10240000;
        //设置上传文件类型
        $Up->allowExts = explode(',','jpg,jpeg,png');
        //设置上传文件mime类型
        $Up->allowTypes=array('application/octet-stream','image/jpeg','image/x-png');
        //创建未审核文件夹
        $Up->savePath = './PhotoUploads/';
        $path=$Up->savePath.'recommended';
        if(!is_dir($path)){
            if(@mkdir($path,0777)){
                $Up->savePath = $path.'/';
            }else {
             $Up->savePath = './PhotoUploads/';
            }
        }else {
            $Up->savePath = $path.'/';
        }
        //上传处理
        if(!$Up->upload()) {
            //捕获上传异常
            //$this->error($Up->getErrorMsg());
            $this -> ajaxReturn(0,$this->error($Up->getErrorMsg()),0);
        }else {
            //成功上传的文件信息
            $uploadInfo = $Up->getUploadFileInfo();
            $map['id'] = $rid;
            $recommended = D('VideoRecommended');
            //判断图像是否已设置，已设置则删除旧的
            $oldimg = $recommended -> where($map) -> getField('img');
            $oldimg_array = explode('/',$oldimg);
            if($oldimg_array[2] == 'recommended') {
                @unlink($oldimg);
            }
            $new_avatar = $uploadInfo[0]['savepath'].$uploadInfo[0]['savename'];
            $map['img'] = $new_avatar;
            $result = $recommended -> save($map);
            //$Info = json_encode($uploadInfo[0]);
            if(!$result) {
                $this -> ajaxReturn(0,$old_avatar,0);
            }else{
                $this -> ajaxReturn(1,$new_avatar,1);
            }
        }
    }    
}
