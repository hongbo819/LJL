<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>
            开通博客信息录入
        </title>
        <link href="<?=$_SFP?>css/apply.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="content">
            <div class="content_resize">
                <div class="mainbar">
                        <h1>录入网站信息</h1><h3>标 <m>*</m> 为必填内容</h3>
                        <form action="" method="post">
                            <ol>
                                <li>
                                    <label><m>*</m>网站昵称:</label> <input type="text" name="webName" class="input_middle">
                                </li>
                                <li>
                                    <label><m>*</m>一句话介绍网站:</label> <input type="text" name="webDesc" class="input_middle">
                                </li>
                                <li>
                                    <label><m>*</m>网站二级地址（如hello.zhbor.com,只需填写hello即可，不可修改）:</label> <input type="text" name="webSite" class="input_middle">
                                </li>
                                <li>
                                    <label><m>*</m>网站分类（建议4-10个分类，用英文逗号,分割）:</label> <input type="text" name="cate" class="input_middle">
                                </li>
                                <li>
                                    <label><m>*</m>管理员邮箱:</label> <input type="password" name="email" class="input_middle">
                                </li>
                                <li>
                                    <label><m>*</m>管理员账号:</label> <input type="text" name="adminName" class="input_middle">
                                </li>
                                <li>
                                    <label><m>*</m>管理员密码:</label> <input type="password" name="adminPassword" class="input_middle">
                                </li>
                                <li>
                                    <label>微博id（用于页面显示自己微博关注按钮，可不填）:</label> <input type="text" name="weiboUid" class="input_middle">
                                </li>
                                <li>
                                    <br/><input name="submit" type="submit" value="提交信息">
                                </li>
                            </ol>
                        </form>
                </div>
            <div class="myfoot">
                Copyright © http://www.zhbor.com
            </div>
            </div>
        </div>
        </div>
        <script>
			var isError = "<?=$error?>";
			window.onload = function(){
				if(isError == '1'){
					alert('您所填写的网站已经存在，请换个网站地址或名字');return false;
				}
				if(isError == '2'){
					alert('您所填写的信息不完整');return false;
				}
				if(isError == 'noerror'){
					alert('您的信息已提交，请等待开通~');
					location.href = "<?=WWW_WEB?>";
				}
			}
        </script>
    </body>
</html>