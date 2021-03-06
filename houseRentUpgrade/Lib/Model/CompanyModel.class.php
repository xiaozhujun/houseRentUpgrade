<?php
class CompanyModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","公司名不能为空"),
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
	
	//通过名称查找公司对象
	function findByName($name)
	{
		if(is_null($name))
		{
			return null;
		}
		return $this->where("name='{$name}'")->find();
	}
	
	//判断公司是否存在
	function isExist($name)
	{
		$company = $this->findByName($name);
		if($company) return true;
		return false;
	}

}