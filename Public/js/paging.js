function query_page(pagesize){  
   var rowsShown = pagesize;  //每页显示多少条
   var rowsTotal = $("#data tr.tr_info").length; //获取需要处理的行数总数
   var numPages = Math.ceil(rowsTotal/rowsShown); 
   
   $("#data2").append("<div id='nav'>共<"+numPages+">页&nbsp;每页显示*"+rowsShown+"*条&nbsp;</div>");
   
   for(i=0;i<numPages;i++){
	 var pageNum = i+1;
	 $("#nav").append("<a href='#' rel="+i+">第"+pageNum+"页</a>") 
   }
   
   $("#data tr.tr_info").hide();
   $("#data tr.tr_info:first").show();
   $("#data tr.tr_info").slice(0,rowsShown).show();
   
   $("#nav a:first").addClass("active");
   
   $("#nav a").bind("click",function(){
   $("#nav a").removeClass("active"); 
   $(this).addClass("active");
   var currPage = $(this).attr("rel");
   //计算每页显示的记录数
   var startItem = currPage * rowsShown; 
   var endItem = startItem + rowsShown;
	 
   $("#data tr.tr_info").css("opacity","0.0").hide().slice(startItem,endItem).css("display","table-row").animate({opacity:1},0);
 });
 
}
