$(function(){
   //发送内部邮件-判断是否为空
   $("._input").blur(function(){
	  var v = $(this).val();
	  if(v==""){
		 $(this).next().addClass("valid_no");
		 $(this).next().html("&nbsp;");
	  }else{
		 $(this).next().addClass("valid_yes");
		 $(this).next().html("&nbsp;");  
	  }
   });
   
   //判断时候增加附件
   $("input[name='attachment']").click(function(){
	  var v = $(this).val();
	  if(v=="1"){
		 $("#attachment_is").fadeIn(800);  
	  }else{
		 $("#attachment_is").fadeOut(800); 
		     
	  }
   });
   
   //选择邮件接收人
   $("select[name='purpose']").change(function(){
	  var v = this.value;
	  var str = v.split("|");
	  $("input[name='em_purpose']").val(str[0]);
   });
   
   //全选/全不选
   $("#all_check").click(function(){
	  $(".check_is").attr("checked",true);
   });
   $("#no_check").click(function(){
	  $(".check_is").attr("checked",false);
   });
});