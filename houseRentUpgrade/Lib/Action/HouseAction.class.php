<?php
import("@.Model.HouseInfoModel");
import("@.Model.RegionModel");
import("@.Model.UserModel");
import("@.Model.CommunityModel");
import("@.Model.UserCommunityModel");
import("@.Model.UserCompanyModel");
import("@.Model.UserCollegeModel");
import("@.Model.HouseCollectModel");
import("@.Model.HouseViewModel");
import("@.Model.OneDuFriendModel");
import('Common.HousePublish',APP_PATH,'.php');
import('Common.Util',APP_PATH,'.php');
import('Common.Misc',APP_PATH,'.php');

/*
 * 房源相关的操作，发布房源，查询房源
 */
class HouseAction extends Action {
	
	//开始搜索
	function search()
	{
		if(isLogin())
		{
			session_start();
			$this->assign('user',currentUserName());
			header ( "Content-Type:text/html; charset=utf-8" );
		}
// 		$this->display ( "search" );
	}
	
	//关键字查询房源
	function doSearch()
	{
		
	}
	
	/*
	 * 添加房源页面
	 */
	function publishHouse() {
		header ( "Content-Type:text/html; charset=utf-8" );

		$this->display ( "publishhouse" );
	}
	
	/*
	 * 房源列表页面
	 */
	function houseList() {
// 		header ( "Content-Type:application/json; charset=utf-8" );
		$data = array();
		$houseinfo = new HouseInfoModel();
		
		$houseinfolist=$houseinfo->findHouse($_POST);
		$data['all_count']=$houseinfolist["allcount"];

		if($data['all_count']==0){
			$data['current_count']=0;
		}
		if($houseinfolist["list"]){
			$data['current_count']=count($houseinfolist["list"]);
			$data['houseList']=$houseinfolist["list"];
		}else{
			$data['current_count']=0;
			$data['houseList']=null;
			
		}
		
		$housePhotoModel = new HousePhotoModel();
		$userCommunityModel = new UserCommunityModel();
		foreach ($data['houseList'] as $key=>$value)
		{
			$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
			$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
		}
		
		
		
		$this->ajaxReturn($data);
	}
	
	/*
	 * 提交发布房源信息
	 */
	function publishHouseAction(){
		$data = array();
		if(!isLogin())
		{
			$data['code']=-1;
			$data['msg']="请您先登录!";
			$this->ajaxReturn($data);
		}
		$userId = currentUserId();
		$houseInfo = D ("HouseInfo");
		if($houseInfo->create ())
		{
			$houseInfo->userId=$userId;
			$houseInfo->createTime=intNow();
			$houseInfo->viewCount=0;
			
			$houseId = $houseInfo->add();
			$housePhotos = getPhotos();
			deleteSessionKey($key);
			$housePhoto = new HousePhotoModel();
			$housePhoto->addPhotoToHouse($houseId, $userId, $housePhotos);
			
			
			if($houseId){
				$data['code']=0;
				$data['msg']="";
			}else{
				$data['code']=1;
				$data['msg']="publish fail!";
			}	
		}
		else
		{
			$data['code']=1;
			$data['msg']=$user->getError();
		}
		
		$this->ajaxReturn($data);

	}
	
	/*
	 * 提交发布房源信息
	*/
	function updateHouseInfo(){
		$data = array();
		if(!isLogin())
		{
			$data['success']= false;
			$data['msg']="请您先登录!";
			$this->ajaxReturn($data);
		}
		$userId = currentUserId();
		
		$houseInfoModel = new HouseInfoModel();
		$house = $houseInfoModel->where("houseId={$_POST['houseId']} and userId={$userId}")->find();
		if(!isset($house)){
			$data['success']= false;
			$data['msg']="操作失败!";
			$this->ajaxReturn($data);
		}
		
		$houseInfo = D ("HouseInfo");
		if($houseInfo->create ())
		{
			$houseInfo->updateTime=date("Y-m-d H:i:s");
				
			$houseId = $houseInfo->save();
			$housePhotos = getPhotos();
			deleteSessionKey($key);
			$housePhoto = new HousePhotoModel();
			$housePhoto->addPhotoToHouse($houseId, currentUserId(), $housePhotos);
				
				
			if($houseId){
				$data['success']=true;
			}else{
				$data['success']=false;
				$data['msg']="对不起，操作失败!";
			}
		}
		else
		{
			$data['success']=false;
			$data['msg']="对不起，操作失败!";
		}
	
		$this->ajaxReturn($data);
	
	}
	
	/*
	 * 提交发布房源信息
	*/
	function updateHouseStatus(){
		$data = array();
		if(!isLogin())
		{
			$data['success']= false;
			$data['msg']="请您先登录!";
			$this->ajaxReturn($data);
		}
		$userId = currentUserId();
		$houseId = $_POST['houseId'];
	
		$houseInfoModel = new HouseInfoModel();
		$house = $houseInfoModel->where("houseId={$houseId} and userId={$userId}")->find();
		if(!isset($house)){
			$data['success']= false;
			$data['msg']="操作失败!";
			$this->ajaxReturn($data);
		}
	
		$houseInfo = D ("HouseInfo");
		$houseData = array();
		$houseData["houseId"] = $houseId;
		$houseData["status"] = $_POST["status"];
		if($houseInfo->create ($houseData))
		{
			$houseInfo->updateTime=date("Y-m-d H:i:s");
			$houseId = $houseInfo->save();
			
			if($houseId){
				$data['success']=true;
			}else{
				$data['success']=false;
				$data['msg']="对不起，操作失败!";
			}
		}
		else
		{
			$data['success']=false;
			$data['msg']="对不起，操作失败!";
		}
	
		$this->ajaxReturn($data);
	
	}
	
	/*
	 * 根据房屋id查询房屋详情页
	 */
	function houseInfoAction(){
		header ( "Content-Type:text/html; charset=utf-8" );
		if(!isLogin())
		{
			$data['code']=-1;
			$data['msg']="not login!";
			$this->assign ( 'data', $data);
			//$this->display ( "houseinfo" );
			return ;
		}
		$houseId=$_POST['houseId'];
		$data = array();
		$houseinfo = new HouseInfoModel();
		$data["houseinfo"]=$houseinfo->getHouseInfo($houseId);
		$this->assign ( 'data', $data);
	/* 	$this->display ("houseinfo"); */
		$this->ajaxReturn($data);
		
	}
	
	//查看房源信息
	function info()
	{
		$houseId = $_GET['id'];
		$data=array();
		
		if(is_null($houseId))
		{

			$data['success'] = false;
			$data["msg"] = "参数不能为空！";
			$this->ajaxReturn($data);
		}
		if(isLogin())
		{
			$this->assign('user',currentUserName());
			header ( "Content-Type:text/html; charset=utf-8" );
		}
		
		$houseInfo = M('HouseInfo');
		$houseInfoObj = $houseInfo->find($houseId);
		$data['houseinfo']=$houseInfo->field("createTime,title,transferTime,price,street,community,contactPerson,contactPhone,room,parlor,washroom,area,detailDescription,houseId,userId")->find($houseId);
		
		$housePhotoModel = new HousePhotoModel();
		$data['houseinfo']['photos'] = $housePhotoModel->getHousePhotos($data['houseinfo']['houseId']);
		
		$region = M('Region');
		$regionId = $houseInfoObj['region'];
		$regionObj = $region->find($regionId);
		$data['region']=$region->find($regionId);
		
		$houseUser = M("User");
		$houseUserId = $houseInfoObj["userId"];
		$data['houseuser']=$houseUser->field("realName,id")->find($houseUserId);
		
		$userCommunityModel = new UserCommunityModel();
		$data["circles"] = array_values($userCommunityModel->userCommunities($houseUserId,0,10));
		$data["company"] = $userCommunityModel->userCompany($houseUserId);
		$data["college"] = $userCommunityModel->userCollege($houseUserId);
		
		//保存用户浏览房源记录
		$houseViewModel = new HouseViewModel();
		$result = $houseViewModel->saveOrUpdate(currentUserId(),$houseId);
		if(result==1)
		{
			$houseInfo->where("houseId={$houseId}")->setInc("viewCount",1);
		}
		
		header ( "Content-Type:text/html; charset=utf-8" );
		$this->ajaxReturn($data);
	}
	
	//关注度高的房子
	function popularHouse()
	{
		$houseInfoModel = new HouseInfoModel();
		$houseList =$houseInfoModel->popularHouse();
		$data = array();
		$data['result'] = true;
		$data['houseList'] = $houseList;
		$this->ajaxReturn($data);
	}
	
	//一个街道的房子
	function streetHouse()
	{
		$data = array();
		$street = $_POST['street'];
		if(is_null($street))
		{
			$data['result'] = false;
			$data['msg']="参数不正确！";
			$this->ajaxReturn($data);
			return;
		}
		
		$houseInfoModel = new HouseInfoModel();
		$data['result'] = true;
		$data['houseList'] = $houseInfoModel->streetHouse($street);
		$this->ajaxReturn($data);
	}
	
	//好友房源
	function friendHouse()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$houseInfoModel = new HouseInfoModel();
		$houseList = $houseInfoModel->findFriendHouse($userId);
		
		$data["success"] = true;
		$data["houseList"] = $houseList["list"];
		$data["count"]=$houseList["allcount"];
		
		$housePhotoModel = new HousePhotoModel();
		$userCommunityModel = new UserCommunityModel();
		
		foreach ($data['houseList'] as $key=>$value)
		{
			$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
			$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
		}

		$this->ajaxReturn($data);
	}
	
	//一度好友房源
	function oneDuHouse()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$oneDuFriendModel = new OneDuFriendModel();
		$houseList = $oneDuFriendModel->join("INNER JOIN house_info ON one_du_friend.toUser = house_info.userId")->where("one_du_friend.fromUser={$userId}")->field("house_info.*")->order("house_info.houseId desc")->limit(10)->select();
		
		if($houseList==null)
		{
			$houseList = array();
		}
		
		$data["success"] = true;
		$data["houseList"] = $houseList;

		$this->ajaxReturn($data);
	}
	
	//同一个公司的房源
	function companyHouse()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		$companyName = $_POST['company'];
		
		if(is_null($companyName))
		{
			$companyName = currentUserCompany();
			if(is_null($companyName))
			{
				$data['msg'] = "请填写公司信息！";
				$this->ajaxReturn($data);
				return;
			}
		}
		$communityModel = new CommunityModel();
		$company = $communityModel->where("name='{$companyName}' AND communityType=".COMPANY)->find();
			
		$companyId = $company['id'];
		
		$houseInfoModel = new HouseInfoModel();
		$hosueList = $houseInfoModel->findHouseWithCircle($companyId);
		
		
		$data['success'] = true;
		$data['houseList'] = $hosueList["list"];
		
		$housePhotoModel = new HousePhotoModel();
		$userCommunityModel = new UserCommunityModel();
		
		foreach ($data['houseList'] as $key=>$value)
		{
			$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
			$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
		}
		
		$this->ajaxReturn($data);
	}
	
	//同一个学校的房源
	function collegeHouse()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		$collegeName = $_POST['college'];
		
		if(is_null($collegeName))
		{
			$collegeName = currentUserCollege();
			if(is_null($collegeName))
			{
				$data['msg'] = "请填写母校信息！";
				$this->ajaxReturn($data);
				return;
			}
		}
		$communityModel = new CommunityModel();
		$college = $communityModel->where("name='{$collegeName}' AND communityType=".COLLEGE)->find();
			
		$collegeId = $college['id'];
		
		
		//$hosueList = $userCollegeModel->join("INNER JOIN house_info ON user_college.userId = house_info.userId")->where("user_college.collegeId={$collegeId}")->field("house_info.*")->order("house_info.houseId desc")->limit(10)->select();
		$houseInfoModel = new HouseInfoModel();
		$hosueList = $houseInfoModel->findHouseWithCircle($collegeId);
		
		$data['success'] = true;
		$data['houseList'] = $hosueList["list"];
		
		$housePhotoModel = new HousePhotoModel();
		$userCommunityModel = new UserCommunityModel();
		foreach ($data['houseList'] as $key=>$value)
		{
			$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
			$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
		}
		
		$this->ajaxReturn($data);
	}
	
	//小区的房源
	function villageHouse()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		$communityName = $_POST['village'];
	
		if(is_null($communityName))
		{
			$communityName = currentUserTargetCommunity();
			if(is_null($communityName))
			{
				$data["msg"] = "请填写目标小区信息！";
				$this->ajaxReturn($data);
				return;
			}
		}
		$houseInfoModel = new HouseInfoModel();
		$hosueList = $houseInfoModel->findHouseWithCondition("(house_info.community like '%{$communityName}%' or house_info.title like '%{$communityName}%')");
	
		$data['success'] = true;
		$data['houseList'] = $hosueList["list"];
		
		$housePhotoModel = new HousePhotoModel();
		$userCommunityModel = new UserCommunityModel();
		foreach ($data['houseList'] as $key=>$value)
		{
			$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
			$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
		}
		
		$this->ajaxReturn($data);
	}
	
	//上传房间照片
	function upload()
	{
		$data = array();
		$data["success"] =true;
		
		if (!empty($_FILES)) {
	            import("@.ORG.UploadFile");
	            $config=array(
	                'allowExts'=>array('jpg','gif','png'),
	                'savePath'=>'./Public/upload/',
	                'saveRule'=>'time',
	            );
	            $upload = new UploadFile($config);
	            $upload->thumb=true;
	            $upload->thumbMaxHeight=100;
	            $upload->thumbMaxWidth=100;
	            if (!$upload->upload()) {
	            	$data["msg"] = $upload->getErrorMsg();
	            	$this->ajaxReturn($data);
	            	return;
	            } else {
	                $info = $upload->getUploadFileInfo();
					$filename = "/Public/upload/".$info[0]['savename'];
					
					$housePhoto = new HousePhotoModel();
					$housePhotoData = array();
					$housePhotoData["userId"] = currentUserId();
					$housePhotoData["photoURL"] = $filename;
					$photoId = $housePhoto->add($housePhotoData);
					addPhotos($photoId);
					$data["photos"] = getPhotos();
	            }
			}
			$data["success"] =true;
			$data["fileUrl"] = $filename;
			$this->ajaxReturn($data);
		}
		
		//圈子房源信息
		function circleHouse()
		{
			$circleName = $_GET['circleName'];
			
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
			
			$houseInfoModel = new HouseInfoModel();
			$houseList = $houseInfoModel->findHouseWithCircle($communityId);
			
			$data['success'] = true;
			$data['houseList'] = $houseList["list"];
			$data['count'] = $houseList["allcount"];
			
			$housePhotoModel = new HousePhotoModel();
			$userCommunityModel = new UserCommunityModel();
			
			foreach ($data['houseList'] as $key=>$value)
			{
				$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
				$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
			}
			
			$result = $userCommunityModel->communityUserCount($communityId);
			$data["userCount"] = $result[0]["userCount"];
			
			$data["circleMaster"] = $communityModel->communityMaster($communityId);
			$descriptionResult = $communityModel->find($communityId);
			$data["description"] = $descriptionResult["description"];
			
			$data["canEdit"] = $communityModel->isCommunityMaster($communityId, currentUserId());
			
			$this->ajaxReturn($data);
		}
		
		//发布房源列表
		function publishHouseList(){
			$data = array();
			$data['success'] = false;
			if(!isLogin())
			{
				$data["msg"] = "请您登录！";
				$this->ajaxReturn($data);
			}
			
			$userId = currentUserId();
			$houseInfoModel = new HouseInfoModel();
			$data["houseList"] = $houseInfoModel->publishHouseList($userId);
			
			$housePhotoModel = new HousePhotoModel();
			$userCommunityModel = new UserCommunityModel();
				
			foreach ($data['houseList'] as $key=>$value)
			{
				$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
				$data['houseList'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["userId"],0,2));
			}
			$data["success"] = true;
			$this->ajaxReturn($data);
		}
		
	
}
