<?php
import('Common.Misc',APP_PATH,'.php');
import("@.Model.UserCompanyModel");
import("@.Model.CompanyModel");
import("@.Model.UserCollegeModel");
import("@.Model.CollegeModel");
import("@.Model.UserTargetHouseModel");
import("@.Model.TargetHouseModel");

class PublicAction extends Action
{
	//平台首页
	function index()
	{
		if(!isLogin())
		{
			header ( "Content-Type:text/html; charset=utf-8" );
			$this->display ( "loginIndex" );
		}
		else 
		{
			session_start();
			$this->assign('user',$_SESSION ['user']);
			$companyName = "";
			$collegeName = "";
			$communityName = "";
			
			//获得当前用户的公司名称
			$companyName = currentUserCollege();
			//获得当前用户的高校名称
			$collegeName = currentUserCollege();
			//获得当前用户的目标住房
			$communityName =currentUserTargetCommunity();
			
			$this->assign('companyName',$companyName);
			$this->assign('collegeName',$collegeName);
			$this->assign('communityName',$communityName);
			header ( "Content-Type:text/html; charset=utf-8" );
			$this->display ( "index" );
		}
	}
}