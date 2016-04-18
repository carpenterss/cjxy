<?php
  class NoticeAction extends CommonAction{
	    //公告通知默认页面(接收公告通知)
		public function notice(){
			$Uid = $_SESSION['UserId'];
			//查出用户所属部门ID
			$user   = M("employees");			
			$u_info = $user->field("u_department")->find($Uid);
			
			$notice = M("notice");
			$department = M("department");
			
			//分页处理部分
			import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			$count = $notice->where("(n_target = 2 or n_department = {$u_info['u_department']}) and n_rUid != {$Uid}")->count();
			$page = new Page($count,10);
			
			//查询出本部门所发公告或者所有员工接收的公告(排除自身所发公告)
			$n_info = $notice->where("(n_target = 2 or n_department = {$u_info['u_department']}) and n_rUid != {$Uid}")->select();
			
			//通过内部循环将部门ID换成部门名称
			for($i=0;$i<count($n_info);$i++){
				$d_info = $department->where("d_id = {$n_info[$i]['n_department']}")->select();
				$n_info[$i]['n_department'] = $d_info[0]['d_name'];
			} 
			$this->assign("n_info",$n_info);
			$this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//创建公告通知
		public function add_notice(){
			$notice = M("notice");
			$user   = M("employees");
			$department = M("department");
			$Uid = $_SESSION['UserId'];
			//查出用户所属部门ID和姓名
			$u_info = $user->field("u_department,u_name")->find($Uid);
			
			//查询出所有部门以及ID
			$d_info = $department->select();
			$this->assign('d_info',$d_info);			
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//创建公告通知处理
		public function do_Addnotice(){
			$notice = M("notice");
			$user   = M("employees");
			$department = M("department");
			$Uid = $_SESSION['UserId'];
			//查出用户所属部门ID和姓名
			$u_info = $user->field("u_department,u_name")->find($Uid);
			
			//查询出所有部门以及ID
			$d_info = $department->select();
			
			$_POST['n_addtime'] = time();
			$_POST['n_rUid'] = $Uid;
			$_POST['n_rname'] = $u_info['u_name'];
			$_POST['n_department'] = $u_info['u_department'];
			$_POST['n_content'] = nl2br($_POST['n_content']);
			
			$notice->create();
			if($notice->add()){
			   $this->Online($Uid);
			   $this->Log($Uid,"发布公告",1);
			   $this->success("公告发布成功",U('notice'));
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"发布公告",0);
			   $this->error("公告发布失败,请重新尝试!!!",U('notice'));
			}		    	
		}
		
		//查看公告通知详细
		public function look_notice(){
			$n_id = $_GET['n_id'];
			$notice = M("notice");
			$n_info = $notice->find($n_id);
			$this->assign("n_info",$n_info);
			$this->Online($_SESSION['UserId']);
			$this->display();			
		}
		
		//已发布公告查看
		public function history_notice(){
		    $Uid = $_SESSION['UserId'];
			//查出用户所属部门ID
			$user   = M("employees");			
			$u_info = $user->field("u_department")->find($Uid);
			
			$notice = M("notice");
			$department = M("department");
			
			//分页处理部分
			import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			$count = $notice->where("n_rUid = {$Uid}")->count();
			$page = new Page($count,10);
			
			//查询出本部门所发公告或者所有员工接收的公告(排除自身所发公告)
			$n_info = $notice->where("n_rUid = {$Uid}")->select();
			
			//通过内部循环将部门ID换成部门名称
			for($i=0;$i<count($n_info);$i++){
				$d_info = $department->where("d_id = {$n_info[$i]['n_department']}")->select();
				$n_info[$i]['n_department'] = $d_info[0]['d_name'];
			} 
			$this->assign("n_info",$n_info);
			$this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			$this->display();
		}
		
		//修改已发布公告页面
		public function edit_notice(){
		    $n_id = $_GET['n_id'];
			$notice = M("notice");
			$n_info = $notice->find($n_id);	
			$this->assign("n_info",$n_info);
			$this->Online($_SESSION['UserId']);
			$this->display();
		}
		
		//修改公告处理
		public function doEdit_notice(){
			$n_id = $_POST['n_id'];
			
		    $data['n_title'] = $_POST['n_title'];
			$data['n_target'] = $_POST['n_target'];
			$data['n_content'] = $_POST['n_content'];
			
			$notice = M("notice");
			if($notice->where("n_id = {$n_id}")->save($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"修改公告",1);
			     $this->success("公告修改成功",U("Notice/history_notice")); 	
			}else{
				 $this->Online($Uid);
			     $this->Log($Uid,"修改公告",0);
				 $this->error("公告修改失败,请重新尝试",U('notice'));
			}
		}
		
		//单条删除记录处理
		public function del_notice(){
		    $n_id = $_GET['n_id'];
			$notice = M('notice');
			if($notice->where("n_id = {$n_id}")->delete()){
			   $this->Online($Uid);
			   $this->Log($Uid,"删除公告",1);
			   $this->success("删除成功",U("Notice/history_notice"),3);	
			}else{
			  $this->Online($Uid);
			   $this->Log($Uid,"删除公告",0);
			   $this->error("对不起,删除失败!!!",U('notice'));
			}				
		}
		
		
		//批量删除记录处理
		public function batch_del_notice(){			
		    $arr = $_POST['check_is'];
			$notice = M('notice');
			if(!empty($arr)){
				for($i=0;$i<count($arr);$i++){
					$sql = "delete from oa_notice where n_id = {$arr[$i]}";
					$notice->query($sql);
				}
				$this->Online($Uid);
			    $this->Log($Uid,"删除公告",1);
				$this->success("删除操作已完成",U('notice'));
			}else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除公告",0);
			    $this->error('对不起,请选择要删除的记录',U('notice'));
			}	
		}
  }
?>