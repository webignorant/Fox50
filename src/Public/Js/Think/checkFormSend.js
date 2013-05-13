//基于ThinkAjax
//用于检测某个字段是否合法，并且提交表单
//默认php检测方法为checkName(),;

/* 类封装，放弃
var checkFormSend = {
    
}
*/

submitResultCheck = false; //判断是否允许提交表单
dbmode = 'update'; //ajax提交给后端的方法

/**
 * 检查指定名称是否合法
 * @checkname 需要检查的Input的ID
 * 返回值: 无
 * 回调方法: setFormSubmit
 */
function checkName(checkname, mode){
    submitResultCheck = false;
    dbmode = mode;
    switch(dbmode) {
        case 'add':
            ThinkAjax.send(URL+'/checkName/','ajax=1&mode=insert&'+checkname+'='+$F(checkname),setFormSubmit);
            break;
        case 'set':
            ThinkAjax.send(URL+'/checkName/','ajax=1&mode=update&'+checkname+'='+$F(checkname),setFormSubmit);
            break;
        default:alert('表单语法编写错误，checkName()缺少mode');
    }
}
/**
 * 设置表单是否允许提交的状态
 * @data 回调返回的data
 * @status 回调返回的status
 * 返回值: 无
 * 回调方法: 无
 */
function setFormSubmit(data,status){
    if(status != 0){
        //document.getElementById("submitResult").value = "true";
        submitResultCheck = true;
    }else{
        //document.getElementById("submitResult").value = "false";
        submitResultCheck = false;
    }
}
/**
 * 检查表单是否允许提交
 * @checkname 需要检查的Input的ID
 * @mode 需要执行的数据库模式 add,set
 * 返回值: 无
 * 回调方法: sendFormSubmit
 */
function checkForm(checkname, mode){
    var check_name = document.getElementById(checkname).value;
    if(check_name == ''){
        document.getElementById(checkname).focus();
        return false;
    }
    //设置模式，发送需要检查的信息
    dbmode = mode;
    switch(dbmode) {
        case 'add':
            ThinkAjax.send(URL+'/checkName/','ajax=1&mode=insert&'+checkname+'='+$F(checkname),sendFormSubmit);
            break;
        case 'set':
            ThinkAjax.send(URL+'/checkName/','ajax=1&mode=update&'+checkname+'='+$F(checkname),sendFormSubmit);
            break;
        default:alert('表单语法编写错误，checkName()缺少mode');
    }
}
/**
 * 检查表单是否允许提交给update方法
 * @data 回调返回的data
 * @status 回调返回的status
 * 返回值: Ajax返回结果
 * 回调方法: 无
 */
function sendFormSubmit(data,status){
    if(status != 0){
        submitResultCheck = true;
    }else{
        submitResultCheck = false;
    }
    if(!submitResultCheck){
        document.getElementById(checkname).focus();
    }else{
        //判断模式，发送调用后台方法
        switch(dbmode) {
            case 'add':
                ThinkAjax.sendForm('form1',URL+'/insert/',goLocation);
                break;
            case 'set':
                ThinkAjax.sendForm('form1',URL+'/update/');
                break;
            default :alert('表单语法编写错误，checkForm()缺少mode');
        }
    }
}
/**
 * 判断模式跳转路径
 * @data 回调返回的data
 * @status 回调返回的status
 * 返回值: Ajax返回结果
 * 回调方法: 无
 */
function goLocation(data, status) {
    if(status){
        //判断模式，跳转
        switch(dbmode) {
            case 'add':
                timerObj  =setTimeout("window.parent.frames.main.location.reload();",3000);
                break;
            case 'set':
                location.href = URL;
                break;
        }
    }
}