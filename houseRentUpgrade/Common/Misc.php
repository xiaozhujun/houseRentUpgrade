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
	return $photos;
}

//删除session中的图片缓存
function deletePhotos()
{
	$key = "photos";
	deleteSessionKey($key);
}

//删除session中的指定键
function deleteSessionKey($key)
{
	session_start();
	unset($_SESSION[$key]);
}