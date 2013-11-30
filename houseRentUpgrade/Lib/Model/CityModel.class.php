<?php
class CityModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","名称不能为空"),
	);
	
	function findByName($name){
		if(is_null($name))
		{
			return null;
		}
		return $this->where("name='{$name}'")->find();
	}
	
	function iniCity(){
		$cityList = array(
				array("name"=>"北京"),
				array("name"=>"上海"),
				array("name"=>"广州"),
				array("name"=>"深圳"),
				array("name"=>"杭州")
		);
		$cityModel = new CityModel();
		foreach($cityList as $city){
			if($cityModel->create($city)){
				$cityModel->add();
			}
		}
	}
}