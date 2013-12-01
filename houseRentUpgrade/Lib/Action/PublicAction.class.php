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
		$this->display( "index.html" );
	}
}