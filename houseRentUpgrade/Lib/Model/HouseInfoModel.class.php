<?php
import('Common.Misc',APP_PATH,'.php');
class HouseInfoModel extends Model{
	protected $trueTableName = 'house_info';
	
    /*
     * 閫氳繃鍙傛暟淇℃伅鏌ユ壘鎴挎簮
     */
//    function findHouse($region,$price,$houseType)
    function findHouse($post)
    {
    	$region=$post["region"];
    	$price=$post["price"];
    	$houseType=$post["type"];
    	$key=$post["key"];
    	$room=$post["room"];
    	$wheresql="";
    	if(!is_null($region)){
    		if($wheresql==""){
    			$wheresql.=" region=".$region;
    		}else{
    			$wheresql.=" and region=".$region;
    		}
    	}
       	if(!is_null($price)){
       	    if($wheresql==""){
    			$wheresql.=getPriceInfo($price);
    		}else{
    			$wheresql.=" and ".getPriceInfo($price);
    		}
    	}
        if(!is_null($houseType)){
            if($wheresql==""){
    			$wheresql.=" house_type=".$houseType;
    		}else{
    			$wheresql.=" and house_type=".$houseType;
    		}
    	}
        if(!is_null($key)){
            if($wheresql==""){
    			$wheresql.=getKeyWordInfo($key);
    		}else{
    			$wheresql.=" and ".getKeyWordInfo($key);;
    		}
    	}
        if(!is_null($room)){
            if($wheresql==""){
    			$wheresql.=getRoomInfo($room);
    		}else{
    			$wheresql.=" and ".getRoomInfo($room);
    		}
    	}
    	if($wheresql!=""){
    		$wheresql=" and ".$wheresql;
    	}
    	$querySQL = "select house_info.*,DATEDIFF(house_info.transferTime,NOW()) as leftDays,user.realName as realName".
    			" from house_info,user where ".
    					"house_info.userId=user.id and house_info.transferTime >= NOW() ".$wheresql." order by house_info.transferTime asc limit 0,10";
    	$countSQL="select count(*) count  from house_info ".$wheresql;
//       	echo $querySQL;
    	$list["list"]= $this->query($querySQL);
//     	$count=$this->query($countSQL);
//     	if($count){
//     		$list["allcount"]=$count[0]["count"];
//     	}else{
//     		$list["allcount"]=0;
//     	}
    	return $list;
    }
    
    //閫氳繃鏌ユ壘鏉′欢鏌ユ壘鎴挎簮鍒楄〃
    function findHouseWithCondition($condition)
    {
    	$wheresql="";
    	
    	if($condition!=""){
    		$wheresql=" and ".$condition;
    	}
    	$querySQL = "select house_info.*,DATEDIFF(house_info.transferTime,NOW()) as leftDays,user.realName as realName".
    			" from house_info,user where ".
    					"house_info.userId=user.id and house_info.transferTime >= NOW() ".$wheresql." order by house_info.transferTime asc limit 0,10";
//     	echo $querySQL;
    	
    	$countSQL="select count(*) count from house_info ";
    	$list["list"]= $this->query($querySQL);
    	$count=$this->query($countSQL);
    	if($count){
    		$list["allcount"]=$count[0]["count"];
    	}else{
    		$list["allcount"]=0;
    	}
    	return $list;
    }
    
    function findHouseWithCircle($communityId)
    {
    	$wheresql=" and user_community.communityId={$communityId}";
    	 
    	$querySQL = "select house_info.*,DATEDIFF(house_info.transferTime,NOW()) as leftDays,user_community.userName as realName".
    			" from house_info,user_community where ".
    			"house_info.userId=user_community.userId and house_info.transferTime >= NOW() ".$wheresql." order by house_info.transferTime asc limit 0,10";
//     	     	echo $querySQL;
    	 
    	$countSQL= "select count(house_info.houseId) as count from house_info,user,user_community,community where ".
    			"house_info.userId=user.id and house_info.userId=user_community.userId
				and community.id=user_community.communityId and house_info.transferTime >= NOW() ".$wheresql;
    	$list["list"]= $this->query($querySQL);
    	$count=$this->query($countSQL);
    	if($count){
    		$list["allcount"]=$count[0]["count"];
    	}else{
    		$list["allcount"]=0;
    	}
    	return $list;
    }
    
    
    /*
     * 鏍规嵁houseId鏌ヨ鎴垮眿璇︽儏椤�
     */
    function getHouseInfo($houseId){

    	if($houseId<=0){
			$data=null;
			return data;
    	}
    		 
    	$querySQL = "select * from house_info where house_id=".$houseId;
    	$houseinfo= $this->query($querySQL);
		if($houseinfo){
			$data=$houseinfo[0];
		}else{
			$data=null;
		}
    	
    } 
    
    //鍙楁杩庣殑鎴垮瓙
    function popularHouse()
    {
    	$now = dateTime();
    	return $this->where("transferTime>='{$now}'")->order("houseId desc")->limit(10)->select();
    }
    
    //涓�釜琛楅亾鐨勬埧婧�
    function streetHouse($street)
    {
    	if(is_null($street))
    	{
    		return array();
    	}
    	$now = dateTime();
    	return $this->where("transferTime>='{$now}' and street like '%{$street}%'")->order("houseId desc")->limit(10)->select();
    }

}