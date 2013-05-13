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
<!--<meta http-equiv="X-UA-Compatible" content="IE=8" />-->
<link rel="stylesheet" type="text/css"  href="__PUBLIC__/Css/upload.css">
<style type="text/css">
.videoManageBtn{
width:130px;height:30px;border: 1px solid gainsboro; background:#FFFFFF
}
.oneUploadBtn{
width:130px;height:30px;border: 1px solid gainsboro; background:#FFFFFF
}
.multiUploadBtn{
width:130px;height:30px;border: 1px solid gainsboro; background:#FFFFFF
}
.reginput{
clear: both;
margin: 20px 0px;
list-style: none;
padding-left: 12px;
}
.necessary{
color:red;
}
</style>
<!--uploadify插件-->
<script type="text/javascript" src="__PUBLIC__/Js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Plugin/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Plugin/uploadify/uploadify.css" />

<div class="mainCol">
    <div id="upload-mian" class="upload-mian" style="background-image:url(__PUBLIC__/images/fox/upload-bg.jpg)" >
        <form method="post" name="from" action="__URL__/upload" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="300000000000000">
        <ul>
            <li>
                <input class="videoManageBtn" type="button" id="videoManageBtn" onclick="videoManage();" value="视频管理" />
                <input class="videoManageBtn" type="button" id="oneUploadBtn" onclick="oneUpload();" value="单文件上传" style="background:white;color:block;"/>
                <input class="videoManageBtn" type="button" id="multiUploadBtn" value="多文件上传" />
                <hr />
            </li>
            <li>
                <div style="width:400px;height:auto;float:left;">
                    <form>
                        <div id="queue"></div>
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <div id="multiOperateBtn" style="display:none">
                            <input class="videoManageBtn" type="button" onclick="multiUploadCheck();" value="开始上传" />
                            <input class="videoManageBtn" type="button" onclick="javascript:$('#file_upload').uploadify('stop','*');" value="停止上传" />
                            <!--
                            <input type="button" onclick="javascript:$('#file_upload').uploadify('disable', false);" value="激活按钮" />
                            <input type="button" onclick="javascript:$('#file_upload').uploadify('disable', true);" value="禁止按钮" />
                            -->
                            <input class="videoManageBtn" type="button" onclick="javascript:$('#file_upload').uploadify('cancel','*');" value="清除队列" />
                        </div>
                    </form>
                </div>
                <div id="result" style="display:none;width:400px;height:auto;float:left;background:#ECFFFF;"></div>
                <div style="clear:both;"></div>
            </li>
            <li class="reginput"><div id="upload_info" style="color: rgb(255, 0, 0)">单视频上传模式，在对话框中选中一个视频，确定后自动上传，视频标题默认取视频文件名</div></li>
            <li class="reginput">视频栏目类型:
                <select id="catid" name="catid" onchange="typeselec(this.value)">
                  <?php if(is_array($catid)): $i = 0; $__LIST__ = $catid;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ca): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ca["id"]); ?>|<?php echo ($ca["catname"]); ?>"><?php echo ($ca["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <span class="necessary">*</span>
            </li>
            <li class="reginput">所属视频类型:
                <select id="typeid" name="type">  
                  <?php if(is_array($vtype)): $i = 0; $__LIST__ = $vtype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($tp["id"]); ?>|<?php echo ($tp["typename"]); ?>"><?php echo ($tp["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <span class="necessary">*</span>
            </li>
            <li class="reginput">所属地区:
                <select id="regionid" name="diqu">
                    <?php if(is_array($region)): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$re): $mod = ($i % 2 );++$i;?><option value="<?php echo ($i); ?>"><?php echo ($re); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <span class="necessary">*</span>
            </li>
            <li class="reginput">视频标题:<input id="videotitle" type="text" name="title" title="标题默认为视频文件名" /><span class="necessary">*</span></li>
            <li id="actorli" class="reginput">主演:<input id="actor" type="text" name="zhuyan" /></li>
            <li id="directorli" class="reginput">导演:<input id="director" type="text" name="daoyan" /></li>
            <li class="reginput">发行年份:
                <select id="year" name="nianfen">
                    <?php if(is_array($year)): $i = 0; $__LIST__ = $year;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ye): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ye); ?>"><?php echo ($ye); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </li>
            <li class="reginput">内容简介:<textarea id="about" name="content"></textarea></li>
            <li class="reginput"><input type="button" id="savevideoinfo" class="saveBtn" title="上传视频" value="视频未上传" /></li>
            <!--隐藏信息-->
            <input type="hidden" id="up_file_name" name="videofile" value="" onchange="return charge();"/>
            <input type="hidden" id="up_file_path" name="videopath" value="" />
            <input type="hidden" id="up_file_extension" name="videoextension" value="" />
            <!--
            <input type="hidden" id="up_file_size" name="videosize" value="" />
            <input type="hidden" id="definition" name="videodefinition" value="" />
            <input type="hidden" id="playtime" name="videoplaytime" value="" />
            <input type="hidden" id="img" name="videoimg" value="" />
            -->
            <li><b>只支持最大为100M的FLV视频格式的上传！</b></li>
            <li><b>推荐使用Google Chrome、IE8以上浏览器访问</b></li>
            <li></li>
        </ul>
        </form>
    </div>
    
</div> 
<script type="text/javascript" src="__PUBLIC__/Js/json.js"></script>

<script type="text/javascript">
    var uploadStatus = false; //判断是否上传完毕
    var multilMode = false;   //判断是否多文件上传
    $(function() {
        $('#file_upload').uploadify({
            'auto'     : true,
            'buttonText' : '上传视频',
            'height' : 30,
            'width' : 100,
            'fileSizeLimit' : '102400KB',
            'fileTypeExts'  : '*.jpg;*.flv;*.mp4;*.avi',
            'fileObjName' : 'uploadFile', //PHP获取$file的名称
            'swf'      : '__PUBLIC__/Plugin/uploadify/uploadify.swf',
            /*'uploader' : '__PUBLIC__/Plugin/uploadify/uploadify.php',*/
            'uploader' : '__URL__/uploadify',
            'multi' : false,
            'queueID' : 'queue',
            'queueSizeLimit' : 999,
            'uploadLimit' : 50,
            'removeCompleted' : false,
            'removeTimeout' : false,
            'requestErrors' : true,
            'successTimeout' : 3600,
            'OnDisable' : function() {
            
            },
            'onCancel'    : function(file) {
                alert('文件[' + file.name + ']已经移除队列!');
            },
            'onClearQueue' : function(queueItemCount) {
                //alert(queueItemCount + ' file(s) were removed from the queue');
                $('#result').empty();
                $('#result').css({display : 'none'});
            },
            'onFallback' : function() {
                //禁用上传按钮
                $('#file_upload').uploadify('disable', true);
                flashcheck= confirm('检测当前浏览器没有兼容的Flash,无法正常执行上传功能!\n请检测浏览器是否禁用Flash功能，并且开启\n点击确定将登录Adobe网站，下载最新的Adobe Flash.');
                if(flashcheck){
                    location.href = 'http://get.adobe.com/cn/flashplayer/';
                }
            },
            'onSelect' : function(file) {  
                this.addPostParam("file_name",encodeURI(file.name));//改变文件名的编码
                //获取并设置表单标题
                if(multilMode == false) {
                    filename = file.name;  //文件名
                    index = filename.lastIndexOf("."); //需要获取的长度
                    videofiletitle = filename.substring(0,index);  //获取
                    $('#videotitle').val(videofiletitle);
                }
                $('#result').empty();
                $('#result').css({display : 'none'});
            },
            'onUploadComplete' : function(file) {
                
            },
            'onUploadStart' : function(file) {
                //禁用上传按钮
                $('#file_upload').uploadify('disable', true);
                //alert('Starting to upload ' + file.name);
            },
            'onUploadSuccess' : function(file, data, response) {
                //alert(response);
                if(multilMode == false){
                    //alert('视频上传成功，请点击表单保存视频信息！');
                }
                //alert('文件上传成功');
                //转换成json数据
                var obj = eval( "(" + data + ")" );
                var fileinfo = eval( "(" + obj.info + ")" );
                //获取并设置视频存放路径
                $('#up_file_path').val(fileinfo.savepath);
                //获取并设置视频文件名
                $('#up_file_name').val(fileinfo.savename);
                //获取并设置视频文件类型
                $('#up_file_extension').val(fileinfo.extension);
                /*
                //获取视频标题
                filename = file.name;  //文件名
                index = filename.lastIndexOf("."); //需要获取的长度
                videofiletitle = filename.substring(0,index);  //获取
                //获取并设置视频大小
                $('#up_file_size').val(fileinfo.size);
                //获取并设置视频清晰度
                $('#definition').val(fileinfo.definition);
                //获取并设置视频播放时间
                $('#playtime').val(fileinfo.playtime);
                //获取并设置视频封面
                $('#img').val(fileinfo.img);
                */
                //显示视频信息表单
                //$('#upload-mian').css({display: "block"});
                //视频信息预显示
                //$('#videotitle').val(videofiletitle);
                
                //写进数据库
                //setVideoInfo();
                if(multilMode == false){
                    //允许保存表单
                    uploadStatus = true;
                    $('#savevideoinfo').val('请保存视频');
                }else{
                    //设置文件名
                    filename = file.name;  //文件名
                    index = filename.lastIndexOf("."); //需要获取的长度
                    videofiletitle = filename.substring(0,index);  //获取
                    $('#videotitle').val(videofiletitle);
                    
                    setMultiVideoInfo();
                }
                
                //激活上传按钮
                $('#file_upload').uploadify('disable', false);
                
                //暂停上传
                $('#file_upload').uploadify('settings','auto',false);
            },
            'onUploadError' : function(file, errorCode, errorMsg, errorString){
                //激活上传按钮
                $('#file_upload').uploadify('disable', false);
                //alert('文件'+file.name+'上传失败');
            },
            'onQueueComplete' : function(queueData){
                
            }
        });
    });
</script>

<script type="text/javascript">
    function setVideoInfo() {
        var catid = $('#catid').val();
        var typeid = $('#typeid').val();
        var regionid = $('#regionid').val();
        var title = $('#videotitle').val();
        var actor = $('#actor').val();
        var director = $('#director').val();
        var year = $('#year').val();
        var about = $('#about').val();
        var filename = $('#up_file_name').val();
        var path = $('#up_file_path').val();
        var extension = $('#up_file_extension').val();
        //alert(catid+' '+typeid+' '+regionid+' '+title+' '+actor+' '+director+' '+year+' '+about+' '+filename+' '+path);
        $(document).ready(function(){
            $.post("__URL__/savaVideoInfo/",
                {catid:catid, typeid:typeid, regionid:regionid, title:title, actor:actor, director:director, year:year, about:about, filename:filename, path:path, extension:extension},
                function(data){
                    //var json_data = eval( "(" data + ")");
                    //var json_data = eval( "(" + data + ")" );
                    //var Info = eval( "(" + data.info + ")" );
                    //alert(Info.title+' '+Info.img);
                    if(data.data == 1){
                        alert(data.info);
                        window.location.reload();
                    }else{
                        alert(data.info);
                    }
                    //不显示视频信息表单
                    //$('#upload-mian').css({display: "none"});
                });
        })
    }
    function setMultiVideoInfo() {
        $(document).ready(function(){
            var catid = $('#catid').val();
            var typeid = $('#typeid').val();
            var regionid = $('#regionid').val();
            var title = $('#videotitle').val();
            var actor = $('#actor').val();
            var director = $('#director').val();
            var year = $('#year').val();
            var about = $('#about').val();
            var filename = $('#up_file_name').val();
            var path = $('#up_file_path').val();
            var extension = $('#up_file_extension').val();
            //alert(catid+' '+typeid+' '+regionid+' '+title+' '+actor+' '+director+' '+year+' '+about+' '+filename+' '+path);
            //alert('文件上传成功');
            $.post("__URL__/savaVideoInfo/",
                {catid:catid, typeid:typeid, regionid:regionid, title:title, actor:actor, director:director, year:year, about:about, filename:filename, path:path, extension:extension},
                function(data){
                    $('#result').show();
                    if(data.data == 1){
                        $('#result').append('标题为['+title+']的视频信息保存成功<br />');
                    }else{
                        $('#result').append(+'标题为['+title+']的视频信息保存失败<br />');
                    }
                });
        })
    }
    function multiUploadCheck() {
        uploadCheck = confirm('批量上传的视频信息确定是如下\n视频栏目：'+$("#catid option:selected").text()+'\n视频类型：'+$('#typeid option:selected').text()+'\n视频地区：'+$('#regionid option:selected').text());
        if(uploadCheck){
            $('#file_upload').uploadify('upload','*');
        }
    }
</script>

<script>
    //JQ鼠标单击事件
    $(document).ready(function(){
        //视频管理
        $('#videoManageBtn').click(function(e){
            e.preventDefault();
            location.href = '__APP__/Home/Video/video_index';
        })
        //单文件上传
        $('#oneUploadBtn').click(function(e){
            e.preventDefault();
                $('#oneUploadBtn').css({background:"#777",color:"#000"});
                $('#multiUploadBtn').css({background:"",color:"#000"});
            //修改
            multilMode = false;
            $('#multiOperateBtn').css({display:"none"});
            $('#upload_info').css({display:"inline"});
            $('#upload_info').text('单视频上传模式，在对话框中选中一个视频，确定后自动上传，视频标题默认取视频文件名');
            $('#file_upload').uploadify('settings','buttonText','选择视频');
            $('#file_upload').uploadify('settings','multi',false);
            $('#file_upload').uploadify('settings','auto',true);
            $('#savevideoinfo').css({display:"block"});
            $('#result').css({display:"none"});
            $("#videotitle").removeAttr("readonly");
            $('#videotitle').css({background:"#FFF"});
            $('#videotitle').val('视频标题自动获取');
        })
        //单文件上传保存按钮
        $('#savevideoinfo').click(function(e){
            e.preventDefault();
            if(uploadStatus == true){
                setVideoInfo();
            }else{
                alert('请先上传视频');
            }
        });
        //多文件上传
        $('#multiUploadBtn').click(function(e){
            e.preventDefault();
                $('#multiUploadBtn').css({background:"#777",color:"#000"});
                $('#oneUploadBtn').css({background:"",color:"#000"});
            //修改
            multilMode = true;
            $('#multiOperateBtn').css({display:"block"});
            $('#upload_info').css({display:"inline"});
            $('#upload_info').text('多视频上传模式，在对话框中选中多个视频，点击开始上传按钮上传，视频标题默认取视频文件名');
            $('#file_upload').uploadify('settings','buttonText','选择多视频');
            $('#file_upload').uploadify('settings','multi',true);
            $('#file_upload').uploadify('settings','auto',false);
            $('#savevideoinfo').css({display:"none"});
            $('#videotitle').attr({readonly:"true"});
            $('#videotitle').css({background:"#CCC"});
            $('#videotitle').val('多文件上传模式下禁用');
        })
        //针对动漫、资讯、生活栏目隐藏演员、导演输入框
        $('#catid').change(function(){
            var cat_value = $('#catid').val();
            cat_index = cat_value.indexOf('|');
            cat_id = cat_value.substring(0,cat_index);
            if(cat_id == 3 || cat_id == 4 || cat_id == 5 || cat_id == 6){
                $('#actorli').hide();
                $('#directorli').hide();
            }else{
                $('#actorli').show();
                $('#directorli').show();
            }
            
        })
        
    })

</script>

<script type="text/javascript">
    function typeselec(typeselect){
        $("#typeid").load('__URL__/typeselect',{typeid:typeselect.split('|')[0]});
    }
    function charge(){
        var filename = document.getElementById('up_file').value;
        var file_type = filename.substring(filename.lastIndexOf(".")+1);
        if(!(file_type == "mp4" || file_type == "flv" || file_type == "avi"))
           alert ("目前只支持mp4、flv、avi格式");
        
    }
</script>

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