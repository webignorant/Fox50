=========我是分界线======================================================
 
控制器里写入以下内容：
 
<?php
class UserAction extends Action{
    public function user(){
          import("ORG.Util.AjaxPage");// 导入分页类  注意导入的是自己写的AjaxPage类
          $credit = M('user');
          $count = $credit->count(); //计算记录数
        $limitRows = 5; // 设置每页记录数
       
        $p = new AjaxPage($count, $limitRows,"user"); //第三个参数是你需要调用换页的ajax函数名
        $limit_value = $p->firstRow . "," . $p->listRows;
       
        $data = $credit->order('id desc')->limit($limit_value)->select(); // 查询数据
        $page = $p->show(); // 产生分页信息，AJAX的连接在此处生成

        $this->assign('list',$data);
        $this->assign('page',$page);
        $this->display();

     }
}
 
=========我是分界线======================================================
 
模板文件如下：
 
<html>
    <head>
        <title>Ajax无刷新分页</title>
        <script type="text/javascript" src="../Public/jquery-1.7.2.min.js"></script>
        <script type="text/javascript">
            function user(id){    //user函数名 一定要和action中的第三个参数一致上面有
                 var id = id;
                    $.get('User/user', {'p':id}, function(data){  //用get方法发送信息到UserAction中的user方法
                     $("#user").replaceWith("<div  id='user'>"+data+"</div>"); //user一定要和tpl中的一致
                });
             }
            
        </script>
    </head>

    <body>
            <div id='user'>   <!--这里的user和下面js中的test要一致-->
                    <volist id='list' name='list'>   <!--内容输出-->
                    <{$list.id}>&nbsp;&nbsp;<{$list.username}><br/>
            </volist>
            <{$page}>  <!--分页输出-->
        </div>
        
    </body>
</html>