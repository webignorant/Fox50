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

<script src="../Public/js/ajax.js"></script>
<script type="text/javascript" src="../Public/play/swfobject.js"></script>

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
</div>

<style>
.discusscontent_list_li{
	           position:relative;
      }
.discussontent_list_span{position:absolute;right:10px;}
.container{
	width:598px;
	height:130px;
	margin:40px auto;
	overflow:hidden;
	position:relative;
	-moz-user-select:none;
}
.presswraper{
	height:100px;
	border:1px solid #ddd;
	background-color:#f1f1f1;
}
.press{
	line-height:100px;
	white-space:nowrap;
	position:absolute;
	left:0px;
	top:0px;
}
.container2{
	width:685px;
	height:130px;
	margin:0px auto;
	overflow:hidden;
	position:relative;
	-moz-user-select:none;
}
.container2 ul{
	width:10000px;
	position:absolute;
	left:0px;
	top:0px;
	padding:0;
	margin:0;
}
.container2 ul li{
	height:100px;
	width:133px;
	float:left;
	line-height:90px;
	text-align:center;
	background:#eee;
	padding:0;
	margin-right:20px;
	list-style-type:none;
}
.container2 ul .playlistnum{
	height:100px;
	width:10px;
	float:left;
	line-height:90px;
	text-align:center;
	background:#eee;
	padding:0;
	margin-right:2px;
	list-style-type:none;
}
.container2 ul li img{border:1px solid #ccc; padding:2px;}

     <!--选项卡-->
					  #videocard-title{
						   width:262px;
						   height:35px;
					  }
					  h4{
						 width:128px;
						 height:35px;
						 margin-right:1px;
						 border:#CCC solid 1px;
						 float:left;
					  }
					  #videocard{
						  width:262px;
						  height:279px;
					  }
					  #videocard-content{
						  width:262px;
						  height:245px;
						  padding:2px;
						  margin:0;
						  background:#FFF;
						  word-break:break-all;
					  }
					  #videocard-content ul li{
						  border-bottom:#CCC dashed 1px;
						  margin-top:2px;
						  width:255px;
						  height:25px;
						  line-height:25px;
						  word-break:break-all;
						  overflow:hidden;
					  }
					  .videotitle-right{
						  margin-right:0;
					  }
					  .videotitle{
						  background:#FFF;
						  border-bottom:none;
						  border-right:none;
					  }
					   h4 a,h4 a:hover{
						  width:131px;
						  height:35px;
						  line-height:35px;
						  font-size:15px;
						  float:left;
						  text-decoration:none;
						  text-align:center;
						  text-decoration:none;
						  color:#333;
					  }
					  
					  


				    #card_tab{width:683px;height:355px;}
					#card_tab_tit ul li{width:150px;height:35px;text-align:center;float:left;}
					#card_tab_tit ul li a{width:150px;height:35px;margin-right:2px;line-height:35px;font-size:16px;text-decoration:none;}
					#card_tab_tit_one{width:683px;height:35px;border:#e7f2fd solid 1px;}
			        .default_cla{border:#999 solid 1px;border-left:none;border-top:none;}
					.nodefault_one{border-bottom-color:#FFF;background:#e7f2fd;}
					.nodefault_two{background:#f1f8ff;border-bottom-color:#FFF;}
					.con-li{float:left;}
                    #card_tab_content{width:683px; height:320px;border:#e7f2fd solid 1px; border-top:none;}
					#content-two{width:150px;height:150px;padding-left:10px;padding-right:5px;padding-top:5px;}
					#content-title{position:absolute;left:-20px;}
					#content-one-02{width:683px;height:355px;padding-left:10px;}
					#content-one-02 ul li{width:35px;height:25px;border:#CCC solid 1px;margin:5px;text-align:center;line-height:25px;float:left;}
</style>

<!-- 问题 -->
<div class="mplay-bg">
    ﻿<div class="play-area">
        <div class="play-title"><?php echo ($videotitle); ?></div>
        <div id="nav1-l"></div>
        <script type="text/javascript">
		//获取简介
		function newvideoinfo(cad){
		  	var e_ajax = new Ajax();
			var videoinfo=document.getElementById("new_video_info");
			var cid=cad;
                e_ajax.post("__URL__/newvideoinfo" ,{vid:cid},function(data){												   
                  videoinfo.innerHTML=data;
				  $(".play-title").text($(".mv-title").attr("title"));
                });
		}
            function yuh(date){
			
                 if(!date==''){
                 iop=date;
                var so = new SWFObject("../Public/play/CuPlayerMiniV3_Black_S.swf","nav1-l","960","520","9","#000000");
                so.addParam("allowfullscreen","true");
                so.addParam("allowscriptaccess","always");
                so.addParam("wmode","opaque");
                so.addParam("quality","high");
                so.addParam("salign","lt");
                so.addVariable("CuPlayerFile",iop);
                so.addVariable("CuPlayerImage","Images/flashChangfa2.jpg");
                so.addVariable("CuPlayerLogo","Images/logo.png");
                so.addVariable("CuPlayerShowImage","true");
                so.addVariable("CuPlayerWidth","960");
                so.addVariable("CuPlayerHeight","520");
                so.addVariable("CuPlayerAutoPlay","true");
                so.addVariable("CuPlayerAutoRepeat","false");
                so.addVariable("CuPlayerShowControl","true");
                so.addVariable("CuPlayerAutoHideControl","false");
                so.addVariable("CuPlayerAutoHideTime","6");
                so.addVariable("CuPlayerVolume","80");
                so.addVariable("CuPlayerGetNext","true");
                so.write("nav1-l");
                 }else{
                  alert(date);
                 // location.href='http://www.baidu.com'
                 }
               }
                var url_ajax_k=new Ajax();	   
                url_ajax_k.get("__URL__/geturl/vid/" + <?php echo ($vid); ?>,yuh);
		var CuPlayerList = "<?php echo ($lianlook); ?>";
		var sp =CuPlayerList.split("--");
		var num = sp.length;
		var video_index = 0;
		//播放下集触发函数
		function getNext(pars){	  
		  if(video_index < num-2){
				if(sp[video_index].split("||")[0] != ''){
					var url_ajax_k=new Ajax();
				    url_ajax_k.get("__URL__/geturl/vid/" + sp[video_index].split("||")[0],yuh);
					$(".play-title").text(sp[video_index].split("||")[1]);
					newvideoinfo(sp[video_index].split("||")[0]);
				    video_index++;	
				}
			}else{
			   video_index = 0;
			   var url_ajax_k=new Ajax();
			   url_ajax_k.get("__URL__/geturl/vid/" + sp[video_index].split("||")[0],yuh);
			   $(".play-title").test(sp[video_index].split("||")[1]);
			   newvideoinfo(sp[video_index].split("||")[0]);
			   video_index++;
			}
		}
		function changeStream(CuPlayerFile){
		so.addVariable("CuPlayerFile",sp[CuPlayerFile]);
		so.write("nav1-l");	
		}
        </script>
    </div>
</div>
  
<div class="mov_play_box">
    <div class="mov_play_l_box">
    <!--视频列表-->
        <div class="bd">
            <span class="tl"></span><span class="tr"></span>
            <div class="ct">
                <div class="hd">
                    <h3>视频列表</h3><br>
                </div>
                <div id="card_tab">
                  <!--  标题 -->
                  <div id="card_tab_tit">
                       <div id="card_tab_tit_one"><ul>
                               <li id="card_tab_tit01" class="default_cla nodefault_one"><a name="__URL__/recommended/vid/<?php echo ($_GET['vid']); ?>">推荐影片</a></li>
                               <li class="default_cla"><a name="__URL__/video_list/vid/<?php echo ($_GET['vid']); ?>">剧集列表</a></li>
                               <li class="default_cla"><a name="__URL__/alllook/vid/<?php echo ($_GET['vid']); ?>">大家都在看</a></li>
                             </ul></div></div>
                  <!--  内容 -->
                  <div id="card_tab_content"></div>
               </div>
                  <script>
				  var dt_one=null;
			      $("#card_tab_content").load("__URL__/recommended/vid/<?php echo ($_GET['vid']); ?>");
				  $("#card_tab_tit ul li").hover(function (){
										   var carone01=$(this);
										   dt_one = setTimeout(function (){
										   carone01.addClass("nodefault_two").siblings("li").removeClass("nodefault_two");
										   $("#card_tab_tit01").removeClass("nodefault_one");
										   
										   $("#card_tab_content").load(carone01.children("a").eq(0).attr("name"));
										   },200);
										},function (){clearTimeout(dt_one);});
				  //跳转函数
				  function t_url(num){
					  location.href="__APP__/Home/Play/index/vid/" + num;
				  }
				  </script>
                  
                
                
            </div>
            <span class="bl"></span><span class="br"></span> 
        </div>
    <!--视频分享-->
        <br />
        <div class="bd">
            <span class="tl"></span><span class="tr"></span>
            <div class="ct">
                <div class="hd">
                    <h3>视频分享</h3><br>
                </div>
                <ul class="mov_pic_list">
                    <span class="options">
                        <!--分享到开心网代码-->
                        <a href="javascript:d=document;t=d.selection?(d.selection.type!='None'?d.selection.createRange().text:''):(d.getSelection?d.getSelection():'');void(kaixin=window.open('http://www.kaixin001.com/~repaste/repaste.php?&amp;rurl='+escape(d.location.href)+'&amp;rtitle='+escape(d.title)+'&amp;rcontent='+escape(d.title),'kaixin'));kaixin.focus();"><img src="http://www.ecshop120.com/images/toshare/ico_kaixin.gif" alt="转贴到开心网"  border="0" height="16" width="16"></a> 
                        <!--分享到人人网代码--放弃
                        <a name="xn_share" type="icon_count_right" href="#">分享</a><script src="http://static.connect.renren.com/js/share.js" type="text/javascript"></script>
                        -->
                        <!--分享到QQ空间代码-->
                        <a href="javascript:void(0);" onclick="window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+encodeURIComponent(document.location.href));return false;" title="分享到QQ空间"><img src="http://qzonestyle.gtimg.cn/ac/qzone_v5/app/app_share/qz_logo.png" alt="分享到QQ空间"  title="分享到QQ空间"/></a>
                        <!--分享到QQ书签代码-->
                        <a href="javascript:window.open('http://shuqian.qq.com/post?from=3&title='+encodeURIComponent(document.title)+'&uri='+encodeURIComponent(document.location.href)+'&jumpback=2&noui=1','favit','');void(0)"><img src="http://www.ecshop120.com/images/toshare/ico_qqshuqian.gif" alt="QQ书签" title="QQ书签" border="0" ></a> 
                        <!--分享到百度搜藏代码-->
                        <a href="javascript:window.open('http://cang.baidu.com/do/add?it='+encodeURIComponent(document.title.substring(0,76))+'&iu='+encodeURIComponent(location.href)+'&fr=ien#nw=1','_blank','scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes'); void 0" ><IMG alt="添加到百度搜藏" title="添加到百度搜藏" src="http://www.ecshop120.com/images/toshare/ico_soucang.gif"  border=0></a> 
                        <!--腾讯微博分享按钮-->
                        <a href="javascript:void(0)" onclick="postToWb();" class="tmblog"><img  alt="分享到腾讯微博" title="分享到腾讯微博"src="http://v.t.qq.com/share/images/s/weiboicon16.png"></a> <script type="text/javascript"> 
                        function postToWb(){ 
                        var _t = encodeURI(document.title); 
                        var _url = encodeURI(document.location); 
                        var _appkey = encodeURI("appkey");//你从腾讯获得的appkey 
                        var _pic = encodeURI('');//（列如：var _pic='图片url1|图片url2|图片url3....） 
                        var _site = 'http://www.fox50.com.cn';//你的网站地址 
                        var _u = 'http://v.t.qq.com/share/share.php?title='+_t+'&url='+_url+'&appkey='+_appkey+'&site='+_site+'&pic='+_pic; 
                        window.open( _u,'转播到腾讯微博', 'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no' ); 
                        } 
                        </script>
                        <!--腾讯微博分享按钮-->
                        
                        <!--新浪微博分享按钮-->
                        <script type="text/javascript" charset="utf-8">
                        (function(){
                          var _w = 16 , _h = 16;
                          var param = {
                            url:location.href,
                            type:'3',
                            count:'', /**是否显示分享数，1显示(可选)*/
                            appkey:'', /**您申请的应用appkey,显示分享来源(可选)*/
                            title:'', /**分享的文字内容(可选，默认为所在页面的title)*/
                            pic:'', /**分享图片的路径(可选)*/
                            ralateUid:'', /**关联用户的UID，分享微博会@该用户(可选)*/
                            language:'zh_cn', /**设置语言，zh_cn|zh_tw(可选)*/
                            rnd:new Date().valueOf()
                          }
                          var temp = [];
                          for( var p in param ){
                            temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
                          }
                          document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
                        })()
                        </script>
                    </span>
                </ul>
                <!--视频收藏-->
                <?php if($favoriteStatus == false): ?><a id="favoriteBtn" href="javascript:setFavorite(1);">收藏</a>
                <?php elseif($favoriteStatus == true): ?>
                    <a id="favoriteBtn" href="javascript:setFavorite(0);">已收藏</a><?php endif; ?>
                <script>
                function setFavorite(status) {
                    if(status == 1) {
                        //Ajax发送
                        web_url = window.location.search;
                        var url_array = web_url.split("vid/");
                        var videoID = url_array[1].split("/");
                        //location.href = "__APP__/Home/VideoFavorite/insert/objid/"+videoID[0]+"/idtype/video";
                        
                        $.post("__APP__/Home/VideoFavorite/insert",{objid: videoID[0],idtype: "video"},function(data){
                            var obj = eval( "(" + data + ")" );
                            if(obj.status == 1) {
                                $('#favoriteBtn').attr({href: "javascript:setFavorite(0);"});
                                $('#favoriteBtn').text('已收藏');
                            }else{
                                alert(obj.info);
                            }
                            //alert("Data Loaded: " + data);
                        });
                        
                    }else{
                        alert('视频已经收藏！');
                    }
                }
                </script>
                
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
               <a href="javascript:void(0);" id="download_two">下载</a>
                     <ul id="downupload_one" style="display:none;">
                      <li><a href="__URL__/locationdownload/vid/<?php echo ($vid); ?>">本地下载</a></li>
                      <li><a href="<?php echo ($downupload['url_thunder']); ?>">迅雷下载</a></li>
                      <li><a href="<?php echo ($downupload['url_flashget']); ?>">快车下载</a></li>
                      <li><a href="<?php echo ($downupload['url_qqdl']); ?>">旋风下载</a></li>
                    </ul>   
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>视频分享代码</a>
    <input type="text" onclick="this.select();" name="poifen" width="300" value="<div id='sharedvideo'><script type='text/javascript' src='<?php echo ($swfobject); ?>'></script><script>var so = new SWFObject('<?php echo ($CuPlayerMiniV3_Black_S); ?>','sharedvideo','640','480','9','#000000');so.addParam('allowfullscreen','true');so.addVariable('CuPlayerFile','<?php echo ($video_fenxiang); ?>');so.addVariable('CuPlayerWidth','640');so.addVariable('CuPlayerHeight','480');so.write('sharedvideo');</script>
</div>" /> <button style="width:60px; height:22px; border:#999 solid 1px; margin-bottom:-2px; font-size:13px;" margin-left:3px;" onclick="poifen();">复制代码</button>
            </div>
            <span class="bl"></span><span class="br"></span> 
        </div>
    <!--影片评论-->
        <br />
        <div class="bd">
            <span class="tl"></span><span class="tr"></span>
            <div class="ct">
                <div class="hd"><h3>视频评论</h3></div>
<!--*****************评论*******************-->
                <div id="discusscontent">
                  <br />
                 　　没有相关评论!
                </div>
<script type="text/javascript">
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
     setPage('__URL__/comment/vid/<?php echo ($vid); ?>/page/1&aa='+Math.random(),0);
      
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
                b_ajax.post("__URL__/addcomment" ,{vid:<?php echo ($vid); ?>,uid:<?php echo ($userid); ?>,comnemt:document.getElementById('comment_content').value},function(data){
                  if(data==1){
                      alert('评论成功！');
					  setPage('__URL__/comment/vid/<?php echo ($vid); ?>/page/1&aa='+Math.random(),0); 
					  document.getElementById('comment_content').value = '';
                  }else if(data==0){
                      alert('评论失败!');
                  }else{
                      alert('请先登录!');
                  }
                });
            }
        }
        
    function setretun(name){
        document.getElementById('comment_content').value='@' + name + ':';
    }
</script>
<!--*****************评论*******************-->
                <div id="Comments">
                    <div class="form">
                        <textarea type="text" name="content" id="comment_content" rows="5" onFocus="if(this.value=='我来评论，最多200个字。'){this.value='';}" onBlur="if(this.value==''){this.value='我来评论，最多200个字。';};" maxlength="200" class="txt_in ">我来评论，最多200个字。</textarea>
                        <p class="under_row"><input id="comment_button" class="submit" onClick="setconment();" type="button" value="发表评论"></p>
                    </div>
                </div>
            </div>
            <span class="bl"></span><span class="br"></span> 
        </div>  
    </div>
      
    <div class="mov_play_r_box">
        <div class="bd">
            <span class="tl"></span><span class="tr"></span>
            <div class="ct">
                <div class="play-rating"></div>
                
                <div id="videocard">
                   <div id="videocard-title">
                     <h4 class="videotitle"><a name="__URL__/relevance/vid/<?php echo ($vid); ?>">视频续集</a></h4>
                     <h4><a name="__URL__/likevideo" class="videotitle-right">相关影片</a></h4>
                   </div> 
                   <div id="videocard-content"></div>
                </div>
                <script>
				  var dt=null;
				  $("#videocard-content").load("__URL__/relevance/vid/<?php echo ($vid); ?>");
				  $("#videocard-title h4").hover(function (){
										   var si=$(this);
										   dt = setTimeout(function (){
												 si.addClass("videotitle").siblings("h4").removeClass("videotitle");$("#videocard-content").load(si.children("a").eq(0).attr("name"));},200);
										},function (){clearTimeout(dt);});
				  //点击播放视频
				 function  videostart(){
					  $("#videocard-content ul li").mouseover(function(){$(this).css("background","#CFF");}).mouseout(function(){$(this).css("background","#FFF");});
					  $("#videocard-content ul li").click(function(){
														// var url_ajax_su=new Ajax();// url_ajax_su.get("__URL__/geturl/vid/" + $(this).attr("name"),yuh);// newvideoinfo($(this).attr("name"));
														window.location.href = "__APP__/Home/Play/index/vid/" + $(this).attr("name");});
				  }
				  //复制
				  function poifen(){
					 if(typeof window.clipboardData == "undefined"){
						 alert('该浏览器不支持复制，请手动复制右边HTML代码！');
					 }else{
					   if(window.clipboardData.setData("text",document.getElementById('photo_viewer_main').childNodes[0].data) != true){
						  alert('复制失败，请手动复制右边HTML代码！');
					   }else{
							 alert('复制成功！');  
						  }
					 }  
				  }
				  //下载
				  var download_o = true;
				  $("#download_two").click(function(){
													 if(download_o){
													   $("#downupload_one").css("display","block");
													   download_o = false;
													 }
													 else{
													   $("#downupload_one").css("display","none");
													   download_o = true;
													 }
													});
				</script>
                
                <div id="new_video_info">
                        <div class="info">
                            <span class="mv-title" title="<?php echo ($videos['title']); ?>"> <a href="__GROUP__/Play/index?vid=<?php echo ($videos['vid']); ?>" title="<?php echo ($videos['title']); ?>"><?php echo ($videos['title']); ?></a></span>
							<?php if(in_array(($catid), explode(',',"1,2"))): ?><p>主演：<?php echo ($videos['actor']); ?></p>
                            <p>导演：<?php echo ($videos['director']); ?></p><?php endif; ?>
                            <p>地区：<?php echo ($video_region); ?> </p>
                            <p>上映年份：<?php echo ($videos['year']); ?> </p>
                            <p>更新日期：<?php echo (date("Y-m-d",$videos['dateline'])); ?></p>
                            <p>上传者：<?php echo ($uploadUser); ?></p>
                            <p>点击数：<?php echo ($count['viewnum']); ?></p>
                        </div>
                <div class="intro">
                    <p class="title">剧情介绍：</p>
                    <div class="intro_cont">
                        <?php echo ($videos['about']); ?>
                    </div>
                </div>
                
                </div>
                
            </div>
            <span class="bl"></span><span class="br"></span>
        </div>
    </div>

</div>

<div display="none" id="photo_viewer_main">
<!--
<div id="sharedvideo">
    <script type="text/javascript" src="<?php echo ($swfobject); ?>"></script>
    <script>
        var so = new SWFObject("<?php echo ($CuPlayerMiniV3_Black_S); ?>","sharedvideo","640","480","9","#000000");
                    so.addParam("allowfullscreen","true");
                    so.addVariable("CuPlayerFile","<?php echo ($video_fenxiang); ?>");
                    so.addVariable("CuPlayerWidth","640");
                    so.addVariable("CuPlayerHeight","480");
                    so.write("sharedvideo");
    </script>
</div>
-->
</div>

﻿<div id="footer">
    Copyright ? 2012 - 2013 <a href="http://localhost/">fox50</a> Some Rights Reserved 粤ICP备10038672号 <br>
</div>

    </body>
</html>