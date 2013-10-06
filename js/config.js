(function($){
	$.URL = {
		"user":{
			"resetPwd":"/User/resetPwd",
			"update":"/User/update",
			"info":"/User/info",
			"invite":"/InvitationCode/inviteFriend",
			"login":"/User/doLogin",
			"register":"/User/add",
			"verify":"/User/verify",
			"findFriend":"/User/findFriend",
			"checkLogin":"/User/checkLogin",
		},
		"friend":{
			"applyFriend":"/Friend/applyFriend",
			"applyingUntreated":"/Friend/applyingUntreated",
			"applyingPassed":"/Friend/applyingPassed",
			"applyingRefused":"/Friend/applyingRefused",
			"applyingUntreat":"/Friend/applyingUntreat",
			"applyingPass":"/Friend/applyingPass",
			"applyingRefuse":"/Friend/applyingRefuse",
			"refuseApply":"/Friend/refuseApply",
			"passApply":"/Friend/passApply",
			"myFriend":"/Friend/myFriend",
			"invitedFriend":"/Friend/invitedFriend",
		},
		"house":{
			"houselist":"/House/houseList",
			"publishhouse":"/House/publishHouseAction",
			"search":"/House/search",
			"info":"/House/info",
			"popularlist":"/House/popularHouse",
			"streetHouseList":"/House/streetHouse",
			"friendHouseList":"/House/friendHouse",
			"oneDuHouseList":"/House/oneDuHouse",
			"companyHouseList":"/House/companyHouse",
			"collegeHouseList":"/House/collegeHouse",
			"villegeHouseList":"/House/villageHouse",
		},
		"houseApply":{
			"applyHouse":"/HouseApply/applyHouse",
			"applyingUntreated":"/HouseApply/applyingUntreated",
			"applyingPassed":"/HouseApply/applyingPassed",
			"applyingRefused":"/HouseApply/applyingRefused",
			"applyingUntreat":"/HouseApply/applyingUntreat",
			"applyingPass":"/HouseApply/applyingPass",
			"applyingRefuse":"/HouseApply/applyingRefuse",
			"refuseApply":"/HouseApply/refuseApply",
			"passApply":"/HouseApply/passApply",
		},
		"houseCollect":{
			"collect":"/HouseCollect/collect",
			"collectList":"/HouseCollect/collectHouseList",
		},
		"houseComment":{
			"comment":"/HouseComment/comment",
			"commentList":"/HouseComment/houseCommentList",
		},
		"company":{
			"add":"/Company/add",
			"autoComplete":"/Company/autoComplete",
		},
		"college":{
			"add":"/College/add",
			"autoComplete":"/College/autoComplete",
		},
		"targetHouse":{
			"add":"/TargetHouse/add",
			"autoComplete":"/TargetHouse/autoComplete",
		},
		"community":{
			"addVillage":"/Community/addVillage",
			"addCompany":"/Community/addCompany",
			"addCollege":"/Community/addCollege",
			"autoComplete":"/Community/autoComplete",
		}
		
			
	}
})(jQuery);