var DIALOG={
	dialog:"",
	info:{w:500,h:400,title:"详细信息",fun:function(){}},
	init:function(id){
		this.dialog=$("#"+id);
		this.dialog.html('<div id="dialog_close"></div><div id="dialog_c"><div id="dialog_loading"></div></div><div id="dialog_f"></div>');
		$("#dialog_close").click(function(){DIALOG.close();});
		if(navigator.appVersion.indexOf("MSIE 6.0")!=-1){$("#dialog_bg").css({height:$(document).height()});}
	},
	open:function(data){
		if(navigator.appVersion.indexOf("MSIE 6.0")!=-1){$("#dialog").css({top : $(window).height()/2+$(window).scrollTop()});}
		var w=data.w?data.w:this.info.w,
			h=data.h?data.h:this.info.h,
			title=data.title?data.title:this.info.title,
			fun=data.fun?data.fun:this.info.fun;
		fun($("#dialog_c"));
		this.dialog.css({width:w,height:h,marginLeft:-w/2,marginTop:-h/2}).show(500);
		$("#dialog_bg").show();
	},
	close:function(){
		this.dialog.hide(500,function(){$("#dialog_c").html('<div id="dialog_loading"></div>');});
		$("#dialog_bg").hide();
	}
};
