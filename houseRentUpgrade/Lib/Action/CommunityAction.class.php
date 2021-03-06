<?php

import("@.Model.CommunityModel");
import("@.Model.UserCommunityModel");
import('Common.Misc',APP_PATH,'.php');
import('Common.Common',APP_PATH,'.php');
import('Common.UserCommunityFunc',APP_PATH,'.php');

class CommunityAction extends Action
{
	//用户输入自己的公司
	function addCompany()
	{
		if(!isLogin())
		{
			header ( "Content-Type:text/html; charset=utf-8" );
			$this->redirect(C('LOGIN_URL'));
		}
		else
		{
			$data = array();
			$data['success'] = false;
			session_start();
			$userId = currentUserId();
			if(is_null($_POST['name']))
			{
				$data['msg'] = "公司名不能为空";
				$this->ajaxReturn($data);
				return;
			}		
			if(!updateUserCommunity($userId, $_POST['name'],COMPANY))
			{
				$data['msg'] = "操作错误";
				$this->ajaxReturn($data);
				return;
			}
			else
			{
				$data['msg'] = "修改成功";
				$data['success'] =true;
				$data['community'] = $_POST["name"];
				$this->ajaxReturn($data);
				return;
			}
		}
	}
	
	//用户输入自己的高校
	function addCollege()
	{
		if(!isLogin())
		{
			header ( "Content-Type:text/html; charset=utf-8" );
			$this->redirect(C('LOGIN_URL'));
		}
		else
		{
			$data = array();
			$data['success'] = false;
			session_start();
			$userId = currentUserId();
			if(is_null($_POST['name']))
			{
				$data['msg'] = "母校 名不能为空";
				$this->ajaxReturn($data);
				return;
			}
			if(!updateUserCommunity($userId, $_POST['name'],COLLEGE))
			{
				$data['msg'] = "操作错误";
				$this->ajaxReturn($data);
				return;
			}
			else
			{
				$data['msg'] = "修改成功";
				$data['success'] =true;
				$data['community'] = $_POST["name"];
				$this->ajaxReturn($data);
				return;
			}
		}
	}
	
	//用户输入自己的高校
	function addTargetCommunity()
	{
		if(!isLogin())
		{
			header ( "Content-Type:text/html; charset=utf-8" );
			$this->redirect(C('LOGIN_URL'));
		}
		else
		{
			$data = array();
			$data['success'] = false;
			session_start();
			$userId = currentUserId();
			if(is_null($_POST['name']))
			{
				$data['msg'] = "目标区域、小区不能为空";
				$this->ajaxReturn($data);
				return;
			}
			if(!updateUserCommunity($userId, $_POST['name'],COLLEGE))
			{
				$data['msg'] = "操作错误";
				$this->ajaxReturn($data);
				return;
			}
			else
			{
				$data['msg'] = "修改成功";
				$data['success'] =true;
				$data['community'] = $_POST["name"];
				$this->ajaxReturn($data);
				return;
			}
		}
	}
	
	//用户输入自己的高校
	function addCommunity()
	{
		if(!isLogin())
		{
			header ( "Content-Type:text/html; charset=utf-8" );
			$this->redirect(C('LOGIN_URL'));
		}
		else
		{
			$data = array();
			$data['success'] = false;
			$userId = currentUserId();
			if(is_null($_POST['name']))
			{
				$data['msg'] = "圈子名不能为空";
				$this->ajaxReturn($data);
				return;
			}
			if(!updateUserCommunity($userId, $_POST['name'],OTHER))
			{
				$data['msg'] = "操作错误";
				$this->ajaxReturn($data);
				return;
			}
			else
			{
				$data['msg'] = "修改成功";
				$data['success'] =true;
				$this->ajaxReturn($data);
				return;
			}
		}
	}
	
	//自动完成检索功能
	function autoComplete()
	{
		$list = array();
		if(isset($_POST['name']) && !is_null($_POST['name']))
		{
			$community = M('Community');
			$map = array();
			$map['name'] = array('like',"%{$_POST['name']}%");
			$list = $community->where($map)->getField('id,name');
		}
		if(is_null($list))
		{
			$list = array();
		}
		$data = array();
		$data['list'] = $list;
		$data['result'] = true;
		$this->ajaxReturn($data);
	}
	
	//判断用户是否设置公司
	function isUserCompanyExist()
	{
		$userCommunity = new UserCommunityModel();
		$userCompanyExist = $userCommunity->isUserCompanyExist();
		$data = array();
		$data["result"] = $userCompanyExist;
		$this->ajaxReturn($data);
	}
	
	//判断用户是否设置学校
	function isUserCollegeExist()
	{
		$userCommunity = new UserCommunityModel();
		$userCollegeExist = $userCommunity->isUserCollegeExist();
		$data = array();
		$data["result"] = $userCollegeExist;
		$this->ajaxReturn($data);
	}
	
	//保存圈子描述
	function saveDescription()
	{
		$data = array();
		if(!isset($_POST['circleName']) || is_null($_POST['circleName']))
		{
			$data["result"] = false;
			$data["msg"] = "圈子名称不能为空！";
			$this->ajaxReturn($data);
			return;
		}
		
		if(!isset($_POST['description']) || is_null($_POST['description']))
		{
			$data["result"] = false;
			$data["msg"] = "圈子描述不能为空！";
			$this->ajaxReturn($data);
			return;
		}
		
		if(!isLogin())
		{
			$data["result"] = false;
			$data["msg"] = "您还没有登录！";
			$this->ajaxReturn($data);
			return;
		}

		$communityModel = new CommunityModel();
		$community = $communityModel->findByName($_POST['circleName']);
		$communityId = $community["id"];
		
		$userId = currentUserId();
		$isMaster = $communityModel->isCommunityMaster($communityId, $userId);
		if(!isMaster)
		{
			$data["result"] = false;
			$data["msg"] = "您没有操作权限！";
			$this->ajaxReturn($data);
			return;
		}
		
		$communityData = array();
		$communityData["description"] = $_POST["description"];
		$communityModel->where("id={$communityId}")->save($communityData);
		$data["result"] = true;
		$this->ajaxReturn($data);
	}
	
	//圈子用户信息
	function communityMember()
	{
		$circleName = $_POST['circleName'];
			
		$data = array();
		$data['success'] = false;
			
		if(is_null($circleName))
		{
			$data['msg'] = "圈子名称为空！";
			$this->ajaxReturn($data);
			return;
		}
		$communityModel = new CommunityModel();
		$circle = $communityModel->where("name='{$circleName}'")->find();
		
		$communityId = $circle['id'];
			
		$data['success'] = true;
			
		$data["circleMaster"] = $communityModel->communityMaster($communityId);
		$community = $communityModel->find($communityId);
		$data["description"] = $community["description"];
		$data["canEdit"] = $communityModel->isCommunityMaster($communityId, currentUserId());
		
		$userCommunityModel = new UserCommunityModel();
		$data["communityUsers"] = $userCommunityModel->communityUsers($communityId);
		
		$userTagModel = new UserTagModel();
		foreach ($data["communityUsers"] as $key=>$value)
		{
			$data['communityUsers'][$key]["tags"] = $userTagModel->userTags($value["userId"]);
			$data['communityUsers'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
		}
		
		$result = $userCommunityModel->communityUserCount($communityId);
		$data["userCount"] = $result[0]["userCount"];
		$data["houseCount"] = $communityModel->communityHouseCount($communityId);
			
		$this->ajaxReturn($data);
	}
	
	//根据关键字查找圈子
	function search()
	{
		$key = $_POST["key"];
		$orderCondition = $_POST["orderCondition"];
		$data = array();
		$data["success"] = true;
		$communityModel = new CommunityModel();
		$result = $communityModel->searchDetail($key,$orderCondition);
		$data["communityList"] = $result["list"];
		$data["count"] = $result["count"];
		$this->ajaxReturn($data);
	}
	
	//受欢迎的圈子列表
	function popularList()
	{
		$data = array();
		$data["success"] = true;
		$communityModel = new CommunityModel();
		$data["communityList"] = $communityModel->popularList();
		$this->ajaxReturn($data);
	}
	
	//用户参与及管理的圈子
	function userJoinManageCommunity(){
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$userCommunityModel = new UserCommunityModel();
		$data["joinCommunityList"] = $userCommunityModel->userCommunities($userId, 0, 50);
		$data["joinCommunityCount"] = $userCommunityModel->userCommunityCount($userId);
		$data["manageCommunityList"] = $userCommunityModel->userManageCommunity($userId, 0, 50);
		$communityModel = new CommunityModel();
		$data["manageCommunityCount"] = $communityModel->where("creatorId={$userId}")->count("id");
		$data[success] = true;
		$this->ajaxReturn($data);
	}
	
	
	function exitCommunity(){
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		
		$circle = $_POST["circle"];
		if(!isset($circle)){
			$data["msg"] = "对不起，参数不正确！";
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$userCommunityModel = new UserCommunityModel();
		$userCommunityModel->where("communityName='{$circle}' and userId={$userId}")->delete();
		
		$userName = currentUserName();
		createCommunityMessage($userId, $circle,"{$userName}退出了圈子！");
		
		$data["success"]=true;
		$data["circle"] = $circle;
		$this->ajaxReturn($data);
		
	}
	
	//用户主动加入圈子
	function enterCommunity(){
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		
		$circle = $_POST["circle"];
		if(!isset($circle)){
			$data["msg"] = "对不起，参数不正确！";
			$this->ajaxReturn($data);
		}
		$userId = currentUserId();
		
		if(isUserCommunityExist($userId, $circle)){
			$data["msg"] = "您已经加入".$circle;
			$this->ajaxReturn($data);
		}
		
		if(!updateUserCommunity($userId, $circle,OTHER))
		{
			$data['msg'] = "对不起，加入失败！";
			$this->ajaxReturn($data);
		}
		else
		{
			$userName = currentUserName();
			createCommunityMessage($userId,$circle, "{$userName}加入了圈子！");
			$data['success'] =true;
			$this->ajaxReturn($data);
		}
	}
	
	function createCommunity(){
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"]="您还没有登录！";
			$this->ajaxReturn($data);
		}
		else
		{
			$userId = currentUserId();
			$circle = $_POST['circle'];
			if(!isset($circle))
			{
				$data['msg'] = "圈子名不能为空";
				$this->ajaxReturn($data);
			}
			if(!updateUserCommunity($userId, $circle,OTHER))
			{
				$data['msg'] = "操作错误";
				$this->ajaxReturn($data);
				return;
			}
			else
			{
				$description = $_POST["description"];
				if(isset($description)){
					$communityModel = new CommunityModel();
					$community = $communityModel->findByName($circle);
					$communityId = $community["id"];
					$community["description"] = $description;
					if($communityModel->create($community)){
						$communityModel->save();
					}
				} 
				
				$data['msg'] = "修改成功";
				$data['success'] =true;
				$data['community'] = $circle;
				$this->ajaxReturn($data);
				return;
			}
		}
	}
	
}