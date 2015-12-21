//评论
$(".ds-post-button").live('click', function(e){
	var username = decodeURI(readCookie('blog_username'));
	if(!username){ showAll('#model', 'showlogin'); return false;}
	
	var message = $("#message").val();
	var articleId = $("#comment").attr("articleId");
	if(!message){
		$("#message").attr("placeholder", "请输入评论内容");
		return false;
	}
	$.ajax({
		url:mainPage+"index.php?c=ajax_Comment&a=comment",
		type:'post',
		data:{message:message, articleId:articleId},
		datatype:'text',
		async:true,
		success:function(apiDate){
			if(apiDate=='error'){
				$("#message").val('');$("#message").attr("placeholder", "评论失败");return false;
			}
			$(".ds-comments").append('<li class="ds-post"><div class="ds-post-self"><div class="ds-avatar"><img src="'+staticPage+'images/noavatar_default.png" alt="'+username+'"></div><div class="ds-comment-body"><div class="ds-comment-header"><span class="ds-user-name">'+username+'</span></div><p>'+apiDate+'</p><div class="ds-comment-footer ds-comment-actions"><span class="ds-time">刚刚</span></div></div></div></li>');
			$("#message").val('');
			$("#message").attr("placeholder", "评论已发布成功");
		},
		error:function(){
			$("#message").attr("placeholder", "服务器发生错误");
		}
	});
	return false;
});
//顶
$(".ds-post-likes").live('click', function(e){
	var commentId = $(this).parent().attr('commentId');
	if(readCookie("blog_zan_"+commentId)){return false;}
	writeCookie("blog_zan_"+commentId, '1', 1);
	var dingObj = $(this);
	$.get('/index.php?c=ajax_Comment&a=ding&commentid='+ commentId, function(r) {
		var zanNum = parseInt(dingObj.html().match(/\d+/));
		dingObj.html("顶("+(zanNum+1)+")");
	});
});
//回复
$(".ds-post-reply").live('click', function(e){
	window.location.href="#message";
	var applayStr = "回复 "+$(this).parent().attr('user')+':';
	$("#message").val(applayStr);
});
//实例化表情插件
$(function(){
	$('#face1').qqFace({
		id : 'facebox1', //表情盒子的ID
		assign:'message', //给那个控件赋值
		path:'http://static.cuihongbo.com/images/face/'	//表情存放的路径
	});
});