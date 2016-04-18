<?php
  class FileCabinetAction extends CommonAction{
	    //默认查看文件柜页面
	    public function fileCabinet(){
			  $Uid = $_SESSION['UserId'];
			  $filecabinet = M("filecabinet");
			  //分页处理
			  import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			  $count = $filecabinet->where("f_uid = {$Uid}")->count();//获取总数
			  $page = new Page($count,10);
			  
			 			  
			  $f_info = $filecabinet->where("f_uid = {$Uid}")->order("f_addtime desc")->limit($page->limit)->select();
			  $this->assign("f_info",$f_info);
			  $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			  $this->Online($_SESSION['UserId']);
		      $this->display();	
 
		}
		
		//放入文件柜页面
	    public function add_fileCabinet(){
			 //查看个人文件柜空间已经是否允许上传
			 $Uid = $_SESSION['UserId'];
			 $space = M("space");
			 $s_info = $space->where("s_uid = {$Uid}")->find();		 
			 //获得已用空间
			 $s_already = ($s_info['s_space'] - $s_info['s_free_space']);
			 //获得总空间
			 $s_info['s_space'] = $s_info['s_space'];
			 $s_info['s_free_space'] = $s_info['s_free_space'];
			 $this->assign("s_already",$s_already);
			 $this->assign("s_info",$s_info);
			 
			 $this->Online($_SESSION['UserId']);
		     $this->display();	
		}
		
		//处理上传文件
		public function fileCabinet_Upload(){
  			 $Uid = $_SESSION['UserId'];
			 
			 //查看个人文件柜空间信息
			 $space = M("space");
			 $s_info = $space->where("s_uid = {$Uid}")->find();		
			 //判断是否允许本用户上传 
             if($s_info['s_upload_is']!=1){
				$this->error("对不起,您的上传权限已被管理员禁用!!!");  
			 }
			 //判断剩余空间
			 if($s_info['s_free_space'] <= 0){
				$this->error("对不起,您的个人文件柜已满！");  
			 }
		  
			 import('ORG.Net.UploadFile'); //加载上传类
			 $upload = new UploadFile();   //实例化上传类节)
			 $upload->savePath =  './Public/Uploads/'.$Uid."/";// 设置附件上传目录
			 if(!$upload->upload()) {// 上传错误提示错误信息
			     $this->error($upload->getErrorMsg());			 
			 }else{// 上传成功 获取上传文件信息
				 $info =  $upload->getUploadFileInfo();
				 //上传成功后将上传信息插入数据库	
				 $filecabinet = M("filecabinet");
				 $data['f_uid'] = $Uid;
				 $data['f_type'] = $info[0]["extension"];
				 $data['f_path'] = str_replace("./Public/","__PUBLIC__/",$info[0]['savepath']);
				 $data['f_filename'] = $info[0]['savename'];
				 $data['f_newname']  = (empty($_POST['filename']))?$info['name']:$_POST['filename'];
				 $data['f_addtime']  = time();
				 $data['f_size']     = floor($info[0]['size']/1024);
				 
				 if($filecabinet->add($data)){
					//更新该用户剩余空间
					$new_already = ($s_info['s_free_space']-$data['f_size']);   					$save['s_free_space'] = $new_already;
					$space->where("s_uid = {$Uid}")->save($save);
					
					$this->Online($Uid);
			        $this->Log($Uid,"文件上传至文件柜",1);				
					$this->success("文件已成功放入文件柜",U("FileCabinet/fileCabinet"));
				 }else{
					$this->Online($Uid);
			        $this->Log($Uid,"文件上传至文件柜",0);	
					$this->error("文件上传失败,请重新尝试"); 
				 }
			 }			 			 
		}
		
		//删除单个文件
		public function del_file(){
		   //获取GET传过来的删除相关信息
		   $f_id = $_GET['f_id'];
		   $f_size = $_GET['f_size'];
		   $f_filename = $_GET['f_filename'];

		   $Uid = $_SESSION['UserId'];
		   $filecabinet = M("filecabinet");
		   
		   if($filecabinet->where("f_id = {$f_id}")->delete()){
			  //删除相应的文件
			  $file = "./Public/Uploads/{$Uid}/".$f_filename;
			  unlink($file);
			  
		      $space = M("space");
			  $free = $space->field("s_free_space,s_space")->where("s_uid = {$Uid}")->find();   
			  //限制不能超越规定的磁盘大小
			  if($free['s_free_space']>$free['s_space']){
				 $data['s_free_space'] =  $free['s_space'];     
			  }else{
			     $new_free = ($free['s_free_space'] + $f_size);
				 $data['s_free_space'] = $new_free;
			  }			  
			  $space->where("s_uid = {$Uid}")->save($data);
			  
			  $this->Online($Uid);
			  $this->Log($Uid,"删除文件柜文件",1);	
			  $this->success("文件已从您的文件柜中删除.");
		   }else{
			  $this->Online($Uid);
			  $this->Log($Uid,"删除文件柜文件",0);
			  $this->error("文件删除失败,请重新尝试");   
		   }
		   
		}
  }
?>