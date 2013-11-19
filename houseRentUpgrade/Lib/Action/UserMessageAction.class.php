<?php
import ( "@.Model.UserModel" );
import ( "@.Model.UserMessageModel" );
import ( 'Common.Misc', APP_PATH, '.php' );

class UserMessageAction extends Action {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ( "/" );
	}
	
	//用户标签
	public function userMessages(){
		$data = array();
		if(!isLogin()){
			$data["success"] = false;
			$data["msg"] = "请您登陆后再操作！";
			$this->ajaxReturn($data);
			return;
		}
		
		$userId = currentUserId();
		$userMessageModel = new UserMessageModel();
		$messageCount = $userMessageModel->userNewMessageCount($userId);
		$data["messages"] = $userMessageModel->userMessages($userId, $messageCount);
		$data["messageCount"] = $messageCount;
		$data["success"] = true;
		
		//设置用户信息为已读
		$userMessageModel->setMessageRead($userId);
		$this->ajaxReturn($data);
	}
	
}