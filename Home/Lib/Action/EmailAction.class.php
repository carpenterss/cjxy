<?php
  class EmailAction extends CommonAction{
	    //默认进入的电子邮件页面
	    public function email(){
			//调取出相应用户下所发的内部电子邮件信息
			$Uid = session('UserId');
			$email = M('email');
			
			import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			
			$count = $email->where(array('em_uid'=>$Uid,'em_type'=>0))->count();//获取总数
			$page = new Page($count,10);
		    //联合查询邮件表和用户表
			$sql = "select * from oa_email where em_uid = $Uid and em_type = 0 limit ".$page->limit;
			$email_info = $email->query($sql);
			
			$this->assign('email_info',$email_info);
			$this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//发送内部邮件页面
		public function send_email(){
			$Uid = $_SESSION['UserId'];	
			//获取公司通讯录(员工姓名和内部邮件地址)
			$user = M("employees");
			$e_info = $user->field("u_name,u_email_in")->where("u_id != {$Uid}")->select();
			$this->assign("e_info",$e_info);
			
			//获取发送人的源地址和姓名
			$email = M('email');		
			$sql = "select * from oa_employees as e,oa_email as em where e.u_id = em.em_uid and e.u_id = {$Uid} order by em.em_addtime desc limit 1";
			$email_info = $email->query($sql);
			$this->assign("email_info",$email_info);
			
			//继续发送选项处理
			if(isset($_GET['action'])&&($_GET['action']=="continue")){
			   $em_id = $_GET['em_id'];
			   $purpose = $email->field('em_purpose')->find($em_id);	
			   $this->assign("purpose",$purpose['em_purpose']);
			}
			$this->Online($_SESSION['UserId']);				
			$this->display();
		}
		
		//发送内部邮件处理部分
		public function doSend(){	
		    $email = M('email');
			$Uid = $_SESSION['UserId'];				
			
			$_POST['em_addtime'] = time();
			$_POST['em_status'] = 1;
			$purpose = explode("|",$_POST['purpose']);
			$_POST['em_sname'] = $purpose[1];			
			//处理邮件内容保存换行
			$_POST['em_content'] = nl2br($_POST['em_content']);
			
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();
			$upload->maxSize  = 1000000;
			$upload->savePath = './Public/Email_attachment/';
			if(!$upload->upload()) {
				if($upload->getErrorMsg()!="没有选择上传文件"){
				   $this->error($upload->getErrorMsg());	
				}
			}else{
				$info = $upload->getUploadFileInfo();
				$_POST['em_filename'] = $info[0]['name'];
				$_POST['em_fileUpload'] = $info[0]['savename'];
			}
			
			$email->create();
			if($email->add()){
			   $this->Online($Uid);
			   $this->Log($Uid,"发送内部邮件",1);
			   $this->success("邮件发送成功",U("Email/email"),3);	
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"发送内部邮件",0);			   
			   $this->error("对不起,邮件发送失败!!!");
			}
		}
		
		//单条删除记录处理
		public function delete_email(){
		    $em_id = $_GET['em_id'];
			$email = M('email');
			if($email->where("em_id = {$em_id}")->delete()){
			   $this->Online($Uid);
			   $this->Log($Uid,"删除邮件",1);
			   $this->success("删除成功",U("Email/email"),3);	
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"删除邮件",0);
			   $this->error("对不起,删除失败!!!");
			}				
		}
		
		//批量删除记录处理
		public function batch_del(){			
		    $arr = $_POST['check_is'];
			$email = M('email');
			if(!empty($arr)){
				for($i=0;$i<count($arr);$i++){
					$sql = "delete from oa_email where em_id = {$arr[$i]}";
					$email->query($sql);
				}
				$this->Online($Uid);
			    $this->Log($Uid,"删除邮件",1);
				$this->success("删除操作已完成");
			}else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除邮件",0);
			    $this->error('对不起,请选择要删除的记录');	
			}	
		}
		
		//接收内部邮件页面
		public function receive_email(){
			//根据用户SESSION查询出用户的内部邮箱地址
			$user = M('employees');
			$Uid = $_SESSION['UserId'];	
								
			$u_info = $user->field('u_email_in')->find($Uid);
			//查询出总共有多少条未接收的邮件
			$email = M("email");
			$count['em_purpose'] = $u_info['u_email_in'];
			$count['em_receive_is'] = 0;
			$count['em_type'] = 0;
            $num = $email->where($count)->count();			
			$this->assign("num",$num);
			//根据查询出的邮箱地址得到所接收的文件			
			$where['em_purpose'] = $u_info['u_email_in'];
			$where['em_uid'] = $Uid;
			$where['em_type'] = 1;
			//分页处理
			import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)		
			$count = $email->where($where)->count();//获取总数
			$page = new Page($count,10);
			
			$e_info = $email->where($where)->limit($page->limit)->select();
			$this->assign("e_info",$e_info);
			$this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			
			//点击接收新邮件
			if(!empty($_GET['action'])&&($_GET['action']=='look')){
			   $sql = "select * from oa_email where em_purpose = '{$u_info['u_email_in']}' and em_type = 0 and em_receive_is = 0";
			   $e_info = $email->query($sql);
			   if(!empty($e_info)){
				  for($i=0;$i<count($e_info);$i++){
					  $data[] = array();
					  $data['em_title'] = $e_info[$i]['em_title'];
					  $data['em_content'] = $e_info[$i]['em_content'];
					  $data['em_filename'] = $e_info[$i]['em_filename'];
					  $data['em_fileUpload'] = $e_info[$i]['em_fileUpload'];
					  $data['em_uid'] = $Uid;
					  $data['em_name'] = $e_info[$i]['em_name'];
					  $data['em_sname'] = $e_info[$i]['em_sname'];
					  $data['em_source'] = $e_info[$i]['em_source'];
					  $data['em_purpose'] = $e_info[$i]['em_purpose'];
					  $data['em_status'] = $e_info[$i]['em_status']; 
					  $data['em_addtime'] = $e_info[$i]['em_addtime'];
					  $data['em_look_is'] = $e_info[$i]['em_look_is'];
					  $data['em_type'] = 1;
					  
					  $data2['em_receive_is'] = 1;
					  $email->where("em_id = {$e_info[$i]['em_id']}")->save($data2);
					  $email->add($data);
				  }
			   } 
			   
			   $this->assign("e_info",$e_info);
			}	
			$this->Online($_SESSION['UserId']);				
			$this->display(); 
		}  
		
		//查看邮件
		public function look_email(){
		    $em_id = $_GET['em_id'];
			$email = M("email");
			$e_info = $email->find($em_id);
			if($e_info){
			   $data['em_look_is'] = 1;
               $email->where("em_id = {$em_id}")->save($data);     
			}
			$this->assign("e_info",$e_info);	
			$this->Online($_SESSION['UserId']);		
			$this->display();	
		}
		
		//删除单条接收邮件
		public function delete_out_email(){
		   	$em_id = $_GET['em_id'];
			$email = M('email');
			if($email->where("em_id = {$em_id}")->delete()){
			   $this->Online($Uid);
			   $this->Log($Uid,"删除邮件",1);
			   $this->success("删除成功",U("Email/email"),3);	
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"删除邮件",0);
			   $this->error("对不起,删除失败!!!");
			}	
		}
		
		//批量删除接收邮件
		public function batch_out_del(){
		    $arr = $_POST['check_is'];
			$email = M('email');
			if(!empty($arr)){
				for($i=0;$i<count($arr);$i++){
					$sql = "delete from oa_email where em_id = {$arr[$i]}";
					$email->query($sql);
				}
				$this->Online($Uid);
			    $this->Log($Uid,"删除邮件",1);
				$this->success("删除操作已完成");
			}else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除邮件",0);
			    $this->error('对不起,请选择要删除的记录');	
			}		
		}
		
		//外部邮件管理页面
		public function out_email(){
			$Uid = $_SESSION['UserId'];
			$send_email = M("outemail");
			//分页处理
			import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)		
			$count = $send_email->where("o_uid = {$Uid}")->count();//获取总数
			$page = new Page($count,10);
		
			$e_info = $send_email->where("o_uid = {$Uid}")->order("o_addtime desc")->limit($page->limit)->select();
			
			$this->assign("e_info",$e_info);
			$this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//外部发送邮件页面
		public function send_out_email(){
			$Uid = $_SESSION['UserId'];
			$user = M("employees");
			$source = $user->field('u_email')->find($Uid);
			$this->assign("source",$source['u_email']);
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//外部发送邮件处理
		public function do_outEmail(){
			//判断表单选项是否输入值
			if(empty($_POST['o_purpose'])||empty($_POST['o_title'])||empty($_POST['o_content'])){
			   $this->error("对不起,请正确填写表单内容");	
			}
			
			//导入邮件发送类
		    import('ORG.Util.Phpmailer');
			//从用户表中查询出发送的源地址
			$Uid = $_SESSION['UserId'];
			$user = M("employees");
			$source = $user->field('u_email')->find($Uid);
   		    //查询邮件配置表调取发送邮件所需要的参数
			$email_config = M("emailconfig");
			$config = $email_config->where("ec_uid = {$Uid}")->select();
			try {
			$mail = new PHPMailer(true); 
			
			$mail->IsSMTP();
			$mail->CharSet='UTF-8'; //设置邮件的字符编码这很重要不然中文乱
			$mail->SMTPAuth = true; //开启认证
			$mail->Port = $config[0]['ec_smtppost'];
			$mail->Host = $config[0]['ec_smtpserver'];
			$mail->Username = $config[0]['ec_smtpuser'];  
			$mail->Password = $config[0]['ec_smtppass'];
			$mail->AddReplyTo($source['u_email'],"AAA");//回复地址
			$mail->From = $source['u_email'];
			$to = $_POST['o_purpose'];
			$mail->AddAddress($to);
			$mail->Subject = $_POST['o_title'];
			$mail->Body = $_POST['o_content']; 
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示可以省略 
			$mail->WordWrap = 80; // 设置每行字符串的长度
			//$mail->AddAttachment("./06114207.jpg"); //可以添加附件 
			$mail->IsHTML(true); 
			$mail->Send();
			
			$email = M("outemail");
			   $_POST['o_source'] = $source['u_email'];
			   $_POST['o_addtime'] = time();
			   $_POST['o_uid']   = $Uid;
			   $_POST['o_status'] = 1;
			   $email->create();
			   $email->add();
			   
			   $this->Online($Uid);
			   $this->Log($Uid,"发送外部邮件",1);
			   $this->success("邮件发送成功",U('Email/out_email'));
			} catch (phpmailerException $e) {
	           $email = M("outemail");	
			   $_POST['o_source'] = $source['u_email'];
			   $_POST['o_addtime'] = time();
			   $_POST['o_uid']   = $Uid;
			   $_POST['o_status'] = 0;
			   $email->create();
			   $email->add();
			   
			   $this->Online($Uid);
			   $this->Log($Uid,"发送外部邮件",0);
			   $this->error("邮件发送失败");	 
			}
		}
		
		//外部发送邮件详细查看
		public function look_outEmail(){
			 $o_id = $_GET['o_id'];
			 $out_email = M('outemail');
			 $e_info = $out_email->find($o_id);
			 $this->assign("e_info",$e_info);
			 $this->Online($_SESSION['UserId']);
			 $this->display();
		}
		
		//删除单条外部发送邮件记录处理
		public function del_outEmail(){
		    $o_id = $_GET['o_id'];
			$email = M('outemail');
			if($email->where("o_id = {$o_id}")->delete()){
			   $this->Online($Uid);
			   $this->Log($Uid,"删除邮件",1);
			   $this->success("删除成功",U("Email/out_email"),3);	
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"删除邮件",0);
			   $this->error("对不起,删除失败!!!");
			}	 	
		}
		
		//批量删除外部发送邮件记录
		public function batch_outEmail_del(){
		    $arr = $_POST['check_is'];
			$email = M('outemail');
			if(!empty($arr)){
				for($i=0;$i<count($arr);$i++){
					$sql = "delete from oa_outemail where o_id = {$arr[$i]}";
					$email->query($sql);
				}
				$this->Online($Uid);
			    $this->Log($Uid,"删除邮件",1);
				$this->success("删除操作已完成");
			}else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除邮件",0);
			    $this->error('对不起,请选择要删除的记录');	
			}		
		}
  }
?>