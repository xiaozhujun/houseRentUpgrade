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
		return $this->join("community on user_community.communityId=community.id")->where("user_community.userId={$userId} AND community.communityType={$communityType}")->field("user_community.id as id,user_community.userId as userId,user_community.communityName as communityName")->select();
	}
	
	function userCompany($userId)
	{
		//获得当前用户的公司名称
		$userCommunity = new UserCommunityModel();
		$userCompanyList = $this->findCommunityWithType($userId,COMPANY);
		if($userCompanyList && count($userCompanyList)>0)
		{
			return $userCompanyList[0]["communityName"];
		}
		return null;
	}
	
	function userCollege($userId)
	{
		//获得当前用户的学校名称
		$userCommunity = new UserCommunityModel();
		$userCollegeList = $userCommunity->findCommunityWithType($userId,COLLEGE);
		if($userCollegeList && count($userCollegeList)>0)
		{
			return $userCollegeList[0]["communityName"];
		}
		return null;
	}
	
	//用户参与的圈子
	function userCommunities($userId,$limitStart,$limitCount)
	{
		return $this->join("community on user_community.communityId=community.id")->where("user_community.userId={$userId}")->field("user_community.communityName as name,user_community.communityId as id")->order("community.communityType asc")->limit($limitStart,$limitCount)->select();
	}
	
	//用户参与圈子数
	function userCommunityCount($userId){
		return $this->join("community on user_community.communityId=community.id")->where("user_community.userId={$userId}")->count("community.id");
	}
	
	//圈子成员总数
	function communityUserCount($communityId)
	{
		$querySQL = "select count(userId) as userCount from user_community where communityId=".$communityId;
		return $this->query($querySQL);
	}
	
	//圈子用户
	function communityUsers($communityId)
	{
		$querySQL = "select userId,userName from user_community where communityId=".$communityId;
		return $this->query($querySQL);
	}
	
	//用户管理的圈子
	function userManageCommunity($userId,$limitStart,$limitCount){
		$sql = "select id,name from community where creatorId={$userId} order by id desc limit {$limitStart},{$limitCount}";
		return  $this->query($sql);
	}
	
}