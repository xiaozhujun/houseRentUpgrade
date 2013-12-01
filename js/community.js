var circleMasterId;
var circleMasterName;

function openDescriptionEdit(canEdit)
{
	if(canEdit){
		$("#circleDescription").click(editDescription);
		var editTip = $('<div style="text-align:right;"><a>编辑</a></div>');
		$("#circleDescription").append(editTip);
	}
	
}

function editDescription()
{
	var editor = $('<textarea id="descriptionInput" name="area1" rows="10" style="width:95%"></textarea>');
	var editorContainer = $('<div id="editorContainer" style="width:100%"></div>');
	editor.html($("#circleDescriptionEditor").html());
	editorContainer.html(editor);
	$("#circleDescription").html(editorContainer);
	var saveBtn = $('<a id="descriptionSaveBtn" href="#" class="issueBtn">保存</a>');
	var saveBtnContainer = $('<div id="saveBtnContainer" style="width:100%"></div>');
	saveBtnContainer.html(saveBtn);
	$("#circleDescription").append(saveBtnContainer);
	saveBtn.click(function(){
		var description = editor.val();
		var descriptionData = {};
		descriptionData.circleName = circleName;
		descriptionData.description = description;
		$.post($.URL.community.saveDescription,descriptionData,saveDescriptionCallback,"json");
	});
	$("#circleDescription").unbind("click");
}

function saveDescriptionCallback(data)
{
	if(!data.result){
		alert(data.msg);
		return;
	}
	var circleDescriptionEditor = $('<div id="circleDescriptionEditor" class="circleBriefBottom m10"></div>');
	circleDescriptionEditor.html($("#descriptionInput").val());
	$("#circleDescription").html(circleDescriptionEditor);
	

	var editTip = $('<div style="text-align:right;"><a>编辑</a></div>');
	$("#circleDescription").append(editTip);
	
	$("#circleDescription").click(editDescription);
}

function getCircleHouseListCallback(data)
{
	var targetContainer = "#circleHouseInfo";
	renderingPage(data,targetContainer);
}

//渲染圈主信息
function renderMaster(master)
{
	$("#masterList").html("");
	for(var i=0;i<master.length;i++){
		var masterLi = $('<li class="mb10"><a class="img" href="#"><img src="images/person_bg.png" alt="" width="42" height="42"></a></li>');
		var rightDiv = $('<div class="right"></div>');
		var masterName=$('<strong></strong>').html($('<a href="#"></a>').html(master[i].userName));
		var actionForMaster = $('<p class="atw"><a class="friendAddBtn" userId='+master[i].userId+' userName='+master[i].userName+' href="#">加为好友</a></p>');
		rightDiv.append(masterName).append(actionForMaster);
		masterLi.append(rightDiv);
		$("#masterList").append(masterLi);
	}
	$(".friendAddBtn").click(function(){
		circleMasterId =$(this).attr("userId");
		circleMasterName = $(this).attr("userName");
		showPopAddFriend();
	});
	
}

var  popAddFriendStr = 
	 '<div id="popLogin">' + 
	    '    <div class="login_main">' + 
	    '        <div class="content_head">' + 
	    '            <h1>添加好友</h1>' + 
	    '        </div>' + 
	    '        <form action="">' + 
	    '            <div id="popUserNameDiv" class="popFriendName mb5">' + 
	    '            </div>' + 
	    '            <div class="password mb5">' + 
	    '                <textarea id="friendApplyInput" style="width:100%;" rows=10>请输入您的申请信息！</textarea>' + 
	    '            </div>' + 
	    '            <div id="popAddFriendBtn" class="enterbtn mb10">发送申请</div>' + 
	    '            <div id="popAddFriendMessage" class="error"></div>' + 
	    '        </form>' + 
	    '    </div>' + 
	    '</div> '
	    ;

function showPopAddFriend()
{
	if(!isLogin)
	{
		showPopLogin();
		return false;
	}
	
	 DIALOG.init("dialog");
	    DIALOG.open({
	        title:100000,
	        w:326,
	        h:345,
	        fun:function(element){ 
	            element.html(popAddFriendStr);
	            $("#popUserNameDiv").html("与"+circleMasterName+"成为好友吧！");
	            iePlaceHolder();
	        }
	    });	
	    
	    $("#popAddFriendBtn").click(function(){
	    	var data = {};
			data.authInfo = $('#friendApplyInput').val();
			data.toUser = circleMasterId;
			$.post($.URL.friend.applyFriend,data,addFriendCallback,"json");
	    });
}

function addFriendCallback(data)
{
	if(data.success)
	{
		alert("恭喜您，操作成功！");
		DIALOG.close();
	}
	else
	{
		$('#popAddFriendMessage').html(data.msg);
	}
	
} 