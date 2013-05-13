<?php
//用户模块
class UserAction extends CommonAction {
    
    //验证码
    Public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
    
    //检查用户是否登录
    public function checkUserLogin() {
        if(!isset($_SESSION['id'])){
          $this->error('用户未登录！',U('Home/User/login'));
        }
    }
    
    //用户登录
    public function login() {
        //判断是否存在cookie
        $account = cookie('account');
        if(isset($account)) {
            $this -> cookieLoginCheck();
            return ;
        }
        $this->assign('webpagetitle',"用户登录 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this->display('login');
    }
    
    //登录检查
    public function logincheck() {
        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误!');
        }else{
            $User = M('user');
            $temp_var = $User->where("account='%s' and password='%s'",htmlspecialchars($_POST['username']),md5(htmlspecialchars($_POST['userpwd'])))->select();
            if($temp_var){
                $data['last_login_time']=time();
                $data['last_login_ip']=get_client_ip();
                $str="account='".$_POST['username']."'";
                if($User->where($str)->save($data)) {
                    $User->where($str)->setInc('login_count',1);
                  //  $id=$User->where($str)->getField('id');
                    $id = $temp_var[0]['id'];
                    $_SESSION['id'] = $id;
                    $_SESSION[C('USER_AUTH_KEY')] = $id;
                    $_SESSION['username'] = $_POST['username'];  
                    //如果需要则保存cookie
                    if($_POST['autoLogin'] == 'on') {
                        cookie('account', md5($_SESSION['username']),60*60*24);
                        //setcookie('fox50_account',$_SESSION['username'],time()+60*60*24);
                    }
                    //积分
                    if(date('z',$temp_var[0]['last_login_time']) != date('z')){
                    	$User->where($str)->setInc('integral',2);
                    }
                    $this->success('会员登录成功!',U('Home/Index/index'));
                }else{
                    $this->error('会员登录失败!',U('Home/User/login'));
                }
            }else{
                $this->error('账号或密码不正确!',U('Home/User/login'));
            }
        }
    }
    
    //cookie登录检查
    public function cookieLoginCheck() {
        $User = D('user');
        $map = array();
        //$map['account'] = cookie('account');
        //找出md5加密的用户名对比
        $list = $User -> field("id,md5(account) as account,last_login_time") -> select();
        foreach($list as $key => $arr) {
            if($arr['account'] == cookie('account')) {
                $map['id'] = $arr['id'];
                $result = true;
            }
        }
        if(!$result) {
            $this->error('会员登录失败!',U('Home/User/login'));
        }else{
            $data['last_login_time']=time();
            $data['last_login_ip']=get_client_ip();
            if($User->where($map)->save($data)) {
                $User->where($map)->setInc('login_count',1);
                $result = $User -> where($map) -> field("id,account") -> select();
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION[C('USER_AUTH_KEY')] = $result[0]['id'];
                $_SESSION['username'] = $result[0]['account'];
                $this->success('通过cookie验证登录成功!',U('Home/Index/index'));
            }
            //积分
            if(date('z',$list[0]['last_login_time']) != date('z')){
            	$User->where($map)->setInc('integral',2);
            }
        }
    }
    
    public function register() {
        $this->assign('webpagetitle',"用户注册 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this->display('register');
    }
    
    //注册检查
    public function registercheck(){
        $data = array();
        if(empty($_POST['username'])){
        	$this->error('用户名不能为空!',U('Home/User/register'));
        }
        if(empty($_POST['userpwd'])){
        	$this->error('密码不能为空!',U('Home/User/register'));
        }
        if($_POST['username'] == $_POST['userpwd']){
            $this->error('用户名和密码不能相同!',U('Home/User/register'));
        }
        if(empty($_POST['email'])){
        	$this->error('邮箱不能为空!',U('Home/User/register'));
        }
        if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',$_POST['email'])){
        	$this->error('邮箱格式不正确!',U('Home/User/register'));
        }
        $data['account']= htmlspecialchars($_POST['username']);
        $data['nickname']= htmlspecialchars($_POST['username']);
        $data['password']= md5(htmlspecialchars($_POST['userpwd']));
        $data['bind_account']= '不详';
        $data['last_login_time']= time();
        $data['last_login_ip']= get_client_ip();
        $data['login_count']= '1' ;
        $data['verify']= '不详';
        $data['email']= htmlspecialchars($_POST['email']);
        $data['remark']= '不详';
        $data['create_time']= time();
        $data['update_time']= time();
        $data['status']= 1;
        $data['type_id']= 0;
        $data['info']= htmlspecialchars($_POST['info']);
        $data['question']= htmlspecialchars($_POST['question']);
        $data['answer']= htmlspecialchars($_POST['answer']);
        $User = D("user");
        
        if($createuid=$User->add($data)){
            $_SESSION['id'] = $createuid;
        	$_SESSION['username'] = $data['account'];
            $this->success('注册会员成功,正在跳转..',U('Home/Index/index'));
        }else{
            $this->error('会员添加失败!',U('Home/User/register'));
        }
    }
    
    //检查注册用户
    public function readuser(){
        $User = M("user");
        $data['account']=$_POST['send_user'];
        if($User->where("account='".$_POST['send_user']."'")->select()){
            //echo $_POST['send_user'].'已注册!';
            $this -> error($_POST['send_user'].'已注册!');
        }elseif($_POST['send_user'] == ''){
            //echo '用户名不能为空!';
            $this -> error('用户名不能为空!');
        }else{
            //echo $_POST['send_user'].'可以注册!';
            $this -> success($_POST['send_user'].'可以注册!');
        }
    }
    
    //用户退出
    public function logout() {
        if(isset($_SESSION['id'])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION['id']);
            unset($_SESSION['username']);
            unset($_SESSION);
            session_destroy();
            cookie(null,'fox50_');
            $this->success('注销成功！',U('Home/Index/index/'));
        }else {
            $this->error('已经注销！');
        }
    }
    
    //修改密码
    public function repass() {
        if(!isset($_SESSION['username'])) {
            $this->error('非法访问',U('Home/Index/index'));
        }
        $this->assign('webpagetitle',"修改密码 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this->display();
    }
    
    // 修改密码检查
    public function repasscheck() {
        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误!');
        }else{
            $username = $_POST['username'];
            $oldpassword = md5($_POST['oldpassword']);
            $newpassword = md5($_POST['password']);
            $repassword = md5($_POST['repassword']);
            if($this->checkUserExist($username) == null) {
                $this->error('没有该用户');
            }
            if(($this->checkUserPassword($username,$oldpassword,$newpassword,$repassword)) != true) {
                $this->error('用户名或密码不对!');
            }else{
                $User = D("User");
                $map['username'] = $username;
                $data['password'] = $newpassword;
                $result = $User->where($map)->save($data);
                if(false !== $result) {
                    $this->success('密码修改成功！');
                }else{
                    $this->error('密码修改失败!');
                }
            }
        }
    }
    
    //检查用户是否存在
    protected function checkUserExist($username) {
        $User = D('User');
        $map['account'] = $username;
        $result = $User->where($map)->field('id')->select();
        return $result;
    }
    
    //检查用户密码
    protected function checkUserPassword($username, $oldpassword, $newpassword, $repassword) {
        if($newpassword != $repassword) {
            $this->error('两次密码不一样');
        }
        $User = D('User');
        $map['account'] = $username;
        $map['password'] = $oldpassword;
        $newpassword = $newpassword;
        $result = $User->where($map)->field('password')->select();
        if($result[0]['password'] == $oldpassword) {
            return true;
        }else{
            return false;
        }
    }
    
    //检查用户邮箱
    protected function checkUserEmail($username, $email) {
        $User = D('User');
        $map['account'] = $username;
        $map['email'] = $email;
        $result = $User->where($map)->field('id')->select();
        if($result[0]['id'] != null) {
            return true;
        }else{
            return false;
        }
    }
    
    //检查用户密保
    protected function checkUserProtect($userid,$info) {
        $User = D('User');
        $map['id'] = $userid;
        $result = $User->where($map)->field('md5(info)')->select();
        if($result[0]['md5(info)'] == $info) {
            return true;
        }else{
            return false;
        }
    }
    
    //找回密码
    public function forgotpass() {
        $this->assign('webpagetitle',"找回密码 - Fox50视频网 - 最好的视频网站");
        layout(true);
        $this->display();
    }
    
    //找回密码检查
    public function forgotpasscheck() {
        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误!');
        }else{
            $username = $_POST['username'];
            $email = $_POST['email'];
            $info = md5($_POST['info']);
            $userid = $this->checkUserExist($username);
            $userid = $userid[0]['id'];
            if($userid == null) {
                $this->error('没有该用户');
            }
            if(($this->checkUserEmail($username, $email)) != true) {
                $this->error('用户邮箱信息错误!');
            }else if(($this->checkUserProtect($userid,$info)) == false) {
                $this->error('密保错误');
            }else{
                $User = D('User');
                $map['account'] = $username;
                $map['password'] = $oldpassword;
                $newpassword = $newpassword;
                $result = $User->where($map)->field('password')->select();
                
                import("@.ORG.Util.Phpmailer");
                import("@.ORG.Util.Smtp");
                $mail        =        new PHPMailer();
                $mail->CharSet        =        "UTF-8";
                $mail->IsSMTP();
                $mail->Host            =        "smtp.admin.cn";           // SMTP服务器地址
                $mail->SMTPAuth        =        true;                           // SMTP是否需要验证，现在STMP服务器基本上都需要验证
                $mail->Username        =        "admin@admin.com";           // 登录用户名
                $mail->Password        =        "admin";            //  登录密码
                
                $mail->From = "admin@admin.com";                                     //  发件人地址(username@163.com)
                $mail->FromName = "Fox50管理员";                    //   发件人名称
                
                $mail->AddAddress($email);               //这里是收件人地址(test@hnce.net)
                $mail->WordWrap   = 50;
                $mail->IsHTML(true);
                
                $mail->Subject    = "来自Fox50视频网的邮件";
                $mail->Body       = "<p>您好，".$username."<BR>  请点击<a href='".U('Home/User/setnewpass','','','',true)."/uid/".base64_encode($userid)."/identity/".$info."'>".U('Home/User/setnewpass','','','',true)."/uid/".base64_encode($userid)."/identity/".$info."</a>设置新密码!<hr />From Fox50视频网站--最好的视频网站<BR><BR>";
                if(!$mail->Send())
                {
                    $this->error("邮件发送失败，稍等后再发! <br />错误信息：" . $mail->ErrorInfo);
                } 
                else
                {
                    $this->success('邮件发送成功，请前往邮箱进行密码重置!',$_SERVER['HTTP_REFERER'],60);
                }
            }
        }
    }
    
    //设置新密码
    public function setnewpass() {
        if((!isset($_GET['uid']) && (!isset($_GET['identity'])))) {
            $this->error('非法访问',U('Home/Index/'));
        }
        $this->assign('webpagetitle',"重置密码 - Fox50视频网 - 最好的视频网站");
        $userid = base64_decode($_GET['uid']);
        if(!($this->checkUserProtect($userid,$_GET['identity']))){
            $this->error('非法访问',U('Home/User/login'));
        }
        $user = D('User');
        $info = $user->getById($userid);
        $this->assign('user',$info);
        layout(true);
        $this->display();
    }
    
    //设置新密码检查
    public function setnewpasscheck() {
        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误!');
        }else{
            $username = $_POST['username'];
            $newpassword = md5($_POST['password']);
            $repassword = md5($_POST['repassword']);
            if($newpassword != $repassword) {
                $this->error('两次密码不一样');
            }
            if($this->checkUserExist($username) == null) {
                $this->error('没有该用户');
            }
            $User = D("User");
            $map['username'] = $username;
            $data['password'] = $newpassword;
            $result = $User->where($map)->save($data);
            if(false !== $result) {
                $this->success('密码修改成功！',U('Home/User/login'));
            }else{
                $this->error('密码修改失败!');
            }
        }
    }
    
    //用户首页
    public function index() {
        $model = D('User');
        $data['id'] = $_SESSION['id'];
        $result = $model -> where($data) -> field('account,nickname,email,avatar,login_count,last_login_time,last_login_ip,create_time,remark') -> select();
        $this -> assign('info',$result[0]);
        //layout(true);
        $this -> display();
    }
    
    //用户修改资料
    public function profile() {
        $this->checkUserLogin();
        $User	 =	 M("User");
        //$vo	=	$User->getById($_SESSION[C('USER_AUTH_KEY')]);
        $data['id'] = $_SESSION[C('USER_AUTH_KEY')];
        $vo = $User -> where($data) -> field('id,nickname,email,remark,avatar') -> select();
        $this->assign('vo',$vo[0]);
        $this->display();
    }
    
    //用户修改密码
    public function password() {
        $this->display();
    }
    
}

?>