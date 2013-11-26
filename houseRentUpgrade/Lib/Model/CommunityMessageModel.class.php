<?php
class CommunityMessageModel extends Model{
	//自动验证
	protected $_validate=array(
			//每个字段的详细验证内容
			array("message","require","标签名不能为空"),
			array("communityId","require","圈子编号不能为空"),
	);
	
	function communityMessages($communityId,$count)
	{
		if(!isset($communityId) || !isset($count)) return null;
		return $this->where("communityId={$communityId}")->field("id,message,createTime")->order("id desc")->limit(0,$count)->select();
	}
	
	function saveMessage($userId,$communityName,$message){
		$communityModel = new CommunityModel();
		$community = $communityModel->findByName($communityName);
		
		if(isset($community)){
			$data = array(
					"userId"=>$userId,
					"communityId"=>$community["id"],
					"message"=>$message,
					"createTime"=>date("Y-m-d H:i:s")
			);
			
			if($this->create($data)){
				$this->add();
				return true;
			}
			else{
				return false;
			}
		}
		
		return false;
	}

}