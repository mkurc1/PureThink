function isIdExitst(id){var element=document.getElementById(id);if(typeof element!=undefined&&typeof element!=null&&typeof element!="undefined"){return false}else{return true}}function beautifySelects(){$(".sintetic-select").chosen({allow_single_deselect:true});$(".sintetic-select_top").chosen({allow_single_deselect:true,top:true,disable_search:true})}function getURLParameter(name){return decodeURI((RegExp(name+"="+"(.+?)(&|$)").exec(location.search)||[,null])[1])}function isDev(array){var url=document.URL;if(url.indexOf("app_dev.php")>0){$.each(array,function(index,val){array[index]="/app_dev.php"+val})}}Array.prototype.clear=function(){this.length=0};(function($){$.fn.setCursorToTextEnd=function(){$initialVal=this.val();this.val($initialVal+" ");this.val($initialVal)}})(jQuery);(function($){$.fn.center=function(){this.css({position:"fixed",left:"50%",top:"50%"});this.css({"margin-left":-this.outerWidth()/2+"px","margin-top":-this.outerHeight()/2+"px"});return this}})(jQuery);(function($){$.fn.hasAttr=function(val){var attr=$(this).attr(val);if(typeof attr!=="undefined"&&attr!==false){return true}else{return false}}})(jQuery);