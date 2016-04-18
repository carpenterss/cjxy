<?php
  class ChatChannelAction extends CommonAction{
	    //公共频道
		public function publicChannel(){
			   $Uid = $_SESSION['UserId'];
			   $this->Online($_SESSION['UserId']);
			   $employees = M("employees");
			   $e_info = $employees->field("u_name")->where("u_id = {$Uid}")->find();
			   $this->assign("u_name",$e_info['u_name']);
 			   $this->display();
		}
		
		//公司相册
		public function companyPhoto(){
			   $this->Online($_SESSION['UserId']);
			   $photos = M("photos");
			   $p_info = $photos->select();
			   $this->assign("p_info",$p_info);
		       $this->display();	
		}
		
		//聊天AJAX处理程序
		public function backend(){
			$chatroom = M("chatroom");
		    header("Content-type: text/xml");
			header("Cache-Control: no-cache");	
			
			foreach($_POST as $key => $value){
	      		    $$key = $value;
			}
			
			//屏敝任何错误提示,判断action是否等于 postmsg
			if(@$action == "postmsg"){
			//插入数据
			$data['c_user'] = $name;
			$data['c_msg']	= $message;
			$data['c_time'] = time();
			$chatroom->add($data);
			}
			
			$time = $_POST['time'];
			
			$c_info = $chatroom->where("c_time > {$time}")->order("c_time desc")->limit(10)->select();
			if(empty($c_info)) $status_code = 2;
			else $status_code = 1;

			//返回xml数据结构
			echo "<?xml version=\"1.0\"?>\n";
			echo "<response>\n";
			echo "\t<status>{$status_code}</status>\n";
			echo "\t<time>".time()."</time>\n";
			if($status_code == 1){ //如果有记录
				for($i=0;$i<count($c_info);$i++){
					$c_info[$i]['c_msg'] = htmlspecialchars(stripslashes($c_info[$i]['c_msg']));
					echo "\t<message>\n";
					echo "\t\t<author>{$c_info[$i][c_user]}</author>\n";
					echo "\t\t<text>{$c_info[$i][c_msg]}</text>\n";
					echo "\t\t<times>".date('H:m:s',$c_info[$i][c_time])."</times>\n";
					echo "\t</message>\n";
				}
			}
			echo "</response>";
		}
  }
?>