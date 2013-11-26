<?php
import ( "@.Model.UserModel" );
import ( "@.Model.UserMessageModel" );
import ( 'Common.Misc', APP_PATH, '.php' );

class CommunityMessageAction extends Action {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ( "/" );
	}
	
	//用户标签
	public function communityMessages(){
		$data = array();
		$data["success"] = false;
		$circle = $_POST["circleName"];
		if(!isset($circle)){
			$data["msg"] = "圈子名称不能为空！";
			$this->ajaxReturn($data);
		}
		
		$communityModel = new CommunityModel();
		$community = $communityModel->findByName($circle);
		if(!isset($community)){
			$data["msg"] = "圈子不存在！";
			$this->ajaxReturn($data);
		}
		
		$communityMessageModel = new CommunityMessageModel();
		$data["list"] = $communityMessageModel->communityMessages($community["id"], 20);
		$data["success"] = true;
		$this->ajaxReturn($data);
	}
	
}