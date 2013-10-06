<?php
import('Common.Common',APP_PATH,'.php');

class UserCommunityModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("userId","require","用户编号不能为空"),
			array("communityId","require","圈子编号不能为空"),
	);
	
	//自动填充
	protected $_auto=array(
			array("createTime","dateTime",1,'callback'),
	);
	
	//当前系统时间
	function dateTime()
	{
		return date("Y-m-d H:i:s");
	}
	
	//判断用户公司是否存在
	function isUserCompanyExist($userId)
	{
		$userCompanyRecord = $this->join("community on user_community.communityId=community.id")->where("user_community.userId =".$userId." AND community.communityType=".COMMPANY)->find();
		if($userCompanyRecord)
		{
			return true;
		}
		return false;
	}
	
	//判断用户学校是否存在
	function isUserCollegeExsit()
	{
		$userCompanyRecord = $this->join("community on user_community.communityId=community.id")->where("user_community.userId =".$userId." AND community.communityType=".COLLEGE)->find();
		if($userCompanyRecord)
		{
			return true;
		}
		return false;
	}
	
	//根据圈子类型获得用户圈子
	function findCommunityWithType($userId,$communityType)
	{
		return $this->join("community on user_community.communityId=community.id")->where("user_community.userId=".$userId." AND community.communityType=".$communityType)->select();
	}
	
	//用户的圈子
	function userCommunities($userId)
	{
		return $this->join("community on user_community.communityId=community.id")->where("user_community.userId={$userId}")->field("user_community.communityName as name")->order("community.communityType asc")->limit(0,3)->select();
	}
}