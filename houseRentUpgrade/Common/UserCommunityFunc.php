<?php

import('Common.Common',APP_PATH,'.php');
//更新用户所在圈子信息
function updateUserCommunity($userId,$communityName,$communityType)
{ 	
	$communityModel = new CommunityModel();
	$userCommunityModel = new UserCommunityModel();
	//判断该公司信息是否存在，不存在则在数据库中添加一条记录
	$communityObj = $communityModel->findByName($communityName);
	//圈子不存在
	if(!$communityObj)
	{
		$communityData = array(
				"name"=>$communityName,
				"communityType"=>$communityType,
				"creator"=>currentUserName(),
				"creatorId"=>currentUserId(),
				"createTime"=>date("Y-m-d H:i:s"),
				"updateTime"=>date("Y-m-d H:i:s"),
		);
		if($communityModel->create($communityData))
		{
			$communityId = $communityModel->add();
		}
		else 
		{
			return false;
		}
	}
	else //圈子已经存在
	{
		$communityId = $communityObj["id"];
	}
	//更新用户的公司模型信息
	$userCommunityList = $userCommunityModel->findCommunityWithType($userId,$communityType);
	$userCommunityObj = null;
	if($userCommunityList  && count($userCommunityList)>0)
	{
		$userCommunityObj = $userCommunityList[0];
	}
	
	if(!is_null($userCommunityObj))
	{
		
		$userCommunityObj = array(
				"userId"=>$userId,
				"userName"=>currentUserName(),
				"communityId"=>$communityId,
				"communityName"=>$communityName,
				"communityType"=>$communityType,
				"createTime"=>date("Y-m-d H:i:s"),
		
		);
		
		$saveResult = $userCommunityModel->create($userCommunityObj);
		if($communityType==OTHER){
			$result = $userCommunityModel->add();
		}else{
			$userCommunityObj['id'] = $userCommunityList[0]["id"];
			$result = $userCommunityModel->save();
		}
	}
	else 
	{
		$userCommunityObj = array(
				"userId"=>$userId,
				"userName"=>currentUserName(),
				"communityId"=>$communityId,
				"communityName"=>$communityName,
				"communityType"=>$communityType,
				"createTime"=>date("Y-m-d H:i:s"),
				
		);
		$userCommunityModel = new UserCommunityModel();
		if($userCommunityModel->create($userCommunityObj))
		{
			$userCommunityModel->add();
		}
		else 
		{
			return false;
		}
	}
	return true;
}

//判断用户是否已经加入圈子
function isUserCommunityExist($userId,$communityName){
	$userCommunityModel = new UserCommunityModel();
	$count = $userCommunityModel->where("userId={$userId} and communityName='{$communityName}'")->count("id");
	if($count>0){
		return true;
	}else{
		return false;
	}
}