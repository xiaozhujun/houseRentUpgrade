<?php
import ( "@.Model.UserModel" );
import ( "@.Model.UserTagModel" );
import ( 'Common.Misc', APP_PATH, '.php' );

class UserTagAction extends Action {
	public function index() {
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->display ( "/" );
	}
	
	//添加标签
	public function addTag(){
		$data = array();
		if(!isLogin()){
			$data["success"] = false;
			$data["msg"] = "请您登陆后再操作！";
			$this->ajaxReturn($data);
			return;
		}
		
		$tagName = $_POST["tagName"];
		if(is_null($tagName) || empty($tagName)){
			$data["success"] = false;
			$data["msg"] = "标签名不能为空！";
			$this->ajaxReturn($data);
			return;
		}
		
		$userId = currentUserId();
		$userTagModel = new UserTagModel();
		$saveData = array();
		$saveData["userId"] = $userId;
		$saveData["tagName"] = $tagName;
		if($userTagModel->create($saveData)){
			$userTagModel->add();
		}
		else{
			$data["success"] = false;
			$data["msg"] = $userTagModel->getError();
			$this->ajaxReturn($data);
			return;
		}
		$data["success"] = true;
		$data["tagName"] = $tagName;
		$this->ajaxReturn($data);
	}
	
	//删除标签
	public function deleteTag(){
		$data = array();
		if(!isLogin()){
			$data["success"] = false;
			$data["msg"] = "请您登陆后再操作！";
			$this->ajaxReturn($data);
			return;
		}
		
		$tagName = $_POST["tagName"];
		if(is_null($tagName) || empty($tagName)){
			$data["success"] = false;
			$data["msg"] = "标签名不能为空！";
			$this->ajaxReturn($data);
			return;
		}
		
		$userId = currentUserId();
		$userTagModel = new UserTagModel();
		$userTagModel->where("userId={$userId} and tagName='{$tagName}'")->delete();
		$data["success"] = true;
		$data["tagName"] = $tagName;
		$this->ajaxReturn($data);
	}
	
	//某个用户的所有标签
	public function currentUserTags(){
		$data = array();
		if(!isLogin()){
			$data["success"] = false;
			$data["msg"] = "请您登陆后再操作！";
			$this->ajaxReturn($data);
			return;
		}
		
		$userId = currentUserId();
		$userTagModel = new UserTagModel();
		$data["success"] = true;
		$data["tags"] = $userTagModel->userTags($userId);
		$this->ajaxReturn($data);
	}
	
}