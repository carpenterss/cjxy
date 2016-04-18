$(function(){
	//统计效果处理
	var zhengchang = ($("table tr td[bgcolor='green']").length-1);
	var chidao = ($("table tr td[bgcolor='yellow']").length-1);
	var zaotui = ($("table tr td[bgcolor='#FF9900']").length-1);
	var am_qingjia = ($("table tr td[bgcolor='#0099FF']").length-1);
	var pm_qingjia = ($("table tr td[bgcolor='#FFCC99']").length-1);
	var qingjia = ($("table tr td[bgcolor='#FF00FF']").length-1);
	var zhoumo = ($("table tr td[bgcolor='#66CC33']").length-1);
	var kuanggong = ($("table tr td[bgcolor='#FF0000']").length-1);	
	var zhengchang_list = zhengchang+chidao+zaotui;
	var chidao_list = chidao+zaotui;
	
	$("#chidao_list").html(chidao_list);
	$("#zhengchang_list").html(zhengchang_list);
	$("#zhengchang").html(zhengchang);
	$("#chidao").html(chidao);
	$("#zaotui").html(zaotui);
	$("#am_qingjia").html(am_qingjia);
	$("#pm_qingjia").html(pm_qingjia);
	$("#qingjia").html(qingjia);
	$("#zhoumo").html(zhoumo);
	$("#kuanggong").html(kuanggong);
});