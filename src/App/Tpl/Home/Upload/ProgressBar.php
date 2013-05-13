<?php 
if ('source' == $_GET['act']) {           //查看源代码 
    show_source($_SERVER["SCRIPT_FILENAME"]); 
    exit; 
}   //end if 
set_time_limit(0); 
for ($i = 0; $i < 500; $i++) {  
   $users[] = 'Tom_' . $i; 
}   //end for 
$width = 500;                      //显示的进度条长度，单位 px 
$total = count($users);     //总共需要操作的记录数 
$pix = $width / $total;        //每条记录的操作所占的进度条单位长度 
$progress = 0;                   //当前进度条长度 
?> 
<html> 
<head> 
    <title>动态显示服务器运行程序的进度条</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" /> 
    <style> 
    body, div input { font-family: Tahoma; font-size: 9pt } 
    </style> 
    <script language="JavaScript"> 
    <!-- 
    function updateProgress(sMsg, iWidth) 
    {  
        document.getElementById("status").innerHTML = sMsg; 
        document.getElementById("progress").style.width = iWidth + "px"; 
        document.getElementById("percent").innerHTML = parseInt(iWidth / <?php echo $width; ?> * 100) + "%"; 
     } 
    //--> 
    </script>     
</head> 

<body> 
<div style="margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: <?php echo $width+8; ?>px"> 
    <div><font color="gray">如下进度条的动态效果由服务器端 PHP 程序结合客户端 JavaScript 程序生成。</font></div> 
    <div style="padding: 0; background-color: white; border: 1px solid navy; width: <?php echo $width; ?>px"> 
    <div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center;   height: 16px"></div>             
    </div> 
    <div id="status">&nbsp;</div> 
    <div id="percent" style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt">0%</div> 
</div> 
<?php 
flush();    //将输出发送给客户端浏览器 
foreach ($users as $user) {  
   //   在此处使用空循环模拟较为耗时的操作，实际应用中需将其替换； 
    //   如果你的操作不耗时，我想你就没必要使用这个脚本了 :) 
   for ($i = 0; $i < 1000000; $i++) {  
        ;; 
     } 
?> 
<script language="JavaScript"> 
    updateProgress("正在操作用户“<?php echo $user; ?>” ....", <?php echo min($width, intval($progress)); ?>); 
</script> 
<?php 
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。 
   $progress += $pix;     
}   //end foreach 
//   最后将进度条设置成最大值 $width，同时显示操作完成 
?> 
<script language="JavaScript"> 
    updateProgress("操作完成！", <?php echo $width; ?>); 
</script> 
<?php 
flush(); 
?> 
<input type="button" value="查看源码" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?act=source'" /> 
</body> 
</html> 