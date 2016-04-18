<?php
  class PanelAction extends CommonAction{
	    public function panel(){
			$Uid = $_SESSION['UserId'];
			
			//内部电子邮件数量
			$email = M("email");
			$e_sum = $email->where("em_uid = {$Uid}")->count();
			$this->assign("e_sum",$e_sum);
			//外部电子邮件数量
			$outemail = M("outemail");
			$o_sum = $email->where("o_uid = {$Uid}")->count();
			$this->assign("o_sum",$o_sum);
			//总电子邮件数量
			$this->assign("email_sum",($e_sum+$o_sum));
			//已接收短信息数量
			$message = M("message");
			$m_sum = $message->where("m_reUid = {$Uid}")->count();
			$this->assign("m_sum",$m_sum);
			//未回复短信数量
			$m_reply_sum = $message->where("m_reUid = {$Uid} and m_reply_is = 0")->count();
			$this->assign("m_reply_sum",$m_reply_sum);
			//未查看短信数量
			$m_look_sum = $message->where("m_reUid = {$Uid} and m_looks_is = 0")->count();
			$this->assign("m_look_sum",$m_look_sum);
			//已有日程安排数量
			$schedule = M("schedule");
			$s_sum = $schedule->where("s_uid = {$Uid}")->count();
			$this->assign("s_sum",$s_sum);
			//已写工作日志数量
			$joblog = M("joblog");
			$j_sum = $joblog->where("j_uid = {$Uid}")->count();
			$this->assign("j_sum",$j_sum);
			//领导审批过的工作日志数量
			$j_review_sum = $joblog->where("j_uid = {$Uid} and j_look_review = 1")->count();
			$this->assign("j_review_sum",$j_review_sum);
			//已存入个人文件柜数量
			$filecabinet = M("filecabinet");
			$f_sum = $filecabinet->where("f_uid = {$Uid}")->count();
			$this->assign("f_sum",$f_sum);
			//剩余空间大小
			$space = M("space");
			$f_free = $space->field("s_free_space")->where("s_uid = {$Uid}")->find();
			$this->assign("f_free",$f_free['s_free_space']);
			//客户信息
			$customer = M("customer");
			$c_sum = $customer->where("c_uid = {$Uid}")->count();
			$this->assign("c_sum",$c_sum);
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
  }
?>