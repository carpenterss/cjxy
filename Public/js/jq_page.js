function query_page(pagesize){  
   var rowsShown = pagesize;  //每页显示多少条
   var rowsTotal = $("#data tr.tr_info").length; //获取需要处理的行数总数
   var numPages = Math.ceil(rowsTotal/rowsShown); 
   
   $("#data2").append("<div id='nav' style='padding-right:10px;'>共<b><"+numPages+"></b>页&nbsp;每页显示&nbsp;<b style='border:1px solid #ccc;padding:2px;background:#f0f0f0;'>"+rowsShown+"</b>&nbsp;条&nbsp;</div>");
   
   for(i=0;i<numPages;i++){
	 var pageNum = i+1;
	 $("#nav").append("&nbsp;<a href='#' rel="+i+" style='border:1px solid #ccc;padding:2px;background:#FFFFFF;color:#333;'>第"+pageNum+"页</a>") 
   }
   
   $("#data tr.tr_info").hide();
   $("#data tr.tr_info:first").show();
   $("#data tr.tr_info").slice(0,rowsShown).show();
   
   $("#nav a:first").css("background","#CCCCCC");

   $("#nav a").bind("click",function(){	
   $(this).css("background","#CCCCCC").siblings("a").css("background","#FFFFFF");
   var currPage = $(this).attr("rel");
   //计算每页显示的记录数
   var startItem = currPage * rowsShown; 
   var endItem = startItem + rowsShown;
	 
   $("#data tr.tr_info").css("opacity","0.0").hide().slice(startItem,endItem).css("display","table-row").animate({opacity:1},0);
 });
 
}

//设为首页JS实现代码
function setHomepage() {
            if (document.all) {
                document.body.style.behavior = 'url(#default#homepage)';
                document.body.setHomePage('http://www.baidu.com');//要设置的首页
            }
            else if (window.sidebar) {
                if (window.netscape) {
                    try {
                        netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                    }
                    catch (e) {
                        alert("该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true");
                    }
                }
                var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                prefs.setCharPref('browser.startup.homepage', 'http://www.e00fen.com');
            }
        }
 //表格效果
/*$(function(){
   $(".tr_info").hover(function(){
	  $(this).css({"background":"#FFCC66"}).siblings().css({"background":"#eef7fe"});
   },function(){
	  $(this).css({"background":"#eef7fe"});
   }); 
});*/


