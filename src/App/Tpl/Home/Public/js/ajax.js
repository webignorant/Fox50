
 function Ajax(recvType){
	 var aj=new Object();
	 aj.recvType=recvType ? recvType.toUpperCase() : 'HTML' //用于判断是用来干什么的，可以不传参数，可以传HTML或XML，如果是XML则返回的是对象。
	 
	 aj.targetUrl='';//请求地址；
	 
	 aj.sendString='';//发送的字符串
	 
	 aj.resultHandle=null;//回调函数；
	 
	
	
	//   创建对象方法 
	
  aj.createXMLHttpRequest=function createXMLHttpRequest(){                         
		var request=false;
		//window对象中有XMLHttpRequest存在就是非IE，包括（IE7，IE8）
		if(window.XMLHttpRequest){
			//非IE系列只创建一个就行了
			request=new XMLHttpRequest();
			
			//有些浏览器有个属性，我们需要覆盖它
			if(request.overrideMimeType){
			  request.overrideMimeType("text/xml");
			}
			
	    }else if(window.ActiveXObject){
		 //IE系列,不同版本有不同的参数，所以要用循环来做 　
		   var versions=['Microsoft.XMLHTTP',
		                 'MSXML.XMLHTTP',
		                 'Msxml2.XMLHTTP.7.0',
		                 'Msxml2.XMLHTTP.6.0',
		                 'Msxml2.XMLHTTP.5.0',
		                 'Msxml2.XMLHTTP.4.0', 
		                 'MSXML2.XMLHTTP.3.0',
		                 'MSXML2.XMLHTTP'];
		     for(var i=0;i<versions.length;i++){
			 //尝试去创建对象,因为不确定是什么版本的IE
			    try{
		             request=new ActiveXObject(versions[i]);
					 //创建成功时返回
					 if(request){
					    return request;
					 } 
				   }catch(e){
				     //创建不成功时扔掉对象
				      request=false;
				   }
		    }
		}
		 return request;
		}
		
      aj.XMLHttpRequest=aj.createXMLHttpRequest();
	
	 //事件触发时调用的方法
    aj.processHandle=function(){
		 if(aj.XMLHttpRequest.readyState==4){
			 if(aj.XMLHttpRequest.status==200){
				if(aj.recvType=='HTML'){
				  aj.resultHandle(aj.XMLHttpRequest.responseText);
				}else{
				  aj.resultHandle(aj.XMLHttpRequest.responseXML);
				}
			 }
		 }
		 
	}
	 
	 
//*********************************************************************************************** 
	 aj.get=function(targetUrl,resultHandle){
		 aj.targetUrl=targetUrl;
		 
		 
		 //回调函数不为空的情况
		 if(resultHandle!=null){
			 aj.XMLHttpRequest.onreadystatechange=aj.processHandle;//事件触发时调用这个方法
		     aj.resultHandle=resultHandle;
		 }
			 
			 
		//非IE时 
		 if(window.XMLHttpRequest){	 
		   aj.XMLHttpRequest.open("get",aj.targetUrl);
		   aj.XMLHttpRequest.send(null);
		 }else{
		 //ie时
		   aj.XMLHttpRequest.open("get",aj.targetUrl,true);
		   aj.XMLHttpRequest.send();
		 }
	 }
	 
//************************************************************************************************ 
	 
	 

	 
	 aj.post=function(targetUrl,sendString,resultHandle){
		 aj.targetUrl=targetUrl;
		 
		 //判断传进来的是对象还是什么字符串
		 if(typeof(sendString)=="object"){
			var str=""; 
			for(var pro in sendString){
			  str+=pro+"="+sendString[pro]+"&";
			}
			aj.sendString=str.substr(0,str.length-1);//减去最后一个&符
		 }else{
			aj.sendString=sendString;
		 }
		 
		 //回调函数不为空的情况,看是否想接收发送回来的值
		 if(resultHandle!=null){
			 aj.XMLHttpRequest.onreadystatechange=aj.processHandle;//事件触发时调用这个方法
		     aj.resultHandle=resultHandle;
		 }
		 
		 
		 aj.XMLHttpRequest.open("post",targetUrl);
		 aj.XMLHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		 aj.XMLHttpRequest.send(aj.sendString);
		 
	 }
	 
	 return aj;
	 
 }