<?php
    class ClockInAction extends CommonAction{
		  //申请历史查看
	      public function apply_list(){
			  $Uid = $_SESSION['UserId'];
			  $this->Online($_SESSION['UserId']);
			  $employees = M("employees");
		      $e_info = $employees->field("u_department")->where("u_id = {$Uid}")->find();
			  
			  $department = M("department");
			  $d_info = $department->where("d_id = {$e_info['u_department']}")->find(); 

 			  $apply = M("apply");
			  if(strstr($d_info['d_name'],"管理")){
				 $this->assign("level","1");
			  	 $a_info = $apply->where("a_mudi_uid = {$Uid}")->select();
			 	 $this->assign("a_info",$a_info);
			  }else{
				 $this->assign("level","2");
			 	 $a_info = $apply->where("a_uid = {$Uid}")->select();
			 	 $this->assign("a_info",$a_info);
			  }
			  
			  $this->display();
		  }
		  
		  //填写申请页面
		  public function add_apply(){
			  $Uid = $_SESSION['UserId'];
			  $this->Online($_SESSION['UserId']);
			  $employees = M("employees");
			  $e_info = $employees->field("u_id,u_name")->where("u_id != {$Uid}")->select();
			  $this->assign("e_info",$e_info);
			  $this->display(); 
		  }
		  
		  //填写申请处理
		  public function do_add_apply(){
			  $Uid = $_SESSION['UserId'];
			  
			  $data['a_uid'] = $Uid;
			  $data['a_mudi_uid'] = $_POST['a_mudi_uid'];
			  $data['a_type'] = $_POST['a_type'];
			  $data['a_content'] = nl2br($_POST['a_content']);
			  
			  $apply = M("apply");
			  if($apply->add($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"提交申请",1);	
				 $this->success("申请提交成功",U("ClockIn/apply_list")); 
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"提交申请",0);	
				 $this->error("申请提交失败");  
			  }
		  }
		  
		  //查看申请页面
		  public function look_apply(){
			  $a_id = $_GET['a_id'];
		      $this->Online($_SESSION['UserId']);
			  $apply = M("apply");
			  
			  //更新查看状态
			  $data['a_is_look'] = 1;
			  $apply->where("a_id = {$a_id}")->save($data);

			  //记录日志
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"查看申请详细",1);
			  
			  $a_info = $apply->where("a_id = {$a_id}")->find();
			  $this->assign("a_info",$a_info);
			  
			  $employees = M("employees");
		      $e_info = $employees->field("u_name")->where("u_id = {$a_info['a_uid']}")->find();
			  
			  $this->assign("u_name",$e_info['u_name']);
			  $this->display();
			    
		  }
		  
		  //回复操作
		  public function do_reply(){
			  $a_id = $_POST['a_id'];
			  $data['a_is_approval'] = $_POST['approval']; 
		      $data['a_reply'] = nl2br($_POST['reply']);
			  
			  $apply = M("apply");
			  if($apply->where("a_id = {$a_id}")->save($data)){
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"回复申请操作",1);
				 $this->success("回复操作成功",U("ClockIn/apply_list"));  
			  }else{
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"回复申请操作",0);
				 $this->success("对不起,回复操作失败");   
			  }
		  }
		  
		  //删除申请
		  public function del_apply(){
			  $a_id = $_GET['a_id'];
			  
			  $apply = M("apply");
			  if($apply->where("a_id = {$a_id}")->delete()){
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"删除申请记录",1);
				 $this->success("删除申请记录成功");   
			  }else{
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"删除申请记录",0);
				 $this->error("对不起,删除申请记录失败");     
			  }
		  }
		  
		  //草稿纸
		  public function caogaozhi(){
			  $this->Online($_SESSION['UserId']);
			  $this->display();  
		  }
 		  
		 
	 }
?>