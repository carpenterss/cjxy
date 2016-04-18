<?php
  class AddressBookAction extends CommonAction{
      ///322131
	    public function addressBook(){
			//查询出相应用户的通讯录
			$Uid = $_SESSION['UserId'];
			$this->Online($_SESSION['UserId']);
			$addressBook = M("addressbook");
			$a_info = $addressBook->where("a_uid = {$Uid}")->order("a_pname asc")->select();
			$this->assign("a_info",$a_info);
			
			//根据名字进行查询
			if(!empty($_GET['action'])&&($_GET['action']=='query_name')){
			   $v = $_POST['query_content'];
			   $where['a_uid']  = $Uid;
			   $where['a_name'] = array("like","%{$v}%");
			   $a_info = $addressBook->where($where)->order("a_pname asc")->select();	
			   $this->assign("a_info",$a_info);
			}

		    $this->display();	
		}
		
		//处理AJAX显示联系人信息的效果
		public function do_lookName(){
		    $a_id = $_GET['a_id'];
			$addressBook = M("addressbook");
			$name_info = $addressBook->find($a_id);
			//获取表中的所有字段名称
			$sql = "select COLUMN_NAME from information_schema.COLUMNS where table_name = 'oa_addressbook'";
			$colnum_name = $addressBook->query($sql);
            for($i=0;$i<count($colnum_name);$i++){
				$string .= $name_info[$colnum_name[$i]['COLUMN_NAME']]."|";
			}
			$new_string  = rtrim($string,"|");
			//将数据处理成为一个字符串 传到前台
			echo $new_string;
		}
		
		//添加新的联系人页面
		public function add_addressBook(){
			$this->Online($_SESSION['UserId']);
		    $this->display();	
		}
		
		//添加联系人处理
		public function do_add_addressbook(){
		    $Uid = $_SESSION['UserId'];
			$addressBook = M("addressbook");
			
			//判断重要选项是否为空
			if(empty($_POST['a_name'])||empty($_POST['a_pname'])||empty($_POST['a_phone'])){
			    $this->error("对不起,请正确填写联系人信息");	
			}
			
			$_POST['a_uid'] = $Uid;
			$_POST['a_note'] = nl2br($_POST['a_note']);
			$addressBook->create();
			if($addressBook->add()){
			   $this->Log($Uid,"添加联系人",1);
			   $this->Online($Uid);
			   $this->success("联系人添加成功",U("AddressBook/addressBook"));	
			}else{
			   $this->Log($Uid,"添加联系人",0);
			   $this->Online($Uid);
			   $this->error("联系人添加失败");	 
			} 
		}
		
		//修改联系人信息页面
		public function edit_addressbook(){
			$this->Online($_SESSION['UserId']);
			$a_id = $_GET['a_id'];
			$addressbook = M("addressbook");			
			$a_info = $addressbook->find($a_id);
			$this->assign("a_info",$a_info);						
		    $this->display();	
		}
		
		//修改联系人处理页面
		public function do_edit_addressbook(){
		    $addressbook = M("addressbook");
			$addressbook->create();
			if($addressbook->save()){
			   $this->Online($Uid);
			   $this->Log($Uid,"更新联系人信息",1);
			   $this->success("信息更新成功");	
			}else{
			   $this->Online($Uid);	
			   $this->Log($Uid,"更新联系人信息",0);
			   $this->error("数据更新失败");	
			}		
		}
		
		//删除联系人处理
		public function del_addressbook(){
			$a_id = $_GET['a_id'];
		   	$addressbook = M("addressbook");
			if($addressbook->where("a_id = {$a_id}")->delete()){
			   $this->Online($Uid);
			   $this->Log($Uid,"删除联系人",1);
			   $this->success("联系人删除成功",U("AddressBook/addressbook"));	
			}else{
			   $this->Online($Uid);
			   $this->Log($Uid,"删除联系人",0);
			   $this->error("联系人删除失败");	 
			} 
		}
		
		
		//公司内部电话本
		public function phone_book(){
			$this->Online($_SESSION['UserId']);
			$quickbooks = M("quickbooks");
			$q_info = $quickbooks->select();
			$this->assign("q_info",$q_info);
			$this->display();
		} 
		
		
  }	  
?>