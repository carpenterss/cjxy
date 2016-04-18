<?php
  class VoteAction extends CommonAction{
	    //输出调查列表
		public function vote_list(){
			   $voteinfo = M("voteinfo");
			   $v_info = $voteinfo->order("v_id desc")->select();
			   
			   $now_time = time();
			   //判断是否过期
			   for($i=0;$i<count($v_info);$i++){
				   if($v_info[$i]['v_endtime'] > $now_time){
					  $v_info[$i]['v_time'] = "<font color=green>未过期</font>";   
				   }else{
				      $v_info[$i]['v_time'] = "<font color=red>已过期</font>";     
				   }
			   } 
			   $this->assign("v_info",$v_info);
			   $this->Online($_SESSION['UserId']);
			   $this->display();
		}
		
		//添加调查
		public function add_vote(){
		  $this->Online($_SESSION['UserId']);
		  $this->display();	
		}
		
		//添加调查处理
		public function do_addVote(){
		  $data['v_title'] = $_POST['v_title']; 	
		  $data['v_type'] = $_POST['v_type'];
		  $data['v_starttime'] = strtotime($_POST['v_starttime']);
		  $data['v_endtime'] = strtotime($_POST['v_endtime']); 	
		  $data['v_display'] = $_POST['v_display']; 
		  
		  $voteinfo = M("voteinfo");
		  if($voteinfo->add($data)){
			 $this->Online($_SESSION['UserId']);
			 $this->Log($_SESSION['UserId'],"添加新调查",1);	
			 $this->success("新调查添加成功",U("Vote/vote_list"));  
		  }else{
			 $this->Online($_SESSION['UserId']);
			 $this->Log($_SESSION['UserId'],"添加新调查",0);	
			 $this->error("对不起,调查添加失败");  
		  }
		}
		
		//编辑调查页面
		public function edit_vote(){
		   $v_id = $_GET['v_id'];
		   $voteinfo = M("voteinfo");
		   $v_info = $voteinfo->where("v_id = {$v_id}")->find();
		   $this->assign("v_info",$v_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();	
		}
		
		//编辑调查页面处理
		public function do_editVote(){
			$v_id = $_POST['v_id'];
			
			$data['v_title'] = $_POST['v_title']; 	
		    $data['v_type'] = $_POST['v_type'];
		    $data['v_starttime'] = strtotime($_POST['v_starttime']);
		    $data['v_endtime'] = strtotime($_POST['v_endtime']); 	
		    $data['v_display'] = $_POST['v_display']; 
			
			$voteinfo = M("voteinfo");
			if($voteinfo->where("v_id = {$v_id}")->save($data)){
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"更新调查信息",1);	
			   $this->success("调查信息更新成功",U("Vote/vote_list"));	
			}else{
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"更新调查信息",0);
			   $this->error("对不起,调查信息更新失败");	
			}	
		}
		
		//调查选项列表页面
		public function item_list(){
		   $v_title = $_GET['v_title'];
		   $v_id = $_GET['v_id'];
		   $this->assign("v_title",$v_title);
		   $this->assign("v_id",$v_id);
		   
		   $iteminfo = M("iteminfo");
		   $i_info = $iteminfo->where("i_vid = {$v_id}")->select();
		   $this->assign("i_info",$i_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();	
		}
		
		//添加选项页面
		public function add_item(){
			$v_title = $_GET['v_title'];
			$v_id = $_GET['v_id'];
		    $this->assign("v_title",$v_title);
			$this->assign("v_id",$v_id);
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//添加选项处理
		public function do_addItem(){
		    $data['i_vid'] = $_POST['v_id'];
			$data['i_title'] = $_POST['i_title'];
			
			$iteminfo = M("iteminfo");
			if($iteminfo->add($data)){
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"添加调查选项",1);
			   $this->success("选项添加成功");	
			}else{
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"添加调查选项",0);
			   $this->error("对不起,选项添加失败");	
			}
		}
		
		//编辑调查选项
		public function edit_item(){
			$v_title = $_GET['v_title'];
			$i_id = $_GET['i_id'];
		    $this->assign("v_title",$v_title);
			
			$iteminfo = M("iteminfo");
			$i_info = $iteminfo->where("i_id = {$i_id}")->find();
			$this->assign("i_info",$i_info);
			$this->Online($_SESSION['UserId']);
		    $this->display();	
	    }
		
		//编辑调查选项处理
		public function do_editItem(){
		    $i_id = $_POST['i_id'];
			$data['i_title'] = $_POST['i_title'];	
			
			$iteminfo = M("iteminfo");
			if($iteminfo->where("i_id = {$i_id}")->save($data)){
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"更新调查选项",1);
			   $this->success("选项更新成功");
			}else{
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"更新调查选项",0);
			   $this->success("对不起,选项更新失败"); 	
			}
		}
		
		//调查选项顺序设置页面
		public function order_item(){
			$v_title = $_GET['v_title'];
			$v_id = $_GET['v_id'];
			$this->assign("v_title",$v_title);
			$this->assign("v_id",$v_id);
			$iteminfo = M("iteminfo");
			$i_info = $iteminfo->where("i_vid = {$v_id}")->select();
			$this->assign("i_info",$i_info);
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//设置调查选项顺序处理
		public function do_orderItem(){
		   $i_id = $_GET['i_id'];
		   $i_order = $_GET['i_order'];	
		   
		   $data['i_id'] = $i_id;
		   $data['i_order'] = $i_order;
		   
		   $iteminfo = M("iteminfo");
		   if($iteminfo->where("i_id = {$i_id}")->save($data)){
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"更新调查选项顺序",1);
			  echo 1;   
		   }else{
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"更新调查选项顺序",0);
			  echo 2;   
		   }
		}
		
		//用户投票信息列表
		public function user_list(){
		   $v_id = $_GET['v_id'];
		   
		   $voteuser = M("voteuser");
		   $v_info = $voteuser->where("u_vid = {$v_id}")->select();
		   $this->assign("v_info",$v_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();	
		}
		
		//投票中心页面（公共投票）
		public function user_vote(){
		   $voteinfo = M("voteinfo");
		   $iteminfo = M("iteminfo");
		   
		   $now_time = time();
		   $where['v_display'] = 1;
		   $where['v_endtime'] = array("gt",$now_time);	
		   $v_info = $voteinfo->where($where)->order("v_id desc")->select();
		   $i_info = $iteminfo->order("i_order asc")->select();
		   
		   $this->assign("v_info",$v_info);
		   $this->assign("i_info",$i_info);
		   $this->Online($_SESSION['UserId']);
		   $this->display();	
		}
		
		//投票中心投票处理
		public function do_vote(){
		   $vid = $_POST['v_id'];
		   $iteminfo = M("iteminfo");	
		   //检查该用户是否投过了
		   $voteuser = M("voteuser");
		   $v_num = $voteuser->where("u_uid = {$_SESSION['UserId']} and u_vid = {$vid}")->count();
		   if($v_num>0){
			  $this->error("对不起,您已经投过票了,请不要重复投票");   
		   }
			
		   $vote_arr = $_POST['v'];
		   for($i=0;$i<count($vote_arr);$i++){
			   $iteminfo->query("update oa_iteminfo set i_count = (i_count+1) where i_id = {$vote_arr[$i]}");
		   }
		   
		   
		   $data['u_vid'] = $vid;
		   $data['u_uid'] = $_SESSION['UserId'];
		   
		   $employees = M("employees");
		   $e_info = $employees->field("u_name")->where("u_id = {$data['u_uid']}")->find();
		   
		   $data['u_name'] = $e_info['u_name'];
		   $data['u_addtime'] = time();
		   
		   
		   if($voteuser->add($data)){
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"投票操作",1);
			  $this->success("恭喜您,投票成功");   
		   }else{
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"投票操作",0);
			  $this->error("对不起,投票失败");  
		   } 
		}
		
		//查看投票结果页面
		public function look_vote(){
		   $vid = $_GET['v_id'];
		   $v_title = $_GET['v_title'];
		   $this->assign("v_title",$v_title);
		   
		   $iteminfo = M("iteminfo");
		   $i_info = $iteminfo->where("i_vid = {$vid}")->select();
		   //总票数
		   $sum = $iteminfo->where("i_vid = {$vid}")->sum("i_count");
		   $this->assign("sum",$sum);
		   
		   for($i=0;$i<count($i_info);$i++){
			   $i_info[$i]['baifenbi'] = (number_format($i_info[$i]['i_count']/$sum,4)*100);
		   }
		   
		   $this->assign("i_info",$i_info);
		   $this->display();	
		}
		
		//删除投票记录
		public function del_vote(){
		   $v_id = $_GET['v_id'];
		   
		   $voteinfo = M("voteinfo");
		   if($voteinfo->where("v_id = {$v_id}")->delete()){
			  $iteminfo = M("iteminfo");
			  if($iteminfo->where("i_vid = {$v_id}")->delete()){
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"删除投票信息",1); 
				 $this->success("投票信息删除成功");   
			  }else{
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"删除投票信息",0);
				 $this->error("对不起,投票信息删除失败");  
			  }
		   }else{
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"删除投票信息",0); 
			  $this->error("对不起,投票信息删除失败");   
		   }
		}
   }
?>