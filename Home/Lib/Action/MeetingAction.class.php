<?php
  class MeetingAction extends CommonAction{
	   //会议室添加页面
	   public function meetingAdd(){
		  $this->Online($_SESSION['UserId']);
		  $this->display();
	   }
	   
	   //会议室添加处理
	   public function do_meetingAdd(){
		  $meetingRoom = M("meetingroom");
		  $meetingRoom->create();
		   
		  if($meetingRoom->add()){
			 $this->Online($Uid);
			 $this->Log($Uid,"新增会议室",1);
			 $this->success("恭喜您,会议室新增成功");  
		  }else{
			 $this->Online($Uid);
			 $this->Log($Uid,"新增会议室",0);
			 $this->error("对不起,会议室新增失败,请重新尝试"); 
		  }
       }
	   
	   //会议室管理页面
	   public function meetingManage(){
		  $meetingRoom = M("meetingroom");
		  $r_info = $meetingRoom->select();
		  $this->assign("r_info",$r_info);
		  $this->Online($_SESSION['UserId']);
	      $this->display();
	   }
	   
	   //修改会议室页面
	   public function edit_meetingRoom(){
		  $r_id = $_GET['r_id'];
		  $meetingRoom = M("meetingroom");
		  $r_info = $meetingRoom->find($r_id);
		  $this->assign("r_info",$r_info);
		  $this->Online($_SESSION['UserId']);
		  $this->display();   
	   }
	   
	   //修改会议室处理
	   public function do_edit_meetingRoom(){
		  $r_id = $_POST['r_id'];
		  $data['r_name'] = $_POST['r_name'];
		  $data['r_renshu'] = $_POST['r_renshu'];
		  $data['r_is_open'] = $_POST['r_is_open'];
		  
		  $meetingRoom = M("meetingroom");
		  if($meetingRoom->where("r_id = {$r_id}")->save($data)){
			 $this->Online($Uid);
			 $this->Log($Uid,"更新会议室信息",1);
			 $this->success("更新成功",U("Meeting/meetingManage")); 
		  }else{
			 $this->Online($Uid);
			 $this->Log($Uid,"更新会议室信息",0);
			 $this->error("对不起,更新失败");  
		  }
	   }
	   
	   //删除会议室处理
	   public function del_meetingRoom(){
		   $r_id = $_GET['r_id'];
		   
		   $meetingRoom = M("meetingroom");
		   if($meetingRoom->where("r_id = {$r_id}")->delete()){
			  $this->Online($Uid);
			  $this->Log($Uid,"删除会议室",1);
			  $this->success("删除成功");   
		   }else{
			  $this->Online($Uid);
			  $this->Log($Uid,"删除会议室",1);
			  $this->error("删除失败"); 
		   }
	   }
	   
	   //会议室预约默认页面
	   public function meetingAppointment(){
		  $meetingRoom = M("meetingroom");
		  $r_info = $meetingRoom->select();
		  
		  //对会议室是否被预约进行判断处理
		  $yuyue = M("yuyuemeeting");
		  $time = time();
		  for($i=0;$i<count($r_info);$i++){
			  $r_id = $r_info[$i]['r_id'];
			  $y_info = $yuyue->where("y_room_id = {$r_id}")->select(); 
			  for($j=0;$j<count($y_info);$j++){
				  if($y_info[$j]['y_yuyue_endtime'] > $time){ 
				     $r_info[$i]['r_is_appointment'] = 1;
				  }
			  }
		  }  
		  
		  $this->assign("r_info",$r_info);
		  $this->Online($_SESSION['UserId']);
	      $this->display();  
	   }
	   
	   //预约会议室页面
	   public function yuyue_meetingRoom(){
		  $r_id = $_GET['r_id'];
		  $this->assign("r_id",$r_id);
		  $time = time();
		  $date_arr = explode("-",date("Y-m-d-H-m",$time));
		  switch($date_arr[1]){
			   case "01":
			   case "03":
			   case "05":
			   case "07":
			   case "08":
			   case "10":
			   case "12":
			   $month_days = "31";
			   break;
			   case "02":
			   $month_days = "28";
			   break;
			   case "04":
			   case "06":
			   case "09":
			   case "11":
			   $month_days = "30";
			   break;
		  }
		  $this->assign("year",$date_arr[0]);
		  $this->assign("month",$date_arr[1]);
		  $this->assign("month_days",$month_days);
		  $this->assign("day",$date_arr[2]);
		  $this->Online($_SESSION['UserId']);
		  $this->display(); 
	   }
	   
	   //预约处理
	   public function do_yuyue(){
		  //获取到预约人的姓名
		  $Uid = $_SESSION['UserId'];
		  $employees = M("employees");
		  $e_info = $employees->field("u_name")->find($Uid);
		  $yuyue_name = $e_info['u_name'];
		  
		  $r_id = $_POST['r_id']; //获取到会议室的ID号
		  $start_nian = $_POST['start_nian'];    
		  $start_yue = $_POST['start_yue'];  
		  $start_ri = $_POST['start_ri'];   
		  $start_shi = $_POST['start_shi'];    
		  $start_fen = $_POST['start_fen'];
		  $end_nian = $_POST['end_nian'];
		  $end_yue = $_POST['end_yue'];  
		  $end_ri = $_POST['end_ri'];   
		  $end_shi = $_POST['end_shi'];    
		  $end_fen = $_POST['end_fen'];  
	       
		  $start_time = mktime($start_shi,$start_fen,0,$start_yue,$start_ri,$start_nian);
		  $end_time = mktime($end_shi,$end_fen,0,$end_yue,$end_ri,$end_nian);
		  
		  $yuyue = M("yuyuemeeting");
		  $meetingRoom = M("meetingroom");
		  		  
		  $data['y_uid'] = $Uid;
		  $data['y_uname'] = $yuyue_name;
		  $data['y_yuyue_starttime'] = $start_time;
		  $data['y_yuyue_endtime'] = $end_time;
		  $data['y_room_id'] = $r_id;
		  
		  if($yuyue->add($data)){
			  //$save['r_is_appointment'] = 1;
			  //$meetingRoom->where("r_id = {$r_id}")->save($save); 
			  $this->Online($Uid);
			  $this->Log($Uid,"预约会议室",1);
			  $this->success("恭喜您,会议室预约成功",U("Meeting/meetingAppointment")); 			  
		  }else{
			  $this->Online($Uid);
			  $this->Log($Uid,"预约会议室",0);
			  $this->error("对不起,会议室预约失败,请重新尝试");  
		  }  
	   }	
	   
	   //查看预约使用的详细信息
	   public function yuyue_info(){
		   $r_id = $_GET['r_id'];
		   $yuyue = M("yuyuemeeting");
		   $y_info = $yuyue->where("y_room_id = {$r_id}")->order("y_id desc")->select();
		   $this->assign("y_info",$y_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();   
	   }
	   
	   //会议安排页面
	   public function meetingArrange(){
		    $Uid = $_SESSION['UserId'];
			//获取预约场馆的编号
			$yuyue = M("yuyuemeeting");
			$y_info = $yuyue->field("y_id,y_yuyue_endtime")->where("y_uid = {$Uid}")->select();
			$this->assign("y_info",$y_info);
			
			//获取公司员工信息
			$employees = M("employees");
			$e_info = $employees->field("u_id,u_name")->select();
			$this->assign("e_info",$e_info);
			
			//获取部门信息
			$department = M("department");
			$d_info = $department->field("d_id,d_name")->select();
			$this->assign("d_info",$d_info);
			$this->Online($_SESSION['UserId']);		
		    $this->display();  
	   } 
	   
	   //会议安排处理
	   public function do_meetingArrange(){
		    $meeting = M("meeting");
			$m_start_day = $_POST['m_start_day'];
			$start_shi = $_POST['start_shi'];
			$start_fen = $_POST['start_fen'];
			$time_arr = explode("-",$m_start_day);
			//将前台提交的时间信息组合获取会议举办时间的时间戳
			$start_time = mktime($start_shi,$start_fen,0,$time_arr[1],$time_arr[2],$time_arr[0]);
			
			$valid_name = M("employees");
			$where['u_name'] = array("like",$_POST['m_name']);
			if(!$valid_name->where($where)->find()){
			   $this->error("对不起,公司没有{$_POST['m_name']}这个人");
			}
			
			$data['m_title'] = $_POST['m_title'];
			$data['m_name']  = $_POST['m_name'];
			$data['m_yuyue_id'] = $_POST['yuyue_id'];
			$data['m_starttime'] = $start_time;
			
			//获取会议通知的部门或者个人
			$departments = $_POST['selected_department'];
			$employees = $_POST['selected_name'];
			
			$meetingNotice = M("meetingnotice");
			if($m_id = $meeting->add($data)){
			   for($i=0;$i<count($departments);$i++){
				   $data2['n_department'] = $departments[$i];
				   $data2['n_mid'] = $m_id;
				   if(!$meetingNotice->add($data2)){
					  $meeting->where("m_id = {$m_id}")->delete();
					  $this->error("对不起,会议创建失败,请重新尝试");   
				   }
			   }
			   
			   for($j=0;$j<count($employees);$j++){
				   $data3['n_uid'] = $employees[$j];
				   $data3['n_mid'] = $m_id;   
				   if(!$meetingNotice->add($data3)){
					  $meeting->where("m_id = {$m_id}")->delete();
					  $this->error("对不起,会议创建失败,请重新尝试");   
				   }
			   }
			   $this->Online($Uid);
			   $this->Log($Uid,"创建会议",1);
			   $this->success("会议创建成功");
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"创建会议",0);
			   $this->error("对不起,会议创建失败,请重新尝试");	
			}		
	   }
	   
	   //会议管理界面
	   public function meetingList(){
		   $Uid = $_SESSION['UserId'];
		   $employees = M("employees");
		   $e_name = $employees->field("u_name")->where("u_id = {$Uid}")->find();  
		   $name = $e_name['u_name'];
		   $meeting = D("Meeting");
		   $m_info = $meeting->relation(true)->where("m_name = '{$name}'")->select();
		   $this->assign("m_info",$m_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();
	   }
	   
	   //查看会议已经通知的人员列表
	   public function look_Employees(){
		   $m_id = $_GET['m_id'];
		   $meetingNotice = D("Meetingnotice");
		   $n_info = $meetingNotice->relation(true)->where("n_mid = {$m_id}")->select();
	       
		   //分别将部门和员工存入两个数组
		   for($i=0;$i<count($n_info);$i++){
			   if($n_info[$i]['n_department']!=0){
		  	   $department[] = $n_info[$i]['d_name'];
			   }
			   if($n_info[$i]['n_uid']!=0){
		  	   $employees[] = $n_info[$i]['u_name'];
			   }
		   }

		   $this->assign("department",$department);
		   $this->assign("employees",$employees);
		   $this->display();
	   }
	   
	   //修改会议信息页面
	   public function edit_meeting(){
		   $m_id = $_GET['m_id'];
		   $meeting = M("meeting");
		   $m_info = $meeting->where("m_id = {$m_id}")->find();
		   $this->assign("m_info",$m_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();   
	   }
	   
	   //修改会议信息处理
	   public function do_edit_meetingArrange(){
		   $m_id = $_POST['m_id'];
		  
		   $m_start_day = $_POST['m_start_day'];
		   $old_shi_fen = $_POST['shi_fen'];
		   $start_shi_fen = $_POST['start_shi_fen'];
		   if($start_shi_fen==""){
			  $start_shi_fen = $old_shi_fen;  
		   }
		   $shi_fen = explode(":",$start_shi_fen);
		   $time_arr = explode("-",$m_start_day);
			//将前台提交的时间信息组合获取会议举办时间的时间戳
		   $start_time = mktime($shi_fen[0],$shi_fen[1],0,$time_arr[1],$time_arr[2],$time_arr[0]);
		   
		   $data['m_yuyue_id'] = $_POST['m_yuyue_id'];
		   $data['m_title'] = $_POST['m_title'];
		   $data['m_starttime'] = $start_time;
		   
		   $meeting = M("meeting");
		   if($meeting->where("m_id = {$m_id}")->save($data)){
			   $this->Online($Uid);
			   $this->Log($Uid,"更新会议信息",1);
			   $this->success("会议室信息更新成功",U("Meeting/meetingList"));
		   }else{
			   $this->Online($Uid);
			   $this->Log($Uid,"更新会议信息",0);
			   $this->error("会议室信息更新失败");
		   }		    
	   }  
	   
	   //取消会议处理
	   public function del_meeting(){
		   $m_id = $_GET['m_id'];
		   $meeting = M("meeting");
		   $meetingNotice = M("meetingnotice");
		   
		   if($meeting->where("m_id = {$m_id}")->delete()){
			  if($meetingNotice->where("n_mid = {$m_id}")->delete()){
				 $this->Online($Uid);
			     $this->Log($Uid,"取消会议",1);
				 $this->success("会议取消成功");  
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"取消会议",1);
				 $this->error("对不起,会议取消失败");  
			  }
		   }else{
			  $this->Online($Uid);
			  $this->Log($Uid,"取消会议",1);
			  $this->error("对不起,会议取消失败");   
		   }
	   }
	   
	   
	//会议查看
	public function huiyi_info(){
		$m_id = $_GET['m_id'];
		$meet = M("meeting");
		$sql = "select * from oa_meeting as m,oa_meetingnotice as mn where m.m_id = {$m_id} and m.m_id = mn.n_mid";
		$m_info = $meet->query($sql);
		
		$sql2 = "select y_room_id from oa_yuyuemeeting where y_id = {$m_info[0]['m_yuyue_id']}";
		$y_info = $meet->query($sql2);
		
		$sql3 = "select r_name from oa_meetingroom where r_id = {$y_info[0]['y_room_id']}";
		$r_info = $meet->query($sql3);
		
		$this->assign("m_info",$m_info);
		$this->assign("r_info",$r_info[0]['r_name']);
		$this->Online($_SESSION['UserId']);
	    $this->display();
	  } 
  } 
?>