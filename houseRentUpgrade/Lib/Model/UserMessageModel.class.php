<?php
class UserMessageModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("message","require","标签名不能为空"),
			array("toUserId","require","接收用户编号不能为空"),
	);
	
	//根据用户编号查找所有对应的标签
	function userMessages($userId,$count)
	{
		if(!isset($userId)) return null;
		return $this->where("toUserId={$userId}")->field("id,message,createTime,status")->limit(0,$count)->select();
	}
	
	//用户未读消息总数
	function userNewMessageCount($userId)
	{
		if(!isset($userId)) return null;
		return $this->where("toUserId={$userId} and status=0")->count();
	}
	
	//设置用未读消息为已读
	function setMessageRead($userId){
		if(!isset($userId)) return false;
		$data = array(
				"status"=>1,
				"updateTime"=>date("Y-m-d H:i:s")
		);
		$this->where("toUserId={$userId} and status=0")->save($data);
		return true;
	}
	
	//添加消息
	function saveMessage($toUserId,$message,$fromUserId){
		$data = array(
				"toUserId"=>$toUserId,
				"message"=>$message,
				"fromUserId"=>$fromUserId,
				"createTime"=>date("Y-m-d H:i:s"),
				"status"=>0
		);
		
		if($this->create($data)){
			$this->add();
		}
		else{
			return false;
		}
		return true;
	}

}