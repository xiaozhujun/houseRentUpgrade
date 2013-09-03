$(function(){
	var slen = $(".simg_slide li").length;  //picContain

	function slide($obj){
		var slen = $obj.find("li").length,
			sWidth = $obj.find("li").width();
		if (slen > 4) {
			$obj.find("ul").css("width","");
		};
	}
});