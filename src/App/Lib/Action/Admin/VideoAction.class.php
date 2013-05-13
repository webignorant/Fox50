<?php
//视频模块
class VideoAction extends CommonAction {
    function _filter(&$map) {
        if(!empty($_POST['title'])) {
            $map['title'] = array('like',"%".$_POST['title']."%");
        }
        $map['status'] = array('neq','-1');
    }
    
    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
     * @param TablePk $pk 主键名称
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _list($model, $map, $sortBy = '', $asc = false, $pk='id') {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        //取得满足条件的记录数
        $count = $model->where($map)->count($pk);
        if ($count > 0) {
            import("@.ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $p = new Page($count, $listRows);
            //分页查询数据

            $voList = $model->where($map)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
            //修改结果集
            foreach($voList as $key =>$value) {
                $Video = D('VideoRecommended');
                $data['vid'] = $value['vid'];
                $recommended = $Video ->where($data)->select();
                if($recommended == false){
                    $voList[$key]['recommended'] = 0;
                }else{
                    $voList[$key]['recommended'] = 1;
                }
            }
            //echo $model->getlastsql();
            //分页跳转的时候保证查询条件
            foreach ($map as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= "$key=" . urlencode($val) . "&";
                }
            }
            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        cookie('_currentUrl_', __SELF__);
        return;
    }
    public function showVideoToPage($category='', $type='', $region='',$year='', $sortBy = '', $asc = false) {
        $Video = D('Video');
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $Video->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        
        $errorinfo='没有找到视频';
        
        //数据过滤开始
        $start = $_GET['p'];
        if($start <= 0 ) {
            $start =0;
        }
        if($category != '') {
            $map['catid']=array('eq',$category);
            $errorinfo = "没有找到该栏目的视频！";
        }
        if($type != '') {
            $map['typeid']=array('eq',$type);
            $errorinfo = "没有找到该类型的视频！";
        }
        if($region != '') {
            $map['regionid']=array('eq',$region);
            $errorinfo = "没有找到该地区的视频！";
        }
        if($year != ''){
        	
        	if($year == '90h'){
        		$map['year'] = array('between','1990,2000');
        	}elseif($year == '80h'){
        		$map['year'] = array('between','1980,1990');
        	}else{
        		$map['year'] = array('eq',$year);
        		$errorinfo = '没有找到该年份的视频！';
        	}

        }
        //数据过滤结束
        
        //数据分页
        $count = $Video->where($map)->count();
        if ($count > 0) {
            import("ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $Page = new Page($count,$listRows);
            $list = $Video->where($map)->order('dateline desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            //$sql = $Video -> getLastSql();
            $show = $Page->show();
        }
        return array($list,$show,$errorinfo);
    }

    //上传显示
  public function uploadindex(){
  	$this->assign('region',$this->region());
  	$this->assign('vtype',$this->type());
  	$this->assign('year',$this->year());
  	$this->assign('catid',$this->catid());
  	$this->display('add');
  }

    //视频上传
  public function upload(){
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
    $Upload = M('Video');
    $type = explode('|',$_POST['type']);
    $catid = explode('|',$_POST['catid']);
    $data=array();
    $data['uid']=$_SESSION[C('USER_AUTH_KEY')];//用户的ID号
    $data['typeid']=$type[0];//视频类型ID
    $data['username']=$_SESSION['loginUserName'];//上传的用户
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
    $data['title']=$_POST['title'];//视频标题
    $data['actor']=$_POST['zhuyan'];//主演
    $data['director']=$_POST['daoyan'];//导演
    $data['year']=$_POST['nianfen'];//发行年份
    $data['about']=$_POST['content'];//简介
    $video_id=$Upload->add($data);
    //视频统计表
    if($video_id){
    	$Videocount = M('VideoCount');
    	$count['id']=$video_id;
    	$count['catid']=$data['catid'];
    	$Videocount->add($count);
    	$this->success('上传成功!',U('Admin/Video/index'));
    }else{
    	$this->success('上传失败!',U('Admin/Video/index'));
    }
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
  * 上传方法
  * 返回上传文件的信息
  */
  private function _upload(){
  	  import('@.ORG.Util.UploadFile');
  	  $Up= new UploadFile;
  	  //设置上传文件大小
      $Up->maxSize  = 32922000000;
      //设置上传文件类型
      $Up->allowExts = explode(',','flv,avi,mp4');
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
   	return $catid->where('shownav=1')->field('id,catname')->select();
   }
   
   
   
   /**
   * 视频类型
   *
   */
   public function type($id=6){
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
   	    '1988');
   }
   
    //后台视频编辑页面
    public function edit() {
        $video = D('Video');
        $result = $video->getByVid($_GET['id']);
        $this->assign('vo',$result);
        $this->assign('region',$this->region());
        $this->assign('vtype',$this->type($result['catid']));
        $this->assign('year',$this->year());
        $this->assign('catid',$this->catid());
        $this->display();
    }
    
    function update() {
        $model = D('Video');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $catid = explode('|',$_POST['catid']);
        $type = explode('|',$_POST['typeid']);
        $data['catid']=$catid[0];//栏目
        $data['typeid']=$type[0];//视频类型ID
        $data['vid'] = $_POST['vid'];
        if(isset($_POST['status'])) {
            $data['status'] = $_POST['status'];
        }
        // 更新数据
        $list = $model->save();
        if (false !== $list) {
            //成功提示
            //$this->success('编辑成功!');
            $this -> ajaxReturn(1,'编辑成功',1);
        } else {
            //错误提示
            //$this->error('编辑失败!');
            $this -> ajaxReturn(0,'编辑失败',0);
        }
    }
    
    //设置推荐视频
    public function setRecommended() {
        $videoId = $_REQUEST['id'];
        $model = D('VideoRecommended');
        $map['vid'] = $videoId;
        $map['img'] = $Video->where('vid='.$videoId[$key])->getField('img');
        $result = $VideoRecommended -> add($map);
        if($result == true) {
            $this->success('推荐视频添加成功');
        }else{
            $this->error('推荐视频添加失败');
        }
    }
    
     //删除指定记录 - 设置状态,如果未入库，则调用直接删除代码
    public function delete() {
        $name = $this->getActionName();
        $model = M($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $id_array = explode(',', $id);
                $condition = array($pk => array('in', $id_array));
                //判断所选的视频是否为未入库视频
                $allNotPass = false;    //是否全为未通过视频
                $statusSituation = 0;   //0不存在未入库视频 1存在未入库视频 2入库与未入库都存在
                foreach($id_array as $key => $arr) {
                    $map['vid'] = $arr;
                    $status = $model -> where($map) -> getField('status');
                    if($status >1) {
                        $statusSituation = 1;
                    }else{
                        //已入库文件，判断是否存在入库文件
                        if($statusSituation == 1) {
                            $statusSituation = 2;
                        }
                    }
                }
                switch($statusSituation) {
                    case 1:
                        $this -> foreverdelete($id);
                        break;
                    case 2:
                        $this->error('已入库视频和未入库视频不能同时删除');
                        break;
                }
                //删除推荐表记录
                $recommended = M('VideoRecommended');
                foreach($id_array as $key => $arr) {
                    $map['vid'] = $arr;
                    $re_exists = $recommended -> where($map) -> count();
                    if($re_exists){
                        $re_del = $recommended -> where($condition) -> delete();
                        if($re_del == false){
                            $this -> error('请移除视频的推荐状态后，再删除！');
                        }
                    }
                }
                $map['status'] = array('lt',2);
                $list = $model->where($map)->where($condition)->setField('status', - 1);
                if (!$list) {
                    $this->error('删除失败！');
                }else {
                    $this->success('删除成功！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }
    
    //永远删除记录及文件信息
    public function foreverdelete($vid) {
        $Video = M('Video');
        $relVideo = $Video -> switchModel("Relation");  //动态切换为Relation关联模型
        //关联定义
        $link = array(
            'VideoCount' => array(
                'mapping_type' => HAS_ONE,
                'foreign_key' => 'id',
            ),
            'VideoComment' => array(
                'mapping_type' => HAS_MANY,
                'foreign_key' => 'vid',
            ),
            'VideoFavorite' => array(
                'mapping_type' => HAS_MANY,
                'foreign_key' => 'objid',
            ),
            'VideoRecently' => array(
                'mapping_type' => HAS_MANY,
                'foreign_key' => 'vid',
            ),
            'VideoRecommended' => array(
                'mapping_type' => HAS_MANY,
                'foreign_key' => 'vid',
            )
        );
        $relVideo -> setProperty("_link",$link);   //切换模型后动态赋值
        if(isset($_REQUEST ['vid'])) {
            $id = $_REQUEST ['vid'];
        }else if(isset($vid)) {
            $id = $vid;
        }
        if (!isset($id)) {
            $this->error('非法操作');
        }else{
            $condition['vid'] = array('in',$id);
            $templist = $relVideo->where($condition)->field('filepath,filename,vid,img')->select();
            $tempvar = '';
            $tempcondition = array();
             foreach($templist as $arr){
                if(!unlink($arr['filepath'].$arr['filename'])){
                    $tempvar .= $arr['vid'].',';
                }
                @unlink($arr['img']);
             }
             if($tempvar != ''){
                $tempvar = explode(',',rtrim($tempvar,','));
                $tempcondition = explode(',',$id);
                foreach($tempcondition as $key=>$value){
                    if(in_array($value,$tempvar)){
                        unset($tempcondition[$key]);
                    }
                }
                $condition['vid']=array('in',implode(',',$tempcondition));
                //$ConditionOnId['id']=array('in',implode(',',$tempcondition));
                if($condition['vid'] == ''){
                  $this->error('删除文件失败！');
                }
             }
            $condition_array = explode(',',$condition['vid'][1]);
            //删除视频表关联记录
            foreach($condition_array as $key => $arr) {
                $result = $relVideo->relation(true)->delete($arr);
            }
            if (!$result) {
                $this->error('永久删除视频失败！');
            } else {
                $this->success('永久删除视频成功！');
            }
        }
    }
    /*
    public function foreverdelete() {
    	$name = $this->getActionName();
    	$model = M($name);
    	
    	if (!empty($model)) {
    		$pk = 'vid';
    		$id = $_REQUEST [$pk];
    		if (isset($id)) {
    			$condition['vid'] = array('in',$id);
    			$templist = $model->where($condition)->field('filepath,filename,vid,img')->select();
    			$tempvar = '';
    			 foreach($templist as $arr){
    			 	if(!unlink($arr['filepath'].$arr['filename'])){
    			 		$tempvar .= $arr['vid'].',';
    			 	}
    			 	@unlink($arr['img']);
    			 }
    			 if($tempvar != ''){
    			 	$tempvar = explode(',',rtrim($tempvar,','));
    			 	$tempcondition = explode(',',$id);
    			 	foreach($tempcondition as $key=>$value){
    			 		if(in_array($value,$tempvar)){
    			 			unset($tempcondition[$key]);
    			 		}
    			 	}
    			 	$condition['vid']=array('in',implode(',',$tempcondition));
    			 	$ConditionOnId['id']=array('in',implode(',',$tempcondition));
    			 	if($condition['vid'] == ''){
    			 	  $this->error('删除文件失败！');
    			 	}
    			 }
    			 //删除视频表记录
    			$list = $model->where($condition)->delete();
	                //删除统计表记录
	                $count = D('VideoCount');
	                $count -> where($ConditionOnId)->delete();
	                //删除评论表纪录
	                $comment = M('VideoComment');
	                $comment -> where($condition) -> delete();
    			if ($list) {
    				$this->success('删除成功!!');
    			} else {
    				$this->error('删除失败！');
    			}
    		} else {
    			$this->error('非法操作');
    		}
    	}
    }
    */
    
    /**************************视频审核处理***************************************/
    //截图入库
    public function setVideodata(){
        $errorCheck = true;     //判断执行是否出错
        $id = $_REQUEST['vid'];
        if(isset($id)) {
            $video = D('Video');
            $Videocount = D('VideoCount');
            //$id_array = explode(',',$id);
            $map['status'] = array('gt',1);
            $condition['vid'] = array('in',$id);
            //错误提示信息
            $errorInfo = '';
    		//截图
    		$photodir='./PhotoUploads/'.date('Ymd');
    		$videodir= './VideoUploads/'.date('Ymd').'/';
    		$info = $video->where($map)->where($condition)->select();
    		foreach($info as $key => $arr) {
                $errorInfo = '批量处理第'.($key+1).'个\n视频编号为'.$arr['vid'].'\n';
                $uniqid=uniqid(rand());
                //$videoinfo=$this->info($info[0]['filepath'].$info[0]['filename']);
                $data=array();
                //$data['vid'] = $info[0]['vid'];
                //$data['definition']=$videoinfo['resolution'];//清晰度
                //$data['playtime']=$videoinfo['file_time'];//播放时长
                $data['filepath']=$videodir;//目录
                $data['filename']=$uniqid.'.flv';//视频名
                $data['img']=$photodir.'/'.$uniqid.'.jpg';
                $data['status'] = '1';//视频状态 0=已通过 1=待审核 2=未转码（不是flv）,3(是FLV格式)
                $video_id = $video->where('vid='.$arr['vid'])->save($data);
                //$true = $this->insertvideo($info[0]['vid'],$videoinfo['resolution'],$videoinfo['file_time'],$videodir,$uniqid.'.flv',$photodir.'/'.$uniqid.'.jpg','1');
                if($video_id){
                    //写入视频统计表
    			$Videocount = M('VideoCount');
                    $count['id']=$arr['vid'];
                    $count['catid']=$arr['catid'];
                    $tempcount = $Videocount->add($count);
    			//积分
    			$User = M('User');
    			$list = $User -> field("last_login_time") -> select();
    			if(date('z',$list[0]['last_login_time']) != date('z')){
    				$User->where('id='.$info[0]['uid'])->setInc('integral',1);
    			}	
                }else{
                    $errorInfo .= '错误：视频'.$arr['title'].'入库失败!';break;
                    //$this->error($errorInfoHeader.'错误：视频'.$arr['title'].'入库失败!');
                }
                if(!file_exists($arr['filepath'].$arr['filename'])){
                    $errorInfo .= '错误：在临时文件夹未找到与['.$arr['title'].']对应的相关视频';break;
                    //$this->error($errorInfoHeader.'错误：在临时文件夹未找到与['.$arr['title'].']对应的相关视频');
                    exit;
                }
                if($this->dir($photodir)){
                    $this->screenshot($arr['filepath'].$arr['filename'],$photodir.'/'.$uniqid.'.jpg');
                    if($this->dir($videodir)){
                        if(!rename($arr['filepath'].$arr['filename'],$videodir.$uniqid.'.flv')){
                            $Videocount->where('id='.$tempcount)->delete(); //删除统计表记录
                            $tempdata['vid'] = $arr['vid'];
                            $tempdata['filepath'] = $arr['filepath'];
                            $tempdata['filename'] = $arr['filename'];
                            $video->where($where)->save($tempdata);
                            $errorInfo .= '错误：入库的视频['.$arr['title'].']移动失败';break;
                            //$this->error($errorInfoHeader.'错误：入库的视频['.$arr['title'].']移动失败');
                        }else{
                            //$this->success('视频入库成功!');
                        }
                    }else{
                        $Videocount->where('id='.$tempcount)->delete();
                        $tempdata['vid'] = $arr['vid'];
                        $tempdata['filepath'] = $arr['filepath'];
                        $tempdata['filename'] = $arr['filename'];
                        $video->where($where)->save($tempdata);
                        $errorInfo .= '错误：创建视频文件夹失败!';break;
                        //$this->error('错误：创建视频文件夹失败!');
                    }
                }else{
                        $Videocount->where('id='.$tempcount)->delete();
                        $tempdata['vid'] = $arr['vid'];
                        $tempdata['filepath'] = $arr['filepath'];
                        $tempdata['filename'] = $arr['filename'];
                        $video->where($where)->save($tempdata);
                        $errorInfo .= '错误：创建图片文件夹失败!';break;
                        //$this->error('错误：创建图片文件夹失败!');
                }
    		}
    		//检查执行流程是否报错，并且输出错误
            if(!$errorCheck) {
                $this -> error($errorInfo);
            }else{
                $this -> success('视频入库成功!');
            }
        }
    }
    
    //关闭与开启视频状态
    public function setVideoStatus(){
    	$id = $_REQUEST['vid'];
    	if(isset($id)){
            $video = D('Video');
            //$id_array = explode(',',$id);
            $condition['status'] = array('lt',2);
            $condition['vid'] = array('in',$id);
            if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'tg'){
                $result = $video->where($condition)->setField('status','1');
                if($result){
                    $this->success('关闭视频成功!');
                }else{
                    $this->error('关闭视频失败!');
                }
            }else{
                if($video->where($condition)->setField('status','0')){
                    $this->success('开启视频成功!');
                }else{
                    $this->error('开启视频失败!');
                }
    	}
    	}
    }
    
    //转码
    public function transcoding(){
    	
    	$where['vid'] = $_REQUEST['vid'];
    	$video = M('Video');
    	$info = $video->where($where)->limit(1)->select();
    	if(!file_exists($info[0]['filepath'].$info[0]['filename'])){
    		$this->error('临时文件夹未找到该视频!');
    		exit;
    	}
    	$videoinfo=$this->info($info[0]['filepath'].$info[0]['filename']);
    	$uniqid=uniqid(rand());
    	//转换格式
    	@set_time_limit(0);
    	$newvideo=$uniqid.'.flv';
    	$this->transition($info[0]['filepath'].$info[0]['filename'],$videoinfo['resolution'],$info[0]['filepath'].$newvideo);
    	$data=array();
    	$data['filename']=$newvideo;
    	$data['status']=3;//视频状态 0=已通过 1=待审核 2=未转码（不是flv）,3(是FLV格式)
    	$video_id=$video->where($where)->save($data);
    	//视频统计表
    	if($video_id){
    		//转码与保存成功
    		@unlink($info[0]['filepath'].$info[0]['filename']);
    	    $this->success('视频转码成功!');
    	}else{
    	    $this->error('视频转码失败!');
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
    
  /*  
    //写数据库
    private function insertvideo($vid,$definition,$playtime,$filepath,$filename,$img,$status){
    	
    	    $videotemplian = M('Video');
    	    $where['vid'] = $vid;
    		$data=array();
    		$data['vid'] = $vid;
    	    $data['definition']=$definition;//清晰度
    	    $data['playtime']=$playtime;//播放时长
    		$data['filepath']=$filepath;//目录
    		$data['filename']=$filename;//视频名
    		$data['img']=$img;
    		$data['status'] = $status;//视频状态 0=已通过 1=待审核 2=未转码（不是flv）,3(是FLV格式)
    		dump($data);
    		return $videotemplian->where($where)->save($data);
    	
    }
  
    
    private function getmicrotime(){
    	list($usec, $sec) = explode(" ",microtime());
    	return ((float)$usec + (float)$sec);
    }
  */
    
}
?>