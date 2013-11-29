<?php
import("@.Model.CityModel");
import("@.Model.DistrictModel");
import('Common.Misc',APP_PATH,'.php');

class CityAction extends Action
{
	//城市列表
	function cityList(){
		$data = array();
		$data["success"] = true;
		$cityModel = new CityModel();
		$data["list"] = $cityModel->select();
		$this->ajaxReturn($data);
	}
	
	
	//城市对应的区域
	function cityDistrict(){
		$data = array();
		$data["success"]  = false;
		
		$city = $_POST["city"];
		if(!isset($city)){
			$data["msg"] = "城市不能为空！";
			$this->ajaxReturn($data);
		}
		
		$cityModel = new CityModel();
		$cityObj = $cityModel->where("name='{$city}'")->find();
		if($cityObj){
			$cityId = $cityObj["id"];
			$districtModel = new DistrictModel();
			$data["list"] = $districtModel->where("cityId={$cityId}")->select();
			$data["success"] = true;
		}

		$this->ajaxReturn($data);
	}
}