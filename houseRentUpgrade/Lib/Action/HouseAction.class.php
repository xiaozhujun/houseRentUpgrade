<?php
import("@.Model.HouseInfoModel");
import("@.Model.RegionModel");
import("@.Model.UserModel");
import("@.Model.UserCompanyModel");
import("@.Model.UserCollegeModel");
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
		
		foreach ($data['houseList'] as $key=>$value)
		{
			$data['houseList'][$key]["photos"] = $housePhotoModel->getHousePhotos($value["houseId"]);
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
			$data['msg']="not login!";
			$this->ajaxReturn($data);
		}
		session_start();
		$houseInfo = D ("HouseInfo");
		if($houseInfo->create ())
		{
			$houseInfo->userId=$_SESSION['userId'];
			$houseInfo->createTime=intNow();
			$houseInfo->viewCount=0;
			
			$houseId = $houseInfo->add();
			$housePhotos = getPhotos();
			deleteSessionKey($key);
			$housePhoto = new HousePhotoModel();
			$housePhoto->addPhotoToHouse($houseId, currentUserId(), $housePhotos);
			
			
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

			header ( "Content-Type:text/html; charset=utf-8" );
			echo "对不起，您的请求中参数正确！";
			return;
		}
		if(isLogin())
		{
			$this->assign('user',currentUserName());
			header ( "Content-Type:text/html; charset=utf-8" );
		}
		
		$houseInfo = M('HouseInfo');
		$houseInfoObj = $houseInfo->find($houseId);
		$data['houseinfo']=$houseInfo->find($houseId);
		
		$housePhotoModel = new HousePhotoModel();
		$data['houseinfo']['photos'] = $housePhotoModel->getHousePhotos($data['houseinfo']['houseId']);
		//$this->assign('houseInfo',$houseInfoObj);
		$region = M('Region');
		$regionId = $houseInfoObj['region'];
		$regionObj = $region->find($regionId);
		//$this->assign("region",$regionObj);
         $data['region']=$region->find($regionId);
		$houseUser = M("User");
		$houseUserId = $houseInfoObj["userId"];
		$houseUserObj = $houseUser->find($houseUserId);
		//$this->assign("houseUser",$houseUserObj);
		$data['houseuser']=$houseUser->find($houseUserId);
		$userCompany = new UserCompanyModel();
		$company = $userCompany->getUserCompany($houseUserId);
		//$this->assign("company",$company);
		$data['company']=$userCompany->getUserCompany($houseUserId);
		$userCollege = new UserCollegeModel();
		$college = $userCollege->getUserCollege($houseUserId);
		//$this->assign("college",$college);
		$data['college']=$userCollege->getUserCollege($houseUserId);
		//保存用户浏览房源记录
		$houseViewModel = new HouseViewModel();
		$result = $houseViewModel->saveOrUpdate(currentUserId(),$houseId);
		if(result==1)
		{
			$houseInfo->where("houseId={$houseId}")->setInc("viewCount",1);
		}
		
		
		header ( "Content-Type:text/html; charset=utf-8" );
		//$this->display("houseInfo");
		//$this->ajaxReturn($data);
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
		$street = $_GET['street'];
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
		if(!isLogin())
		{
			redirect(C('LOGIN_URL'));
			return;
		}
		
		$userId = currentUserId();
		$friendModel = new FriendModel();
		$houseList = $friendModel->join("INNER JOIN house_info ON friend.toUser = house_info.userId")->where("friend.fromUser={$userId}")->field("house_info.*")->order("house_info.houseId desc")->limit(10)->select();
		
		if($houseList==null)
		{
			$houseList = array();
		}
		
		$data = array();
		$data["success"] = true;
		$data["houseList"] = $houseList;

		$this->ajaxReturn($data);
	}
	
	//一度好友房源
	function oneDuHouse()
	{
		if(!isLogin())
		{
			redirect(C('LOGIN_URL'));
			return;
		}
		
		$userId = currentUserId();
		$oneDuFriendModel = new OneDuFriendModel();
		$houseList = $oneDuFriendModel->join("INNER JOIN house_info ON one_du_friend.toUser = house_info.userId")->where("one_du_friend.fromUser={$userId}")->field("house_info.*")->order("house_info.houseId desc")->limit(10)->select();
		
		if($houseList==null)
		{
			$houseList = array();
		}
		
		$data = array();
		$data["success"] = true;
		$data["houseList"] = $houseList;

		$this->ajaxReturn($data);
	}
	
	//同一个公司的房源
	function companyHouse()
	{
		if(!isLogin())
		{
			redirect(C('LOGIN_URL'));
			return;
		}
		$companyName = $_POST['company'];
		
		$data = array();
		$data['success'] = false;
		
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
		$companyModel = new CompanyModel();
		$company = $companyModel->where("name='{$companyName}'")->find();
		
		$companyId = $company['id'];
		
// 		$userCompanyModel = new UserCompanyModel();
// 		$hosueList = $userCompanyModel->join("INNER JOIN house_info ON user_company.userId = house_info.userId")->where("user_company.companyId={$companyId}")->field("house_info.*")->order("house_info.houseId desc")->limit(10)->select();
		
		$houseInfoModel = new HouseInfoModel();
		$hosueList = $houseInfoModel->findHouseWithCondition("user_company.companyId={$companyId}");
		
		
		$data['success'] = true;
		$data['houseList'] = $hosueList["list"];
		$this->ajaxReturn($data);
	}
	
	//同一个学校的房源
	function collegeHouse()
	{
		if(!isLogin())
		{
			redirect(C('LOGIN_URL'));
			return;
		}
		$collegeName = $_POST['college'];
		$data = array();
		$data['success'] = false;
		
		if(is_null($collegeName))
		{
			$collegeName = currentUserCollege();
			if(is_null($collegeName))
			{
				$data['msg'] = "请填写学校信息！";
				$this->ajaxReturn($data);
				return;
			}
			
		}
		$collegeModel = new CollegeModel();
		$college = $collegeModel->where("name='{$collegeName}'")->find();
		
		$collegeId = $college['id'];
		
		
		//$hosueList = $userCollegeModel->join("INNER JOIN house_info ON user_college.userId = house_info.userId")->where("user_college.collegeId={$collegeId}")->field("house_info.*")->order("house_info.houseId desc")->limit(10)->select();
		$houseInfoModel = new HouseInfoModel();
		$hosueList = $houseInfoModel->findHouseWithCondition("user_college.collegeId={$collegeId}");
		
		$data['success'] = true;
		$data['houseList'] = $hosueList["list"];
		$this->ajaxReturn($data);
	}
	
	//小区的房源
	function communityHouse()
	{
		if(!isLogin())
		{
			redirect(C('LOGIN_URL'));
			return;
		}
		$communityName = $_POST['community'];
		$data = array();
		$data['success'] = false;
	
		if(is_null($communityName))
		{
			$communityName = currentUserTargetCommunity();
			if(is_null($communityName))
			{
				$data['msg'] = "请填写目标小区信息！";
				$this->ajaxReturn($data);
				return;
			}
		}
		$houseInfoModel = new HouseInfoModel();
		$hosueList = $houseInfoModel->findHouseWithCondition("house_info.community like '%{$_POST['community']}%'");
	
		$data['success'] = true;
		$data['houseList'] = $hosueList["list"];
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
		
		 
	
}
