<?php
//视频管理模块
class VideoAction extends CommonAction {

    function _filter(&$map){
        if(!empty($_POST['title'])) {
        $map['title'] = array('like',"%".$_POST['title']."%");
        }
    }
    
    //视频管理首页
    public function video_index() {
        $login = A('Home/User');
        $login -> checkUserLogin();
        
        //列表过滤器，生成查询Map对象
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('Video');
        if (!empty($model)) {
            //判断数据表主键是否为id ByFeng
            if($model->getPk()=='id') {
                $this->_list($model, $map);
            }else{
                $this->_list($model, $map, '', false,$model->getPk());
            }    
        }
        $this->assign('webpagetitle',"视频管理 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this -> display('Video:index');
        //$this -> display('User:video_index');
        return;
    }
    
    //视频编辑页面
    function edit() {
        $model = D('Video');
        $id = $_REQUEST ['id'];
        $vo = $model->getByVid($id);
        $this->assign('info',$vo);
        $video = A('Home/Upload');
        $this->assign('region',$video->region());
        $this->assign('vtype',$video->type($vo['catid']));
        $this->assign('year',$video->year());
        $this->assign('catid',$video->catid());
        //$this->display('User:video_edit');
        layout(true);
        $this->display('Video:user_video_edit');
    }
    
    //视频上传页面
    function video_upload() {
        if(!isset($_SESSION['username'])) {
            $this->error('非法访问',U('Home/Index/index'));
        }
        $upload = A('Home/Upload');
        $this->assign('webpagetitle',"上传视频 - 精彩无限 - Fox50视频网 - 最好的视频网站");
        $this->assign('region',$upload->region());
        $this->assign('vtype',$upload->type());
        $this->assign('year',$upload->year());
        $this->assign('catid',$upload->catid());
        //$this->display('User:video_upload');
        layout(true);
        $this->display('Video:user_video_upload');
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
        $data['uid'] = $_SESSION['id'];
        //取得满足条件的记录数
        $count = $model->where($map)->where($data)->count($pk);
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

            $voList = $model->where($map)->where($data)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
            $audit = '';   //已审核视频
            //修改结果集
            foreach($voList as $key => $arr) {
                if(is_numeric($arr['status'])) {
                    switch($arr['status']) {
                        case -1:$voList[$key]['situation'] = '已禁用';break;
                        case 0:$voList[$key]['situation'] = '已通过';$audit.='|'.$voList[$key]['vid'];break;
                        case 1:$voList[$key]['situation'] = '未审核';break;
                        case 2:$voList[$key]['situation'] = '未转码';break;
                        case 3:$voList[$key]['situation'] = '已转码';break;
                    }
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
            $this->assign('AuditList',$audit);
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
    
    /**
      +----------------------------------------------------------
     * 默认删除操作
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
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
    public function delete() {
        $pk = 'vid';
        $id = $_REQUEST [$pk];
        if (isset($id)) {
            //执行条件
            $id_array = explode(',', $id);
            //删除文件
            foreach($id_array as $key => $arr) {
                //$result = $this -> delVideoImageFile($id);
                $result = true;
                //如果错误，则仅处理已删除文件的记录
                if(!$result){
                    if($key != 0){
                        $id_array = array_splice($id_array,0,$key);
                    }else{
                        $id_array = array();
                    }
                }
            }
            if($id_array != null){
                //生成查询条件
                $condition = array($pk => array('in', $id_array));
                $condition_id = array(id => array('in',$id_array));
                //事务处理 - 为InnoDb引擎预留
                $transaction = new Model();
                $transaction -> startTrans();    //开启事务
                //删除连播表记录 - 先判断
                $relevanceid_map['relevanceid'] = array('neq','0');
                $relevanceid_array = $transaction->table(C('DB_PREFIX').'video')->where($condition) -> where($relevanceid_map) -> field('vid,relevanceid') -> select();
                if($relevanceid_array != null){
                    $Flow = D('VideoFlow');
                    foreach($relevanceid_array as $key => $arr){
                        $relevanceid_res = $Flow -> delVideoFlowOnVidList($arr['id'], $arr['relevanceid']);
                    }
                    if($relevanceid_res == false){
                        $relevanceid_res = true;
                        break;
                    }
                }
                //删除视频表
                $video_res = $transaction ->table(C('DB_PREFIX').'video')->where($condition)->delete();
                //删除统计表记录
                $count_res = $transaction->table(C('DB_PREFIX').'video_count')->where($condition_id)->delete();
                //删除评论表纪录 - 先判断
                $comment_array = $transaction->table(C('DB_PREFIX').'video_comment')->where($condition) -> field('vid') -> select();
                foreach($comment_array as $key => $arr){
                    $comment_condition[$key] = $arr['vid'];
                }
                $comment_condition = array($pk => array('in',$comment_condition));
                if($comment_condition != null){
                    $comment_res = $transaction->table(C('DB_PREFIX').'video_comment')->where($comment_condition) -> delete();
                    if($comment_res == false){
                        $comment_res = true;
                    }
                }
                //删除推荐表记录 - 先判断
                $recommended_array = $transaction->table(C('DB_PREFIX').'video_recommended')->where($condition) -> field('vid') -> select();
                foreach($recommended_array as $key => $arr){
                    $recommended_condition[$key] = $arr['vid'];
                }
                $recommended_condition = array($pk => array('in',$recommended_condition));
                if($recommended_condition != null){
                    $recommended_res = $transaction->table(C('DB_PREFIX').'video_recommended') -> where($recommended_condition) -> delete();
                    if($recommended_res == false){
                        $recommended_res = true;
                    }
                }
                if($video_res && $count_res) {
                    $transaction->commit(); //提交事务
                    $this->success('删除视频文件和记录成功！',U('Home/Video/video_index'));
                }else{
                    $transaction->rollback();   //回滚事务
                    $this->error('删除视频文件和记录失败！',U('Home/Video/video_index'));
                }
            }else{
                $this->error('删除视频图片文件失败，请联系管理员询问文件权限设置',U('Home/Video/video_index'));
            }
        } else {
            $this->error('非法操作',U('Home/Video/video_index'));
        }
    }
    */
    
    //删除视频图片文件
    public function delVideoImageFile($id) {
        $model = D('Video');
        $info = $model -> where('vid='.$id) -> field('filepath,filename,img') -> select();
        $videofile = $info[0]['filepath'].$info[0]['filename'];  //视频文件路径
        $imagefile = $info[0]['img'];   //图片文件路径
        if($imagefile != "") {
            if (file_exists($videofile) && file_exists($imagefile)) {
                $delVideo= @unlink ($videofile);
                $delImage = @unlink($imagefile);
                if($delVideo || $delImage){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            if (file_exists($videofile)) {
                $delVideo= @unlink ($videofile);
                if($delVideo){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

    }
    
   /**
   * 视频类型
   *
   */
    private function type($id=6){
        $type= M('VideoType');
        return $type->where('upid='.$id)->field('id,typename')->select();
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

    //获取视频指定属性信息
    public function getVideoInfo($vid, $field) {
        $model = M('Video');
        $map['vid'] = array('eq',$vid);
        $result = $model->where($map)->field($field)->select();
        return $result;
    }
    
    //获取视频地区名
    public function getVideoRegion($rid) {
        $model = M('VideoRegion');
        $map['id'] = array('eq',$rid);
        $result = $model->where($map)->field('regionname')->select();
        return $result;
    }
    
    //查询视频总数量
    public function getVideoMaxNum() {
        $model = D('Video');
        return $model->count("vid");
    }
    
    //查询最近更新视频
    public function showNewVideo() {
        $model = D('Video');
        return $model->order('dateline desc')->select();
    }
    
    //查询今日更新视频数量
    public function showNewVideoNumInToday() {
        $model = D('Video');
        $today = date('Ymd');
        //$map['dateline'] = $today;
        $result = $model->field("FROM_UNIXTIME(dateline,'%Y%m%d') as dateline")->select();
        foreach($result as $key => $value) {
            if($today == $value['dateline']){
                global $num ;
                $num  = $num +1;
            }
        }
        if($num === null) {
            $num = 0;
        }
        return $num;
    }
    
    //查询视频 - 关联模型
    public function showAllData($id) {
        if(!isset($id)){
            $this -> error('非法访问');
        }
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
        );
        $relVideo -> setProperty("_link",$link);   //切换模型后动态赋值
        $map['vid'] = $id;
        $result = $relVideo -> relation(true)->where($map)->select();
    }
    
}

?>