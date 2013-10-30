<?php
class HouseCollectModel extends Model{

	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("collectUser","require","收藏人不能为空"),
			array("houseUser","require","房源发布人不能为空"),
			array("houseId","require","房源编号不能为空"),
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
	
	//判断收藏是否存在
	function isExist($userId,$houseId)
	{
		$result = $this->where("collectUserId={$userId} and houseId={$houseId}")->select();
		if(sizeOf($result)>=1)
		{
			return true;
		}
		return false;
	}
	
	function findCollectHouseList($userId)
	{
		$wheresql=" and house_collect.collectUserId={$userId}";
	
		$querySQL = "select house_info.*,DATEDIFF(house_info.transferTime,NOW()) as leftDays,user.realName as realName".
				" from house_collect,house_info,user where ".
				" house_collect.houseId=house_info.houseId and house_collect.houseUserId=user.id  and house_info.transferTime >= NOW() ".$wheresql." order by house_info.transferTime asc limit 0,10";
		//     	     	echo $querySQL;
	
		$countSQL= "select count(house_info.houseId) as count from house_info,user,house_collect where ".
				"house_collect.houseId=house_info.houseId and house_collect.houseUserId=user.id and house_info.transferTime >= NOW() ".$wheresql;
		$list["list"]= $this->query($querySQL);
		$count=$this->query($countSQL);
		if($count){
			$list["allcount"]=$count[0]["count"];
		}else{
			$list["allcount"]=0;
		}
		return $list;
	}
	
}