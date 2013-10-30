<?php
class UserTagModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("tagName","require","标签名不能为空"),
			array("userId","require","用户编号不能为空"),
	);
	
	//根据用户编号查找所有对应的标签
	function userTags($userId)
	{
		if(!isset($userId)) return null;
		return $this->where("userId={$userId}")->select();
	}

}