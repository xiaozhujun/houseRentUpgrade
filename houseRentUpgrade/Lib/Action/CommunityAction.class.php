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
			session_start();
			$userId = $_SESSION['userId'];
			if(is_null($_POST['name']))
			{
				$data['msg'] = "公司名不能为空";
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
		$communityId = $communityModel->findByName($_POST['circleName'])["id"];
		
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
		$data["description"] = $communityModel->find($communityId)["description"];
		$data["canEdit"] = $communityModel->isCommunityMaster($communityId, currentUserId());
		
		$userCommunityModel = new UserCommunityModel();
		$data["communityUsers"] = $userCommunityModel->communityUsers($communityId);
		
		$result = $userCommunityModel->communityUserCount($communityId);
		$data["userCount"] = $result[0]["userCount"];
		$data["houseCount"] = $communityModel->communityHouseCount($communityId);
			
		$this->ajaxReturn($data);
	}
	
}