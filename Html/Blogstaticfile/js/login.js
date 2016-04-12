//兼容火狐、IE8
function showMask(){
	$("#mask").css("height",$(document).height());
	$("#mask").css("width",$(document).width());
	$("#mask").show();
}
//让指定的DIV始终显示在屏幕正中间
function letDivCenter(divName){ 
	var top = ($(window).height() - $(divName).height())/3; 
	var left = ($(window).width() - $(divName).width())/2; 
	var scrollTop = $(document).scrollTop(); 
	var scrollLeft = $(document).scrollLeft(); 
	$(divName).css( { position : 'absolute', 'top' : top + scrollTop, left : left/2 + scrollLeft/2 } ).show();
}
function letDivHide(){ 
	$("#model").fadeOut();
	$("#model").remove();
}
function hideMask(){
	$("#mask").fadeOut();
	$("#mask").remove();
}
function hideAll(){
	letDivHide();
	hideMask();
}
function showAll(divName,action){
	letDivHide();
	hideMask();
	$.ajax({
		url:mainPage+"index.php?c=ajax_User&a="+action,
		type:'post',
		data:{},
		datatype:'text',
		async:true,
		success:function(apiDate){
			$("body").after(apiDate);
			showMask();
			letDivCenter(divName);
		},
		error:function(){
			
		}
	});
}
//跨浏览器事件对象
var EventUtil = {
	addHandler: function(element, type, handler){
		if (element.addEventListener){
			element.addEventListener(type, handler, false);
		} else if (element.attachEvent){
			element.attachEvent("on" + type, handler);
		} else {
			element["on" + type] = handler;
		}
	},			
	
	getEvent: function(event){
		return event ? event : window.event;
	},
	//从A到B 的 A
	getTarget: function(event){
		return event.target || event.srcElement;
	},
	//从A 到B 的 B
	getRelatedTarget: function(event){
		if(event.relatedTarget){
			return event.relatedTarget;
		} else if (event.toElement){
			return event.toElement;
		} else if (event.fromElement){
			return event.fromElement;
		} else {
			return null;
		}
	},
	//鼠标按钮事件（0：左键，1：滚轮键，2：右键）			
	getButton: function(event){
		if (document.implementation.hasFeature("MouseEvents", "2.0")){
			return event.button;
		} else {
			switch(event.button){
			case 0:
			case 1:
			case 3:
			case 5:
			case 7:
				return 0;
			case 2:
			case 6:
				return 2;
			case 4:
				return 1;
			}
		}
	},
	//剪贴板操作 - 获取剪贴板信息
	getClipboardText: function(event){
		var clipboardData = (event.clipboardData || window.clipboardData);
		return clipboardData.getData("text");
	},
	
	//剪贴板操作 - 设置剪贴板信息
	setClipboardText: function(event, value){
		if (event.clipboardData){
			return event.clipboardData.setData("text/plain", value);
		} else if (window.clipboardData){
			return window.clipboardData.setData("text", value);
		}
	},
	//返回按键字符编码
	getCharCode: function(event){
		if(typeof event.charCode == "number"){
			return event.charCode;
		} else {
			return event.keyCode;
		}
	},
	
	preventDefault: function(event){
		if(event.preventDefault){
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
	},
	
	stopPropagation: function(event){
		if (event.stopPropagation){
			event.stopPropagation();
		} else {
			event.cancelBubble = true;
		}
	},
	removeHandler: function(element, type, handler){
		if (element.removeEventListener){
			element.removeEventlistener(type, handler, false);
		} else if (element.detachEvent){
			element.detachEvent("on" + type, handler);
		} else {
			element["on" + type] = null;
		}
	}
};
//登录、注册相关
$("#user-register").live('click', function(e){
	var username = $("input[name='username']").val();
	var email    = $("input[name='email']").val();
	var password1= $("input[name='password1']").val();
	var password2= $("input[name='password2']").val();
	
	var errorMsg = document.createElement("p");
	errorMsg.style.color = 'red';
	$(this).parent().find("p").remove();
	
	if(password1 != password2){
		errorMsg.innerHTML = '密码不一致';
		$(this).parent().append(errorMsg);
		return false;
	}
	
	if(!/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(email)){
		errorMsg.innerHTML = '邮箱格式不正确';
		$(this).parent().append(errorMsg);
		return false;
	}
	var inputObj = $(this);
	$.ajax({
		url:mainPage+"index.php?c=ajax_User&a=register",
		type:'post',
		data:{username:username, email:email, password1:password1, password2:password2},
		datatype:'text',
		async:true,
		success:function(apiDate){
			
			if(apiDate.indexOf('ok')>-1){
				var loginEle = '<a id="login_sign">'+username+'</a>&nbsp;&nbsp;<a href=":;" id="login_out">退出</a>';
				document.getElementById('login-button').innerHTML = loginEle;
				hideAll();
			}else{
				errorMsg.innerHTML = apiDate;
				inputObj.parent().append(errorMsg);
			}
		},
		error:function(){
			errorMsg.innerHTML = '服务器出错';
			inputObj.parent().append(errorMsg);
		}
	});
	$(this)[0].disabled = false;
	return false;
});
function writeCookie(name, value, day) {
    expire = "";
    expire = new Date();
    expire.setTime(expire.getTime() + day * 24 * 3600 * 1000);
    expire = expire.toGMTString();
    document.cookie = name + "=" + escape(value) + ";expires=" + expire;
}
$("#user-login").live('click', function(e){
	var username = $("input[name='username']").val();
	var password= $("input[name='password']").val();
	
	var errorMsg = document.createElement("p");
	errorMsg.style.color = 'red';
	$(this).parent().find("p").remove();
	
	var inputObj = $(this);
	$.ajax({
		url:mainPage+"index.php?c=ajax_User&a=login",
		type:'post',
		data:{username:username, password:password},
		datatype:'text',
		async:true,
		success:function(apiDate){
			if(apiDate.indexOf('ok')>-1){
				if(apiDate.indexOf('_adm')>-1){
					var loginEle = '<a target="_blank" href="'+mainPage+'index.php?c=admin&a=list">后台管理</a>&nbsp;&nbsp;<a id="login_sign">'+apiDate.replace(/_ok_adm/,"")+'</a>&nbsp;&nbsp;<a href=":;" id="login_out">退出</a>';
				}else{
					var loginEle = '<a id="login_sign">'+apiDate.replace(/_ok/,"")+'</a>&nbsp;&nbsp;<a href=":;" id="login_out">退出</a>';
				}
				document.getElementById('login-button').innerHTML = loginEle;
				hideAll();
			}else{
				errorMsg.innerHTML = apiDate;
				inputObj.parent().append(errorMsg);
			}
		},
		error:function(){
			errorMsg.innerHTML = '服务器发生错误';
			inputObj.parent().append(errorMsg);
		}
	});
	$(this)[0].disabled = false;
	return false;
});
$("#login_out").live('click', function(e){
	$.get(mainPage+"index.php?c=ajax_User&a=loginout", function(r) {
		var loginEle = '<a href="javascript:;" onclick="showAll(\'#model\', \'showlogin\')">登陆</a> <a href="javascript:;" onclick="showAll(\'#model\', \'showregister\')">注册</a>';
		document.getElementById('login-button').innerHTML = loginEle;
	})
	return false;
});
function readCookie(name) {
    cookieValue = "";
    search1 = name + "=";
    if (document.cookie.length > 0) {
        offset = document.cookie.indexOf(search1);
        if (offset != -1) {
            offset += search1.length;
            end = document.cookie.indexOf(";", offset);
            if (end == -1) end = document.cookie.length;
            cookieValue = unescape(document.cookie.substring(offset, end));
        }
    }
    return cookieValue;
}
$(function(){
	var username = readCookie('blog_username');
	if(username){
		var manageStr = '';
		if(readCookie('mda_')){
			manageStr += '<a target="_blank" href="'+mainPage+'index.php?c=admin&a=list">后台管理</a>&nbsp;&nbsp;';
		}
		var loginEle = manageStr+'<a id="login_sign">'+decodeURI(username)+'</a>&nbsp;&nbsp;<a href=":;" id="login_out">退出</a>';
		document.getElementById('login-button').innerHTML = loginEle;
	}
});


