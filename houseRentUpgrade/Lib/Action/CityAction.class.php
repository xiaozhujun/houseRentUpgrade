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
		
		$cityObj = $cityModel->findByName($city);
		if(isset($cityObj)){
			$cityId = $cityObj["id"];
			$districtModel = new DistrictModel();
			$data["list"] = $districtModel->where("cityId={$cityId}")->select();
			$data["success"] = true;
		}else{
			$data["msg"] = "对不起，操作错误！";
		}

		$this->ajaxReturn($data);
	}
	
	function iniCity(){
		$cityModel = new CityModel();
		$cityModel->iniCity();
		$data = array();
		$data["success"] = true;
		$this->ajaxReturn($data);
		
	}
	
	function iniDistrict(){
		$districtModel = new DistrictModel();
		$districtModel->iniDistrict();
		$data = array();
		$data["success"] = true;
		$this->ajaxReturn($data);
	
	}
}