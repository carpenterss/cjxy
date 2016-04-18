$(function(){
	$("#search_name").focus(function(){
		if(this.value=="请输入要查询的员工姓名"){
		   this.value="";
		}
	});	
	
	//查看任务
	$(".look_tasks").click(function(){
		var t_content = $(this).attr("title");
		alert(t_content);
	});
});