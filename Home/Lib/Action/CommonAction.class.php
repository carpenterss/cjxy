<?php
  class CommonAction extends Action{
	  /*
	   * 验证用户是否进行过登陆
	   */
	   
	  public function _initialize(){
		date_default_timezone_set("Asia/Shanghai");
		
	    if(!isset($_SESSION['Login'])&&($_SESSION['Login']!=true)){
		     $this->redirect('Login/login');
		}
	  }  
	  
	  //日志记录函数
	  public function Log($uid,$content,$status){
		 $config = M("config");
		 $log_info = $config->field("c_is_log")->find();
		 if($log_info['c_is_log'] == 1){
		 $log = M("log");
		 $data['l_uid'] = $uid;
		 $data['l_content'] = $content;
		 $data['l_status'] = $status;
		 $data['l_time']   = time();
		 $log->add($data);  
		 }
	  }
	  
	  //记录用户状态
	  public function Online($uid){
		 $online = M("online");
		 $data['o_uid'] = $uid;
		 $data['o_time'] = time();
		 $online->where("o_uid = {$uid}")->save($data);	    
	  }

	  public function test(){
		  var_dump(get_AI_ID());
	  }
  }
?>