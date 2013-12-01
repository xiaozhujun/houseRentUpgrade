(function($, n){

    var len = $(".pic ul li").length,
        index = 1, 
        timer;

    $(".pic ul").css({"width":len*n+"px"});
    
    function turnSlide(){
        
        if (index != len) {
            $(".btns li").removeClass("cur").eq(index).addClass("cur");
            $(".pic ul").stop().animate({"margin-left":-1*n*index+"px"}, 300, "linear", function(){
                index ++;
            });
        } else {
            $(".btns li").removeClass("cur").eq(0).addClass("cur");
            $(".pic ul").stop().animate({"margin-left":"0"}, 300, "linear", function(){
                index = 1;
            });
        }
                    
    }

    $(".btns li").mouseover(function(){
        
        index = $(this).text() -1;
        clearInterval(timer);
        turnSlide();
        timer = setInterval(turnSlide, 3000);
        
    });

    timer = setInterval(turnSlide, 3000);

})(jQuery, 540);
    