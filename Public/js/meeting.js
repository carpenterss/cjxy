$(function(){
	//对部门进行选择
	//移到右边
	$('#add').click(function() {
	//获取选中的选项，删除并追加给对方
		$('#select1 option:selected').appendTo('#select2');
	});
	//移到左边
	$('#remove').click(function() {
		$('#select2 option:selected').appendTo('#select1');
	});
	//全部移到右边
	$('#add_all').click(function() {
		//获取全部的选项,删除并追加给对方
		$('#select1 option').appendTo('#select2');
	});
	//全部移到左边
	$('#remove_all').click(function() {
		$('#select2 option').appendTo('#select1');
	});
	//双击选项
	$('#select1').dblclick(function(){ //绑定双击事件
		//获取全部的选项,删除并追加给对方
		$("option:selected",this).appendTo('#select2'); //追加给对方
	});
	//双击选项
	$('#select2').dblclick(function(){
	   $("option:selected",this).appendTo('#select1');
	});
	
	//对单个员工进行选择
	//移到右边
	$('#add2').click(function() {
	//获取选中的选项，删除并追加给对方
		$('#select11 option:selected').appendTo('#select22');
	});
	//移到左边
	$('#remove2').click(function() {
		$('#select22 option:selected').appendTo('#select11');
	});
	//全部移到右边
	$('#add_all2').click(function() {
		//获取全部的选项,删除并追加给对方
		$('#select11 option').appendTo('#select22');
	});
	//全部移到左边
	$('#remove_all2').click(function() {
		$('#select22 option').appendTo('#select11');
	});
	//双击选项
	$('#select11').dblclick(function(){ //绑定双击事件
		//获取全部的选项,删除并追加给对方
		$("option:selected",this).appendTo('#select22'); //追加给对方
	});
	//双击选项
	$('#select22').dblclick(function(){
	   $("option:selected",this).appendTo('#select11');
	});
	
	
	//选择通知类型处理
	$("input[name='notice_type']").click(function(){
		if(this.value=="1"){
		   $("#department_status").fadeIn(800);
		   $("#employees_status").hide();
		}else{
		   $("#employees_status").fadeIn(800);
		   $("#department_status").hide();
		}
	});
   
});