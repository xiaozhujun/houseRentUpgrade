<?php

define("UNTREAT",0);
define("PASS",1);
define("REFUSE",2);

import("@.Model.OneDuFriend");

import('Common.Misc',APP_PATH,'.php');
import('Common.DateUtil',APP_PATH,'.php');
import('Common.FriendUtil',APP_PATH,'.php');

class FriendAction extends Action
{
	//返回申请好友页面
	function applyFriendPage()
	{
		$result_msg = '';
		if(!isset($_GET[userId]) || empty($_GET['userId']))
		{
			$result_msg = '操作失败！';
		}
		else
		{
			$user = M('User');
			$appliedFriend = $user->find($_GET['userId']);
			$this->assign('realName',$appliedFriend['realName']);
			$this->assign('toUser',$appliedFriend['id']);
		}
		$this->assign('result_msg',$result_msg);
		$this->display('applyFriend');
	}
	
	//申请加为好友
	function applyFriend()
	{
		$data = array();
		$data['success'] = false;
		
		if(!isLogin())
		{
			$data["msg"] = "请您先登录！";
			$this->ajaxReturn($data);
		}
		
		if(!isset($_POST['toUser']) || empty($_POST['toUser']))
		{
			$data['msg'] = '被申请人未设置，操作失败！';
			$this->ajaxReturn($data);
		}
		
		if(!isset($_POST['authInfo']) || empty($_POST['authInfo']))
		{
			$data['msg'] = '验证信息不能为空！';
			$this->ajaxReturn($data);
		}
		
		$friendApply = M('FriendApply');
		$isExist = $friendApply->where("fromUser={$_SESSION['userId']}  and toUser={$_POST['toUser']} and status=0")->count();
		if($isExist)
		{
			$data['msg'] = '您已经提交的申请，请耐心等待！';
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$userModel = new UserModel();
		$fromUser = $userModel->find($userId);
		$toUser = $userModel->find($_POST['toUser']);
		$friendApplyData = array(
			"fromUser"=>$userId,
			"fromRealName"=>$fromUser['realName'],
			"toUser"=>$_POST['toUser'],
			"toRealName"=>$toUser['realName'],
			"authInfo"=>$_POST['authInfo'],
				"createTime"=>dateTime(),
			"status"=>UNTREAT,
		);
		
		if($friendApply->create($friendApplyData))
		{
			if($friendApply->add())
			{
				$data['msg'] = '您的好友申请已经发送成功！';
				$data['success'] = true;
			}
			else 
			{
				$data['msg'] = $friendApply->getError();
			}	
		}
		else
		{
			$data['msg'] = $friendApply->getError();
		}
		createMessage($houseInfo['userId'], "{$fromUser['realName']}申请加您好友，赶快去处理吧！", $userId);
		
		$this->ajaxReturn($data);
		
	}
	
	//没有被处理的申请
	function applyingUntreated()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data['msg'] = "没有权限！";
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$applyList = $friendApply->where("fromUser={$userId} and status=".UNTREAT)->field("toUser,fromUser,fromRealName,toRealName,authInfo,createTime")->order("createTime desc")->limit(0,10)->select();
		$data['success'] = true;
		$data['list'] = $applyList;
		$this->ajaxReturn($data);
		
		
	}
	
	//被通过的申请
	function applyingPassed()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data['msg'] = "没有权限！";
			$this->ajaxReturn($data);
		}
	
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$applyList = $friendApply->where("fromUser={$userId} and status=".PASS)->field("toUser,fromUser,fromRealName,toRealName,authInfo,createTime")->order("createTime desc")->limit(0,10)->select();
		$data['success'] = true;
		$data['list'] = $applyList;
		$this->ajaxReturn($data);
	}
	
	//被拒绝的申请
	function applyingRefused()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data['msg'] = "没有权限！";
			$this->ajaxReturn($data);
		}
	
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$applyList = $friendApply->where("fromUser={$userId} and status=".REFUSE)->field("toUser,fromUser,fromRealName,toRealName,replyInfo,createTime")->order("createTime desc")->limit(0,10)->select();
		$data['success'] = true;
		$data['list'] = $applyList;
		$this->ajaxReturn($data);
	}
	
	//没有处理的申请
	function applyingUntreat()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data['msg'] = "没有权限！";
			$this->ajaxReturn($data);
		}
	
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$applyList = $friendApply->where("toUser={$userId} and status=".UNTREAT)->field("fromUser,fromRealName,authInfo,createTime")->order("createTime desc")->limit(0,10)->select();
		$data['success'] = true;
		$data['list'] = $applyList;
		$userTagModel = new UserTagModel();
		$userCommunityModel = new UserCommunityModel();
		foreach ($data['list'] as $key=>$value)
		{
			$data['list'][$key]["tags"] = $userTagModel->userTags($value["fromUser"]);
			$data['list'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["fromUser"],0,2));
		}
		$this->ajaxReturn($data);
	
	
	}
	
	//通过的申请
	function applyingPass()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data['msg'] = "没有权限！";
			$this->ajaxReturn($data);
		}
	
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$applyList = $friendApply->where("toUser={$userId} and status=".PASS)->field("toUser,fromUser,fromRealName,toRealName,authInfo,createTime")->order("createTime desc")->select();
		$data['success'] = true;
		$data['list'] = $applyList;
		$this->ajaxReturn($data);
	}
	
	//拒绝的申请
	function applyingRefuse()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data['msg'] = "没有权限！";
			$this->ajaxReturn($data);
		}
	
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$applyList = $friendApply->where("toUser={$userId} and status=".REFUSE)->field("toUser,fromUser,fromRealName,toRealName,replyInfo,createTime")->order("createTime desc")->limit(0,10)->select();
		$data['success'] = true;
		$data['list'] = $applyList;
		$this->ajaxReturn($data);
	}
	
	//返回拒绝好友申请页面
	function refuseApplyPage()
	{
		$result_msg = '';
		if(!isset($_GET[fromUser]) || empty($_GET['fromUser']))
		{
			$result_msg = '操作失败！';
		}
		else
		{
			$user = M('User');
			$appliedFriend = $user->find($_GET['fromUser']);
			$this->assign('realName',$appliedFriend['realName']);
			$this->assign('fromUser',$appliedFriend['id']);
		}
		$this->assign('result_msg',$result_msg);
		$this->display('refuseApply');
	}
	
	//拒绝好友申请
	function refuseApply()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}	
		
		$data = array();
		$data['success'] = false;
		$fromUser = $_POST['fromUser'];
		if(!isset($fromUser) || empty($fromUser))
		{
			$data['msg'] = '申请人未设置，操作失败！';
			$this->ajaxReturn($data);
		}
		$userId = currentUserId();
		$friendApply = M('FriendApply');
		$count = $friendApply->where("fromUser={$fromUser} and toUser={$userId} and status=".UNTREAT)->count();
		if(!$count)
		{
			$data['msg'] = '没有符合条件的记录！';
			$this->ajaxReturn($data);
		}
		
		$data = array(
				"status"=>REFUSE,
				"replyInfo"=>$_POST['replyInfo'],
		);
		$result = $friendApply->where("fromUser={$fromUser} and toUser={$userId} and status=".UNTREAT)->save($data);
		if($result)
		{
			$data['msg'] = '操作成功！';
			$data['success'] = true;
			$data["fromUser"] = $fromUser;
			
			$fromUserName = currentUserName();
			createMessage($fromUser, "{$fromUserName}，拒绝了您的好友申请哦！", $userId);
		}
		else 
		{
			$data['msg'] = '操作失败';
		}
		$this->ajaxReturn($data);
		
	}
	
	//通过好友申请
	function passApply()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}	
		$fromUserId = $_POST['fromUser'];
		if(!isset($fromUserId) || empty($fromUserId))
		{
			$data['msg'] = '申请人未设置，操作失败！';
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		
		$friendApply = M('FriendApply');
		$count = $friendApply->where("fromUser={$fromUserId} and toUser={$userId} and status=".UNTREAT)->count();
		if(!$count)
		{
			$data['msg'] = '没有符合条件的记录！';
			$this->ajaxReturn($data);
		}
		
		$data = array(
				"status"=>PASS,
		);
		$result = $friendApply->where("fromUser={$fromUserId} and toUser={$userId} and status=".UNTREAT)->save($data);
		
		$userModel = new UserModel();
		$fromUser = $userModel->field("realName")->find($fromUserId);
		$fromUserName = $fromUser["realName"];
		$friend = M('Friend');
		$friendData = array(
				"fromUser"=>$fromUserId,
				"fromUserName"=>$fromUserName,
				"toUser"=>$userId,
				"toUserName"=>currentUserName(),
				"createTime"=>dateTime(),
		);
		
		addOneDuFriend($friendData["fromUser"],$friendData["toUser"]);
		
		if($friend->create($friendData))
		{
			$friend->add();	
		}
		
		$friendData = array(
				"fromUser"=>$userId,
				"fromUserName"=>currentUserName(),
				"toUser"=>$fromUserId,
				"toUserName"=>$fromUserName,
				"createTime"=>dateTime(),
		);
		$friend = M('Friend');
		if($friend->create($friendData))
		{
			$friend->add();
		}
		
		if($result)
		{
			$data['msg'] = '操作成功！';
			$data['success'] = true;
			$data["fromUser"] = $fromUserId;
			
			$fromUserName = currentUserName();
			createMessage($fromUserId, "{$fromUserName}，通过了您的好友申请哦！", $userId);
		}
		else
		{
			$data['msg'] = "操作失败";
		}
		$this->ajaxReturn($data);
	}
	
	//我的好友列表
	function myFriend()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}	
	
		$friend = M('Friend');
		$userId = currentUserId();
		$friendListId = $friend->join("user ON friend.toUser=user.id")->where("friend.fromUser={$userId}")->field("user.id,user.name,user.realName")->select();
		
		$data['list'] = $friendListId;
		$data['msg'] = '操作成功！';
		$data['success'] = true;
		$this->ajaxReturn($data);
	}
	
	//邀请的好友列表
	function invitedFriend()
	{
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}	
		
		$userId = currentUserId();
		$userModel = M("User");
		$friendList = $userModel->where("invitor={$userId}")->field("id,name,realName")->select();
		
		$data['list'] = $friendList;
		$data['msg'] = '操作成功！';
		$data['success'] = true;
		$this->ajaxReturn($data);
	}
	
	//用户好友列表
	function friendList(){
		$data = array();
		$data['success'] = false;
		if(!isLogin())
		{
			$data["msg"] = "请您登录！";
			$this->ajaxReturn($data);
		}
		
		$userId = currentUserId();
		$friend = new FriendModel();
		$data["list"] = $friend->where("fromUser={$userId}")->field("toUser,toUserName")->limit(0,30)->select();
		$userTagModel = new UserTagModel();
		$userCommunityModel = new UserCommunityModel();
		foreach ($data['list'] as $key=>$value)
		{
			$data['list'][$key]["tags"] = $userTagModel->userTags($value["toUser"]);
			$data['list'][$key]["circles"] = array_values($userCommunityModel->userCommunities($value["toUser"],0,2));
		}	
		$data["friendCount"] = $friend->where("fromUser={$userId}")->count("id");
		$friendApply = M('FriendApply');
		$data["applyCount"] = $friendApply->where("toUser={$userId} and status=".UNTREAT)->count("id");
		
		$data["success"] = true;
		$this->ajaxReturn($data);
	}
}