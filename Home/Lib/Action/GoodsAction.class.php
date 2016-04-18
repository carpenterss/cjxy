<?php
  class GoodsAction extends CommonAction{
		//物品管理
		public function goods(){
		       $goods = M("goods");
			   
			   import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			   $count = $goods->count();//获取总数
			   $page = new Page($count,10);
			   
			   
			   $g_info = $goods->limit($page->limit)->select();
			   $this->assign("g_info",$g_info);
			   $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			   $this->Online($_SESSION['UserId']);
		       $this->display(); 
		}  
		
		//更新物品信息页面
		public function update_goods(){
		       $g_id = $_GET['g_id'];
			   $goods = M("goods");
			   
			   $g_info = $goods->where("g_id={$g_id}")->find();
			   $this->assign("g_info",$g_info);
			   $this->Online($_SESSION['UserId']);
		       $this->display(); 
		}
		
		//更新物品信息处理
		public function do_update_goods(){
		       $g_id = $_POST['g_id'];
			   $goods = M("goods");
			   
			   $data['g_name'] = $_POST['g_name'];
			   $data['g_jiage'] = $_POST['g_jiage'];
			   $data['g_sum'] = $_POST['g_sum'];
			   
			   if($goods->where("g_id = {$g_id}")->save($data)){
				  $this->Online($Uid);
			      $this->Log($Uid,"更新物品信息",1);
			      $this->success("物品信息更新成功",U("Goods/goods"));
			   }else{
				  $this->Online($Uid);
			      $this->Log($Uid,"更新物品信息",0);
			      $this->error("对不起,物品信息更新失败");
			   }
		}
		
		//删除物品信息处理
		public function delete_goods(){
		       $g_id = $_GET['g_id'];
			   $goods = M("goods");
			   
			   if($goods->where("g_id={$g_id}")->delete()){
				  $this->Online($Uid);
			      $this->Log($Uid,"删除物品信息",1);
			      $this->success("物品信息删除成功");
			   }else{
				  $this->Online($Uid);
			      $this->Log($Uid,"删除物品信息",0);
			      $this->success("对不起,物品信息删除失败");  
			   }
		}
		
		//物品入库
		public function add_goods(){
			  $this->Online($_SESSION['UserId']);
		      $this->display();
		}
		
		//物品入库处理
		public function do_add_goods(){
		     $goods = M("goods");
			 
			 $data['g_name'] = $_POST['g_name'];
			 $data['g_jiage'] = $_POST['g_jiage'];
			 $data['g_sum'] = $_POST['g_sum'];
			 
			 if($goods->add($data)){
				$this->Online($Uid);
			    $this->Log($Uid,"录入物品",1);
			    $this->success("物品录入成功");
			 }else{
				$this->Online($Uid);
			    $this->Log($Uid,"录入物品",0);
			    $this->error("对不起,物品录入失败");
			 }
		}
		
		//物品领取页面
		public function get_goods(){
		 	 $goods = M("goods");
			 $g_info = $goods->select();
			 $this->assign("g_info",$g_info);
			 
			 $employees = M("employees");
			 $e_info = $employees->field("u_id,u_name")->select();
			 $this->assign("e_info",$e_info);
			 $this->Online($_SESSION['UserId']);
		     $this->display();
		}
		
		//物品领取处理页面
		public function do_get_goods(){
		     $goodsmanage = M("goodsmanage");
			 $goods = M("goods");
			 
			 $gm_goods = explode("|",$_POST['gm_goods']);
			 $data['gm_gid'] = $gm_goods[0];
			 $data['gm_gname'] = $gm_goods[1];
			 
			 $gm_user = explode("|",$_POST['gm_u']);
			 $data['gm_uid'] = $gm_user[0];
			 $data['gm_uname'] = $gm_user[1];
			 $data['gm_gtime'] = time();
			 $data['gm_gsum']  = $_POST['gm_gsum'];
			 $data['gm_givename'] = $_POST['gm_givename'];
			 
			 $goods_info = $goods->where("g_id = {$data['gm_gid']}")->find();
				  if($goods_info['g_sum']<0){
				     $this->error("对不起,该物品已没有库存");
				  }
				  
			 if($goodsmanage->add($data)){
				  $this->Online($Uid);
			      $this->Log($Uid,"物品领取记录",1);	
				  $this->success("物品领取录入成功");		     
				  $goods->query("update oa_goods set g_sum=g_sum-{$data['gm_gsum']} where g_id = {$data['gm_gid']}");
			 }else{
				$this->Online($Uid);
			    $this->Log($Uid,"物品领取记录",0);
			    $this->error("对不起,物品领取录入失败");
			 }
		}
		
		//物品领取记录
		public function get_goods_manage(){
		     $goodsmanage = M("goodsmanage");
			 
			 import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
			 $count = $goodsmanage->count();//获取总数
			 $page = new Page($count,10);
			   
			 $g_info = $goodsmanage->limit($page->limit)->select();
			 $this->assign("g_info",$g_info);
			 $this->assign("fpage",$page->fpage(1,4,5,6,0,3));
			 $this->Online($_SESSION['UserId']);
		     $this->display();
		}
		
		//删除物品领取记录
		public function delete_get_goods(){
		     $goodsmanage = M("goodsmanage");
			 
			 $gm_id = $_GET['gm_id'];
			 if($goodsmanage->where("gm_id={$gm_id}")->delete()){
				$this->Online($Uid);
			    $this->Log($Uid,"删除物品领取记录",1);
			    $this->success("领取记录删除成功");
			 }else{
				$this->Online($Uid);
			    $this->Log($Uid,"删除物品领取记录",0);
			    $this->error("对不起,领取记录删除失败");
			 }
		}
		
		//公司规章制度页面
		public function regime(){
		     $this->Online($_SESSION['UserId']);
		     $this->display();
		}
		
		
  } 
?>