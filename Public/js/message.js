$(function(){
   //全选/全不选
   $("#all_check").click(function(){
	  $(".check_is").attr("checked",true);
   });
   $("#no_check").click(function(){
	  $(".check_is").attr("checked",false);
   });
   
   //批量发送选择接收人处理
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


	$('#add2').click(function() {
	//获取选中的选项，删除并追加给对方
		$('#select3 option:selected').appendTo('#select4');
	});
	//移到左边
	$('#remove2').click(function() {
		$('#select4 option:selected').appendTo('#select3');
	});
	//全部移到右边
	$('#add_all2').click(function() {
		//获取全部的选项,删除并追加给对方
		$('#select3 option').appendTo('#select4');
	});
	//全部移到左边
	$('#remove_all2').click(function() {
		$('#select4 option').appendTo('#select3');
	});
	//双击选项
	$('#select3').dblclick(function(){ //绑定双击事件
		//获取全部的选项,删除并追加给对方
		$("option:selected",this).appendTo('#select4'); //追加给对方
	});
	//双击选项
	$('#select4').dblclick(function(){
	   $("option:selected",this).appendTo('#select3');
	});
   
});