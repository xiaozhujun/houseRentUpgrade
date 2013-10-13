<?php

//更新用户所在高校信息
function updateUserCommunity($userId,$communityName,$communityType)
{ 	
	$communityModel = D('Community');
	$userCommunityModel = D('UserCommunity');
	//判断该公司信息是否存在，不存在则在数据库中添加一条记录
	$communityObj = $communityModel->findByName($communityName);
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
	else 
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
		$userCommunityObj['communityId'] = $communityId;
		$userCommunityObj['communityName'] = $communityName;
		$result = $userCommunityModel->data($userCommunityObj)->save();
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