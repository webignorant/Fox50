<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="qc:admins" content="5573160667667050636" />
<meta name="keywords" content="fox50视频网">
<meta name="description" content="Fox50-最好的视频网站">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title><?php echo ($webpagetitle); ?></title>
<script type="text/javascript" src="__PUBLIC__/Js/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Think/ThinkAjax.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Form/CheckForm.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/nav.js"></script>

<!--New_Fox Index-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/system.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/default/template.css" />
<load href="__PUBLIC__/default/nav.css" >

<!--<script type="text/javascript" src="__PUBLIC__/default/template.js"></script>-->

<!--New_Fox User-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/user.css" />

<script type="text/javascript" src="__PUBLIC__/Js/New/jquery.js"></script>
<!--<script type="text/javascript" src="__PUBLIC__/Js/New/system.js"></script>-->
<!--<script type="text/javascript" src="__PUBLIC__/Js/New/history.js"></script>-->
<link rel="shortcut icon" href="__PUBLIC__/Images/favicon.ico" type="images/x-icon">

<script language="JavaScript">
//指定当前组模块URL地址 
var URL = '__URL__';
var APP	 =	 '__APP__';
var PUBLIC = '__PUBLIC__';
</script>

</head>
    <body>
        <!--********************这里是最顶部内容********************-->

<div class="apex" style="width:100%;height:20px;border-bottom:1px solid #f2f6f8">
    <div class="apex_center" style="width:1000px;height:20px;margin:0 auto;text-align:left;">
        <span style="float:left;text-align:left;">
            <a href="#" onclick="SetHome();">设为首页</a> | <a href="#" onclick="SetFavorite();">加入收藏</a>
        </span>
        <!--
        <span style="float:right;text-align:right;">
            本网站由太阳能驱动 | 本网站采用微服务器
        </span>
        -->
    </div>
</div>

<script>
//设为首页 
function SetHome() {
    if (document.all) {
        document.body.style.behavior = 'url(#default#homepage)';
        document.body.setHomePage(window.location.href);
    } else if (window.sidebar) {
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            } catch (e) {
                alert("该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config ,然后将项 signed.applets.codebase_principal_support 值该为true");
                history.go(-1);
            }
        }
        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
        prefs.setCharPref('browser.startup.homepage', window.location.href);
    }
} 
// 加入收藏夹
function SetFavorite() {
var sTitle=document.title;
var sURL=document.location.href;
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败,请手动添加.");
        }
    }

}
</script>
<!--********************这里是最顶部内容********************-->
        <div id="wrapper">
            <!--********************这里是头部内容********************-->

<div class="header">
    <div class="top">
        <div title="fox50" class="logo"></div>
		
        <div id="login" class="login">
            <!--QQ登录测试-->
            <!--
            <a href='__APP__/Home/User/qq_user_login_check'><img src="__PUBLIC__/API/Connect2.0/image/Connect_logo_7.png"></a>
        <script type="text/javascript">
            var childWindow;
            function toQzoneLogin()
            {
                childWindow = window.open("__PUBLIC__/API/Connect2.0/example/oauth/index.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            } 
            
            function closeChildWindow()
            {
                childWindow.close();
            }
        </script>
            -->
            <?php switch($checklogin): case "true": ?><div id="accountOption" class="accountOption">
                        <b><?php echo ($user["account"]); ?></b>
                        <?php if($user["avatar"] == null): ?><a href="__APP__/Home/User/profile"><img id="userImg" width="20" height="20" title="点击可以编辑用户资料" src="__PUBLIC__/Images/user/face.jpg"></a>
                        <?php else: ?>
                            <a href="__APP__/Home/User/profile"><img id="userImg" width="20" height="20" title="点击可以编辑用户资料" src="<?php echo ($user["avatar"]); ?>"></a><?php endif; ?>
                        <img id="accountOptionBtn" width="15" height="15" src="__PUBLIC__/Images/admin/down.gif" />
                    </div>
                    <div id="historyOption" class="historyOption"><a>看过的<img id="accountOptionBtn" width="15" height="15" src="__PUBLIC__/Images/admin/down.gif" /></a></div>
                    <div id="uploadOption" class="uploadOption"><a href="<?php echo U('Home/Upload/index/');?>">上传<img id="accountOptionBtn" width="15" height="15" src="__PUBLIC__/Images/admin/up.gif" /></a></div><?php break;?>
                <?php default: ?>
                    <a href="<?php echo U('Home/User/login/');?>">登陆</a> &nbsp;|&nbsp;
                    <a href="<?php echo U('Home/User/register/');?>">注册</a><?php endswitch;?>
            <!--用户列表显示层-->
            <div id="accountOptionDiv" class="accountOptionDiv">
                <ul>
                    <li><a href="<?php echo U('Home/User/index/');?>">个人中心</a></li>
                    <li><a href="<?php echo U('Home/Video/video_index/');?>">视频管理</a></li>
                    <li><a href="<?php echo U('Home/User/profile/');?>">账号设置</a></li>
                    <li><a href="<?php echo U('Home/User/logout/');?>">退出注销</a></li>
                </ul>
            </div>
            <!--历史列表显示层-->
            <div id="historyOptionDiv" class="historyOptionDiv">
                <div id="videoHistory" class="videoHistory">
                    <?php if(is_array($RecentlyList)): $i = 0; $__LIST__ = $RecentlyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="videoHistory_left"><a href="<?php echo U('Home/Play/index/','vid='.$vo[vid]);?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,10,'utf-8',true)); ?></a></div>
                        <div class="videoHistory_right"><a href="<?php echo U('Home/Play/index/','vid='.$vo[vid]);?>">继续播放</a></div>
                        <hr style="border:1px dashed #86BCD4; height: 1;"/><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="videoHistoryBottom">
                    <div class="videoHistoryLeft"><a href="<?php echo U('Home/VideoRecently/index/');?>">查看更多</a></div>
                    <div class="videoHistoryRight"><a href="javascript:clearHistory();">清空全部记录</a></div>
                </div>
            </div>
        </div>
        <div class="control">
            <div class="cc_logo"></div>
            本网站由太阳能驱动&nbsp;|&nbsp;本网站采用微服务器
        </div>
		
    </div>
    <div id="nav" class="nav">
        <a href="__APP__/Home/Index/" class="cur">首页</a>
        <?php if(is_array($NavList)): $i = 0; $__LIST__ = $NavList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a onfocus="this.blur();" href="__APP__/Home/VideoCategory/index/catid/<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
	
    <div class="query">
        <span class="query_l"></span>
        <div style="width:450px;float:left"><?php if(($notice) != ""): ?>公告：<marquee behavior="alternate" direction="right" scrollamount="3" width="400"><?php echo ($notice); ?></marquee><?php endif; ?></div>
		<div style="float:right">
            <form action="<?php echo U('Home/VideoSearch/index/');?>" method="post" name="search" id="search">
                <input type="text" value="请输入视频名称" id="title" name="title" autocomplete="off" maxlength="35" /><!--onBlur="this.style.borderColor='#dcdcdc';this.value ='请输入视频名称';this.style.color='#aab9c4';"-->
                <div id="search_sort">
                    <span id="cur_txt">分类</span>
                    <ul class="sort" id="sort" style="display: none;" >
                    <?php if(is_array($videoCategory)): $i = 0; $__LIST__ = $videoCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:void(0)" category="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                 </div>
                <button type="submit" class="search_bt"><span>搜索</span></button>
                <input type="hidden" name="__gxcmsform__" value="ea010d0258c390b657b29c4bc615436a" />
            </form>
        </div>
        <span class="query_r"></span> 
    </div>
</div>

<script>
accountOptionDivShow = false;   //是否显示用户选项层
historyOptionDivShow = false;   //是否显示历史选项层
$(document).ready(function(){
    // 用户选项span点击事件
    $('#accountOption').click(function(){
        divHide('account');
        if(!accountOptionDivShow) {
            //修改span样式
            $('#accountOption').css({"border-left": "1px solid #c6c6c6", "border-right": "1px solid #c6c6c6", "border-top": "1px solid #c6c6c6"});
            //显示option
            accountOptionDivShow = true;
            var weizhi = $('#accountOption').position();
            var spanHeight = $('#accountOption').height();
            var spanWidth = $('#accountOption').height();
            var divWidth = spanWidth + weizhi.top;
            $("#accountOptionDiv").css({ left: weizhi.left, top:divWidth});
            $('#accountOptionDiv').show();
        }else{
            //修改span样式
            $('#accountOption').css({"border-left": "", "border-right": "", "border-top": ""});
            accountOptionDivShow = false;
            $('#accountOptionDiv').hide();
        }
    });
    $('#historyOption').click(function(){
        divHide('history');
        if(!historyOptionDivShow) {
            //修改span样式
            $('#historyOption').css({"border-left": "1px solid #c6c6c6", "border-right": "1px solid #c6c6c6", "border-top": "1px solid #c6c6c6"});
            historyOptionDivShow = true;
            //获取uploadOption的位置，以定位
            var weizhi = $('#uploadOption').position();
            var weizhi_right = weizhi.left + $('#uploadOption').width();
            var weizhi_left = weizhi_right - $('#historyOptionDiv').width() -2;
            var divWidth = weizhi.top + $('#historyOption').height();
            $("#historyOptionDiv").css({ left: weizhi_left, top:divWidth});
            $('#historyOptionDiv').show();
        }else{
            //修改span样式
            $('#historyOption').css({"border-left": "", "border-right": "", "border-top": ""});
            historyOptionDivShow = false;
            $('#historyOptionDiv').hide();
        }
    });
    $('#accountOptionDiv').hover(
        function(){},
        function(){
            divHide();
        }
    );
    $('#historyOptionDiv').hover(
        function(){},
        function(){
            divHide();
        }
    );
});
function divHide(div){
    if(accountOptionDivShow && div!= 'account') {
        $('#accountOption').css({"border-left": "", "border-right": "", "border-top": ""});
        accountOptionDivShow = false;
        $('#accountOptionDiv').hide();
    }else if(historyOptionDivShow && div!= 'history') {
        $('#historyOption').css({"border-left": "", "border-right": "", "border-top": ""});
        historyOptionDivShow = false;
        $('#historyOptionDiv').hide();
    }
}
//清空历史记录
function clearHistory(){
    $.ajax({
        url :"<?php echo U('Home/VideoRecently/clearAllHistory');?>",
        success: function(){
            $("#videoHistory").html('');
        }
    });
}
</script>

<script>
//搜索类型选择
$(document).ready(function(){
	$('#title').focus(function(){
	if($('#title').val()=='请输入视频名称'){
			$('#title').val('');
		}
	});
	$('#title').blur(function(){
		if($('#title').val()==''){
			$('#title').val('请输入视频名称');
		}
	});
	$('#sort').hide();
	$('#cur_txt').click(function(){
		$('#sort').show();
		$('#sort>li>a').click(function(){
			var id = $(this).attr('category');
			var newaction = $('#search').attr('action')+'/catid/'+id;
			$('#search').attr('action',newaction);
			name = $(this).html();
			$('#cur_txt').html(name);
			$('#sort').hide();
		});
	});
	$('#sort').hover(
        function(){
        },
        function(){
            $('#sort').hide();
        }
	);
	$('#cur_txt').blur(function(){	
		$('#sort').hide();
	});
});
</script>

<!--********************这里是头部内容********************-->
                    <!--********************这里是主体内容********************-->

<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/user.css">

<style>
.result_info{
    margin-left:10px;
    width:300px;
    color:blue;
    display:none;
}
</style>

<div class="user_login">
	<form action="__URL__/registercheck" method="post" name="gxcms" id="gxcms" onsubmit="return checkform();" enctype="multipart/form-data">
        <input name="jumpurl" type="hidden" value="http://localhost/fox%2050/?s=video/lists/id/1.html" />
        <div class="regleft"><span>用户注册</span></div>
        <div class="right">
        <ul>
            <li class="reginput">帐户名称：<input name="username" id="username" onkeypress="return event.keyCode>=48&&event.keyCode<=57||(event.keyCode>=97&&event.keyCode<=122)" type="text" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc';" maxlength="12" error="帐户名不能为空" title="不超过12个字符">
            <span id="usernameResult" class="result_info"></span><span id="usernameCheck" class="result_info"></span>
            </li>
            
            <li class="reginput">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱：<input name="email" id="email" type="text" maxlength="50" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" this.style.borderColor='#dcdcdc'" error="邮箱不能为空" title="不超过50个字符">
            <span id="emailResult" class="result_info"></span>
            </li>
            
            <li class="reginput">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码：<input name="userpwd" id="userpwd" type="password" maxlength="15" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" error="密码不能为空" title="不超过15个字符">
            <span id="userpwdResult" class="result_info"></span>
            </li>
            
            <li class="reginput">确认密码：<input name="reuserpwd" id="reuserpwd" type="password" maxlength="15" onfocus="this.style.borderColor='#fc9938'" onblur="onpass();this.style.borderColor='#dcdcdc'" error="两次输入的密码不一样">
            <span id="reuserpwdResult" class="result_info"></span>
            </li>
            
            <li class="reginput">密保问题：<input name="question" id="question" type="text" maxlength="15" title="填写一个密保问题，最多只能输入10个汉字" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" error="密保问题不能为空">
            <span id="questionResult" class="result_info"></span>
            </li>
            
            <li class="reginput">密保答案：<input name="answer" id="answer" type="text" maxlength="15" title="填写密保问题的答案，最多只能输入20个汉字" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" error="密保答案不能为空">
            <span id="answerResult" class="result_info"></span>
            </li>
            
            <li class="reginput">&nbsp;&nbsp;&nbsp;验证码：<input type="text" name="verify" id="verify" style="width:70px;"/>&nbsp;&nbsp;&nbsp;<img src='__URL__/verify/' onclick="function fleshVerify(a){var timenow = new Date().getTime();a.src='__URL__/verify/'+timenow;};fleshVerify(this) " />
            </li>
            
            <li style="padding-left:60px"><input name="agree" id="check" type="checkbox" checked="checked" style="border:none;background:none" error="同意协议才能注册为本网站用户">
            <span class="f12">我确认我同意</span> 
            <a href="javascript:void(0);" id="syxy">使用协议</a>
            </li>
            
            <li style="padding-left:35px"><input type="submit" name="" class="" style="width:75px; height:25px" value="注册" />
             已经是会员，请<a href="index.php?s=User/Login">登录</a>
            </li>
            
        </ul>
        </div>
        <input type="hidden" name="__gxcmsform__" value="157396af641a5811eb0d5ad7408b4908" />
    </form>
    
<script>
allow = false; //是否允许提交表单
/*
errorPosition = new Array(); //错误地点,数组保存
error = '';
//设置错误数组
//参数:错误的ID名称 执行的模式true为增加,false为删除
function setErrorArray(checkID ,mode){
    //mode=arguments[1]?arguments[1]:true;
    //检测是否存在，不存在就添加
    //alert(errorPosition.length);
    //errorPosition.push(checkID);
    //alert(errorPosition[1]);
    if(errorPosition.length == 0){
        errorPosition.push(checkID);
    }
    for(var i = 0; i <= errorPosition.length; i++) {
        if(errorPosition[i] == checkID){
            if(!mode){
                delete errorPosition[i]; 
                break;
            }else{
                break;
            }
        }
        if(i == errorPosition.length){
            errorPosition.push(checkID);
            break;
        }
    }

    for(var i = 0; i < errorPosition.length; i++) {
        if(i == errorPosition.length){
            return errorPosition.length;
        }
    }
}
*/
$(document).ready(function(){
    //用户名检查
    $('#username').focus(function(){
        $('#usernameResult').css({color : 'blue'});
        $('#usernameResult').text('字母开头，允许5-20字节，允许字母数字下划线');
        $('#usernameCheck').hide();
        $('#usernameResult').show();
    });
    $('#username').blur(function(){
        if(!$('#username').val()){
            $('#usernameResult').css({color : 'red'});
            $('#usernameResult').text('用户名不能为空');
        }else{
            //var reg=eval("^[a-zA-Z][a-zA-Z0-9_]{5,19}$");
            //var reg = ^[0-9a-zA-Z]+$;
            var reg = new RegExp("^[a-zA-Z][a-zA-Z0-9_]{4,19}$"); 
            usernameStr = $('#username').val();
            if(!reg.test(usernameStr)){
                $('#usernameResult').css({color : 'red'});
                $('#usernameResult').text('用户名格式不符合');
            }else{
                //判断用户名是否已注册
                userNameExist = 0;
                $.post('__URL__/readuser', {send_user :$('#username').val()}, function(data){
                    obj = eval("(" + data + ")");
                    if(obj.status == 0){
                        $('#usernameCheck').css({color : 'red'});
                        $('#usernameResult').css({color : 'red'});
                        $('#usernameResult').text('不通过');
                    }else{
                        $('#usernameCheck').css({color : 'green'});
                        $('#usernameResult').css({color : 'green'});
                        $('#usernameResult').text('已通过');
                    }
                    $('#usernameCheck').text(obj.info);
                    $('#usernameCheck').show();
                });
            }
        }
        //$("#usernameCheck").load("__URL__/readuser",{send_user:$("input[name='username']").val()});
    });
    //电子邮件检查
    $('#email').focus(function(){
        $('#emailResult').css({color : 'blue'});
        $('#emailResult').text('电子邮件不能为空，且不能大于二十个汉字');
        $('#emailResult').show();
    });
    $('#email').blur(function(){
        if(!$('#email').val()){
            $('#emailResult').css({color : 'red'});
            $('#emailResult').text('电子邮件不能为空');
        }else{
            var reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            emailStr = $('#email').val();
            if(!reg.test(emailStr)){
                $('#emailResult').css({color : 'red'});
                $('#emailResult').text('电子邮件格式不符合');
            }else{
                $('#emailResult').css({color : 'green'});
                $('#emailResult').text('已通过');
            }
        }
    });
    //用户密码检查
    $('#userpwd').focus(function(){
        $('#userpwdResult').css({color : 'blue'});
        $('#userpwdResult').text('只能输入6-20个字母、数字、下划线');
        $('#userpwdResult').show();
    });
    $('#userpwd').blur(function(){
        if(!$('#userpwd').val()){
            $('#userpwdResult').css({color : 'red'});
            $('#userpwdResult').text('密码不能为空');
        }else if($('#username').val() == $('#userpwd').val()){
            $('#userpwdResult').css({color : 'red'});
            $('#userpwdResult').text('用户名和密码不能相同！');
        }else{
            var reg=/^(\w){6,20}$/;
            userpwdStr = $('#userpwd').val();
            if(!reg.test(userpwdStr)){
                $('#userpwdResult').css({color : 'red'});
                $('#userpwdResult').text('密码格式不符合');
            }else{
                $('#userpwdResult').css({color : 'green'});
                $('#userpwdResult').text('已通过');
            }
        }
    });
    //用户确认密码检查
    $('#reuserpwd').focus(function(){
        if(!$('#userpwd').val()){
            $('#userpwdResult').show();
            $('#userpwd').focus();
        }else{
            $('#reuserpwdResult').css({color : 'blue'});
            $('#reuserpwdResult').text('请再一次输入密码');
            $('#reuserpwdResult').show();
        }
    });
    $('#reuserpwd').blur(function(){
        if($('#userpwd').val() != $('#reuserpwd').val()){
            $('#reuserpwdResult').css({color : 'red'});
            $('#reuserpwdResult').text('两次密码不一样');
            $('#userpwd').focus();
        }else{
            $('#reuserpwdResult').css({color : 'green'});
            $('#reuserpwdResult').text('已通过');
        }
    });
    //密保问题检查
    $('#question').focus(function(){
        $('#questionResult').css({color : 'blue'});
        $('#questionResult').text('密保问题不能为空，且不能大于十个汉字');
        $('#questionResult').show();
    });
    $('#question').blur(function(){
        if(!$('#question').val()){
            $('#questionResult').css({color : 'red'});
            $('#questionResult').text('密保问题不能为空');
        }else if($('#question').val().length > 10) {
            $('#questionResult').css({color : 'red'});
            $('#questionResult').text('密保问题大于十个汉字');
        }else{
            $('#questionResult').css({color : 'green'});
            $('#questionResult').text('已通过');
        }
    });
    //密保答案检查
    $('#answer').focus(function(){
        $('#answerResult').css({color : 'blue'});
        $('#answerResult').text('密保答案不能为空，且不能大于二十个汉字');
        $('#answerResult').show();
    });
    $('#answer').blur(function(){
        if(!$('#answer').val()){
            $('#answerResult').css({color : 'red'});
            $('#answerResult').text('密保答案不能为空');
        }else if($('#answer').val().length > 20) {
            $('#answerResult').css({color : 'red'});
            $('#answerResult').text('密保答案大于二十个汉字');
        }else{
            $('#answerResult').css({color : 'green'});
            $('#answerResult').text('已通过');
        }
    });
});
</script>

<script>
function checkform(){
	//同意协议才能注册为本网站用户
	if(!$('#check').attr('checked')){
		alert($('#check').attr('error'));
		$('#check').focus();
		return false;
	}
	//验证码
	if(!$('#verify').val()){
		alert('验证码不能为空');
		$('#verify').focus();
		return false;
	}
	if($('#username').val() == ''){
        $('#username').focus();
        return false;
	}else if($('#emailResult').text() != '已通过'){
        $('#email').focus();
        return false;
	}else if($('#userpwdResult').text() != '已通过'){
        $('#userpwd').focus();
        return false;
	}else if($('#reuserpwdResult').text() != '已通过'){
        $('#reuserpwd').focus();
        return false;
	}
	else if($('#questionResult').text() != '已通过'){
        $('#question').focus();
        return false;
	}else if($('#answerResult').text() != '已通过'){
        $('#answer').focus();
        return false;
	}else{
        return true;
	}
}
</script>

</div>

<script language="JavaScript">
$(document).ready(function(){
    if(self!=top){top.location=self.location;}
    $('#syxy').click(function(){
		var offset = $("#syxy").offset();
		var left = offset.left/2;
		var top = offset.top/2;
		$("#showagree").toggleClass("regnone"); 
		$("#showagree").css({left:left,top:top,display:""});
    });
    $('#showagree').click(function(){
        $("#showagree").hide();
    });
});
</script>

<style>.regnone{display:none}</style>
<div id="showagree" style="position:absolute;background: #F2F2F2;border:2px solid #ccc;padding:5px; width:600px;height:320px;" class="regnone"><h4 style="font-size:14px;color:#000000; height:25px; line-height:25px"><span style="float:left">fox50使用协议:</span><span style=" float:right;cursor:pointer">关闭</span></h4>
    <textarea style="width:100%; height:250px;">注册用户的义务
      (1) 遵守《全国人大常委会关于维护互联网安全的决定》、《互联网电子公告服务管理规定》及中华人民共和国其他各项有关法律、法规，承担一切因您的行为直接或间接引起的民事或刑事法律责任。
      (2) 尊重网上道德，严禁发表危害国家安全、破坏民族团结、破坏国家宗教政策、破坏社会稳定、侮辱、诽谤、教唆、虚假、淫秽等内容的作品。
      (3) 注册时提供您本人真实、正确、最新及完整的资料，并负责进行更新，以确保其真实、正确、最新及完整。
      (4) 注册用户自行负担上网所需的设备及费用。
      (5) 在任何情况下，注册用户不得利用[fox50]进行违反或可能违反国家法律和法规的言论或行为，否则，[fox50]可在任何时候不经任何事先通知终止向您提供服务。并且用户对自己的言论或行为负责。
    若您提供任何错误、不实、过时或不完整的资料或信息，并为[fox50]所确知，或者[fox50]有合理的理由怀疑前述资料或信息为错误、不实、过时或不完整，[fox50]有权暂停或终止您的帐号，并拒绝您于现在和未来使用[fox50]全部或部分的服务。
    </textarea>
</div>

<!--********************这里是主体内容********************-->
            <!--********************这里是友情链接内容********************-->
<div class="friend_link bd">
    <span class="tl"></span><span class="tr"></span>
    <div class="ct">
        <div class="hd"><h3>友情链接</h3></div>
        <ul>
        <?php if(is_array($FriendLink)): $i = 0; $__LIST__ = $FriendLink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="http://<?php echo ($vo["url"]); ?>" target="_blank" title="<?php echo ($vo["description"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <span class="bl"></span><span class="br"></span> 
</div>
<!--********************这里是友情链接内容********************-->

            <!--********************这里是尾部内容********************-->

<!-- 版权信息区域 -->
<div id="footer">
    Copyright Test<?php echo ($companyname); ?> 2012 - 2013 <a href="http://www.fox50.cn">Fox50</a> Some Rights Reserved 粤ICP备13000894号-2
    <script src="http://s15.cnzz.com/stat.php?id=5187626&web_id=5187626&show=pic1" language="JavaScript"></script>
    <!--
    <div id="network" style="width:25px; height:25px; display:inline;">
        <a href="http://www.alexa.com/siteinfo/fox50.cn"><script type='text/javascript' src='http://xslt.alexa.com/site_stats/js/t/b?url=fox50.cn'></script></a>
    </div>
    -->
</div>

<!--********************这里是尾部内容********************-->
        </div>
    </body>
</html>