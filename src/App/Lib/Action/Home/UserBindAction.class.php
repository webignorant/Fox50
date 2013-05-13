<?php
//加载QQ互联API
require_once("./Public/API/Connect2.0/API/qqConnectAPI.php"); 

//绑定用户模块
class UserBindAction extends CommonAction {
    //前置操作方法
    public function _before_index(){

    }
    
    //绑定用户检查
    public function bind_user_check($bing_account) {
        $User = D('User');
        $map['bind_account'] = $bing_account;
        $count = $User -> where($map) -> count();
        if($count == 0) {
            return false;
        }else{
            return true;
        }
    }
    //通过Authorization Code获取Access Token get_access_token
    public function qq_callback() {
        $qc = new QC();
        echo $qc->qq_callback();
        echo '<hr />';
        echo $qc->get_openid();
        exit;
    /*
        if(!isset($_GET['code'])) {
            $this -> error('非法访问');
        }else{
            $parameter = 'grant_type=authorization_code&client_id=100423741&client_secret=7891ccdb5d5eb6a0cf5f7efa0f8f372d&code='.$code.'&redirect_uri=www.fox50.cn/index.php/UserBind/qq_user_login_check';
            $url = 'https://graph.qq.com/oauth2.0/token'.'?'.$parameter;
            redirect($url);
        }
    */
    }
    //QQ用户登录
    public function qq_user_login() {
        $qc = new QC();
        $qc->qq_login();
    }
    //QQ用户登录检查
    public function qq_user_login_check() {
        $code = $_GET['code'];
        if(!isset($code)){
            $this -> error('非法访问');
        }
        if(!isset($_GET['access_token'])) {
            //获取Access Token
            $this -> qq_callback();
        }
        $access_token = $_GET['access_token'];
        //生成认证条件
        $map            =   array();
        // 支持使用绑定帐号登录
        $map['bind_account'] = $access_token;
        $map["status"]	=	array('gt',0);
        import ( '@.ORG.Util.RBAC' );
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(false === $authInfo) {
            //没有该用户则注册
            $this -> qq_user_reg();
        }else {
            //存在用户则登录
            $_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
            $_SESSION['account']	=	$authInfo['account'];
            $_SESSION['nickname']	=	$authInfo['nickname'];
            $_SESSION['bind_account']	=	$access_token;
            $_SESSION['email']	=	$authInfo['email'];
            $_SESSION['loginUserName']		=	$authInfo['nickname'];
            $_SESSION['lastLoginTime']		=	$authInfo['last_login_time'];
            $_SESSION['login_count']	=	$authInfo['login_count'];
            //保存登录信息
            $User	=	M('User');
            $ip		=	get_client_ip();
            $time	=	time();
            $data = array();
            $data['id']	=	$authInfo['id'];
            $data['last_login_time']	=	$time;
            $data['login_count']	=	array('exp','login_count+1');
            $data['last_login_ip']	=	$ip;
            $User->save($data);

            // 缓存访问权限
            RBAC::saveAccessList();
            $this->success('登录成功！',__APP__.'/Index/index');
        }
        /*
        //检查是否存在该用户
        if(!$this -> bind_user_check($access_token)) {
            //没有该用户则注册
            $this -> qq_user_reg();
        }else{
        
        }
        */
    }
    //QQ用户注册
    public function qq_user_reg() {
        $info = $this -> qq_get_user_info();
        $this -> assign('info',$info);
        layout(true);
        $this -> display('Home:UserBind:userbind_qq_reg');
    }
    //QQ用户注册检查
    public function qq_user_reg_check() {
        $User = D('User');
        $formdata = $User->create();
        if(!formdata){
            $this -> error('表单数据出错');
        }
        $result = $User -> add();
        if(!$result){
            $this -> error('QQ用户注册错误');
        }else{
            $this -> success('QQ用户注册成功',U('Home/Index/'));
        }
    }
    //QQ用户绑定
    public function qq_user_bind_check() {
        $User = D('User');
        $formdata = $User->create();
        if(!formdata){
            $this -> error('表单数据出错');
        }
        $map['account'] = $_POST['account'];
        $map['userpwd'] = $_POST['userpwd'];
        $userid = $User -> where($map) -> getField('id');
        if($userid == null){
            $this -> qq_user_login_check();
        }else{
            $data['id'] = $userid;
            $data['bind_account'] = $this -> qq_callback();
            $result = $User -> sava($data);
            if(!$result){
                $this -> error('QQ用户绑定错误');
            }else{
                $this -> success('QQ用户绑定成功');
            }
        }
    }
    
/*
 *调用接口代码
 *
 **/
    /*user*/
    //获取QQ用户信息
    public function qq_get_user_info() {
        echo "<meta charset='utf-8' />";
        dump('坐等服务器开启443端口...');
        dump('用户请留步，表示目前无法正常使用QQ登录功能...');
        exit;
        $qc = new QC();
        $arr = $qc->get_user_info();
        return $arr;
        /*
echo "Gender:".$arr["gender"];
echo "NickName:".$arr["nickname"];
echo "<img src=\"".$arr['figureurl']."\">";
echo "<img src=\"".$arr['figureurl_1']."\">";
echo "<img src=\"".$arr['figureurl_2']."\">";
echo "vip:".$arr["vip"];
echo "level:".$arr["level"];
echo "is_yellow_year_vip:".$arr["is_yellow_year_vip"];
        */
    }
    /*share*/
    //添加分享
    public function qq_add_share() {
        $qc = new QC();
        $ret = $qc->add_share($_GET);
        if($ret['ret'] != 0) {
            $this -> error('分享失败');
        }else{
            $this -> success('分享成功');
        }
        /*
if($ret['ret'] == 0){
    echo "分享成功";
}else{
    echo "分享失败";
}
        */
    }
    /*photo*/
    //获取相册列表
    public function qq_list_album() {
        $qc = new QC();
        $arr = $qc->list_album();
        return $arr;
        /*
<meta charset="utf-8" />
<?php
foreach($arr['album'] as $v){
?>
    <div style="float:left;width:300px;height:400px;">
        <div>
            <img src="<?=$v['coverurl']?>" style="width:150px;height:150px;" />
        </div>
        <ul>
            <li>名称  <?=$v['name']?></li>
            <li>albumid <?=$v['albumid']?></li>
            <li>classid <?=$v['classid']?></li>
            <li>简介  <?=$v['desc']?></li>
            <li>创作时间  <?=date("Y-m-d",$v['createtime'])?></li>
            <li>图片数量 <?=$v['picnum']?></li>
        </ul>
    </div>
        

<?php
}
?>
        */
    }
    //创建相册
    public function qq_add_album() {
        $qc = new QC();
        $arr = $qc->add_album($_POST);
        return $arr;
        /*
<meta charset="utf-8" />
<?php
if($arr['ret'] == 0){
    echo "创建成功,请到空间相册查看您的相册";
}else{
    echo "创建失败";
}
?>
        */
    }
    //上传相片
    public function qq_upload_pic() {
        $qc = new QC();
        $arr = $qc->list_album();
        return $arr;
        /*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TEST UPLOAD PIC</title>
</head>

<body>
<form action="upload_pic_p.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="photodesc" value="test" /><br />
经度<input type="text" name="x" value="1" /><br />
纬度<input type="text" name="y" value="1" /><br />
相册ID：<select name='albumid'>
<?php
foreach($arr['album'] as $v){
?>
<option  value="<?=$v['albumid']?>"><?=$v['name']?></option>
<?php } ?>
</select>
<input type="hidden" name="format" value="json"/><br />
<input type="hidden" name="title" value="test" /><br />
<input type="file" name="picture" /><br />
<input type="submit" value="提交"/><br />
</form>
</body>
</html>
        */
    }
    /*blog*/
    //发表日志
    public function qq_add_blog() {
        $_POST['title'] = urlencode($_POST['title']);
        $_POST['title'] = urlencode($_POST['content']);
        $ret = $qc->add_one_blog($_POST);
        if($ret['ret'] != 0) {
            $this -> error('发表日志失败');
        }else{
            $this -> success('发表日志成功');
        }
    }
    /*topic*/
    //发表说说
    public function qq_add_topic() {
        $qc = new QC();
        $ret = $qc->add_topic($_POST);
        if($ret['ret'] != 0) {
            $this -> error('发表说说失败');
        }else{
            $this -> success('发表说说成功');
        }
    }
    /*weibo*/
    //发表微博
    public function qq_add_weibo() {
        $qc = new QC();
        $_POST['img'] = urlencode($_POST['img']);
        $ret = $qc->add_t($_POST);
        if($ret['ret'] != 0) {
            $this -> error('发表微博失败');
        }else{
            $this -> success('发表微博成功');
        }
    }
    /*check_fan*/
    //检查是否是认证空间的粉丝
    public function qq_check_page_fans() {
        if($_GET) {
            $qc = new QC();
            $ret = $qc->check_page_fans($_GET);
            if($ret['isfans']) {
                echo "是认证空间{$_GET['page_id']}的粉丝";
            }else{
                echo "不是认证空间{$_GET['page_id']}的粉丝";
            }
        }else{
            require_once("check_page_fans.html");
        }
    }
    /*add_pic_t*/
    //发图片消息到微博
    public function qq_add_pic_t() {
        if($_POST){
            require_once("../../API/qqConnectAPI.php");
            $qc = new QC();
            $ret = $qc->add_pic_t($_POST);

            echo "<meta charset='utf-8' />";
            if($ret['ret'] == 0){
                echo "发表成功,请查看微博";
            }else{
                echo "发表失败，请开启调试查看原因";
            }
        }else{
            //load view
            require_once("add_pic_t.html");
        }
    }
    /*get_info*/
    //获取微博用户信息
    public function qq_get_info() {
        $qc = new QC();
        $ret = $qc->get_info();

        // show result
        if($ret['ret'] == 0){
            echo "<meta charset='utf-8' />";
            require_once("get_info.html");
        }else{
            echo "<meta charset='utf-8' />";
            echo "获取失败，请开启调试查看原因";
        }
    }
    /*get_fanslist*/
    //获取用户的听众列表
    public function qq_get_fanslist() {
        $qc = new QC();
        $setting = array(
            "reqnum" => 10,//请求获取的听众个数。取值范围为1-30。
            "startindex" => 0//开始
           );
        $ret = $qc->get_fanslist($setting);

        // show result
        if($ret['ret'] == 0){
            echo "<meta charset='utf-8' />";
            require_once("get_fanslist.html");
        }else{
            echo "<meta charset='utf-8' />";
            echo "获取失败，请开启调试查看原因";
        }
    }
    /*get_idollist*/
    //获取用户的收听列表
    public function qq_get_idollist() {
        $qc = new QC();
        $setting = array(
            "reqnum" => 10,//请求获取的听众个数。取值范围为1-30。
            "startindex" => 0//开始
           );
        $ret = $qc->get_idollist($setting);

        // show result
        if($ret['ret'] == 0){
            echo "<meta charset='utf-8' />";
            require_once("get_idollist.html");
        }else{
            echo "<meta charset='utf-8' />";
            echo "获取失败，请开启调试查看原因";
        }
    }
    /*add_idol*/
    //收听腾讯微博上的用户
    public function qq_add_idol() {
        if($_POST){
            require_once("../../API/qqConnectAPI.php");
            $qc = new QC();
            $ret = $qc->add_idol($_POST);

            echo "<meta charset='utf-8' />";
            if($ret['ret'] == 0){
                echo "收听成功,请查看微博";
            }else{
                echo "收听失败，请开启调试查看原因";
            }
        }else{
            //load view
            require_once("add_idol.html");
        }
    }
    /*get_tenpay_addr*/
    //获取财付通用户的收货地址
    public function qq_get_tenpay_addr() {
        $qc = new QC();
        $ret = $qc->get_tenpay_addr();
        // show result
        if($ret['ret'] == 0){
            echo "<meta charset='utf-8' />";
            require_once("get_tenpay_addr.html");
        }else{
            echo "<meta charset='utf-8' />";
            echo "获取失败，请开启调试查看原因";
        }
    }
}

?>