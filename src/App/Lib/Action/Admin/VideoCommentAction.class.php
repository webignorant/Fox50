<?php
class VideoCommentAction extends CommonAction {
   function _filter(&$map){
        if(!empty($_POST['id'])) {
            $map['id'] = array('like',"%".$_POST['id']."%");
        }
    }
    
    
    /**
    * ɾ��
    *
    */
    public function delete(){
      $VideoComment=M('VideoComment');
    	$de['cid']=array('in',$_GET['id']);
    	 if (false !== $VideoComment->where($de)->delete()) {
                $this->success('ɾ���ɹ�!');
            } else {
                $this->error('ɾ������!');
            }
    } 
}