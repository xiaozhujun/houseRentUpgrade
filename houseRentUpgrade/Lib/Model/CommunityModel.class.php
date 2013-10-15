<?php
class CommunityModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","圈子名不能为空"),
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

	//通过名称查找圈子对象
	function findByName($name)
	{
		if(is_null($name))
		{
			return null;
		}
		return $this->where("name='{$name}'")->find();
	}
	
	//判断圈子是否存在
	function isExist($name)
	{
		$college = $this->findByName($name);
		if($college) return true;
		return false;
	}
	
	//获得圈主
	function communityMaster($communityId)
	{
		$querySQL = "select creatorId as userId,creator as userName from community where id={$communityId}";
		return $this->query($querySQL);
	}
	
	//当前用户是否为圈主
	function isCommunityMaster($communityId,$userId)
	{
		$querySQL = "select count(id) as count from community where id={$communityId} and creatorId={$userId}";
// 		echo $querySQL;
		$result = $this->query($querySQL);
		if($result[0]["count"]>0) return true;
		
		return false;
	}
	
	//圈子房源数
	function communityHouseCount($communityId)
	{
		if(is_null($communityId)){
			return 0;
		}
			
		$countSQL= "select count(house_info.houseId) as count from house_info,user,user_community,community where ".
				"house_info.userId=user.id and house_info.userId=user_community.userId
				and community.id=user_community.communityId and house_info.transferTime >= NOW()  and user_community.communityId={$communityId}";
		$count=$this->query($countSQL);
		if($count){
			return $count[0]["count"];
		}else{
			return 0;
		}
	}
}