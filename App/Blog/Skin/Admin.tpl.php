<!DOCTYPE HTML>
<html>
<head>
    <title>发布文章</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
    <script type="text/javascript" charset="utf-8" src="<?=$_SFP?>ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=$_SFP?>ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="<?=$_SFP?>ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=$_SFP?>js/jquery-1.7.1.min.js"></script>
    <style type="text/css">
        div{
            width:100%;
        }
        #upload-images div{
	       width:auto;
           height:100px;
        }
        #upload-images div img{
	       width:100px;
           height:100px;
        }
        input{
	       margin:10px;
        }
    </style>
</head>
<body>
<div align="center">
    <div style="margin:0 auto;">
        <h1>发布文章&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo Blog_Plugin_Urls::getAdminListUrl(array('page'=>1));?>" style="font-size: 8px;">查看文章列表</a></h1>
        选择分类：<select id="cate" name="cate">
            <?php if($cate){ foreach($cate as $key=>$val){ ?>
                <option value="<?=$key?>" <?php if($key==$articleInfo['cate']){?>selected<?php }?>><?=$val[0]?></option>
            <?php }}?>
        </select><br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题目：<input id="title" type="text" name="title" value="<?=$articleInfo['title']?>" style="width:500px;"/><br>
        (非原创请注明)来源：<input id="source" type="text" name="source" value="<?=$articleInfo['source']?>" style="width:500px;"/><br>
        (英文逗号分割)标签：<input id="tags" type="text" name="tags" value="<?=$articleInfo['tags']?>" style="width:500px;"/><br>
        <p>上传图片后点击图片即可插入文章中</p>
        
        <form id="cuiPicform" action="index.php?c=admin&a=uploadImg" method="post" enctype="multipart/form-data" target="hidframe">
            <input id="uploadButton" name="uppic" type="file" onchange="onPreview(this)">
        </form>
        <iframe style="display: none;" name="hidframe" id="hidframe" scrolling="no" frameborder="0"></iframe>
            
        <div id="upload-images">
            <div>
                <?php 
                    if($picArr){
                        foreach($picArr as $val){
                            ?>
                            <img src="<?=$val?>">
                            <?php 
                        }
                    }
                ?>
            </div>
        </div>
        <script id="editor" type="text/plain" style="width:900px;height:500px;"></script>
    </div>
    <p></p>
    <div id="btns" style="margin:60;" articleid="<?=$articleId?>">
       <button>预览文章</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button>发布文章</button>
       <p>预览文章不会出现在列表页，别人无从查看</p>
    </div>
</div>
<textarea id="articleContent" style="display:none"><?=$articleInfo['content']?></textarea>
<script type="text/javascript">
	var imgArr = [];
	var contentFromId = document.getElementById('articleContent').value;
	function publishArticle(){
		var btnBox = document.getElementById("btns");
		var buttons = btnBox.getElementsByTagName("button");
		for(var i=0; i<buttons.length; i++){
			(function() {
		        var p = i;//p即第一个预览按钮是0 第二个提交按钮是1
		        buttons[i].onclick = function(){
					var title = document.getElementById("title").value;
					var source = document.getElementById("source").value;
					var tags = document.getElementById("tags").value;
					var content = UE.getEditor('editor').getContent();
					var cate = document.getElementById("cate").value;
					var articleId = btnBox.getAttribute("articleid");
					$.post('index.php?c=admin&a=publish', {
						ispublish: p,//发布或者预览的标志0：预览，1：发布
						articleId: articleId,//如果有改id说明是修改，否则为新增
						cate: cate,
						title: title,
						tags: tags,
						source: source,
						content: content,
						imgArr: imgArr
					}, function(r) {
						articleId = r;
						if(r==='error'){
							alert('在同一个类型下，不允许发布两篇文章的题目相同。');return false;
						}
						//window.open("");
						window.location.href = "<?php echo Blog_Plugin_Urls::getDetailUrl(array('articleid'=>'"+articleId+"'));?>";
					})
				}
		    })();
		}
	}
	publishArticle()
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
	//图片追加到内容
    function appendImgToContent(){
    	var imgArr = document.getElementById("upload-images").getElementsByTagName("img");
        if(imgArr){
    		for(var i=0; i< imgArr.length; i++){
    			imgArr[i].onclick = function (){
    				setContent(this.outerHTML);
    			}
    		}
        }
    }
    appendImgToContent()
    //无刷新上传相关
	//在php脚本中会调用这个函数
	function addPic(webPath, imgId) {
    	var img = document.createElement("img");
    	img.src = webPath;
    	imgArr.push(imgId);
    	document.getElementById("upload-images").getElementsByTagName("div")[0].appendChild(img);
    	appendImgToContent()
	}
	//绑定上传事件
	function onPreview(file) {
	    document.getElementById('cuiPicform').submit();
	}
    	
    //函数列表
	function setContent(content) {
        UE.getEditor('editor').setContent(content, true);
    }
	$(function(){
        //判断ueditor 编辑器是否创建成功
        ue.addListener("ready", function () {
        // editor准备好之后才可以使用
        ue.setContent(contentFromId);
        });
    });
</script>
</body>
</html>