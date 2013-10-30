<?php
import ( "@.Model.HouseInfoModel" );
import ( "@.Model.HouseCollectModel" );

import ( 'Common.MailUtil', APP_PATH, '.php' );
import ( 'Common.DateUtil', APP_PATH, '.php' );
import ( 'Common.Misc', APP_PATH, '.php' );

// 本类由系统自动生成，仅供测试用途
class HouseCollectAction extends Action {
	
	//收集房源
	function collect() {
		$data = array();
		$data["success"] = false;
		if(!isLogin())
		{
			$data["msg"] = "您还没有登录哦！";
			$this->ajaxReturn($data);
		}
		$houseId = $_POST["houseId"];
		if(!isset($houseId) || empty($houseId)){
			$data["msg"] = "没有房源编号哦！";
			$this->ajaxReturn($data);
		}
		
		
		$userId = currentUserId();
		
		$houseCollectModel = new HouseCollectModel();
		if($houseCollectModel->isExist($userId, $houseId))
		{
			$data['msg'] = "您已经收藏了该房源哦！";
			$this->ajaxReturn($data);
		}
		
		$houseInfoModel = new HouseInfoModel();
		$houseInfo = $houseInfoModel->where("houseId={$houseId}")->find();
		$houseCollectObj = array(
				"collectUserId"=>$userId,
				"houseUserId"=>$houseInfo['userId'],
				"houseId"=>$houseInfo['houseId'],
				"createTime"=>dateTime(),
		);
		$houseCollectModel = new HouseCollectModel();
		if($houseCollectModel->create($houseCollectObj))
		{
			$houseCollectModel->add();
			$data['success'] = true;
		}
		else 
		{
			$data['msg'] = $houseCollectModel->getError();
		}
		$this->ajaxReturn($data);
	}
	
	//用户收集的房源列表
	function collectHouseList()
	{
		if(!isLogin())
		{
			redirect("/login.html");
			return;
		}
		$data = array();
		$data['result'] = true;
		
		$userId = currentUserId();
		$houseCollectModel = new HouseCollectModel();
		$data['houseList']=$houseCollectModel->join("house_info ON house_collect.houseId=house_info.houseId")->where("house_collect.collectUser={$userId}")->field("house_info.houseId,house_info.title,house_info.price,house_info.transferTime,house_info.room,house_info.parlor,house_info.washroom")->select();
		$this->ajaxReturn($data);
	}
	
}