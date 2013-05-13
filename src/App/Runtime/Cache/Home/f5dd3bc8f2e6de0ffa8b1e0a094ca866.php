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
        <?php if(is_array($NavList)): $i = 0; $__LIST__ = $NavList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a onfocus="this.blur();" href="<?php echo U('Home/VideoCategory/index','catid='.$vo[id],'.fhtml');?>"><?php echo ($vo["catname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
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
                    <style>
#discusscontent li{
  	height:80px;
	word-break: break-all;word-wrap: break-word;
}
.s_span{
 margin-top:65px;position:relative; right:-100px;
}
</style>
<div id="wrapper">
<script src="../Public/js/ajax.js"></script>
<div class="box"><span>您现在所在的位置：</span><a href="__APP__">首页</a> &gt; <a href="__APP__/Home/VideoCategory/index/catid/<?php echo ($getCate['catid']); ?>"><?php echo ($getCate['catname']); ?></a> &gt;<span> <?php echo ($videoinfo[0]['title']); ?></span></div>
<div class="blank"></div>
<div class="mov_detail_box">
  
  <div class="mov_detail">
    <div class="bd"><span class="tl"></span><span class="tr"></span>
      <div class="ct">
        <div class="mov_detail_intro">
          <p class="pic"><a href="<?php echo U('Home/Play/index?vid='.$videoinfo[0]['vid']);?>"><img src="<?php echo ($videoinfo[0]['img']); ?>" title="" onerror="this.src='__PUBLIC__/Images/nophoto.jpg'" width="119" height="170" border="0"></a></p>
                    <p class="score"><span id="Scorenum"></span><span id="Scoreer"></span></p>          <p class="intro"><a href="<?php echo U('Home/Play/index?vid='.$videoinfo[0]['vid']);?>" class="title" title="<?php echo ($videoinfo[0]['title']); ?>"><?php echo ($videoinfo[0]['title']); ?></a><span class="intro"></span></p>
          <p class="actor">主演：<?php echo ($videoinfo[0]['actor']); ?> <br>

            <span class="wide">导演：<?php echo ($videoinfo[0]['director']); ?></span>
            <span class="wide">影片类型：<?php echo ($videoinfo[0]['typeid']); ?></span><br>
            <span class="wide">地区：<?php echo ($videoinfo[0]['regionid']); ?></span>
            <span class="wide">上映时间：<?php echo ($videoinfo[0]['year']); ?></span><br>
            <span class="wide">语言：未知</span>
            <span class="wide">更新时间：<?php echo (date("Y-m-d",$videoinfo[0]['dateline'])); ?></span><br>
          </p>
          <p class="bar"> <a href="#comment" class="com_btn">发表评论</a>&nbsp;</p>
          <p><a href="<?php echo U('Home/Play/index?vid='.$videoinfo[0]['vid']);?>" class="view_btn"><span>立即观看</span></a></p>
          <div id="ckepop" class="jia"><a class="jiathis_button_baidu" title="分享到百度搜藏"><span class="jiathis_txt jtico jtico_baidu"></span></a><a class="jiathis_button_tsina" title="分享到新浪微博"><span class="jiathis_txt jtico jtico_tsina"></span></a><a class="jiathis_button_tqq" title="分享到腾讯微博"><span class="jiathis_txt jtico jtico_tqq"></span></a><a class="jiathis_button_kaixin001" title="分享到开心网"><span class="jiathis_txt jtico jtico_kaixin001"></span></a><a class="jiathis_button_renren" title="分享到人人网"><span class="jiathis_txt jtico jtico_renren"></span></a></div>
        </div>
      </div>
      <span class="bl"></span><span class="br"></span></div>
  </div>
</div>
<div class="blank"></div>
<div class="mov_detail_box bd"><span class="tl"></span><span class="tr"></span>
  <div class="ct">
    <div class="hd"><h3>影片摘要</h3></div>
    <div class="play_list">
      <p class="title">播放列表：<span class="tip">(点击单集开始播放)</span></p>
      <div id="plist">
        <ul class="split-list">
          <?php if($videorelevance != 0): if(is_array($videorelevance)): $i = 0; $__LIST__ = $videorelevance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Play/index?vid='.$vo['vid']);?>" target="_blank"><?php echo ($key+1); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
           <?php else: ?>
             <li><a href="<?php echo U('Home/Play/index?vid='.$videoinfo[0]['vid']);?>" target="_blank">1</a></li><?php endif; ?>
        </ul>
              </div>
    </div>	    <div class="brief_info">
      <div class="title">影片介绍：</div>
      <div class="brief_info_cont"><?php echo ($videoinfo[0]['about']); ?> </div>
    </div>
    <div class="rt_recom">
   <?php if($similarvideo != 0): ?><div class="title">同类热门推荐：</div><?php endif; ?>
      <ul class="mov_pic_list">
      	<span id="hot_video" href="/gx/index.php?s=my/show/id/hot_video/cid/17/limit/7">
 <?php if(is_array($similarvideo)): $i = 0; $__LIST__ = $similarvideo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
<div class="pic"><a href="/gx/?s=video/detail/id/91.html" target="_blank"><img src="" title="" onerror="this.src='__PUBLIC__/Images/nophoto.jpg'" border="0" height="140" width="98"></a></div>
<div><a href="/gx/?s=video/detail/id/91.html" title="神雕侠侣傅声版">神雕侠侣傅声版</a></div>
</li><?php endforeach; endif; else: echo "" ;endif; ?>


</span>
      </ul>
    </div>
  </div>
  <span class="bl"></span><span class="br"></span> </div>
<div class="blank"></div>

<div class="mov_detail_box bd"><span class="tl"></span><span class="tr"></span>
  <div class="ct">
  	<div class="hd"><h3>影片评论</h3></div><a name="comment" id="comment"></a>
    <div id="Comments">

<ul class="list">

   <div id="discusscontent">
                  <br />
                 　　没有相关评论!
     </div>
</ul>
<script type="text/javascript">
     //回复函数
     function setretun(name){
        document.getElementById('comment_content').value='@' + name + ':';
     }
    //评论
     function setconment(){
            var login1='<?php echo ($login); ?>';
            if(login1==''){
              alert('请先登录!');
            }else{
				if(document.getElementById('comment_content').value == ''){
					alert('评论内容不能为空！');return;
				}else if(document.getElementById('comment_content').value == '我来评论，最多200个字。'){
					alert('请填写相关评论内容!');return;
				}else if(document.getElementById('comment_content').value.length > 200){
					alert('评论内容不能超过200字符!');return;
				}
                var b_ajax = new Ajax();
                 b_ajax.post("__URL__/addcomment" ,{vid:<?php echo ($_GET['vid']); ?>,uid:<?php echo ($userid); ?>,comnemt:document.getElementById('comment_content').value},function(data){
                 if(data == 1){
                            alert('评论成功！');
					         setPage('__URL__/comment/vid/<?php echo ($_GET['vid']); ?>/page/1&aa='+Math.random(),0); 
					         document.getElementById('comment_content').value = '';
                  }else if(data==0){
                      alert('评论失败!');
                  }else{
                      alert('请先登录!');
                  }
                });
            }
        }
</script>

<script>
    setPage('__APP__/Home/PlayLoad/comment/vid/<?php echo ($_GET['vid']); ?>/page/1&aa='+Math.random(),0);
   //加载评论
   function setPage(url,su_obj){
        var obj=document.getElementById("discusscontent");
           var a_ajax=new Ajax();	   
           a_ajax.get(url,function(date){
             if(!date==''){
              obj.innerHTML=date;
             }else{
              obj.innerHTML='没有相关评论';
             }
           });
        }

</script>


<div class="form1">
	        <textarea name="content" id="comment_content" rows="5" onfocus="if(this.value=='我来评论，最多200个字。'){this.value='';}" onblur="if(this.value==''){this.value='我来评论，最多200个字。';};" maxlength="200" class="txt_in">我来评论，最多200个字。</textarea>
        <p class="under_row"><input id="comment_button" class="submit" onClick="setconment();" type="button" value="发表评论"></p></div></div>
  </div>
  </div>

</div>

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