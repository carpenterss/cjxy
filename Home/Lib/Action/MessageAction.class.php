<?php
  class MessageAction extends CommonAction{
	  //默认接收短信息页面
	  public function message(){
		   //查询出接收到的短信息
		   $Uid = $_SESSION['UserId'];	
		   $message = M("message");
		   
		   import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)		
		   $count = $message->where("m_reUid = $Uid")->count();//获取总数
		   $page = new Page($count,10);
   
		   $m_info = $message->where("m_reUid = $Uid")->order("m_addtime desc")->limit($page->limit)->select();
		   $this->assign("m_info",$m_info);
		   $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
		   $this->Online($_SESSION['UserId']);
		   $this->display();  
	  }
	  
	  //单独发送短信息页面
	  public function alone_message(){
		   $Uid = $_SESSION['UserId'];	
		   //获取公司通讯录(员工姓名和内部邮件地址)
		   $user = M("employees");
		   $e_info = $user->field("u_name,u_id")->where("u_id != {$Uid}")->select();

		   $this->assign("e_info",$e_info);  
		   $this->Online($_SESSION['UserId']); 
		   $this->display(); 
	  }
	  
	  //单独信息发送处理
	  public function doMessage(){
		   if(empty($_POST['m_content'])){
              $this->error("对不起,信息内容不能为空");
		   }
		  
		   $Uid = $_SESSION['UserId'];
		   $user = M("employees");
		   //获取发送人姓名		   
		   $sendname = $user->field("u_name")->find($Uid);
		   $_POST['m_addtime']  = time();  
	       $_POST['m_sendname'] = $sendname['u_name'];
		   $_POST['m_sendUid']  = $Uid;
		   $receive = explode("|",$_POST['m_re']);
		   $_POST['m_rename']   = $receive[1];
		   $_POST['m_reUid']    = $receive[0];
		   
		   $message = M("message");
		   $message->create();
		   if($message->add()){
			  $this->Online($Uid);
			  $this->Log($Uid,"发送短信息",1);
			  $this->success("信息发送成功",U('message'));
		   }else{
			  $this->Online($Uid);
			  $this->Log($Uid,"发送短信息",0); 
			  $this->error("信息发送失败,请重新尝试",U('message'));
		   }
	  }
	  
	  //查看后更新查看字段状态AJAX处理
	  public function doLook(){
		  $m_id = $_GET['m_id'];
		  $message = M("message");
		  $data['m_looks_is'] = 1;
		  $message->where("m_id = {$m_id}")->save($data);  
	  }
	  
	  //回复信息处理页面
	  public function reply_message(){
		   $message = M("message");	
		   //通过AJAX传值然后插入信息表	 
		   $m_id = $_GET['m_id']; 
		   $save['m_reply_is'] = 1;
		   
		   $data['m_content']  = $_GET['m_content']; 
		   $data['m_sendname'] = $_GET['m_rename'];
		   $data['m_sendUid']  = $_GET['m_reUid'];
		   $data['m_rename']   = $_GET['m_sendname'];
		   $data['m_reUid']    = $_GET['m_sendUid'];
		   $data['m_addtime']  = time();
		   if($message->add($data)){
			    echo 1;
				$this->Online($Uid);
			    $this->Log($Uid,"发送短信息",1);
				//如果回复成功更新,回复状态
				$message->where("m_id = {$m_id}")->save($save);
		   }else{
			    $this->Online($Uid);
			    $this->Log($Uid,"发送短信息",0);
		        echo 2;
		   }
 
	  } 
	  

	  //批量记录删除处理
	  public function batch_message_del(){
		    $arr = $_POST['check_is'];
			$message = M('message');
			if(!empty($arr)){
				for($i=0;$i<count($arr);$i++){
					$sql = "delete from oa_message where m_id = {$arr[$i]}";
					$message->query($sql);
				}
				$this->Online($Uid);
			    $this->Log($Uid,"删除短信息",1);
				$this->success("删除操作已完成");
			}else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除短信息",0);
			    $this->error('对不起,请选择要删除的记录');	
			}	  
	  }
	  
	  //批量发送短信息页面
	  public function batch_message(){
		    $Uid = $_SESSION['UserId'];	
		    //获取公司通讯录(员工姓名和内部邮件地址)
		    $user = M("employees");
		    $e_info = $user->field("u_name,u_id")->where("u_id != {$Uid}")->select();

		    $this->assign("e_info",$e_info); 
			$this->Online($_SESSION['UserId']); 
		    $this->display();  
	  }
	  
	  //批量发送短信处理页面
	  public function do_batch_message(){
		   $Uid = $_SESSION['UserId'];
		   $user = M("employees");
		   $message = M("message");
		   //获取发送人姓名		   
		   $sendname = $user->field("u_name")->find($Uid);
		   $renames = $_POST['selected_name'];  //获取接收人组
		   $content = nl2br($_POST['contents']);
		   for($i=0;$i<count($renames);$i++){
			   $new_arr = explode("|",$renames[$i]);
			   $_POST['m_content']  = $content;
			   $_POST['m_addtime']  = time();
			   $_POST['m_sendname'] = $sendname['u_name'];
			   $_POST['m_sendUid']  = $Uid;
			   $_POST['m_rename']   = $new_arr[1];
			   $_POST['m_reUid']    = $new_arr[0];
			   $message->create();
			   if(!$message->add()){
				   $this->Online($Uid);
			       $this->Log($Uid,"批量发送短信息",0);
				   $this->error("批量发送失败,请重新尝试!!!",U('message'));
			   }
		   }
		   $this->Online($Uid);
		   $this->Log($Uid,"批量发送短信息",1);
		   $this->success("短息息批量发送成功",U('message'));
	  }
	  
  }
?>