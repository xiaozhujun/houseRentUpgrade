<?php
class CommunityModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("name","require","圈子名不能为空"),
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

	//通过名称查找圈子对象
	function findByName($name)
	{
		if(is_null($name))
		{
			return null;
		}
		return $this->where("name='{$name}'")->find();
	}
	
	//判断圈子是否存在
	function isExist($name)
	{
		$college = $this->findByName($name);
		if($college) return true;
		return false;
	}
}