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
    '        <a href="#">北京</a>' + 
    '        <a href="#">北京</a>' + 
    '        <a href="#">北京</a>' + 
    '    </div>' + 
    '    <div id="userLoginActions" class="login fr">' + 
    '        <a href="login.html">登录</a>&nbsp;&nbsp;<a href="register.html">注册</a>' + 
    '    </div>' + 
    '    <div id="usernameDiv" class="user fr none">欢迎你，<a id="usernameLink" href="#">肖竹君</a></div>' + 
    '</div>'
    ;


temp.header = 
	'<div class="headerContent">' +
    '    <a id="logo" target="_self" href="index.html">' +
    '        <img alt="中文最大社交房产信息门户" src="images/logo.png">' +
    '    </a>' +
    '    <form action="">' +
    '        <div id="searchbar">' +
    '            <div class="saerkey">' +
    '                <span class="key">' +
    '                    <input id="searchInput" class="keyinput" type="text" placeholder="请输入房源信息">' + 
    '                </span>  ' +                  
    '            </div>' +
    '            <div class="submit fl">' +
    '                <input id="searchBtn" type="submit" value="出租房源">' +
    '            </div>' +
    '        </div>' +
    '    </form>' +

    '    <div class="hot">' +
    '        <a href="#">出租房源</a>' +
    '        <a href="#">出租房源</a>' +
    '        <a href="#">出租房源</a>' +
    '    </div>' +
    '    <a id="issue" href="#">免费发布房源信息</a>' +
    '</div>'
    ;

temp.headerNoSearch = 
	'<div class="headerContent">' +
    '    <a id="logo" target="_self" href="index.html">' +
    '        <img alt="中文最大社交房产信息门户" src="images/logo.png">' +
    '    </a>' +
    '    <a id="issue" href="#">免费发布房源信息</a>' +
    '</div>'
    ;

$("#topbar").html(temp.topbar);
$("#header").html(temp.header);
$("#headerNoSearch").html(temp.headerNoSearch);

$('#searchBtn').click(function(){
	key = $('#searchInput').val();
	if(key!="")
	{
		var data = {};
	getPramsFromUrl(data,key,price,region,room,type);
	$.post($.URL.house.houselist,data,searchCallback,"json");
	}
	else
	{
		alert("请输入房源搜索关键字！");
	}
});

$.get($.URL.user.checkLogin,null,checkLoginCallback,"json");

var isLogin = false;
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


