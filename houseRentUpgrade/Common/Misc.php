<?php
//判断用户是否登陆
function  isLogin()
{
	session_start();
	if(is_null($_SESSION['user']))
	{
		return false;
	}
	return true;
}

//判断用户是否管理员
function isAdmin()
{
	
}

//当前用户编号
function currentUserName()
{
	$userName = $_SESSION['user'];
	return 	$userName;
}

//当前用户所在城市
function currentUserCity()
{
	$city = $_SESSION['city'];
	return 	$city;
}

function currentUserCompany()
{
	if(!isLogin())
	{
		return "";
	}
	
	//获得当前用户的公司名称
	$userCommunity = new UserCommunityModel();
	$userCompanyList = $userCommunity->findCommunityWithType(currentUserId(),COMPANY);
	if($userCompanyList && count($userCompanyList)>0)
	{
		return $userCompanyList[0]["communityName"];
	}
	return null;
}

//添加图片编号到session
function addPhotos($photoId)
{
	$key = "photos";
	$photos = sessionGet($key);
	if(is_null($photos))
	{
		$photos = "".$photoId;
	}
	else
	{
		$photos = $photos.",".$photoId;
	}
	sessionPut($key, $photos);
}

//获得session中的图片列表
function getPhotos()
{
	$key = "photos";
	$photos = sessionGet($key);
	deleteSessionKey($key);
	return $photos;
}

function currentUserCollege()
{
	if(!isLogin())
	{
		return "";
	}

	//获得当前用户的学校名称
	$userCommunity = new UserCommunityModel();
	$userCollegeList = $userCommunity->findCommunityWithType(currentUserId(),COLLEGE);
	if($userCollegeList && count($userCollegeList)>0)
	{
		return $userCollegeList[0]["communityName"];
	}
	return null;
}

function currentUserTargetCommunity()
{
	if(!isLogin())
	{
		return "";
	}

	//获得当前用户的目标住房
	$userTargetHouse = new UserTargetHouseModel();
	$userTargetHouseObj = $userTargetHouse->findByUserId($_SESSION['userId']);
	if($userTargetHouseObj)
	{
		$targetHouse = new TargetHouseModel();
		$targetHouseObj = $targetHouse->find($userTargetHouseObj['targetHouseId']);
		return $targetHouseObj['name'];
	}			
	return "";
}



//当前用户编号
function currentUserId()
{
	$userId = $_SESSION['userId'];
	return 	$userId;
}

//获得session里面指定的key的值
function sessionGet($key)
{
	session_start();
	return $_SESSION[$key];
}

//在session存储键值对
function sessionPut($key,$value)
{
	session_start();
	$_SESSION[$key] = $value;
}

//删除session中的指定键
function deleteSessionKey($key)
{
	session_start();
	unset($_SESSION[$key]);
}

//创建消息
function createMessage($toUserId,$message,$fromUserId){
	$userMessageModel = new UserMessageModel();
	$userMessageModel->saveMessage($toUserId, $message, $fromUserId);
}

//创建圈子消息
function createCommunityMessage($userId,$communityName, $message){
	$communityMessageModel = new CommunityMessageModel();
	$communityMessageModel->saveMessage($userId,$communityName, $message);
}

function escapeFilePath($path){
	if(IS_BAE){
		
	}
}