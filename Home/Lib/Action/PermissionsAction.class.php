<?php
  class PermissionsAction extends CommonAction{
	     public $pp;
	     function __construct(){	     	
			   if(!isset($_SESSION['Login'])&&($_SESSION['Login']!=true)){
		           $this->redirect('Login/login');
		       }
			   
			   $Uid = $_SESSION['UserId'];
			   $permissions = M("permissions");
			   
			   //获取到当前用户对OA管理模块的操作权限
			   $pp = $permissions->where("p_column_id = 7 and p_uid = {$Uid}")->find();
			   $p_column_sonName = $pp['p_column_sonName'];
			   $p_column_son = $pp['p_column_son'];  
			   
			   $p_column_son = explode(",",$p_column_son);
			   $p_column_sonName = explode("|",$p_column_sonName);
			   
			   $this->pp = $p_column_son;  
	   	}
	  
	  
	    //用户管理页面
	    public function permissions(){
//			$permissions_info = $this->pp;
//			   if($permissions_info[4]!=1){
//				  $this->error("对不起,您没有对本模块的操作权限");
//			   }
			
			
			//查询出公司OA用户
			$employees = M("employees");
			$e_info = $employees->field("u_id,u_username,u_name")->select();
			$this->assign("e_info",$e_info);
			
		    $this->display();	
		}
		
		//操作权限页面
		public function action_permissions(){
//			$permissions_info = $this->pp;
//			   if($permissions_info[4]!=1){
//				  $this->error("对不起,您没有对本模块的操作权限");
//			   }
			
			
			$uid = $_GET['uid'];
			$this->assign("uid",$uid);
			//获取相应用户的权限信息
			$permissions = M("permissions");
			$p_info = $permissions->where("p_uid = {$uid}")->order("p_column_id asc")->select();
			$this->assign("p_info",$p_info);
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//处理权限操作
		public function do_permissions(){
			$u_id = $_GET['u_id']; //获取要更改的用户的ID
			$column = $_GET['column']; //获取到前台传入的主栏目数组
			$column_son = $_GET['column_son']; //获取到前台传入的主栏目字符
			$column_son = explode("|",$column_son);
			
			$permissions = M("permissions");
			$p_info = $permissions->field("p_column_name,p_column_id")->where("p_uid = {$u_id}")->order("p_column_id asc")->select();
			//写入数据库
			for($i=0;$i<count($column);$i++){
			    $data['p_column_enable'] = $column[$i];
				$data['p_column_son'] = $column_son[$i];
				$p_column_id = ($i+1);
				
				if($permissions->where("p_uid = {$u_id} and p_column_id = {$p_column_id}")->save($data)){
	
					if($p_info[$i]['p_column_id']==$p_column_id){
				   	   $p_column_id = $p_info[$i]['p_column_name'];
					}
				
				   echo "《".$p_column_id."》栏目----已更改.\n\n";	
				}else{
					
					if($p_info[$i]['p_column_id']==$p_column_id){
				   	   $p_column_id = $p_info[$i]['p_column_name'];
					}
					
				   echo "《".$p_column_id."》栏目----未更改.\n\n";	
				}
			}
		}  
		
		//生成权限控制
		public function add_permissions(){
//			$permissions_info = $this->pp;
//			   if($permissions_info[4]!=1){
//				  $this->error("对不起,您没有对本模块的操作权限");
//			   }
			
			
			$Uid = $_SESSION['UserId'];
			$permissions = M("permissions");
			$p_info = $permissions->where("p_uid = {$Uid}")->select();
			$this->assign("xd_enable",C('XD_ENABLE'));
			$this->assign("cd_enable",C('CD_ENABLE'));
			$this->assign("db_enable",C('DB_ENABLE'));
			$this->assign("p_info",$p_info);
			$this->Online($_SESSION['UserId']);
			$this->display();
		}
		//修改权限控制
		public function edit_permissions(){
			$Uid = $_GET['uid'];
			$permissions = M("permissions");
			$p_info = $permissions->where("p_uid = {$Uid}")->order("p_column_id asc")->select();
			$this->assign("p_info",$p_info);
			$this->assign("xd_enable",C('XD_ENABLE'));
			$this->assign("cd_enable",C('CD_ENABLE'));
			$this->assign("db_enable",C('DB_ENABLE'));
			$this->Online($_SESSION['UserId']);
			$this->display();
		}
		
		//生成权限控制处理
		public function do_add_permissions(){
			
			$Uid = $_SESSION['UserId'];
		    $column_son = $_GET['column_son'];
			$column_son = explode("|",$column_son);
			
			$column = $_GET['column'];
			$u_id = $_GET['u_id'];	
			
			$permissions = M("permissions");
			$p_info = $permissions->where("p_uid = {$Uid}")->order("p_column_id asc")->select();

			for($i=0;$i<count($p_info);$i++){
			    $data['p_uid'] = $u_id;
				$data['p_column_name'] = $p_info[$i]['p_column_name'];
				$data['p_column_id'] = 	$p_info[$i]['p_column_id'];
				$data['p_column_enable'] = 	$column[$i];
				$data['p_column_sonName'] = $p_info[$i]['p_column_sonName'];
				$data['p_column_son'] = $column_son[$i];
				
				if($permissions->add($data)){
				   	 echo "《".$data['p_column_name']."》栏目----权限控制生成.\n\n";
				}else{
					 echo "《".$data['p_column_name']."》栏目----权限控制未生成.\n\n";	
				}
			}
		}
		//修改权限控制处理
		public function do_edit_permissions(){

			$Uid = $_SESSION['UserId'];
		    $column_son = $_GET['column_son'];
			$column_son = explode("|",$column_son);

			$column = $_GET['column'];
			$u_id = $_GET['u_id'];

			$permissions = M("permissions");
			$p_info = $permissions->where("p_uid = {$Uid}")->order("p_column_id asc")->select();

			M("permissions")->where("p_uid = {$u_id}")->delete();
			for($i=0;$i<count($p_info);$i++){
			    $data['p_uid'] = $u_id;
				$data['p_column_name'] = $p_info[$i]['p_column_name'];
				$data['p_column_id'] = 	$p_info[$i]['p_column_id'];
				$data['p_column_enable'] = 	$column[$i];
				$data['p_column_sonName'] = $p_info[$i]['p_column_sonName'];
				$data['p_column_son'] = $column_son[$i];

				if($permissions->add($data)){
				   	 echo "《".$data['p_column_name']."》栏目----权限控制已修改.\n\n";
				}else{
					 echo "《".$data['p_column_name']."》栏目----权限控制修改未成功.\n\n";
				}
			}
		}

  }
?>