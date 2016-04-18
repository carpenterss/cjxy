<?php
    class EmployeesInfoAction extends CommonAction{
	    public $pp;
	    function __construct(){	     	
			   if(!isset($_SESSION['Login'])&&($_SESSION['Login']!=true)){
		           $this->redirect('Login/login');
		       }
			   
			   $Uid = $_SESSION['UserId'];
			   $permissions = M("permissions");
			   
			   //获取到当前用户对OA管理模块的操作权限
			   $pp = $permissions->where("p_column_id = 5 and p_uid = {$Uid}")->find();
			   $p_column_sonName = $pp['p_column_sonName'];
			   $p_column_son = $pp['p_column_son'];
			   $p_column_son = explode(",",$p_column_son);
			   $p_column_sonName = explode("|",$p_column_sonName);
			   
			   $this->pp = $p_column_son;  
	   	}
		
		
	      //调取员工资料
		  public function employeesInfo(){
			  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		      }
			  
			  
			  $Uid = $_SESSION['UserId'];
			  $employees = D("Employees");
			  
			  import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			  $count = $employees->relation(true)->where("u_id != {$Uid}")->count();//获取总数
			  $page = new Page($count,10);
			  
			  $e_info = $employees->relation(true)->where("u_id != {$Uid}")->limit($page->limit)->select();
			  $this->assign("e_info",$e_info);
			  $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			  
			  //根据姓名进行员工的模糊查询
			  if(!empty($_GET['action'])&&($_GET['action']=='search_name')){
				  $u_name = $_POST['u_name'];
				  $where['u_name'] = array("like","%{$u_name}%");	
				  $count = $employees->relation(true)->where($where)->count();//获取总数
				  $page = new Page($count,10);		 	  
				  $e_info = $employees->relation(true)->where($where)->limit($page->limit)->select();
				  $this->assign("e_info",$e_info);
				  $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			  }
			  $this->Online($_SESSION['UserId']);
 			  $this->display();  
		  }
		  
		  
		  //禁止或允许员工登陆OA处理
		  public function employees_status(){
			  $u_id = $_GET['u_id'];
			  $action = $_GET['action'];
			  $employees = M("employees");
			  
			  if(!empty($action)&&$action=='no'){
				  $data['u_enable'] = 0;
			  }else{
				  $data['u_enable'] = 1;
			  }
			  
			  if($employees->where("u_id = {$u_id}")->save($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"更新OA登陆状态",1);
				 $this->success("操作成功");  
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"更新OA登陆状态",0);
				 $this->error("对不起,操作失败"); 
			  }
		  }
		  
		  //上传简历页面
		  public function add_employees(){
			  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		      }
			  $this->Online($_SESSION['UserId']);
			  $this->display();  
		  } 
		  
		  //上传简历处理页面
		  public function do_add_Employees(){
			  $Uid = $_SESSION['UserId'];
			  $employees = M("employees");
			  
			  import('ORG.Net.UploadFile');
			  $upload = new UploadFile();// 实例化上传类
			  $upload->savePath =  './Public/Resume/';// 设置附件上传目录
			  if(!$upload->upload()) {// 上传错误提示错误信息
			  		$this->error($upload->getErrorMsg());
			  }else{// 上传成功 获取上传文件信息
		      		$info =  $upload->getUploadFileInfo();
			  }
			  
			  			  
			  $data['u_resume_url'] = $info[0]['savename'];
			  
			  if($employees->where("u_id = {$Uid}")->save($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"上传简历",1);
				 $this->success("简历上传成功");  
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"上传简历",0);
				 $this->error("简历上传失败");  
			  }
		  }
		  
		  //任务分派
		  public function tasks(){
			  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		      }
			  
			  //获取所有部门名称
			  $department = M("department");
			  $d_info = $department->select();
			  $this->assign("d_info",$d_info);
			  $this->Online($_SESSION['UserId']);
			  $this->display();  
		  }
		  
		  //部门->员工 AJAX处理
		  public function tasks_ajax(){
			  $d_id = $_GET['d_id'];
			  $employees = M("employees");
			  $e_info = $employees->where("u_department = {$d_id}")->select();  
			  for($i=0;$i<count($e_info);$i++){
				  echo "<option value='{$e_info[$i]['u_id']}' class='_remove'>{$e_info[$i]['u_name']}</option>";
			  }			  
		  }
		  
		  //下达任务处理
		  public function do_add_tasks(){
			  $Uid = $_SESSION['UserId'];
			  //获取任务下达人的姓名
			  $employees = M("employees");
			  $t_name = $employees->field("u_name")->where("u_id = {$Uid}")->find();
			  $t_name = $t_name['u_name'];
			  
			  //获取表单提交的信息
			  $data['t_uid'] = $_POST['u_id'];
			  $data['t_addtime'] = time();
			  $data['t_content'] = nl2br($_POST['t_content']);
			  $data['t_name'] = $t_name;
			  
			  //插入任务表
			  $tasks = M("tasks");
			  if($tasks->add($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"下达任务",1);
				 $this->success("任务已分配"); 
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"下达任务",0);
				 $this->success("对不起,任务分配失败,请从新尝试");  
			  }
		  } 
		  
		  //任务管理页面
		  public function tasks_list(){
			  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		      }
			  
			  $Uid = $_SESSION['UserId'];
			  //获取任务下达人的姓名
			  $employees = M("employees");
			  $t_name = $employees->field("u_name")->where("u_id = {$Uid}")->find();
			  $tasks = D("Tasks");
			  //分页处理
			  import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			  $count = $tasks->relation(true)->where("t_name = '{$t_name['u_name']}'")->count(); //获取总数
			  $page = new Page($count,10);
 
			  $t_info = $tasks->relation(true)->where("t_name = '{$t_name['u_name']}'")->limit($page->limit)->select();
			  
			  $this->assign("t_info",$t_info);
			  $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			  $this->Online($_SESSION['UserId']);
			  $this->display();
		  }
		  
		  //更新任务状态
		  public function tasks_isOK(){
			 $t_id = $_GET['t_id'];
			 $tasks = M("tasks");
			 $data['t_isOK'] = 1;
			 if($tasks->where("t_id = {$t_id}")->save($data)){
				$this->Online($Uid);
			    $this->Log($Uid,"更新任务状态",1);
				$this->success("任务状态已更新为完成"); 
			 }else{
				$this->Online($Uid);
			    $this->Log($Uid,"更新任务状态",0); 
				$this->error("对不起,更新失败,请重新尝试");  
			 }
		  }
		  
		  //删除任务记录
		  public function del_tasks(){
			 $t_id = $_GET['t_id'];
			 $tasks = M("tasks");
			 if($tasks->where("t_id = {$t_id}")->delete()){
				$this->Online($Uid);
			    $this->Log($Uid,"删除任务记录",1);
				$this->success("任务记录已删除");  
			 }else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除任务记录",0);
				$this->error("对不起,记录删除失败"); 
			 }
		  }
		  
		  public function look_tasks(){
			 
			  
			 $Uid = $_SESSION['UserId'];
			 $tasks = M("tasks");
			 $t_info = $tasks->where("t_uid = {$Uid}")->select(); 
			 $this->assign("t_info",$t_info); 
			 $this->Online($_SESSION['UserId']);
			 $this->display();
		  }
		  
		  //发布紧急通知页面
		  public function release_notice(){
			  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		      }
			  $this->Online($_SESSION['UserId']);
			  $this->display();  
		  }
		  
		  //发布紧急通知处理
		  public function do_releaseNotice(){
			  $data['j_title'] = $_POST['j_title'];
			  $data['j_content']  = nl2br($_POST['j_content']);
			  $data['j_starttime'] = strtotime($_POST['j_starttime']);
			  
			  $jinji = M("jinji");
			  if($jinji->add($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"发布紧急通知",1);
				 $this->success("紧急通知发布成功");  
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"发布紧急通知",1);
				 $this->error("对不起,紧急通知发布失败");  
			  }
		  }
		  
		  //用户个人配置
		  public function update_peizhi(){
			  $Uid = $_SESSION['UserId'];
			  $employees = M("employees");
			  $u_window = $employees->field("u_window")->where("u_id = {$Uid}")->find();
			  $this->assign("u_window",$u_window['u_window']);
			  $this->Online($_SESSION['UserId']);
			  $this->display();  
		  }
		  
		  //用户更改密码处理
		  public function do_update_mima(){
			  $Uid = $_SESSION['UserId'];
			  $e_pwd = md5($_POST['e_pwd']);
			  $e_pwd2 = md5($_POST['e_pwd2']);
			  $e_pwd3 = md5($_POST['e_pwd3']);
			  
			  $employees = M("employees");
			  if(!$employees->where("u_password = '{$e_pwd}'")->find()){
				 $this->error("对不起,您的原始密码有误！");  
			  }
			  
			  if($e_pwd2!=$e_pwd3){
				 $this->error("对不起,两次新密码输入的不一致");  
			  }
			  
			  $data['u_password'] = $e_pwd2;
			  if($employees->where("u_id = {$Uid}")->save($data)){
				 $this->Online($Uid);
			     $this->Log($Uid,"更改密码",1);
				 $this->success("密码更新成功");  
			  }else{
				 $this->Online($Uid);
			     $this->Log($Uid,"更改密码",0);
				 $this->error("对不起,密码更新失败"); 
			  }
		  }
		  
		  //个人桌面启动关闭配置处理
		  public function update_window(){
			 $Uid = $_SESSION['UserId'];
			 $data['u_window'] = $_POST['u_window'];
			 
			 $employees = M("employees");
			 if($employees->where("u_id = {$Uid}")->save($data)){
				$this->Online($Uid);
			    $this->Log($Uid,"配置个人桌面",1);
				$this->success("个人桌面配置成功");  
			 }else{
				$this->Online($Uid);
			    $this->Log($Uid,"配置个人桌面",0);
				$this->error("对不起,个人桌面配置失败");  
			 }
		  }
	}
?>