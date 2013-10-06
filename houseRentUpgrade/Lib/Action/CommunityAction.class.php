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
}