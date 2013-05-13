window.onload = function(){
  if(self!=top){top.location=self.location;}
}

//检查邮箱
function checkemail(){
	var reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	var temp = document.getElementById("email");
 if(!reg.test(temp.value)){
   alert('请输入有效的E-mail!');
   return false;
 }else{
   return true; 
 }
}

function showagree(){
	var offset = $("#syxy").offset();
	var left = offset.left/2;
	var top = offset.top/2;
	$("#showagree").toggleClass("regnone"); 
	$("#showagree").css({left:left,top:top,display:""});
}
function closereg(){
	$("#showagree").hide();
}
//检查表单
function checkform(){
	//账户名不能为空
	if(!$('#username').val()){
		alert($('#username').attr('error'));
		$('#username').focus();
		return false;
	}
	//用户名跟密码不能相同
	if($('#username').val() == $('#userpwd').val()){
		alert('用户名跟密码不能相同!');
		$('#userpwd').focus();
		return false;
	}
	//邮箱不能为空
	if(!$('#email').val()){
		alert($('#email').attr('error'));
		$('#email').focus();
		return false;
	}
	//密码不能为空
	if(!$('#userpwd').val()){
		alert($('#userpwd').attr('error'));
		$('#userpwd').focus();
		return false;
	}
	
    if($('#userpwd').val().length < 5){
        alert('密码不能为空而且需要5位以上');
        $('#userpwd').focus();
        return false;
    }
	
	//两次输入的密码不一样
	if($("#userpwd").val() != $("#reuserpwd").val()){
		alert($('#reuserpwd').attr('error'));
		$('#reuserpwd').focus();
		return false;
	}
	
    if(!$('#question').val()){
        alert($('#question').attr('error'));
        $('#question').focus();
        return false;
    }

    if($('#question').val().length > 10){
        alert('密保问题不能大于十个中文');
        $('#question').focus();
        return false;
    }
    
    if(!$('#answer').val()){
        alert($('#answer').attr('error'));
        $('#answer').focus();
        return false;
    }
    
    if(!$('#answer').val().length > 10){
        alert('密保答案不能大于十个中文');
        $('#answer').focus();
        return false;
    }
    
	//同意协议才能注册为本网站用户
	if(!$('#check').attr('checked')){
		alert($('#check').attr('error'));
		$('#check').focus();
		return false;
	}
	//检查有效的邮箱
	if(!checkemail()){
	   return false;
	}
}


function onpass(){
    if($("input[name='userpwd']").val() != $("input[name='reuserpwd']").val()){
        alert('两次密码不一致!');
        $("#userpwd").focus();
    }
}
  

