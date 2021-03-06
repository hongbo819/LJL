<?php 
    $redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $loginurl = LJL_Api::run('Open.Sina.getAuthorizeURL' , array('redirect_uri'=>$redirect_uri));
?>
<div id="mask" class="mask"></div>
<div id="model" class="model">
	<span>账户信息</span>
	<a id="click-close" href='javascript:;' onclick='hideAll()'>×</a>
	<?php if($pageType == 'login'){?>
	       <form id="user-login-form" action='' method='post'>
        		用户名：<input type='text' name='username' autofocus required placeholder="用户名/邮箱"><br/>
        		密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type='password' name='password' required><br/>
        		<input id="user-login" type='submit' name='submit-btn' value="登录"> &nbsp;&nbsp;<a href="javascript:;" onclick="showAll('#model', 'showregister')">快速注册</a> &nbsp;&nbsp;<a href="<?=$loginurl?>" style="border-bottom: #666666 dashed 1px;font-weight: 600;font-size: 20px;">微博登录</a>
        	</form>
	       <?php 
	   }elseif($pageType == 'register'){?>
	       <form id="user-register-form" action='' method='post'>
        		用户名：<input type='text' name='username' autofocus required placeholder="必填项"><br/>
        		邮&nbsp;&nbsp;&nbsp;&nbsp;箱：<input type='email' name='email' required placeholder='必填项'><br/>
        		密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type='password' name='password1' placeholder='密码可为空'><br/>
        		密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type='password' name='password2' placeholder='密码可为空'><br/>
        		<input id="user-register" type='submit' name='submit-btn' value="快速注册"> &nbsp;&nbsp;<a href="javascript:;" onclick="showAll('#model', 'showlogin')">登陆</a> &nbsp;&nbsp;<a href="<?=$loginurl?>" style="border-bottom: #666666 dashed 1px;font-weight: 600;font-size: 20px;">微博登录</a>
        	</form>
	       <?php }?>
</div>
<script>
//第二个文本框只允许输入数字字符下划线的处理
if(document.getElementById("user-register-form")){
	var textbox2 = document.getElementById("user-register-form").elements['username'];
	EventUtil.addHandler(textbox2, 'keypress', function(event){
		event = EventUtil.getEvent(event);
		var target = EventUtil.getTarget(event);
		var charCode = EventUtil.getCharCode(event);
		//大于9的处理是空格键和删除键，event.ctrlKey的处理是允许用户粘贴复制等
		if(!/^\w+$/.test(String.fromCharCode(charCode)) && charCode > 9 && !event.ctrlKey){
			EventUtil.preventDefault(event);
		}
	});
	var form = document.getElementById("user-register-form");
}
if(document.getElementById("user-login-form")){
	var form = document.getElementById("user-login-form");
}

//防止表单重复提交
EventUtil.addHandler(form, 'submit', function(event){
	event = EventUtil.getEvent(event);
	var target = EventUtil.getTarget(event);
	var btn = target.elements['submit-btn'];
	btn.disabled = true;//防止表单再次提价
});
</script>
