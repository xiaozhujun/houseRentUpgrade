var key="";
var price="";
var region="";
var room="";
var type="";

function iniSearchParam(){
	key = $.getUrlParam("key");
	price = $.getUrlParam("price");
	region = $.getUrlParam("region");
	room = $.getUrlParam("room");
	type = $.getUrlParam("type");
}

function getPramsFromUrl(data,key,price,region,room,type){
	if(key!="" && key!=null){
		data['key']=key;
	}
	if(price!="" && price!=null){
		data['price']=price;
	}
	if(region!="" && region!=null){
		data['region']=region;
	}
	if(room!="" && room!=null){
		data['room']=room;
	}
	if(type!="" && type!=null){
		data['type']=type;
	}
}

//ie模拟placeholder
function iePlaceHolder(){
    var doc = document,
        inputs = doc.getElementsByTagName('input'),
        supportPlaceholder = 'placeholder' in doc.createElement('input');
    var placeholder = function(input,phColor,rColor){
        var text = input.getAttribute('placeholder'),
            defaultValue = input.defaultValue;
        if(defaultValue == ''){
            input.style.color = phColor;
            input.value = text;
        }
        input.onfocus = function(){
            this.style.color = rColor;
            if(input.value === text){
                this.value = '';
            }
        };
        input.onblur = function(){
            if(input.value === ''){
                this.style.color = phColor;
                this.value = text;
            } else{
                this.style.color = rColor;
            }
        }
    };
    
    if(!supportPlaceholder){
        for(var i = 0,len = inputs.length; i < len; i++){
            var input = inputs[i],
                text = input.getAttribute('placeholder');
            if(input.type === 'text' && text){
                placeholder(input,"#BABABA","#000");
            }
        }
    }
}
iePlaceHolder();



var temp = {};

temp.topbar = 
	'<div class="content w990">' + 
    '    <div class="nav fl">' + 
    '        <a class="cur" href="#">北京</a>' + 
    '    </div>' + 
    '    <div id="userLoginActions" class="login fr">' + 
    '        <a href="login.html">登录</a>&nbsp;&nbsp;<a href="register.html">注册</a>' + 
    '    </div>' + 
    '    <div id="usernameDiv" class="user fr none">欢迎您，<a id="usernameLink" href="/User/personCenter">肖竹君</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/User/logout">安全退出</a></div>' + 
    '</div>'
    ;


temp.header = 
	'<div class="headerContent">' +
    '    <a id="logo" target="_self" href="index.html">' +
    '        <img alt="中文最大社交房产信息门户" src="images/logo.png">' +
    '    </a>' +
    '        <div id="searchbar">' +
    '            <div class="saerkey">' +
    '                <span class="key">' +
    '                    <input id="searchInput" class="keyinput" type="text" placeholder="请输入房源信息">' + 
    '                </span>  ' +                  
    '            </div>' +
    '            <div class="submit fl">' +
    '                <input id="searchBtn" type="button" value="搜索房源">' +
    '            </div>' +
    '        </div>' +

    '    <div class="hot">' +
    '        <a href="#">出租房源</a>' +
    '        <a href="#">出租房源</a>' +
    '        <a href="#">出租房源</a>' +
    '    </div>' +
    '    <a id="issue" href="releaseInfo.html">免费发布房源信息</a>' +
    '</div>'
    ;

temp.headerNoSearch = 
	'<div class="headerContent">' +
    '    <a id="logo" target="_self" href="index.html">' +
    '        <img alt="中文最大社交房产信息门户" src="images/logo.png">' +
    '    </a>' +
    '    <a id="issue" href="releaseInfo.html">免费发布房源信息</a>' +
    '</div>'
    ;

$("#topbar").html(temp.topbar);
$("#header").html(temp.header);
$("#headerNoSearch").html(temp.headerNoSearch);

$('#searchBtn').click(function(){
	key = $('#searchInput').val();
	if(key!="")
	{
		var newLocation = "/new/index.html?key="+key;
		window.location.href = newLocation;
//		var data = {};
//		getPramsFromUrl(data,key,price,region,room,type);
//		$.post($.URL.house.houselist,data,searchCallback,"json");
	}
	else
	{
		alert("请输入房源搜索关键字！");
	}
});

var isLogin = false;

function getLoginInfo()
{
	$.get($.URL.user.checkLogin,null,checkLoginCallback,"json");
}
getLoginInfo();

function checkLoginCallback(data)
{
	if(data.isLogin)
		{
			$("#usernameLink").html(data.userName);
			$("#usernameLink").parent().removeClass("none");
			$("#userLoginActions").addClass("none");
			isLogin = true;
		}
}

var popLoginStr = 
    '<div id="popLogin">' + 
    '    <div class="login_main">' + 
    '        <div class="content_head">' + 
    '            <h1>登录</h1>' + 
    '        </div>' + 
    '        <form action="">' + 
    '            <div class="username mb20">' + 
    '                <input id="popEmailInput" type="text" placeholder="邮箱" maxlength="100">' + 
    '            </div>' + 
    '            <div class="password mb20">' + 
    '                <input id="popPwdInput" type="password" placeholder="密码" maxlength="100">' + 
    '            </div>' + 
    '            <div class="iskeep mb10">' + 
    '                <input type="checkbox">' + 
    '                保持登录状态' + 
    '            </div>' + 
    '            <div id="popLoginBtn" class="enterbtn mb10">登 录</div>' + 
    '            <div class="outfun mb10">' + 
    '                <span class="doubt">还不是友居客户？</span>' + 
    '                <a class="apply" href="register.html">我要注册</a>' + 
    '                <a class="forget" href="">忘记密码？</a>' + 
    '            </div>' + 
    '            <div id="popLoginMessage" class="error"></div>' + 
    '        </form>' + 
    '    </div>' + 
    '</div> '
    ;

function showPopLogin()
{
	 DIALOG.init("dialog");
	    DIALOG.open({
	        title:100000,
	        w:326,
	        h:345,
	        fun:function(element){ 
	            element.html(popLoginStr);
	            iePlaceHolder();
	        }
	    });	
	    
	    $("#popLoginBtn").click(function(){
	    	var data = {};
			data.email = $('#popEmailInput').val();
			data.password = $('#popPwdInput').val();
			$.post($.URL.user.login,data,popLoginCallback,"json");
	    });
}

function validateLogin()
{
	if(!isLogin)
		{
			showPopLogin();
		}
	return isLogin;
}


function popLoginCallback(result)
{
	if(result.success)
	{
		getLoginInfo();
		DIALOG.close();
	}
	else
	{
		$('#popLoginMessage').html(result.msg);
	}
	
}

$("#issue").click(function(){
	return validateLogin();
});
