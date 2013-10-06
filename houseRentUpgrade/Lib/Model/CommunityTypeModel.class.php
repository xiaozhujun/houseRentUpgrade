<?php
class CommunityTypeModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","类型名称不能为空"),
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

	//通过名称查找圈子类型对象
	function findByName($name)
	{
		if(is_null($name))
		{
			return null;
		}
		return $this->where("name='{$name}'")->find();
	}
	
	//判断圈子类型是否存在
	function isExist($name)
	{
		$commnunityType = $this->findByName($name);
		if($commnunityType) return true;
		return false;
	}
}