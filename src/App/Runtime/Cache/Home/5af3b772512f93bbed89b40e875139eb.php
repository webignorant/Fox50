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
                    <!--********************这里是主体内容********************-->

<script src="__PUBLIC__/Js/jquery-1.8.3.min.js" type="text/javascript"></script>
<link href="__PUBLIC__/Plugin/slideBox/css/jquery.slideBox.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Plugin/slideBox/js/jquery.slideBox.min.js" type="text/javascript"></script>
<script>
$('#videoslide').ready(function(){
	$('#videoslide').slideBox({
		duration : 0.3,//滚动持续时间，单位：秒
		easing : 'linear',//swing,linear//滚动特效
		delay : 5,//滚动延迟时间，单位：秒
		hideClickBar : false,//不自动隐藏点选按键
		clickBarRadius : 10
	});
});
</script>
<div style="width:1000px; height:305px; padding-top:5px; ">
    <div id="videoslide" class="slideBox" style="float:left; width:665px; height:305px;border:1px solid #d2dbe4">
        <ul class="slideitems">
        <?php if(($RecommendedList) == ""): ?>没有还推荐的视频<?php endif; ?>
        <?php if(is_array($RecommendedList)): $i = 0; $__LIST__ = $RecommendedList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><img width="665" height="305" src="<?php echo ($vo["img"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
<style>
.jiaodian ul{ border-bottom:#999999 dotted 1px; padding-bottom:5px; padding-top:3px;}
.jiaodian ul li{ padding:5px; width:310px;}
.jiaodian span{ overflow:hidden; display:inline-block; width:250px; height:15px;}
.jiaodian .data{width:55px; margin-left:3px;}
.jiaodian .hd { width:322px; padding:0 5px; height:25px;}
.jiaodian .hd h3{ font-size:14px; font-weight:bold; width:250px; float:left;}
.jiaodian .more { float:left }
</style>
    <div class="jiaodian"  style="width:320px; height:295px; border:1px solid #c5ddf6; float:right; font-size:13px; padding:5px;">
        <div class="hd">
            <h3>最热视频</h3>
        </div>
        <ul>
        <?php if(($HotList) == ""): ?>还没有视频，本站建设中...<?php endif; ?>
        <?php if(is_array($HotList)): $i = 0; $__LIST__ = $HotList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href='<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>'><span class='hot'><?php echo (msubstr($vo["title"],0,18,'utf-8',true)); ?></span><span class='data'><?php echo ($vo["viewnum"]); ?></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>

<!--最近更新视频-->
<div class="box">
    <div class="left_col">
        <div class="topbrd"></div>
        <div class="bd">
            <div class="ct">
                <div class="hd"><h3>最近更新</h3></div>
                <ul class="index_top_video">
                    <?php echo ($LatestVideoError); ?>
                    <?php if(is_array($LatestVideo)): $i = 0; $__LIST__ = $LatestVideo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><em><?php echo ($i); ?></em><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,12,'utf-8',true)); ?></a> <span><font color="red"><?php echo (date("m-d",$vo["dateline"])); ?></font></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <div class="total">今日更新：<span>[<?php echo ($NewVideoNumInToday); ?>]</span> 总视频数量：<span>[<?php echo ($VideoMaxNum); ?>]</span></div>
            </div>
        </div>
        <div class="btmbrd"></div>
    </div>
      
    <div class="right_col">
        <div class="bd"><span class="tl"></span><span class="tr"></span>
            <div class="ct">
                <div class="hd">
                  <h3 class="rec"><span>近期热门视频推荐</span></h3> 
                </div>
                <ul class="mov_pic_list index_rec">
                    <?php echo ($LatestVideoError); ?>
                    <?php if(is_array($LatestVideo)): $i = 0; $__LIST__ = $LatestVideo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><div class="pic"><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><img src="<?php echo ($vo["img"]); ?>" onerror="this.src='__PUBLIC__/Images/nophoto.jpg'" border="0" height="140" width="98"></a></div><div class="ver"><?php echo ($vo["definition"]); ?></div><div class="mid_title"><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,9,'utf-8',true)); ?></a></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <span class="bl"></span><span class="br"></span>
        </div>
    </div>
</div>

<!--视频栏目推荐-->
<?php if(is_array($VideoCategory)): $i = 0; $__LIST__ = $VideoCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><div class="box">
    <div class="left_col">
        <div class="topbrd"></div>
        <div class="bd">
            <div class="ct">
                <div class="hd">
                  <h3><?php echo ($category["catname"]); ?>热门排行榜</h3>
                </div>
                <ul class="index_top_video">
                    <?php if(($category['top']) == ""): ?>该栏目还没有视频<?php endif; ?>
                    <?php if(is_array($category['top'])): $i = 0; $__LIST__ = $category['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><em><?php echo ($i); ?></em><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,12,'utf-8',true)); ?></a> <span><font color="red"><?php echo ($vo["viewnum"]); ?></font></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <div class="btmbrd"></div>
    </div>
    <div class="right_col">
        <div class="bd"><span class="tl"></span><span class="tr"></span>
            <div class="ct">
                <div class="hd">
                    <h3><?php echo ($category["catname"]); ?></h3>
                    <a href="<?php echo U('Home/VideoCategory/index','catid='.$category[id],'fhtml');?>" class="more">全部&gt;&gt;</a>
                    <div class="sort">
                        <?php if($category['mode'] == 'region'): if(is_array($category['retrieval'])): $i = 0; $__LIST__ = $category['retrieval'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/VideoCategory/index','catid=1&rid='.$vo[id],'fhtml');?>" title="<?php echo ($vo["regionname"]); ?>"><?php echo ($vo["regionname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php else: ?>
                            <?php if(is_array($category['retrieval'])): $i = 0; $__LIST__ = $category['retrieval'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/VideoCategory/index','catid='.$vo[upid].'&tid='.$vo[id],'fhtml');?>" title="<?php echo ($vo["typename"]); ?>"><?php echo ($vo["typename"]); ?></a><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                </div>
                <div class="index_mov">
                    <ul class="mov_pic_list">
                        <?php if(($category['recommend']) == ""): echo ($category["catname"]); ?>栏目还没有视频<?php endif; ?>
                        <?php if(is_array($category['recommend'])): $i = 0; $__LIST__ = $category['recommend'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><div class="pic"><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><img src="<?php echo ($vo["img"]); ?>" onerror="this.src='__PUBLIC__/Images/nophoto.jpg'" border="0" height="140" width="98"></a></div><div class="ver"><?php echo ($vo["definition"]); ?></div><div class="mid_title"><a href="<?php echo U('Home/PlayLoad/index','vid='.$vo[vid]),'.fhtml';?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,9,'utf-8',true)); ?></a></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <div class="mov_text_list">
                        <ul></ul>
                    </div>
                </div>
            </div>
            <span class="bl"></span><span class="br"></span>
        </div>
    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
    
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