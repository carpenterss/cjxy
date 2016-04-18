<?php
    class ScheduleAction extends CommonAction{
		//日程安排默认导航点击默认页面
	    public function schedule(){	   
		   $time = time();
		   $date_info = date("Y-m-d");	
		   $date_arr  = explode("-",$date_info);
		   $this->assign("month",$date_arr[1]);
		   $this->assign("now_day",$date_arr[2]);

		   
		   //获取相应月份的天数
		   switch($date_arr[1]){
			  case "01":
			  case "03":
			  case "05":
			  case "07":
			  case "08":
			  case "10":
			  case "12":
			  $days = '31';
			  break;
			  case "02":
			  $days = '28';
			  break;
			  case "04":
			  case "06":
			  case "09":
			  case "11":
			  $days = '30';
			  break;   
		   }
		   $this->assign("days",$days);
		   $this->Online($_SESSION['UserId']);
		   $this->display();	
		}
		
		//焦点失去AJAX保存日常安排内容处理
		public function save_input(){
			$Uid = $_SESSION['UserId'];
		    $content = $_GET['v']; //日程安排内容
			$day = $_GET['day'];   //获得本月几号
			$month = $_GET['month'];   //获得是几月
			
			$schedule = M("schedule");			
			$rs = $schedule->where("s_day = {$day} and s_uid = {$Uid} and s_month = {$month}")->find();
			if($rs){
			   $data['s_content'] = $content;
			   if($schedule->where("s_day = {$day} and s_uid = {$Uid} and s_month = {$month}")->save($data)){
				  $this->Online($Uid);
			      $this->Log($Uid,"增加日常安排",1);
				  echo "1";   
			   }else{
				  $this->Online($Uid);
			      $this->Log($Uid,"增加日常安排",0);
				  echo "2"; 
			   }			  
			}else{
			   $data['s_uid'] = $Uid;
			   $data['s_day'] = $day;
			   $data['s_month'] = $month;
			   $data['s_content'] = $content;
			   
			   if($schedule->add($data)){
				    $this->Online($Uid);
			        $this->Log($Uid,"更新日常安排",1);
				    echo "1";
			   }else{
				    $this->Online($Uid);
			        $this->Log($Uid,"更新日常安排",1);
				    echo "2";
			   }
			}
		}
		
		
		//查看日程安排AJAX处理
		public function look_schedule(){
		    $Uid = $_SESSION['UserId'];
			$day = $_GET['day'];
			$month = $_GET['month'];
			
			$schedule = M("schedule");
			$s_info = $schedule->where("s_uid = {$Uid} and s_day = {$day} and s_month = {$month}")->find();			
		    if($s_info){
			    echo $s_info['s_content']."&nbsp;<font color=red>(双击->可进行日程安排的更改!!!)</font>";	
			}else{
				echo "暂无安排->双击可以进行日程安排!!!";	
			}
		}
	}
?>