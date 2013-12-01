(function($){
	$.getUrlParam = function(name)
	{
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if (r!=null) return URL.decode(unescape(r[2])); return null;
	}
	
	$.getThumbImg = function(img){
		if(img!=null && typeof img !="undefined"){
			if(img.indexOf("bcs.duapp.com")>-1){
				var imgNameStartIndex = img.lastIndexOf("/");
				var thumbImgPath = img.substring(0,imgNameStartIndex)+"/thumb_"+img.substring(imgNameStartIndex+1);
				return thumbImgPath;
			}else{
				return img;
			}
			
		}
		return "images/house_bg.png";
	}
	
	$.getOrignImg = function(img){
		if(img.indexOf("bcs.duapp.com")>-1){
			var thumbIndex = img.lastIndexOf("thumb_");
			if(thumbIndex>-1){
				var imgPath = img.substring(0,thumbIndex)+img.substring(thumbIndex+6,img.length);
				return imgPath;
			}
		}
		return img;
	}
})(jQuery);

/** 
* 
*  URL encode / decode 
*  http://www.webtoolkit.info/ 
* 注意，使用方法 Url.encode(string) 得到的是UTF-8编码的数据 
**/ 
 
var URL = { 
 
        // public method for url encoding 
        encode : function (string) { 
        	if(string!=null){
        		return escape(this._utf8_encode(string));
        	}else{
        		return '';
        	}
                 
        }, 
 
        // public method for url decoding 
        decode : function (string) { 
                return this._utf8_decode(unescape(string)); 
        }, 
 
        // private method for UTF-8 encoding 
        _utf8_encode : function (string) { 
                string = string.replace(/\r\n/g,"\n"); 
                var utftext = ""; 
 
                for (var n = 0; n < string.length; n++) { 
 
                        var c = string.charCodeAt(n); 
 
                        if (c < 128) { 
                                utftext += String.fromCharCode(c); 
                        } 
                        else if((c > 127) && (c < 2048)) { 
                                utftext += String.fromCharCode((c >> 6) | 192); 
                                utftext += String.fromCharCode((c & 63) | 128); 
                        } 
                        else { 
                                utftext += String.fromCharCode((c >> 12) | 224); 
                                utftext += String.fromCharCode(((c >> 6) & 63) | 128); 
                                utftext += String.fromCharCode((c & 63) | 128); 
                        } 
 
                } 
 
                return utftext; 
        }, 
 
        // private method for UTF-8 decoding 
        _utf8_decode : function (utftext) { 
                var string = ""; 
                var i = 0; 
                var c = c1 = c2 = 0; 
 
                while ( i < utftext.length ) { 
 
                        c = utftext.charCodeAt(i); 
 
                        if (c < 128) { 
                                string += String.fromCharCode(c); 
                                i++; 
                        } 
                        else if((c > 191) && (c < 224)) { 
                                c2 = utftext.charCodeAt(i+1); 
                                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63)); 
                                i += 2; 
                        } 
                        else { 
                                c2 = utftext.charCodeAt(i+1); 
                                c3 = utftext.charCodeAt(i+2); 
                                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63)); 
                                i += 3; 
                        } 
 
                } 
 
                return string; 
        } 
 
}
