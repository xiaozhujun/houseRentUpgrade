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
		var actionForMaster = $('<p class="atw"><a class="add" href="#">♥ 关注</a></p>');
		rightDiv.append(masterName).append(actionForMaster);
		masterLi.append(rightDiv);
		$("#masterList").append(masterLi);
	}
}