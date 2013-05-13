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
                    


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<!-- 菜单区域  -->

<style>
/*浮动*/
.fLeft{float:left}
.fRig{float:right}
.fNone{float:none}
.cBoth{clear:both}
/*边距*/
.hMargin{margin-left:0px; margin-right:1px}
.vMargin{margin-top:3px; margin-bottom:3px}
/*大小*/
.huge{width:350px}
.large{width:280px}
.medium{width:150px;margin-right:3px}
.small{width:65px}
.mini{width:35px}
/*盒子*/
.box{clear:both;overflow:hidden;height:auto;zoom:1;margin:10px 0 0;width:960; MARGIN-RIGHT: auto; MARGIN-LEFT: auto;}
.box_left_col{float:left;width:160px;}
.left_col{float:left;width:160px;margin-bottom:10px;}
.left_col .bd{border-width:0 1px;}
.left_col .ct{margin:0 1px;background-color:#f1f8ff;}
.left_col .hd{height:20px;background:url(images/bg.gif) no-repeat 14px -146px;}
.left_col h3{padding:0 0 8px;line-height:16px;}

.right_col{float:right;width:1000px; height:auto; }
.right_col .hd{padding:8px 0 8px 8px;}
.right_col h3{padding:0 0 0 10px;line-height:18px;background:url(images/bg.gif) transparent no-repeat 0 -73px;}
.right_col h3.rec{position:relative;height:18px;}
.right_col h3.rec span{display:inline-block;position:absolute;top:-6px;left:-14px;width:112px;height:31px;text-indent:-1000px;background:url(images/bg.gif) no-repeat 0 -111px;}
.right_col .ct{background:url(images/hd_bg.gif) repeat-x 0 0;}
.right_col .sort{display:inline-block;float:right;margin:2px 0 0;padding:0;color:#0082cb;}
.right_col .sort a,.sort span{margin:0 8px 0 0;}

/*输入框*/
input.imgButton{width:65px; height:22px; margin:0; border:0;font-size:15px; padding-top:1px !important; padding-top:5px;letter-spacing:4px;border:1px solid silver; background-color:white; background-position:5px 40%; background-repeat:no-repeat; cursor:pointer; text-align:center}
/*表格*/
table.list{margin:3px 0px; padding:8px; border:1px solid gray; text-align:left; width:100%; float:left;border-collapse:collapse;}
table.select{margin:3px 0px; padding:3px; border-collapse:collapse; border:1px solid gray; text-align:left; width:500px; clear:both}
table.order{margin:3px 0px; padding:3px; border-collapse:collapse; border:1px solid gray; text-align:left; width:260px; clear:both}
table.login{margin:15% auto 0% auto; padding:3px; border-collapse:collapse; border:1px solid gray; text-align:left; width:350px; max-width:350px; clear:both}
table.message{margin:10% auto 0px auto; padding:3px; border-collapse:collapse; border:1px solid gray; text-align:center; width:55%}
table.error{margin:12px 0px; border-collapse:collapse; border:2px groove #d4d4d4; padding:5px; text-align:left; line-height:165%; width:90%}
table th{background:rgb(131, 200, 255)}
table thead th{border-left:1px solid #cdd; background-color:#dee; background-image:url(../images/bgcolor.gif); color:#899}
 table.message th, 
 table.message td, 
  table.select th, 
 table.select td, 
  table.order th, 
 table.order td, 
  table.error th, 
 table.error td, 
   table.login th, 
 table.login td, 
 table.list th, 
 table.list td{border-left:1px solid silver; border-bottom:1px solid silver; vertical-align:top; padding:3px}
table td.topTd{background:url(../images/bgline.gif) repeat-x; border-bottom:1pt solid gray;padding:0px;}
table td.bottomTd{background:url(../images/bgline.gif) repeat-x; border-bottom:1pt solid gray;padding:0px;}
table th.active, td.active{background-color:#CFC}
table tr.row{background-color:#FFF}
table tr.active{background-color:#CFC}
table th.head{background:url(../images/titlebg.gif) repeat-x; background-position:12px 45%; padding-left:25px; color:white}

.over{background-color:#CFC}
.out{background-color:#FFF}
.down{background-color:#CF9}
.click{background-color:#CC3}

</style>

<script type="text/javascript" src="__PUBLIC__/Js/jquery-1.8.3.min.js"></script>

<div class="box">
	<!--
    <div class="left_col">
        <div class="medium hMargin" ><b>视频管理</b></div>
        <div class="medium hMargin" ><input type="button" id="" name="add" value="我上传的" onclick="user_video();" class="medium" /></div>
        <div class="medium hMargin" ><input type="button" id="" name="add" value="我连播的" onclick="continuous();" class="medium" /></div>

        <div class="medium hMargin" ><input type="button" id="" name="add" value="我收藏的" onclick="user_collect();" class="medium" /></div>
        <div class="medium hMargin" ><b>专辑管理</b></div>
        <div class="medium hMargin" ><input type="button" id="" name="add" value="我创建的" onclick="user_special();" class="medium" /></div>
    </div>
	-->
    <div class="right_col">
        <div class="operate" >
            <div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="上传" onclick="upload();" class="add imgButton"></div>
            <div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="edit" value="编辑" onclick="edit()" class="edit imgButton"></div>
            <div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="del" value="删除" onclick="del()" class="del imgButton"></div>
            <div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="special" value="专辑" onclick="user_special();" class="special imgButton"></div>
            <div class="fRig">
            <form method='post' action="__URL__/video_index">
                <div class="fLeft"><span id="key"><input type="text" name="title" title="视频查询" class="medium" ></span></div>
                <div class="impBtn hMargin fLeft shadow" ><input type="submit" id="" name="search" value="查询" onclick="" class="search imgButton"></div>
            </div>
            <div  id="searchM" class=" none search cBoth" ></div>
            </form>
        </div>
        
        <div class="list" >
            <!-- Think 系统列表组件开始 -->
<table id="checkList" class="list" cellpadding=0 cellspacing=0 ><tr><td height="5" colspan="5" class="topTd" ></td></tr><tr class="row" ><th width="8"><input type="checkbox" id="check" onclick="CheckAll('checkList')"></th><th width="30%"><a href="javascript:sortBy('title','<?php echo ($sort); ?>','video_index')" title="按照标题<?php echo ($sortType); ?> ">标题<?php if(($order) == "title"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="16%"><a href="javascript:sortBy('dateline','<?php echo ($sort); ?>','video_index')" title="按照添加时间<?php echo ($sortType); ?> ">添加时间<?php if(($order) == "dateline"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="6%"><a href="javascript:sortBy('status','<?php echo ($sort); ?>','video_index')" title="按照状态<?php echo ($sortType); ?> ">状态<?php if(($order) == "situation"): ?><img src="../Public/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th >操作</th></tr><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><tr class="row" onmouseover="over(event)" onmouseout="out(event)" onclick="change(event)" ><td><input type="checkbox" name="key"	value="<?php echo ($video["vid"]); ?>"></td><td><a href="javascript:play('<?php echo (addslashes($video["vid"])); ?>')"><?php echo ($video["title"]); ?></a></td><td><?php echo (todate($video["dateline"],'Y-m-d H#i#s')); ?></td><td><?php echo ($video["situation"]); ?></td><td><a href="javascript:edit('<?php echo ($video["vid"]); ?>')">编辑视频</a>&nbsp;<a href="javascript:delVideo('<?php echo ($video["vid"]); ?>')">删除视频</a>&nbsp;</td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td height="5" colspan="5" class="bottomTd"></td></tr></table>
<!-- Think 系统列表组件结束 -->

            <input type="hidden" id="AuditList" value="<?php echo ($AuditList); ?>" />
        </div>
        <div class="paging"><?php echo ($page); ?></div>
    </div>
</div>

<script language="JavaScript">
function user_video(){
    location.href  = '<?php echo U('Home/Video/video_index');?>';
}
function user_collect(){
alert('不提供');
    //location.href  = '<?php echo U('Home/Video/collect_index');?>';
}
function user_special(){
    location.href  = '<?php echo U('Home/VideoSpecial/index');?>';
}
function play(id){
    auditList = $('#AuditList').val();
    var reg = "/("+id+")/";
    regresult = auditList.match(eval(reg));
    if(regresult){
        location.href  = '__APP__/Home/Play/index/vid/'+id;
    }else{
        alert('视频没有审核通过');
    }
}
function upload(id){
	if (id)
	{
		 location.href  = '<?php echo U('Home/Upload/index');?>';
	}else{
		 location.href  = '<?php echo U('Home/Upload/index');?>';
	}
}
function delVideo(id){
    if(id) {
        location.href  = '__URL__/foreverdelete/vid/'+id;
    }else{
        location.href  = '<?php echo U('Home/Video/foreverdelete');?>';
    }
}
function del(id){
	var keyValue;
	if (id)
	{
		keyValue = id;
	}else {
		keyValue = getSelectCheckboxValues();
	}
	if (!keyValue)
	{
		alert('请选择删除项！');
		return false;
	}

	if (window.confirm('确实要删除选择项吗？'))
	{
        location.href =  URL+"/foreverdelete/vid/"+keyValue;
		//ThinkAjax.send(URL+"/foreverdelete/","vid="+keyValue+'&ajax=1',doDelete);
	}
}
function sortBy (field,sort){
	location.href = URL+"/video_index/&_order="+field+"&_sort="+sort;
}
</script>


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