<?php
import('Common.Misc',APP_PATH,'.php');
class HouseInfoModel extends Model{
	protected $trueTableName = 'house_info';
	
    /*
     * 通过参数信息查找房源
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
    		$wheresql=$wheresql." and ";
    	}
//     	$querySQL = "select * from house_info,user u,user_college c1,user_company c2".$wheresql."house_info.userId=u.id and house_info.userId=c1.id";
    	$querySQL = "select house_info.*,DATEDIFF(house_info.transferTime,NOW()) as leftDays,u.realName as realName,c3.`name` as collegeName,c4.`name` as companyName".
	" from house_info,user u,user_college c1,user_company c2,college c3,company c4 where ".
	$wheresql."house_info.userId=u.id and house_info.userId=c1.userId and house_info.userId=c2.userId
				and c3.id=c1.collegeId and c4.id=c2.companyId";
    	$countSQL="select count(*) count  from house_info ".$wheresql;
      	//echo $querySQL;
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
     * 根据houseId查询房屋详情页
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
    
    //受欢迎的房子
    function popularHouse()
    {
    	$now = dateTime();
    	return $this->where("transferTime>='{$now}'")->order("houseId desc")->limit(10)->select();
    }
    
    //一个街道的房源
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