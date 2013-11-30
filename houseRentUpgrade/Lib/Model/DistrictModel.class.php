<?php
class DistrictModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","名称不能为空"),
	);
	
	function iniDistrict(){
		$districtList = array(
				array("name"=>"东城区",cityId=>1),
				array("name"=>"西城区",cityId=>1),
				array("name"=>"宣武区",cityId=>1),
				array("name"=>"朝阳区",cityId=>1),
				array("name"=>"丰台区",cityId=>1),
				array("name"=>"石景山区",cityId=>1),
				array("name"=>"海淀区",cityId=>1),
				array("name"=>"门头沟区",cityId=>1),
				array("name"=>"房山区",cityId=>1),
				array("name"=>"通州区",cityId=>1),
				array("name"=>"顺义区",cityId=>1),
				array("name"=>"昌平区",cityId=>1),
				array("name"=>"大兴区",cityId=>1),
				array("name"=>"虹口区",cityId=>2),
				array("name"=>"闸北区",cityId=>2),
				array("name"=>"浦东新区",cityId=>2),
				array("name"=>"普陀区",cityId=>2),
				array("name"=>"长宁区",cityId=>2),
				array("name"=>"徐汇区",cityId=>2),
				array("name"=>"宝山区",cityId=>2),
				array("name"=>"嘉定区",cityId=>2),
				array("name"=>"青浦区",cityId=>2),
				array("name"=>"闽行区",cityId=>2),
				array("name"=>"奉贤区",cityId=>2),
				array("name"=>"白云区",cityId=>3),
				array("name"=>"天河区",cityId=>3),
				array("name"=>"海珠区",cityId=>3),
				array("name"=>"萝岗区",cityId=>3),
				array("name"=>"黄埔区",cityId=>3),
				array("name"=>"番禺区",cityId=>3),
				array("name"=>"顺德区",cityId=>3),
				array("name"=>"高明区",cityId=>3),
				array("name"=>"南沙区",cityId=>3),
				array("name"=>"三水区",cityId=>3),
				array("name"=>"花都区",cityId=>3),
				array("name"=>"福田区",cityId=>4),
				array("name"=>"罗湖区",cityId=>4),
				array("name"=>"南山区",cityId=>4),
				array("name"=>"盐田区",cityId=>4),
				array("name"=>"宝安区",cityId=>4),
				array("name"=>"龙岗区",cityId=>4),
				array("name"=>"西湖区",cityId=>5),
				array("name"=>"上城区",cityId=>5),
				array("name"=>"下城区",cityId=>5),
				array("name"=>"江干区",cityId=>5),
				array("name"=>"滨江区",cityId=>5),
				array("name"=>"拱野区",cityId=>5),
				array("name"=>"萧山区",cityId=>5)
		);
		$districtModel = new DistrictModel();
		foreach($districtList as $district){
			if($districtModel->create($district)){
				$districtModel->add();
			}
		}
	}
}