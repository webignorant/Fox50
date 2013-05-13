<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#backdata{
    width:100%;
	height:200px;
	white-space:normal;
	word-break:break-all;
	border:#CCC solid 1px;
	padding:10px;
}
#recoverdata{
  width:100%;
  height:200px;
  white-space:normal;
  word-break:break-all;
  margin-top:10px;
  border:#CCC solid 1px;
  padding:10px;
  
}
#backtable{
  width:100%;
  height:200px;
  	white-space:normal;
	word-break:break-all;
  margin-top:10px;
  border:#CCC solid 1px;
  padding:10px;
}

#recovertable{
  width:100%;
  height:200px;
  	white-space:normal;
	word-break:break-all;
  margin-top:10px;
  border:#CCC solid 1px;
  padding:10px;
}

</style>
</head>

<body>
<div id="sql_index">
<!--
<a href="__URL__/bakdata">备份数据</a>
<a href="__URL__/recoverdata">恢复数据</a>
</div>
-->

<div id="backdata">
    <h5 style="margin-left:45%;">备份数据</h5>
    <form action="__URL__/backdata" method="post">
        <?php if(is_array($tablelist)): $i = 0; $__LIST__ = $tablelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><input type="checkbox" name="ch[]" value="<?php echo ($temp); ?>" /><?php echo ($temp); endforeach; endif; else: echo "" ;endif; ?>
        
        <br />
        <input type="submit" value="备份选中的数据" />
    </form>
   
</div>

<div id="recoverdata">
<h5 style="margin-left:45%;">恢复数据</h5>

    <form action="__URL__/redata" method="post">
    <?php if(is_array($redata)): $i = 0; $__LIST__ = $redata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><input type="checkbox" name="rech[]" value="<?php echo ($temp); ?>" /><?php echo ($temp); endforeach; endif; else: echo "" ;endif; ?>
          <br />
        <input type="submit" value="恢复选中的数据" />
    </form>
</div>


<div id="backtable">
<h5 style="margin-left:45%;">备份数据表结构</h5>
<form action="__URL__/backtable" method="post">
    <?php if(is_array($tablelist)): $i = 0; $__LIST__ = $tablelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><input type="checkbox" name="cht[]" value="<?php echo ($temp); ?>" /><?php echo ($temp); endforeach; endif; else: echo "" ;endif; ?>
    <br />
    <input type="submit" value="备份选中的数据" />
    </form>
</div>


<div id="recovertable">
<h5 style="margin-left:45%;">恢复数据表结构</h5>
<form action="__URL__/retable" method="post">
    <?php if(is_array($retable)): $i = 0; $__LIST__ = $retable;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><input type="checkbox" name="recht[]" value="<?php echo ($temp); ?>" /><?php echo ($temp); endforeach; endif; else: echo "" ;endif; ?>
        <br />
    <input type="submit" value="恢复选中的数据" />
    </form>
</div>



</body>
</html>