<?php /* Smarty version Smarty-3.1.8, created on 2013-07-26 15:54:08
         compiled from "./houseRent/Tpl/House/houseInfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:186303618551f22b2045aae2-61269429%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f406271d95376e5355180b657ae6798637eac4db' => 
    array (
      0 => './houseRent/Tpl/House/houseInfo.tpl',
      1 => 1374824932,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186303618551f22b2045aae2-61269429',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'houseInfo' => 0,
    'region' => 0,
    'houseUser' => 0,
    'company' => 0,
    'college' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51f22b20511254_34796975',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f22b20511254_34796975')) {function content_51f22b20511254_34796975($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">  
<html>  
<head>  
<script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="/js/config.js" type="text/javascript"></script>
<script src="/js/urlUtil.js" type="text/javascript"></script>
<script src="/js/resouce.js" type="text/javascript"></script>
<script src="/js/emptyNote.js" type="text/javascript"></script>
<script src="/js/house.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="/js/jquery-dateFormat.js" type="text/javascript"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=0414726b722ea5ad257d0b96a3c6117a"></script>

<?php if (!isset($_smarty_tpl->tpl_vars['user']->value)){?>
<link href="/css/headLogin.css" type="text/css" rel="stylesheet">
<?php }?>

<link href="/css/common.css" type="text/css" rel="stylesheet">
<link href="/css/header.css" type="text/css" rel="stylesheet">
<link href="/css/house/houseInfo.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta name="Keywords" content="租房,租客,团租,租客团,房源,圈子" />
<meta name="Description" content="租客团是中国领先的提供房源分享与交换社区服务的互联网技术公司，为用户提供免费的房源分享、检索、交换、交易服务。" />
<meta name="robots" content="info, follow" />
<meta name="googlebot" content="info, follow" />   
<title>租客团-房源详情</title>  
</head>  
<body>  
<script type="text/javascript">
	var houseId = <?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['houseId'];?>
;
	var replyComment = null;
	$(document).ready(function(){
		$("input").emptyValue();
		
		$.get($.URL.house.streetHouseList+"?street=<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['street'];?>
",null,streetHouseCallback,"json");
		$.get($.URL.houseComment.commentList+"?houseId="+houseId,null,commentListCallback,'json');
		
		$("a.addFriendBtn").fancybox({
							'transitionIn'	:	'elastic',
							'transitionOut'	:	'elastic',
							'speedIn'		:	200, 
							'speedOut'		:	200, 
							'overlayShow'	:	false
							});
							
		$('#loginBtn').click(function(){
				var data = {};
				data.email = $('#emailLoginInput').val();
				data.password = $('#pwdLoginInput').val();
				$.post($.URL.user.login,data,loginCallback,"json");
			});
			
		$("#collectBtn").click(function(){
			var data = {};
			data.houseId = houseId;
			$.post($.URL.houseCollect.collect,data,collectCallback,'json');
		});
		
		$("#commentBtn").click(function(){
			var comment = $("#commentInput").val();
			if(comment=="请输入您的评价！"||comment=="")
			{
				alert("请输入评论内容！");
				return;
			}
		
			var data = {};
			data.houseId = houseId;
			data.comment = comment;
			if(replyComment!=null)
			{
				data.replyComment = replyComment;
			}
			$.post($.URL.houseComment.comment,data,commentCallback,'json');
		});
		
		showHouseLocation();
	});
	
	function showHouseLocation()
	{
		var map = new BMap.Map("allmap");
var point = new BMap.Point(116.331398,39.897445);
map.centerAndZoom(point,12);
// 创建地址解析器实例
var myGeo = new BMap.Geocoder();
// 将地址解析结果显示在地图上,并调整地图视野
myGeo.getPoint("<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['street'];?>
<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['community'];?>
", function(point){
  if (point) {
    map.centerAndZoom(point, 16);
    map.addOverlay(new BMap.Marker(point));
  }
}, "北京市");
	}
	
	//评论列表回调
	function commentListCallback(result)
	{
		$("#commentList").html("");
		$.each(result.commentList,function(index,item){
			var commentRow = $("<div class='commentRow'></div>");
			var commentTitle = $("<div class='commentTitle'></div>")
			var commentUser = $("<div class='commentUser'>"+item.realName+" 评论说：</div>");
			var commentTime = $("<div class='commetTime'>评论时间："+item.createTime+"</div>")
			var commentContent = $("<div class='commentContent'>"+item.comment+"</div>");
			
			commentTitle.append(commentUser).append(commentTime);
			commentRow.append(commentTitle).append(commentContent);
			$("#commentList").append(commentRow);
		});
	}
	
	//评论回调
	function commentCallback(result)
	{
		if(result.success)
		{
			$("#commentInput").val('请输入您的评价！');
			$.get($.URL.houseComment.commentList+"?houseId="+houseId,null,commentListCallback,'json');
		}
		else
		{
			alert(result.msg);
		}
	}
	
	//收藏房源回调
	function collectCallback(result)
	{
		if(result.result)
		{
			alert("收藏成功");
		}
		else
		{
			alert(result.msg);
		}
	}
	
	//街道相对应的房源
	function streetHouseCallback(result)
	{
		$.each(result.houseList,function(index,value){

   			var houseInfo = $("<div class='houseItem'></div>");
   			houseInfo.attr('houseId',value.houseId);
   			var title = $("<div class='houseItemColumn'></div>").append(value.title);
   			var price = $("<div class='houseItemColumn'></div>").append(value.price).append("&nbsp;元/月");
   			var type = $("<div class='houseItemColumn'></div>").append("房屋户型： "+value.room+"室"+value.parlor+"厅"+value.washroom+"卫");
   			var transferTime = $("<div class='houseItemColumn'></div>").append("出租时间： "+$.format.date(value.transferTime,"yyyy-MM-dd"));
   			houseInfo.append(title).append(price).append(type).append(transferTime);
   			$("#houseList").append(houseInfo);
		});
		
		$('.houseItem').click(function(){
			location=$.URL.house.info+"?id="+$(this).attr("houseId");
		});
	}
	
	//登录回调函数
	function loginCallback(result)
	{
		if(result.success)
		{
			location.reload();
		}
		else
		{
			$('#loginMsg').html(result.msg);
		}
			
	}
</script>
<div id='mainContainer'>
    <div id='headContainer'>
    	<div id='logoDiv'><a href='/'><img height=100% src='/assets/logo.jpg'/></a></div>
    	<div id='headLeftDiv'>
    		<div id='aimDiv'>让您不在为租房烦恼</div>
    		<div id='cityDiv'>城市</div>
    	</div>
    	<div id='headRightDiv'>
    	<?php if (isset($_smarty_tpl->tpl_vars['user']->value)){?>
    		<div id='headBottomDiv'>
    			<div id='loginRegDiv'>
    				hi,<a href='/User/personCenter'><?php echo $_smarty_tpl->tpl_vars['user']->value;?>
</a>&nbsp;<a href='/User/logout'>安全退出</a>
    			</div>
    			<div id='contactDiv'>联系我们</div>
    			<div id='inviteDiv'><a id='inviteLink' href='/mod/user/invite.html'>邀请好友</a></div>
    		</div>
   		<?php }else{ ?>
   			<div class='headRightRow'>
    			<div id='topRow'>
	    			<div class='nameInputDiv'>
	    				<div class='loginColumnDiv'><input id='emailLoginInput' type='text' data-empty='账号'/></div>
	    			</div>
	    			<div class='pwdInputDiv'>
	    				<div class='loginColumnDiv'><input type='text' data-empty='密码'  pass-empty='true'/><input id='pwdLoginInput' type='password' data-empty='密码'  pass-empty='true'/></div>
	    			</div>
	    			<div class='loginBtnDiv'>
	    				<div class='loginColumnDiv'><input id='loginBtn' type='submit' value='登录'/></div>
	    			</div>
    			</div>
    			<div id='bottomRow'>
    				<div id='autoLogin'><input type='checkbox'/>下次自动登录</div>
    				<div id='forgotPassword'><a href='#'>忘记密码</a></div>
    				<div id='loginMsg'></div>
    			</div>
    		</div>
    	<?php }?>
    	</div>
    </div>
    
    <div id='houseInfoBody'>
    	<div id='leftInfo'>
    		<div id='title'>
				<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['title'];?>

    		</div>
    		<div id='details'>
    			<div class='infoRow'>
    				<div class='infoLabel'>租金价格：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['price'];?>
元</div>
    			</div>
    			<div class='infoRow'>
    				<div class='infoLabel'>房屋户型：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['room'];?>
室<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['parlor'];?>
厅<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['washroom'];?>
卫 &nbsp; <?php echo $_smarty_tpl->tpl_vars['houseInfo']->value["area"];?>
平米</div>
    			</div>
    			<div class='infoRow'>
    				<div class='infoLabel'>房屋情况：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['decoration'];?>
</div>
    			</div>
    			<div class='infoRow'>
    				<div class='infoLabel'>所属楼层：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['currentFloor'];?>
层/<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['maxFloor'];?>
层</div>
    			</div>
    			<div class='infoRow'>
    				<div class='infoLabel'>所在区域：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['region']->value['areaname'];?>
</div>
    			</div>
    			<div class='infoRow'>
    				<div class='infoLabel'>所在地址：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['street'];?>
<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['community'];?>
</div>
    			</div>
    			<div class='infoRow'>
    				<div class='infoLabel'>转让时间：</div>
    				<div class='infoValue'><?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['transferTime'];?>
</div>
    			</div>
    		</div>
    		<div id='actions'>
    			<div id='applyBtn' class='myButton'><a class='addFriendBtn' href="/HouseApply/applyHousePage?userId=<?php echo $_smarty_tpl->tpl_vars['houseUser']->value['id'];?>
&houseId=<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['houseId'];?>
">申请房源</a></div>
    			<div id='collectBtn' class='myButton'>收藏</div>
    		</div>
    		<div id='description'>
    			<div class='underLine'>
    				<div id='descriptionTab'>房源详情</div>
    			</div>
    			<div id='infoDescription'>
					<?php echo $_smarty_tpl->tpl_vars['houseInfo']->value['detailDescription'];?>

    			</div>
    		</div>
    		<div id="allmap"></div>
    		<div id='comment'>
    			<div id='comentTitle'>房源评价：</div>
    			<div id='commentContainer'>
    				<div class='comentRow'>
    					<div class='commentLabel'>内容：</div>
    					<div class='comemntInput'>
    						<textarea id='commentInput' rows="8" cols="60">请输入您的评价！</textarea>
    					</div>
    				</div>
    				<div class='comentRow'>
    					<div class='commentLabel'>&nbsp;</div>
    					<div class='comemntInput'><div id='commentBtn' class='myButton'>评论</div></div>
    				</div>
    			</div>
    			<div id="commentList">
    				
    			</div>
    		</div>
    	</div>
    	<div id='rightInfo'>
    		<div id='user'>
    			<div id='userInfoRow'>
    				<div id='headIcon'><img src='/assets/headIcon.png' height='100%'></div>
    				<div id='userInfoDetail'>
    					<div id='name'><?php echo $_smarty_tpl->tpl_vars['houseUser']->value["realName"];?>
</div>
    					<div id='company'><?php echo $_smarty_tpl->tpl_vars['company']->value;?>
</div>
    					<div id='college'><?php echo $_smarty_tpl->tpl_vars['college']->value;?>
</div>
    					<div id='addFrinend'><div id='addFriendBtn' class='myButton'><a class='addFriendBtn' href="/Friend/applyFriendPage?userId=<?php echo $_smarty_tpl->tpl_vars['houseUser']->value['id'];?>
">+ 加为好友</a></div></div>
    				</div>
    			</div>
    		</div>
    		
    		<div id='relationship'>
    					<div id='peopleBetween'>通过2个人可以认识她</div>
    					<div id='relationshipDetail'>&nbsp;</div>
    		</div>
    		<div class='underLine'></div>
    		<div id='relatedHouse'>
    					<div id='relatedHouseTitle'>相关房源推荐：</div>
    					<div id='houseList'>
    						
    					</div>
    		</div>
    	</div>
   </div>
</div>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa712b75dc1788d09dbf388a019b92836' type='text/javascript'%3E%3C/script%3E"));
</script>
</body>  
</html>  
  
<script>  
      
</script>  <?php }} ?>