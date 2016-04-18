<?php
  class ProjectAction extends CommonAction{
	    public $pp;
	    function __construct(){	     	
			   if(!isset($_SESSION['Login'])&&($_SESSION['Login']!=true)){
		           $this->redirect('Login/login');
		       }
			   
			   $Uid = $_SESSION['UserId'];
			   $permissions = M("permissions");
			   
			   //获取到当前用户对OA管理模块的操作权限
			   $pp = $permissions->where("p_column_id = 8 and p_uid = {$Uid}")->find();
			   $p_column_sonName = $pp['p_column_sonName'];
			   $p_column_son = $pp['p_column_son'];  
			   
			   $p_column_son = explode(",",$p_column_son);
			   $p_column_sonName = explode("|",$p_column_sonName);
			   echo hello;
			   $this->pp = $p_column_son;  
	   	}
	  
	  
	  //新增项目页面
	  public function add_Project(){
		$permissions_info = $this->pp;
			   if($permissions_info[0]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		}
		//获取公司员工列表
		$employees = M("employees");
		$e_info = $employees->select();  
		$this->assign("e_info",$e_info); 
		$this->Online($_SESSION['UserId']); 
		$this->display();
	  }
	  
	  //新增项目处理
	  public function do_add_project(){
		 $data['p_title'] = $_POST['p_title'];
		 $data['p_starttime'] = strtotime($_POST['p_starttime']);
		 $data['p_endtime'] = strtotime($_POST['p_endtime']);
		 $data['p_employees'] = implode("|",$_POST['employees_arr']);
		 $data['p_manage'] = $_POST['p_manage'];
		 $data['p_audit'] = $_POST['p_audit'];
		 $data['p_content'] = nl2br($_POST['p_content']);
		 
		 $project = M("project");
		 if($project->add($data)){
			$this->Online($_SESSION['UserId']);
			$this->Log($_SESSION['UserId'],"新建项目",1);
			$this->success("项目创建成功",U("Project/project"));  
		 }else{
			$this->Online($_SESSION['UserId']);
		    $this->Log($_SESSION['UserId'],"新建项目",0);
			$this->error("项目创建失败"); 
		 }
	  }
	  
	  //管理项目
	  public function project(){
		  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		}
		  $Uid = $_SESSION['UserId'];
		  
		  $project = M("project");
		  $p_info = $project->select();
		  
		  for($i=0;$i<count($p_info);$i++){
			  $p_manage = explode("|",$p_info[$i]['p_manage']); 
			  $p_info[$i]['p_manage'] = $p_manage[1]; 
		  }
		  $this->assign("p_info",$p_info);
		  $this->Online($_SESSION['UserId']);
		  $this->display();  
	  }
	  
	  //上传文档处理
	  public function do_projectUpload(){
		  $p_id = $_POST['pid'];
		  import('ORG.Net.UploadFile');
		  $upload = new UploadFile();// 实例化上传类
		  $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','doc','xls','wps','et','dps');// 设置附件上传类型
	      $upload->savePath =  './Public/project_doc/';// 设置附件上传目录
		  if(!$upload->upload()) {// 上传错误提示错误信息
		 	echo "<script>alert('对不起,上传失败,请重新尝试!!!');</script>";
	      }else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$project = M('project');
			$data['p_document'] = $info[0]['savename'];
			if($project->where("p_id = {$p_id}")->save($data)){
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"上传项目详细文档",1);
			   echo "<script>alert('文档上传成功!!!');</script>";
			}else{
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"上传项目详细文档",0);
			   echo "<script>alert('对不起,上传失败,请重新尝试!!!');</script>";
			}
		  }
	  }
	  
	  //修改项目信息页面
	  public function edit_project(){
		  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		  }
		  
		  //获取公司员工列表
		  $employees = M("employees");
		  $e_info = $employees->select();  
		  $this->assign("e_info",$e_info);  
		  
		  //获取项目信息
		  $pid = $_GET['pid'];
		  $project = M('project');
		  $p_info = $project->where("p_id = {$pid}")->find();
		  $p_info['p_starttime'] = date("Y-m-d",$p_info['p_starttime']);
		  $p_info['p_endtime'] =  date("Y-m-d",$p_info['p_endtime']);
		  
		  //获取原始值
		  $this->assign("old_employees",$p_info['p_employees']);
		  $this->assign("old_manage",$p_info['p_manage']);
		  $this->assign("old_audit",$p_info['p_audit']);
		  
		  $employees_arr = explode("|",$p_info['p_employees']);
		  //处理项目经理值
		  $p_manage = explode("|",$p_info['p_manage']);
		  $p_info['p_manage'] = $p_manage[1];
		  //处理审核人值
		  $p_audit = explode("|",$p_info['p_audit']);
		  $p_info['p_audit'] = $p_manage[1];
		  
		  $employees_list = "";
		  for($i=0;$i<count($employees_arr);$i++){
			  $e = $employees->where("u_id = {$employees_arr[$i]}")->find();
			  $employees_list .= $e['u_name'].",";
		  }
		  $this->assign("p_info",$p_info);
		  $this->assign("employees_list",$employees_list);
		  $this->Online($_SESSION['UserId']);
		  $this->display();  
	  }
	  
	  //修改项目信息处理
	  public function do_edit_project(){
		 $p_id = $_POST['pid']; 
		  
		 $old_employees = $_POST['p_old_employees'];
		 $old_manage = $_POST['p_old_manage'];
		 $old_audit = $_POST['p_old_audit'];
		 
		 $data['p_title'] = $_POST['p_title'];
		 $data['p_starttime'] = strtotime($_POST['p_starttime']);
		 $data['p_endtime'] = strtotime($_POST['p_endtime']);
		 if(empty($_POST['employees_arr'])){
			$data['p_employees'] = $old_employees; 
		 }else{
			$data['p_employees'] = implode("|",$_POST['employees_arr']); 
		 }
		 if(empty($_POST['p_manage'])){
			$data['p_manage'] = $old_manage; 
		 }else{
			$data['p_manage'] = $_POST['p_manage'];
		 }
		 if(empty($_POST['p_audit'])){
			$data['p_audit'] = $old_audit; 
		 }else{
			$data['p_manage'] = $_POST['p_audit']; 
		 }
		 $data['p_content'] = $_POST['p_content']; 
		 $data['p_progress'] = $_POST['p_progress'];
		
		 
		 $project = M("project");
		 if($project->where("p_id = {$p_id}")->save($data)){
			$this->Online($_SESSION['UserId']);
			$this->Log($_SESSION['UserId'],"更新项目信息",1);
		    $this->success("项目信息更新成功",U("Project/project"));
		 }else{
			$this->Online($_SESSION['UserId']);
			$this->Log($_SESSION['UserId'],"更新项目信息",0);
			$this->error("项目信息更新失败"); 
		 }
	  }
	  
	  //查看项目详细
	  public function look_project(){
		  $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		}
		  
		 //获取公司员工列表
		 $employees = M("employees");
		 $e_info = $employees->select();  
		 $this->assign("e_info",$e_info);   
		  
		 $p_id = $_GET['pid']; 
		 $project = M("project");
		 $p_info = $project->where("p_id = {$p_id}")->find();
		 
		 //处理项目组成员值
		 $employees_arr = explode("|",$p_info['p_employees']);
		 $employees_list = "";
		 for($i=0;$i<count($employees_arr);$i++){
			 $e = $employees->where("u_id = {$employees_arr[$i]}")->find();
			 $employees_list .= $e['u_name'].",";
		 }
		 $this->assign("employees_list",$employees_list);
		 
		 //处理项目经理值
		 $p_manage = explode("|",$p_info['p_manage']);
		 $p_info['p_manage'] = $p_manage[1];
		 
		 //处理审核人值
		 $p_audit = explode("|",$p_info['p_audit']);
		 $p_info['p_audit'] = $p_manage[1];
		 
		 $this->assign("p_info",$p_info);
		 $this->display();  
	  }
	  
	  //项目日志页面
	  public function project_log(){
		 $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		} 
		  
		 $p_id = $_GET['pid'];
		 $this->assign("p_id",$p_id);
		 $project_log = M("projectlog");
		 $l_info = $project_log->where("pl_pid = {$p_id}")->order("pl_time desc")->select();
		 $this->assign("l_info",$l_info);
		 $this->Online($_SESSION['UserId']);
		 $this->display();  
	  }
	  
	  //查看项目日志
	  public function log_look(){
		 $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		} 
		  
		 $pl_id = $_GET['pl_id'];
		 $this->assign("p_id",$_GET['pid']);
		 $project_log = M("projectlog");
		 $l_info = $project_log->where("pl_id = {$pl_id}")->find();
		 $this->assign("l_info",$l_info);
		 $this->Online($_SESSION['UserId']);
		 $this->display();
	  }
	  
	  //修改项目日志
	  public function log_edit(){
		 $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		} 
		  
		 $pl_id = $_GET['pl_id'];
		 $this->assign("p_id",$_GET['pid']);
		 $project_log = M("projectlog");
		 $l_info = $project_log->where("pl_id = {$pl_id}")->find(); 
		 $this->assign("l_info",$l_info);
		 $this->Online($_SESSION['UserId']);
		 $this->display(); 
	  }
	  
	  //修改日志处理
	  public function do_edit_log(){
		 $pl_id = $_POST['pl_id'];
		 
		 $data['pl_content'] = $_POST['pl_content'];  
		 $project_log = M("projectlog");
		 if($project_log->where("pl_id = {$pl_id}")->save($data)){
			$this->Online($_SESSION['UserId']);
			$this->Log($_SESSION['UserId'],"修改项目日志",1);
			$this->success("项目日志修改成功");  
		 }else{
			$this->Online($_SESSION['UserId']);
			$this->Log($_SESSION['UserId'],"修改项目日志",0);
			$this->error("对不起,项目日志修改失败");
		 }
	  } 
	  
	  //删除日志
	  public function log_del(){
		  $pl_id = $_GET['pl_id'];
		  $project_log = M("projectlog");
		  if($project_log->where("pl_id = {$pl_id}")->delete()){
			 $this->Online($_SESSION['UserId']);
			 $this->Log($_SESSION['UserId'],"删除项目日志",1);
			 $this->success("项目日志删除成功");  
		 }else{
			$this->Online($_SESSION['UserId']);
			$this->Log($_SESSION['UserId'],"删除项目日志",0);
			$this->error("对不起,项目日志删除失败");
		 }
	  } 
	  
	  //增加项目日志
	  public function add_projectLog(){
		    $permissions_info = $this->pp;
			   if($permissions_info[1]!=1){
				  $this->error("对不起,您没有对本模块的操作权限"); 
		}
		  
		    $p_id = $_GET['pid'];
			$this->assign("p_id",$p_id);
			$this->Online($_SESSION['UserId']);
			$this->display();
	  }
	  
	  //增加项目日志处理
	  public function do_add_log(){
		    $p_id = $_POST['p_id'];
			$data['pl_pid'] = $p_id;
			$data['pl_time'] = time();
			$data['pl_content'] = $_POST['pl_content'];	
			
			$project_log = M("projectlog");
			if($project_log->add($data)){
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"新增项目日志",1);
			   $this->success("项目日志增加成功");	
			}else{
			   $this->Online($_SESSION['UserId']);
			   $this->Log($_SESSION['UserId'],"新增项目日志",0);
			   $this->error("对不起,项目日志增加失败");	
			}
	  }
	  
	  //删除项目
	  public function project_del(){
		   $p_id = $_GET['pid'];
		   $project = M("project");
		   $project_log = M("projectlog");
		   if($project->where("p_id = {$p_id}")->delete()){
			  if($project_log->where("pl_pid = {$p_id}")->delete()){
				 $this->Online($_SESSION['UserId']);
			     $this->Log($_SESSION['UserId'],"删除项目",1);
				 $this->success("项目删除成功");  
			  }
		   }else{
			  $this->Online($_SESSION['UserId']);
			  $this->Log($_SESSION['UserId'],"删除项目",0);
			  $this->error("对不起,项目删除失败"); 
		   }
	  }
  }
?>