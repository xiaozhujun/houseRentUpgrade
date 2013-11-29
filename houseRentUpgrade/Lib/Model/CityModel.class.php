<?php
class CityModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","名称不能为空"),
	);
}