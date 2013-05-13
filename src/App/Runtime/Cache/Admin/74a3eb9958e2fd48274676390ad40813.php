<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link rel='stylesheet' type='text/css' href='__PUBLIC__/Css/style.css'>
            <style>
                html{overflow-x : hidden;}
            </style>
        <base target="main" />
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/blue.css" />
        <script type="text/javascript" src="__PUBLIC__/Js/Base.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Js/prototype.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Js/mootools.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Js/Think/ThinkAjax.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Js/Form/common.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Js/Form/CheckForm.js"></script>
        <script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
    </head>

    <body >
        <div id="menu" class="menu">
            <table class="list shadow" cellpadding=0 cellspacing=0 >
                <tr>
                    <td height='3' colspan=1 class="topTd" ></td>
                </tr>
                <tr class="row" >
                    <th class="tCenter space"><img SRC="__PUBLIC__/Images/home.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align="absmiddle"> <?php if(isset($_GET['title'])): echo ($_GET['title']); endif; if(!isset($_GET['title'])): ?>后台首页<?php endif; ?> </th>
                </tr>
                <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if(($item['group_id']) == $menuTag): if((strtolower($item['name'])) != "public"): if((strtolower($item['name'])) != "index"): if(($item['access']) == "1"): ?><tr class="row " >
                                        <td><div style="margin:0px 5px"><img SRC="__PUBLIC__/Images/comment.gif" WIDTH="9" HEIGHT="9" BORDER="0" align="absmiddle" ALT=""> <a href="<?php echo U('Admin/'.$item[name].'/index/');?>" id="<?php echo ($key); ?>" onclick="thidden();"><?php echo ($item['title']); ?></a></div></td>
                                    </tr><?php endif; endif; endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                    <td height='3' colspan=1 class="bottomTd"></td>
                </tr>
            </table>
        </div>
        
        <style>
		   #menu-header ul li{
			   width:160px;
			   height:60px;
			   border:1px solid #ccc;
			   line-height:60px;
			   text-align:center;
			   font-size:22px;
			   list-style:none;
			   background:#F99;
			   clear:both;
		   }
		   #menu-header ul li:hover{
			   background:#CF9;			   
		   }
		</style>
        <div id="menu-header" style="display:none;">
           <ul>
             <li onclick="tongguo();">通过</li>
             <li onclick="href_3();">返回</li>
           </ul>
        </div>
<script language="JavaScript">
<!--
    var changevid = '';//另一窗体改变
	
	function refreshMainFrame(url)
	{
		parent.main.document.location = url;
	}

	if (document.getElementsByTagName("a")[0].href)
	{
        refreshMainFrame(document.getElementsByTagName("a")[0].href);		
	}
	//跳转
	function href_3(){
	  window.parent.parent[3].history.go(-1);
	  document.getElementById('menu-header').style.display = 'none';
	}
	
	function tongguo(){
		 //ThinkAjax.send("<?php echo U('Admin/Video/setVideoStatus');?>",'ajax=1&vid=' + changevid);
		 //window.parent.parent[3].history.go(-1);
		 window.parent.parent[3].location.href ="<?php echo U('Admin/Video/setVideoStatus');?>/vid/"+changevid;
		 document.getElementById('menu-header').style.display = 'none';
	}
	function thidden(){
		document.getElementById('menu-header').style.display = 'none';
	}

//-->
</script>
    </body>
</html>