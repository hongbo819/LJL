<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Helper管理</title>
<style>
ul,li{list-style: none;}
#cacheParamDiv li{font-size:12px;padding-left:20px;display:none;line-height:22px;}
#opLnk{line-height:25px;}
#paramList {font-size: 12px;margin:10px;}
#paramList input{width:100px;}
#dosubmit{width:500px;text-align: center;padding-top:10px;}
#dosubmit input{width:140px;height:35px;}
#phpcode{margin:0 10px;width:700px;}
.zhushi{color:#999;}


#codearea{background:#1B2426;color:#fff;padding:20px;line-height: 22px;font-size:12px;}
#codearea .zhushi{color:#5CE638}
#codearea .bl1{color:#5BA1CF }
#codearea .bl2{color:#FFAA3E }
</style>

</head>

<body>

<form method="post" action="index.php?c=HelperManage" onsubmit="return doCheck()">
<div id="selectHeader">

助手方法:<select name="funName" id="funName" onchange="jumpPage(this.value)" style="font-family: Courier New;"><option value="0">请选择方法</option>
<?php
if($helperCfgArr){
	$tmpMaxFunLen = 25;

    foreach($helperCfgArr as $groupName => $subHelperCfgArr2){
		echo "<optgroup label='{$groupName}'>";
		foreach($subHelperCfgArr2 as $name => $cfg){
			$selected = $showFunName == $name ? ' selected ' : '';//　
			$comma =  strlen($name) < $tmpMaxFunLen ? str_repeat("-" , $tmpMaxFunLen-strlen($name)) : '';
			echo "<option value='{$name}'{$selected}>{$name} {$comma}--- {$cfg['name']}</option>";
		}
		echo "</optgroup>";
	}

}
?>
</select>
<?php
$paramNameArr = array();#将参数封装成 英文 => 中文的形式
if($funParamArr){
	echo '<table id="paramList">';
	foreach($funParamArr['param'] as $param){
		$pEName = $param[0];
		$pCName = $param[1];
		$paramNameArr[$pEName] = $pCName;
		$pNeedStr = $param[2] == 1 ? '<font color="red">*</font>' : '';
		$validStr = $param[2] == 1 ? ' vali="must" ' : '';
		echo "<tr><td align='right'>{$pCName}{$pNeedStr}:</td><td><input type='text' value='{$paramValArr[$pEName]}' name='{$pEName}' {$validStr}  cnname='{$pCName}'/></td><td class='zhushi'>&nbsp;{$param[3]}</td></tr>";
	}
	echo '</table>';
}
if($showFunName){
	echo "<div id='dosubmit'><input type='submit' value='查看'><input type='hidden' name='dopost' value='1'></div>";
}
?>
</div>
</form>

<?php
if($dopost && $funName){
	$paramValArr = array_filter($paramValArr);
	$funcParamStr = "array(";
	$funcParamStrSm = "array(";

	if($paramValArr){
		foreach($paramValArr as $key => $val){
			$keySpaceStr = strlen($key) < 14 ? str_repeat(" ", 14 - strlen($key)) : "";#为了对齐=>
			$valStr = $val;
			#数字参数的处理
			if(preg_match('/^\d*$/',$val))$valStr = $val;
			else $valStr = "'{$val}'";

			#特殊变量的处理
			if(in_array($key,array('proId','subcateId','manuId','subcateEnName','seriesId','mainId'))){
				$valStr = "\${$key}";
			}

			$tmpStr = "'{$key}'{$keySpaceStr} => <font class='bl2'>{$valStr}</font>,";
			$tmpSpacestr = strlen($tmpStr) < 62 ? str_repeat(" ", 62 - strlen($tmpStr)) : "   ";#注释前面的空格
			$funcParamStr .= "\n\t{$tmpStr}{$tmpSpacestr}<font class='zhushi'>#".$paramNameArr[$key]."</font>";
			$funcParamStrSm .= "'{$key}'=>{$valStr},";
		}

	}
	$funcParamStr .= "\n)";
	$funcParamStrSm .= ")";
	$funcParamStrSm = str_replace(",)",')',$funcParamStrSm);
?>
<!--  迅速copy部分   -->
<br clear="all"/><input type="text" value="Helper_<?=$funName?>(<?=$funcParamStrSm?>)" onclick="this.select();" onfocus="this.select();" style="margin-left:10px;width:680px;background: #FFFFD8;padding:2px 4px 2px 10px;border: 1px solid #878787;"/>

<!--  调用代码显示部分   -->
<div id="phpcode">
<pre  id="codearea">
<font class="zhushi">#<?=$funParamArr['name']?></font>
$dataArr = <font class='bl1'>Helper_<?=$funName?></font>(<?=$funcParamStr?>);
</pre>
</div>
<br clear="all"/>

<!--  调用结果显示部分   -->
<div id="dataResult">
	<?=$htmlVarStr?>
</div>
<?php }?>





<script type="text/javascript" src="http://static.zhbor.com/js/jquery-1.7.1.min.js"></script>
<script>
	function jumpPage(val){
		if(val != "0"){
			window.location.href = 'index.php?c=HelperManage&showFunName='+val;
		}
	}

	function doCheck(){
		okFlag = true;
		msgStr = '请填写必填项:[';
		$("input").each(function(){

			if($(this).attr("vali") && $(this).attr("vali") == 'must' && $(this).val() == ''){
				okFlag = false;
				msgStr += " " + $(this).attr("cnname") + " ";
			}
		});
		msgStr += "]";
		if(!okFlag) alert(msgStr);
		
		return okFlag;
	}
</script>
</body>
</html>