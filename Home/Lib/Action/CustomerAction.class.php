<?php

class CustomerAction extends CommonAction
{
    public $pp;
    public $shqx;
    public $dbrjson;

    function __construct()
    {
        if (!isset($_SESSION['Login']) && ($_SESSION['Login'] != true)) {
            $this->redirect('Login/login');
        }

        $Uid = $_SESSION['UserId'];
        $permissions = M("permissions");

        //获取到当前用户对OA管理模块的操作权限
        $pp = $permissions->where("p_column_id = 2 and p_uid = {$Uid}")->find();
        $p_column_sonName = $pp['p_column_sonName'];
        $p_column_son = $pp['p_column_son'];

        $p_column_son = explode(",", $p_column_son);
        $p_column_sonName = explode("|", $p_column_sonName);

        $this->pp = $p_column_son;
    }

    //管理客户页面
    public function customer()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[3] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $this->Online($_SESSION['UserId']);
            $x_p_customer = M("x_p_customer");
            $x_e_customer = M("x_e_customer");
            $c_info_x_p_customer = $x_p_customer->where("x_p_del = 0")->order("x_p_updatetime desc")->select();
            $c_info_x_e_customer = $x_e_customer->where("x_e_del = 0")->order("x_e_updatetime desc")->select();
            $x_p_data = array();
            $x_e_data = array();
            for ($i = 0; $i < count($c_info_x_p_customer); $i++) {
                $x_p_business = M('xdbusiness')->where("x_id = 1{$c_info_x_p_customer[$i]['id']} and x_del = 0 AND x_status = 1")->order("x_updatetime desc")->select();
                if (count($x_p_business) == 0) {
//                    $x_p_data[] = array(
//                        'xm' => $c_info_x_p_customer[$i]['x_p_name'],
//                        'lxfs' => $c_info_x_p_customer[$i]['x_p_lxfs'],
//                        'c_id' => $c_info_x_p_customer[$i]['id'],
//                        'zjkm' => 0,
//                        'zjkmbz' => "",
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($x_p_business); $j++) {
                        $x_p_data[] = array(
                            'b_id' => $x_p_business[$j]['Id'],
                            'c_id' => $c_info_x_p_customer[$i]['id'],
                            'xm' => $c_info_x_p_customer[$i]['x_p_name'],
                            'lxfs' => $c_info_x_p_customer[$i]['x_p_lxfs'],
                            'zjkm' => $x_p_business[$j]['x_zjkm'],
                            'zjkmbz' => $x_p_business[$j]['x_zjkmbz'],
                        );
                    }
                }
            }
            for ($i = 0; $i < count($c_info_x_e_customer); $i++) {
                $x_e_business = M('xdbusiness')->where("x_id = 2{$c_info_x_e_customer[$i]['id']} and x_del = 0 AND x_status = 1")->order("x_updatetime desc")->select();
                if (count($x_e_business) == 0) {
//                    $x_e_data[] = array(
//                        'xm' => $c_info_x_e_customer[$i]['x_e_name'],
//                        'lxfs' => $c_info_x_e_customer[$i]['x_e_frlxfs'],
//                        'c_id' => $c_info_x_e_customer[$i]['id'],
//                        'zjkm' => 0,
//                        'zjkmbz' => "",
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($x_e_business); $j++) {
                        $x_e_data[] = array(
                            'b_id' => $x_e_business[$j]['Id'],
                            'c_id' => $c_info_x_e_customer[$i]['id'],
                            'xm' => $c_info_x_e_customer[$i]['x_e_name'],
                            'lxfs' => $c_info_x_e_customer[$i]['x_e_frlxfs'],
                            'zjkm' => $x_e_business[$j]['x_zjkm'],
                            'zjkmbz' => $x_e_business[$j]['x_zjkmbz'],
                        );
                    }
                }
            }
            $this->assign("c_info_x_p_customer", $x_p_data);
            $this->assign("c_info_x_e_customer", $x_e_data);
            $this->display();
        } else {
            $this->Online($_SESSION['UserId']);
            $x_p_customer = M("x_p_customer");
            $x_e_customer = M("x_e_customer");
            $c_info_x_p_customer = $x_p_customer->where("c_uid = {$Uid} AND x_p_del = 0")->order("x_p_updatetime desc")->select();
            $c_info_x_e_customer = $x_e_customer->where("c_uid = {$Uid} AND x_e_del = 0")->order("x_e_updatetime desc")->select();
            $x_p_data = array();
            $x_e_data = array();
            for ($i = 0; $i < count($c_info_x_p_customer); $i++) {
                $x_p_business = M('xdbusiness')->where("x_id = 1{$c_info_x_p_customer[$i]['id']} and x_del = 0 AND x_status = 1")->order("x_updatetime desc")->select();
                if (count($x_p_business) == 0) {
//                    $x_p_data[] = array(
//                        'xm' => $c_info_x_p_customer[$i]['x_p_name'],
//                        'lxfs' => $c_info_x_p_customer[$i]['x_p_lxfs'],
//                        'c_id' => $c_info_x_p_customer[$i]['id'],
//                        'zjkm' => $x_p_business[$i]['x_zjkm'],
//                        'zjkmbz' => $x_p_business[$i]['x_zjkmbz'],
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($x_p_business); $j++) {
                        $x_p_data[] = array(
                            'b_id' => $x_p_business[$j]['Id'],
                            'c_id' => $c_info_x_p_customer[$i]['id'],
                            'xm' => $c_info_x_p_customer[$i]['x_p_name'],
                            'lxfs' => $c_info_x_p_customer[$i]['x_p_lxfs'],
                            'zjkmbz' => $x_p_business[$i]['x_zjkmbz'],
                            'zjkm' => $x_p_business[$i]['x_zjkm'],

                        );
                    }
                }
            }
            for ($i = 0; $i < count($c_info_x_e_customer); $i++) {
                $x_e_business = M('xdbusiness')->where("x_id = 2{$c_info_x_e_customer[$i]['id']} and x_del = 0 AND x_status = 1")->order("x_updatetime desc")->select();
                if (count($x_e_business) == 0) {
//                    $x_e_data[] = array(
//                        'xm' => $c_info_x_e_customer[$i]['x_e_name'],
//                        'lxfs' => $c_info_x_e_customer[$i]['x_e_frlxfs'],
//                        'c_id' => $c_info_x_e_customer[$i]['id'],
//                        'zjkm' => $x_e_business[$i]['x_zjkm'],
//                        'zjkmbz' => $x_e_business[$i]['x_zjkmbz'],
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($x_e_business); $j++) {
                        $x_e_data[] = array(
                            'b_id' => $x_e_business[$j]['Id'],
                            'c_id' => $c_info_x_e_customer[$i]['id'],
                            'xm' => $c_info_x_e_customer[$i]['x_e_name'],
                            'lxfs' => $c_info_x_e_customer[$i]['x_e_frlxfs'],
                            'zjkm' => $x_e_business[$i]['x_zjkm'],
                            'zjkmbz' => $x_e_business[$i]['x_zjkmbz'],
                        );
                    }
                }
            }
            $this->assign("c_info_x_p_customer", $x_p_data);
            $this->assign("c_info_x_e_customer", $x_e_data);
            $this->display();
        }
    }

    //新建客户页面
    public function customer_x_p_add()
    {
        if ($_SESSION['dbrjson'] != "") {
            $_SESSION['dbrjson'] = "";
        }
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function x_e_customer_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    //新建客户处理页面
    public function do_customer_x_p_add()
    {
        //获取当前操作员的id
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));

        $data = array(
            'c_uid' => $Uid,
            'x_p_name' => $_POST['x_p_name'],
            'x_p_idcard' => $_POST['x_p_idcard'],
            'x_p_sex' => $_POST['x_p_sex'],
            'x_p_mz' => $_POST['x_p_mz'],
            'x_p_jkzk' => $_POST['x_p_jkzk'],
            'x_p_gzdw' => $_POST['x_p_gzdw'],
            'x_p_zw' => $_POST['x_p_zw'],
            'x_p_hkzz' => $_POST['x_p_hkzz'],
            'x_p_sfzzz' => $_POST['x_p_sfzzz'],
            'x_p_sjzz' => $_POST['x_p_sjzz'],
            'x_p_lxfs' => $_POST['x_p_lxfs'],
            'x_p_hyzk' => $_POST['x_p_hyzk'],
            'x_p_poxm' => $_POST['x_p_poxm'],
            'x_p_posfzh' => $_POST['x_p_posfzh'],
            'x_p_polxfs' => $_POST['x_p_polxfs'],
            'x_p_posr' => $_POST['x_p_posr'],
            'x_p_pogzqk' => $_POST['x_p_pogzqk'],
            'x_p_pozw' => $_POST['x_p_pozw'],
            'x_p_jtzhnsr' => $_POST['x_p_jtzhnsr'],
            'x_p_yhck' => $_POST['x_p_yhck'],
            'x_p_fwxx' => json_encode($_POST['x_p_fwxx']),
            'x_p_clxhjz' => json_encode($_POST['x_p_clxhjz']),
            'x_p_gxr' => json_encode($_POST['gxr']),
            'x_p_jtqtsr' => $_POST['x_p_jtqtsr'],
            'x_p_jtqtsrbz' => $_POST['x_p_jtqtsrbz'],
            'x_p_xyked' => $_POST['x_p_xyked'],
            'x_p_xykfz' => $_POST['x_p_xykfz'],
            'x_p_yhajdk' => $_POST['x_p_yhajdk'],
            'x_p_mjjd' => $_POST['x_p_mjjd'],
            'x_p_dwdbqk' => $_POST['x_p_dwdbqk'],
            'x_p_dbrxm' => $_POST['x_p_dbrxm'],
            'x_p_dbrsfzh' => $_POST['x_p_dbrsfzh'],
            'x_p_dbrinfo' => $_SESSION['dbrjson'],
            'x_p_fwdzjz' => $_SESSION['x_p_fwdzjz'],
            'x_p_kc' => $_POST['x_p_kc'],
            'x_p_yywj' => json_encode($_POST['x_p_yywj']),
            'x_p_hkdj' => 0,
            'x_p_time' => time(),
            'x_p_updatetime' => time(),
            'x_p_type' => '2',
        );
        $map['x_p_idcard'] = $_POST['x_p_idcard'];
        if (M('x_p_customer')->where($map)->select() != "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '客户信息已存在'), 'json');
        } else if (M('x_p_customer')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
//
//		  if($c_id = $customer->add($data)){
//			  $data2['m_cid'] = $c_id;
//			  if($customerMore->add($data2)){
//				 $this->Online($Uid);
//			     $this->Log($Uid,"添加客户",1);
//				 $this->success("客户添加成功");
//			  }
//		  }else{
//			  $this->Online($Uid);
//			  $this->Log($Uid,"添加客户",0);
//			  $this->error("客户添加失败");
//		  }
    }

    public function do_customer_x_e_add()
    {
        //获取当前操作员的id
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');

        $data = array(
            'c_uid' => $Uid,
            'x_e_name' => $_POST['x_e_name'],
            'x_e_yyzzh' => $_POST['x_e_yyzzh'],
            'x_e_sudjzh' => $_POST['x_e_sudjzh'],
            'x_e_zzjgdmzh' => $_POST['x_e_zzjgdmzh'],
            'x_e_frxm' => $_POST['x_e_frxm'],
            'x_e_jycsszd' => $_POST['x_e_jycsszd'],
            'x_e_frpoxm' => $_POST['x_e_frpoxm'],
            'x_e_frsfzh' => $_POST['x_e_frsfzh'],
            'x_e_frhjzz' => $_POST['x_e_frhjzz'],
            'x_e_frsjzz' => $_POST['x_e_frsjzz'],
            'x_e_frlxfs' => $_POST['x_e_frlxfs'],
            'x_e_frposfzh' => $_POST['x_e_frposfzh'],
            'x_e_frpohjzz' => $_POST['x_e_frpohjzz'],
            'x_e_frpolxfs' => $_POST['x_e_frpolxfs'],
            'x_e_sfypo' => $_POST['x_e_sfypo'],
            'x_e_gdxx' => json_encode($_POST['x_e_gdxx']),
            'x_e_fwxx' => json_encode($_POST['x_e_fwxx']),
            'x_e_clxx' => json_encode($_POST['x_e_clxx']),
            'x_e_dkkh' => $_POST['x_e_dkkh'],
            'x_e_khxkzh' => $_POST['x_e_khxkzh'],
            'x_e_jgxydmzh' => $_POST['x_e_jgxydmzh'],
            'x_e_aqscxkzmc' => $_POST['x_e_aqscxkzmc'],
            'x_e_aqxkzhm' => $_POST['x_e_aqxkzhm'],
            'x_e_pwxkzmc' => $_POST['x_e_pwxkzmc'],
            'x_e_kc' => $_POST['x_e_kc'],
            'x_e_ht' => json_encode($_POST['x_e_ht']),
            'x_e_pwxkzhm' => $_POST['x_e_pwxkzhm'],
            'x_e_qyjbhyhls' => json_encode($_POST['x_e_qyjbhyhls']),
            'x_e_gxht' => json_encode($_POST['x_e_gxht']),
            'x_e_bb' => json_encode($_POST['x_e_bb']),
            'x_e_yywj' => json_encode($_POST['x_e_yywj']),
            'x_e_fczhm' => $_POST['x_e_fczhm'],
            'x_e_tdsyzhm' => $_POST['x_e_tdsyzhm'],
            'x_e_qysnzsr' => $_POST['x_e_qysnzsr'],
            'x_e_zczgm' => $_POST['x_e_zczgm'],
            'x_e_qtsrbz' => $_POST['x_e_qtsrbz'],
            'x_e_yhfzye' => $_POST['x_e_yhfzye'],
            'x_e_mjjdye' => $_POST['x_e_mjjdye'],
            'x_e_dwdbed' => $_POST['x_e_dwdbed'],
            'x_e_hkdj' => 0,
            'x_e_time' => time(),
            'x_e_updatetime' => time(),
            'x_e_type' => '2',

        );
        $map['x_e_name'] = $_POST['x_e_name'];
        if (M('x_e_customer')->where($map)->select() != "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '公司已存在'), 'json');
        } else if (M('x_e_customer')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
//
//		  if($c_id = $customer->add($data)){
//			  $data2['m_cid'] = $c_id;
//			  if($customerMore->add($data2)){do_x_e_customer_add
//				 $this->Online($Uid);
//			     $this->Log($Uid,"添加客户",1);
//				 $this->success("客户添加成功");
//			  }
//		  }else{
//			  $this->Online($Uid);
//			  $this->Log($Uid,"添加客户",0);
//			  $this->error("客户添加失败");
//		  }
    }

    //查看/修改个人客户详细信息
    public function customer_x_p_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->assign('enter',I('enter'));
        $id = I('id');
        //查询出客户的详细信息
        $x_p_customer = M("x_p_customer");
        $sql = "select * from oa_x_p_customer as c where  c.id = {$id}";
        $c_info = $x_p_customer->query($sql);
        $this->assign("c_info", $c_info);
        $s_yywj = $x_p_customer->query("select x_p_yywj from oa_x_p_customer where id = {$id}")[0]['x_p_yywj'];
        $s_fwxx = $x_p_customer->query("select x_p_fwxx from oa_x_p_customer where id = {$id}")[0]['x_p_fwxx'];
        $s_clxx = $x_p_customer->query("select x_p_clxhjz from oa_x_p_customer where id = {$id}")[0]['x_p_clxhjz'];
        $s_gxr = $x_p_customer->query("select x_p_gxr from oa_x_p_customer where id = {$id}")[0]['x_p_gxr'];
        $s_yywj = json_decode($s_yywj);
        $s_fwxx = json_decode($s_fwxx, true);
        $s_clxx = json_decode($s_clxx, true);
        $s_gxr = json_decode($s_gxr, true);
        $this->assign("yywj", $s_yywj);
        $this->assign("qpinfo", $s_fwxx);
        $this->assign("clxx", $s_clxx);
        $this->assign("gxrinfo", $s_gxr);

        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //查看修改企业客户详细信息
    public function customer_x_e_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->assign('enter',I('enter'));
        $id = I('id');

        //查询出客户的详细信息
        $x_p_customer = M("x_e_customer");
        $sql = "select * from oa_x_e_customer as c where  c.id = {$id}";
        $c_info = $x_p_customer->query($sql);
        $this->assign("c_info", $c_info);
        $gdxx = M('x_e_customer')->query("select x_e_gdxx from oa_x_e_customer where id = {$id}")[0]['x_e_gdxx'];
        $this->assign("gdxx", json_decode($gdxx));

        //查询出客户相关图片的地址
        $s_qyjbhyhls = $x_p_customer->query("select x_e_qyjbhyhls from oa_x_e_customer where id = {$id}")[0]['x_e_qyjbhyhls'];
        $s_qyjbhyhls = json_decode($s_qyjbhyhls);
        $s_gxht = $x_p_customer->query("select x_e_gxht from oa_x_e_customer where id = {$id}")[0]['x_e_gxht'];
        $s_gxht = json_decode($s_gxht);
        $s_bb = $x_p_customer->query("select x_e_bb from oa_x_e_customer where id = {$id}")[0]['x_e_bb'];
        $s_bb = json_decode($s_bb);
        $s_ht = $x_p_customer->query("select x_e_ht from oa_x_e_customer where id = {$id}")[0]['x_e_ht'];
        $s_ht = json_decode($s_ht);
        $s_yywj = $x_p_customer->query("select x_e_yywj from oa_x_e_customer where id = {$id}")[0]['x_e_yywj'];
        $s_yywj = json_decode($s_yywj);
        $s_gdxx = $x_p_customer->query("select x_e_gdxx from oa_x_e_customer where id = {$id}")[0]['x_e_gdxx'];
        $s_gdxx = json_decode($s_gdxx);
        $s_fwxx = $x_p_customer->query("select x_e_fwxx from oa_x_e_customer where id = {$id}")[0]['x_e_fwxx'];
        $s_fwxx = json_decode($s_fwxx,true);
        $s_clxx = $x_p_customer->query("select x_e_clxx from oa_x_e_customer where id = {$id}")[0]['x_e_clxx'];
        $s_clxx = json_decode($s_clxx,true);


        $this->assign("x_e_gdrs", count(json_decode($c_info[0]['x_e_gdxm'])));
        $this->assign("x_e_gdxm", json_decode($c_info[0]['x_e_gdxm']));
        $this->assign("x_e_gdxx", $s_gdxx);
        $this->assign("fwxx", $s_fwxx);
        $this->assign("clxx", $s_clxx);
        $this->assign("ht", $s_ht);
        $this->assign("qyjbhyhls", $s_qyjbhyhls);
        $this->assign("gxht", $s_gxht);
        $this->assign("bb", $s_bb);
        $this->assign("yywj", $s_yywj);

        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //业务流程
    public function customer_xdyw()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $this->display();
    }

    public function do_xdyw()
    {

        //获取当前操作员的id
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));

        //获取客户的id
        $type = I('x_khlx');
        $customername = I('x_name');
        $customersfzh = I('x_cardid');
        $x_p_map['x_p_name'] = $customername;
        $x_p_map['x_p_cardid'] = "'".$customersfzh."'";
        $x_e_map['x_e_name'] = $customername;
        $x_e_map['x_e_zzjgdmzh'] = $customersfzh;
        if ($type == 1 && M('x_p_customer')->where("x_p_name = '{$customername}' and x_p_idcard = '{$customersfzh}'")->select()[0]['id'] != null) {//个人且存在记录
            $id = "1" . M('x_p_customer')->where("x_p_name = '{$customername}' and x_p_idcard = '{$customersfzh}'")->select()[0]['id'];
        } else if ($type == 2 && M('x_e_customer')->where($x_e_map)->select()[0]['id'] != null) {
            $id = "2" . M('x_e_customer')->where($x_e_map)->select()[0]['id'];
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '该客户尚未有客户基本信息'), 'json');
        }
        $data = array(
            'c_uid' => $Uid,
            'x_id' => $id,
            'x_dkje' => $_POST['x_dkje'],
            'x_yt' => $_POST['x_yt'],
            'x_hkfs' => $_POST['x_hkfs'],
            'x_lv' => $_POST['x_lv'],
            'x_hkly' => $_POST['x_hkly'],
            'x_dbfs' => $_POST['x_dbfs'],
            'x_dy' => $_POST['x_dy'],
            'x_hkzh' => $_POST['x_hkzh'],
            'x_dkqsrq' => $_POST['x_dkqsrq'],
            'x_dkjsrq' => $_POST['x_dkjsrq'],
            'x_ht' => json_encode($_POST['x_ht']),
            'x_kcht' => json_encode($_POST['x_kcht']),
            'x_kc' => $_POST['x_kc'],
            'x_dkffr' => $_POST['x_dkffr'],
            'x_fkje' => $_POST['x_fkje'],
            'x_fkfs' => $_POST['x_fkfs'],
//            'x_hkdj' => $_POST['x_hkdj'],
            'x_dkdqr' => $_POST['x_dkdqr'],
            'x_zjkm' => $_POST['x_zjkm'],
            'x_zjkmbz' => $_POST['x_zjkmbz'],
            'uniquetag' => $_POST['uniquetag'],
            'x_updatetime' => time(),
            'x_time' => time(),
            'x_hkdj' => 0,
            'x_status' => '0'
        );
        $map['x_id'] = $id;
        if (M('xdbusiness')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }


    }

    //更改业务信息资料
    public function ywlc_update()
    {
        $permissions_info = $this->pp;

        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if($department) {
            $shqx = 1;
        }else{
            $shqx = 0;
        }
        $this->assign('sh', $shqx);
        $id = $_GET['id'];

        //查询出客户基础信息
        if (substr($id, 0, 1) == 1) {
            $baseinfo = M("x_p_customer");
            $u_id = substr($id, 1, strlen($id) - 1);
            $b_info = $baseinfo->query("select * from oa_x_p_customer where id = {$u_id}");
            $this->assign("x_name", $b_info[0]['x_p_name']);
            $this->assign("x_sfz", $b_info[0]['x_p_idcard']);
        } else if (substr($id, 0, 1) == 2) {
            $baseinfo = M("x_e_customer");
            $u_id = substr($id, 1, strlen($id) - 1);
            $b_info = $baseinfo->query("select * from oa_x_e_customer where id = {$u_id}");
            $this->assign("x_name", $b_info[0]['x_e_name']);
            $this->assign("x_sfz", $b_info[0]['x_e_zzjgdmzh']);
        }
        //查询出客户的业务信息
        $customer = M("xdbusiness");
        $sql = "select * from oa_xdbusiness as c where  c.x_id = {$id}";
        $c_info = $customer->query($sql);
        $this->assign('x_id', $id);
        $this->assign("c_info", $c_info);

        //查询出客户相关图片的地址
        $s_ht = json_decode($c_info[0]['x_ht']);
        $s_kcht = json_decode($c_info[0]['x_kcht']);
        $this->assign('kcht', $s_kcht);
        $this->assign("ht", $s_ht);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }
    //更改业务信息资料
    public function ywlc_update_by_b_id()
    {
        $permissions_info = $this->pp;

        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if($department) {
            $shqx = 1;
        }else{
            $shqx = 0;
        }
        $this->assign('sh', $shqx);
        $this->assign('enter',I('enter'));
        $id = $_GET['id'];
//        var_dump($id);
        //查询出客户基础信息
//        if (substr($id, 0, 1) == 1) {
//            $baseinfo = M("x_p_customer");
//            $u_id = substr($id, 1, strlen($id) - 1);
//            $b_info = $baseinfo->query("select * from oa_x_p_customer where id = {$u_id}");
//            $this->assign("x_name", $b_info[0]['x_p_name']);
//            $this->assign("x_sfz", $b_info[0]['x_p_idcard']);
//        } else if (substr($id, 0, 1) == 2) {
//            $baseinfo = M("x_e_customer");
//            $u_id = substr($id, 1, strlen($id) - 1);
//            $b_info = $baseinfo->query("select * from oa_x_e_customer where id = {$u_id}");
//            $this->assign("x_name", $b_info[0]['x_e_name']);
//            $this->assign("x_sfz", $b_info[0]['x_e_zzjgdmzh']);
//        }
        $u_id = M('xdbusiness')->where("Id = '{$id}'")->select()[0]['x_id'];
//        var_dump($u_id);
        $u_type = substr($u_id,0,1);
        if($u_type == 1){
            $u_id = substr($u_id, 1, strlen($u_id) - 1);
            $u_info = M('x_p_customer')->where("id = '{$u_id}'")->select();
            $this->assign('id',$u_info[0]['id']);
            $this->assign('x_type',1);
            $this->assign("x_name",$u_info[0]['x_p_name']);
            $this->assign("x_sfz", $u_info[0]['x_p_idcard']);
        }
        if($u_type == 2){
            $u_id = substr($u_id, 1, strlen($u_id) - 1);
            $u_info = M('x_e_customer')->where("id = '{$u_id}'")->select();
            $this->assign('id',$u_info[0]['id']);
            $this->assign('x_type',2);
            $this->assign("x_name",$u_info[0]['x_e_name']);
            $this->assign("x_sfz", $u_info[0]['x_e_zzjgdmzh']);
        }
        //查询出客户的业务信息
        $customer = M("xdbusiness");
        $sql = "select * from oa_xdbusiness as c where  c.Id = {$id}";
        $c_info = $customer->query($sql);
        $this->assign('x_id', $id);
        $this->assign("c_info", $c_info);

        //查询出客户相关图片的地址
        $s_ht = json_decode($c_info[0]['x_ht']);
        $s_kcht = json_decode($c_info[0]['x_kcht']);
        $this->assign('kcht', $s_kcht);
        $this->assign("ht", $s_ht);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function do_edit_ywlc()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_AJAX) _404('页面不存在', U('index'));
        $id = $_POST['id'];

        $customer = M("xdbusiness");

        $data = array(
//            'c_uid' => $Uid,
            'x_dkje' => $_POST['x_dkje'],
            'x_dkqsrq' => $_POST['x_dkqsrq'],
            'x_dkjsrq' => $_POST['x_dkjsrq'],
            'x_yt' => $_POST['x_yt'],
            'x_hkfs' => $_POST['x_hkfs'],
            'x_hkly' => $_POST['x_hkly'],
            'x_lv' => $_POST['x_lv'],
            'x_dbfs' => $_POST['x_dbfs'],
            'x_dy' => $_POST['x_dy'],
            'x_hkzh' => $_POST['x_hkzh'],
            'x_ht' => json_encode($_POST['x_ht']),
            'x_kc' => $_POST['x_kc'],
            'x_kcht' => json_encode($_POST['x_kcht']),
            'x_dkffr' => $_POST['x_dkffr'],
            'x_dkdqr' => $_POST['x_dkdqr'],
            'x_fkje' => $_POST['x_fkje'],
            'x_fkfs' => $_POST['x_fkfs'],
            'x_hkdj' => $_POST['x_hkdj'],
            'x_zjkm' => $_POST['x_zjkm'],
            'x_zjkmbz' => $_POST['x_zjkmbz'],
            'x_jd' => $_POST['x_jd'],
            'x_status' => $_POST['x_status'],
            'x_shxx' => $_POST['x_shxx'],
            'x_updatetime' => time(),
        );

        if ($customer->where("Id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }

    }

    //个人客户信息更新操作
    public function do_edit_x_p_customer()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_AJAX) _404('页面不存在', U('index'));
        $id = $_POST['id'];
//        $customer = M("x_p_customer");
//        $c_info = $customer->query("select * from oa_x_p_customer as x where  x.id = {id} ");
////        $this->assign("c_info", $c_info);
//
//        $this->Online($_SESSION['UserId']);
//        $this->display();
        $customer = M("x_p_customer");
//p($id);
//        die;
        //获取oa_customer表的更新资料


        $data['x_p_name'] = $_POST['x_p_name'];
        $data['x_p_idcard'] = $_POST['x_p_idcard'];
        $data['x_p_sex'] = $_POST['x_p_sex'];
        $data['x_p_mz'] = $_POST['x_p_mz'];
        $data['x_p_jkzk'] = $_POST['x_p_jkzk'];
        $data['x_p_gzdw'] = $_POST['x_p_gzdw'];
        $data['x_p_zw'] = $_POST['x_p_zw'];
        $data['x_p_hkzz'] = $_POST['x_p_hkzz'];
        $data['x_p_sfzzz'] = $_POST['x_p_sfzzz'];
        $data['x_p_sjzz'] = $_POST['x_p_sjzz'];
        $data['x_p_lxfs'] = $_POST['x_p_lxfs'];
        $data['x_p_hyzk'] = $_POST['x_p_hyzk'];
        $data['x_p_poxm'] = $_POST['x_p_poxm'];
        $data['x_p_posfzh'] = $_POST['x_p_posfzh'];
        $data['x_p_polxfs'] = $_POST['x_p_polxfs'];
        $data['x_p_posr'] = $_POST['x_p_posr'];
        $data['x_p_pogzqk'] = $_POST['x_p_pogzqk'];
        $data['x_p_pozw'] = $_POST['x_p_pozw'];
        $data['x_p_jtzhnsr'] = $_POST['x_p_jtzhnsr'];
        $data['x_p_yhck'] = $_POST['x_p_yhck'];
        $data['x_p_fwxz'] = $_POST['x_p_fwxz'];
        $data['x_p_fwwz'] = $_POST['x_p_fwwz'];
        $data['x_p_fwjz'] = $_POST['x_p_fwjz'];
        $data['x_p_clxhjz'] = json_encode($_POST['x_p_clxhjz']);
        $data['x_p_jtqtsr'] = $_POST['x_p_jtqtsr'];
        $data['x_p_jtqtsrbz'] = $_POST['x_p_jtqtsrbz'];
        $data['x_p_xyked'] = $_POST['x_p_xyked'];
        $data['x_p_xykfz'] = $_POST['x_p_xykfz'];
        $data['x_p_yhajdk'] = $_POST['x_p_yhajdk'];
        $data['x_p_mjjd'] = $_POST['x_p_mjjd'];
        $data['x_p_dwdbqk'] = $_POST['x_p_dwdbqk'];
        $data['x_p_fwdzjz'] = $_POST['x_p_fwdzjz'];
        $data['x_p_kc'] = $_POST['x_p_kc'];
        $data['x_p_yywj'] = json_encode($_POST['x_p_yywj']);
        $data['x_p_fwxx'] = json_encode($_POST['x_p_fwxx']);
        $data['x_p_gxr'] = json_encode($_POST['gxr']);
        $data['x_p_updatetime'] = time();
        $data['x_p_type'] = '2';
//        p($data);
//        die;
//p($data);
//        die;

        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }
    }

    //企业客户信息更新操作
    public function do_edit_x_e_customer()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        $id = $_POST['id'];
        $customer = M("x_e_customer");

        $data = array(
            'c_uid' => $Uid,
            'x_e_name' => $_POST['x_e_name'],
            'x_e_yyzzh' => $_POST['x_e_yyzzh'],
            'x_e_sudjzh' => $_POST['x_e_sudjzh'],
            'x_e_zzjgdmzh' => $_POST['x_e_zzjgdmzh'],
            'x_e_frxm' => $_POST['x_e_frxm'],
            'x_e_jycsszd' => $_POST['x_e_jycsszd'],
            'x_e_frsfzh' => $_POST['x_e_frsfzh'],
            'x_e_frhjzz' => $_POST['x_e_frhjzz'],
            'x_e_frsjzz' => $_POST['x_e_frsjzz'],
            'x_e_frlxfs' => $_POST['x_e_frlxfs'],
            'x_e_frpoxm' => $_POST['x_e_frpoxm'],
            'x_e_frposfzh' => $_POST['x_e_frposfzh'],
            'x_e_frpohjzz' => $_POST['x_e_frpohjzz'],
            'x_e_frpolxfs' => $_POST['x_e_frpolxfs'],
            'x_e_sfypo' => $_POST['x_e_sfypo'],
//            'x_e_gdxm' => $_POST['x_e_gdxm'],
//            'x_e_gdsfzh' => $_POST['x_e_gdsfzh'],
            'x_e_gdxx' => json_encode($_POST['x_e_gdxx']),
            'x_e_fwxx' => json_encode($_POST['x_e_fwxx']),
            'x_e_clxx' => json_encode($_POST['x_e_clxx']),
            'x_e_dkkh' => $_POST['x_e_dkkh'],
            'x_e_khxkzh' => $_POST['x_e_khxkzh'],
            'x_e_jgxydmzh' => $_POST['x_e_jgxydmzh'],
            'x_e_aqscxkzmc' => $_POST['x_e_aqscxkzmc'],
            'x_e_aqxkzhm' => $_POST['x_e_aqxkzhm'],
            'x_e_pwxkzmc' => $_POST['x_e_pwxkzmc'],
            'x_e_pwxkzhm' => $_POST['x_e_pwxkzhm'],
            'x_e_qyjbhyhls' => json_encode($_POST['x_e_qyjbhyhls']),
            'x_e_gxht' => json_encode($_POST['x_e_gxht']),
            'x_e_bb' => json_encode($_POST['x_e_bb']),
            'x_e_fczhm' => $_POST['x_e_fczhm'],
            'x_e_tdsyzhm' => $_POST['x_e_tdsyzhm'],
            'x_e_hkdj' => $_POST['x_e_hkdj'],
            'x_e_kc' => $_POST['x_e_kc'],
            'x_e_ht' => json_encode($_POST['x_e_ht']),
            'x_e_yywj' => json_encode($_POST['x_e_yywj']),
            'x_e_qysnzsr' => $_POST['x_e_qysnzsr'],
            'x_e_zczgm' => $_POST['x_e_zczgm'],
            'x_e_qtsrbz' => $_POST['x_e_qtsrbz'],
            'x_e_yhfzye' => $_POST['x_e_yhfzye'],
            'x_e_mjjdye' => $_POST['x_e_mjjdye'],
            'x_e_dwdbed' => $_POST['x_e_dwdbed'],
            'x_e_updatetime' => time(),
            'x_e_type' => '2'
        );

        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }
    }

    //查询客户信息处理
    public function customer_query()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[3] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        $filed_name = $_GET['field_name'];

        $value = $_GET['value'];
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $new_filed = substr($filed_name, 0, 4);

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        $x_p_customer = M("x_p_customer");
        $x_e_customer = M("x_e_customer");
        if ($filed_name == "x_p_dkffr" || $filed_name == "x_p_dkdqr") {
            if ($filed_name == "x_p_dkffr") {
                $filed_name = "x_dkqsrq";
            } else if ($filed_name == "x_p_dkdqr") {
                $filed_name = "x_dkjsrq";
            }
            $sql = "select * from oa_xdbusiness as x where x." . $filed_name . " >= '{$startdate}' and x." . $filed_name . " <= '{$enddate}' and x.x_del = 0 and x.x_status = 1";
            $c_info = M('xdbusiness')->query($sql);
                $infoarray = array();
                for ($i = 0; $i < count($c_info); $i++) {
                    $x_id = substr($c_info[$i]['x_id'], 1);
                    $type = substr($c_info[$i]['x_id'],0,1);
                    if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                        $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                            'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                            'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                            'b_id' => $c_info[$i]['Id'],
                            'zjkm' => $c_info[$i]['x_zjkm'],
                            'zjkmbz' => $c_info[$i]['x_zjkmbz']
                        );
                    }
                }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "p");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } else if ($filed_name == "x_e_dkffr" || $filed_name == "x_e_dkdqr") {
            if ($filed_name == "x_e_dkffr") {
                $filed_name = "x_dkqsrq";
            } else if ($filed_name == "x_e_dkdqr") {
                $filed_name = "x_dkjsrq";
            }
            $sql = "select * from oa_xdbusiness as x where x." . $filed_name . " >= '{$startdate}' and x." . $filed_name . " <= '{$enddate}' and x.x_del = 0 and x.x_status = 1";
            $c_info = M('xdbusiness')->query($sql);
            $infoarray = array();
            for ($i = 0; $i < count($c_info); $i++) {
                $x_id = substr($c_info[$i]['x_id'], 1);
                $type = substr($c_info[$i]['x_id'],0,1);
                if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                    $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                        'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                        'b_id' => $c_info[$i]['Id'],
                        'zjkm' => $c_info[$i]['x_zjkm'],
                        'zjkmbz' => $c_info[$i]['x_zjkmbz']
                    );
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "e");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } else if ($filed_name == "x_p_dkzt" || $filed_name == "x_e_dkzt") {
            if ($filed_name == "x_p_dkzt") {
                if ($value == 1) {
                    $sql = "select * from oa_xdbusiness where (x_hkdj = 1 or x_hkdj = 0) and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                            $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                                'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "p");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                } elseif ($value == 2) {
                    $sql = "select * from oa_xdbusiness where x_jd = 1 and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                            $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                                'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "p");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                } elseif ($value == 4) {
                    $sql = "select * from oa_xdbusiness where x_hkdj = 4 and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                            $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                                'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "p");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                } elseif ($value == 5) {
                    $sql = "select * from oa_xdbusiness where x_jd = 2 and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                            $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                                'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "p");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
            } else if ($filed_name == "x_e_dkzt") {
                if($value == 1){
                    $sql = "select * from oa_xdbusiness where (x_hkdj = 1 or x_hkdj = 0) and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                            $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                                'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "e");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
                elseif($value == 2){
                    $sql = "select * from oa_xdbusiness where x_jd = 1 and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                            $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                                'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "e");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
                elseif($value == 4){
                    $sql = "select * from oa_xdbusiness where x_hkdj = 4 and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                            $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                                'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "e");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
                elseif($value == 5){
                    $sql = "select * from oa_xdbusiness where x_jd = 2 and x_del = 0 and x_status = 1";
                    $c_info = M('xdbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i < count($c_info); $i++) {
                        $x_id = substr($c_info[$i]['x_id'], 1);
                        $type = substr($c_info[$i]['x_id'],0,1);
                        if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                            $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                                'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                                'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                                'b_id' => $c_info[$i]['Id'],
                                'zjkm' => $c_info[$i]['x_zjkm'],
                                'zjkmbz' => $c_info[$i]['x_zjkmbz']
                            );
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "e");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
            }
        } else if ($filed_name == "x_p_zjkm" || $filed_name == "x_e_zjkm") {
            if ($filed_name == "x_p_zjkm") {
                $filed_name = "x_zjkm";
                if ($value == 1) {
                    $sql = "select * from oa_xdbusiness where (x_zjkm = 1 or x_zjkm = 3) and x_status = 1 AND x_id LIKE '1%' ORDER BY x_zjkm";
                } elseif ($value == 2) {
                    $sql = "select * from oa_xdbusiness where (x_zjkm = 2 or x_zjkm = 3) and x_status = 1 AND x_id LIKE '1%' ORDER BY x_zjkm";
                }
                $c_info = M('xdbusiness')->query($sql);
                $infoarray = array();
                for ($i = 0; $i <= count($c_info); $i++) {
                    $x_id = substr($c_info[$i]['x_id'], 1);
                    if (M('x_p_customer')->where("id = {$x_id}")->select()[0]) {
                        $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                            'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                            'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                            'b_id' => $c_info[$i]['Id'],
                            'zjkm' => $c_info[$i]['x_zjkm'],
                            'zjkmbz' => $c_info[$i]['x_zjkmbz']
                        );
                    }
                }
                $count1 = count($c_info);
                $page1 = new Page($count1, 10);
                $this->assign("customertype", "p");
                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                $this->assign("c_info", $infoarray);
            } else if ($filed_name == "x_e_zjkm") {
                $filed_name = "x_zjkm";
                if ($value == 1) {
                    $sql = "select * from oa_xdbusiness where (x_zjkm = 1 or x_zjkm = 3) and x_status = 1 AND x_id LIKE '2%' ORDER BY x_zjkm";
                } elseif ($value == 2) {
                    $sql = "select * from oa_xdbusiness where (x_zjkm = 2 or x_zjkm = 3) and x_status = 1 AND x_id LIKE '2%' ORDER BY x_zjkm";
                }
                $c_info = M('xdbusiness')->query($sql);
                $infoarray = array();
                for ($i = 0; $i <= count($c_info); $i++) {
                    $x_id = substr($c_info[$i]['x_id'], 1);
                    if (M('x_e_customer')->where("id = {$x_id}")->select()[0]) {
                        $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                            'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                            'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                            'b_id' => $c_info[$i]['Id'],
                            'zjkm' => $c_info[$i]['x_zjkm'],
                            'zjkmbz' => $c_info[$i]['x_zjkmbz']
                        );
                    }
                }
                $count1 = count($c_info);
                $page1 = new Page($count1, 10);
                $this->assign("customertype", "e");
                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                $this->assign("c_info", $infoarray);
            }
        }elseif($filed_name == 'x_p_hmd'||$filed_name == 'x_e_hmd'){
            if($filed_name == 'x_p_hmd'){
                $sql = "select * from oa_xdbusiness WHERE x_jd = 2 and x_status = 1";
                $c_info = M('xdbusiness')->query($sql);
                $infoarray = array();
                for ($i = 0; $i < count($c_info); $i++) {
                    $x_id = substr($c_info[$i]['x_id'], 1);
                    $type = substr($c_info[$i]['x_id'],0,1);
                    if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                        $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                            'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                            'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                            'b_id' => $c_info[$i]['Id'],
                            'zjkm' => $c_info[$i]['x_zjkm'],
                            'zjkmbz' => $c_info[$i]['x_zjkmbz']
                        );
                    }
                }
                $count1 = count($c_info);
                $page1 = new Page($count1, 10);
                $this->assign("customertype", "p");
                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                $this->assign("c_info", $infoarray);
            }else{
                $sql = "select * from oa_xdbusiness WHERE x_jd = 2 and x_status = 1";
                $c_info = M('xdbusiness')->query($sql);
                $infoarray = array();
                for ($i = 0; $i < count($c_info); $i++) {
                    $x_id = substr($c_info[$i]['x_id'], 1);
                    $type = substr($c_info[$i]['x_id'],0,1);
                    if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                        $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                            'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                            'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                            'b_id' => $c_info[$i]['Id'],
                            'zjkm' => $c_info[$i]['x_zjkm'],
                            'zjkmbz' => $c_info[$i]['x_zjkmbz']
                        );
                    }
                }
                $count1 = count($c_info);
                $page1 = new Page($count1, 10);
                $this->assign("customertype", "e");
                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                $this->assign("c_info", $infoarray);
            }
        } elseif ($new_filed == "x_p_") {
            $sql = "select * from oa_x_p_customer as x where x." . $filed_name . " = '{$value}' and x.x_p_del <> 1 {$page1->limit}";
            $c_info = $x_p_customer->query($sql);
            $sql = "select * from oa_xdbusiness where x_id = '1{$c_info[0]['id']}'  and x_status = 1";
            $c_info = M()->query($sql);
            $infoarray = array();
            for ($i = 0; $i < count($c_info); $i++) {
                $x_id = substr($c_info[$i]['x_id'], 1);
                $type = substr($c_info[$i]['x_id'],0,1);
                if (M('x_p_customer')->where("id = {$x_id}")->select()[0] && $type == 1) {
                    $infoarray[] = array('x_p_name' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'id' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['id'],
                        'x_p_lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                        'b_id' => $c_info[$i]['Id'],
                        'zjkm' => $c_info[$i]['x_zjkm'],
                        'zjkmbz' => $c_info[$i]['x_zjkmbz']
                    );
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "p");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } else {
            $sql = "select * from oa_x_e_customer as x where x." . $filed_name . " = '{$value}' and x.x_e_del <> 1";
            $c_info = $x_e_customer->query($sql);
            $sql = "select * from oa_xdbusiness where x_id = '2{$c_info[0]['id']}'  and x_status = 1";
            $c_info = M()->query($sql);
            $infoarray = array();
            for ($i = 0; $i < count($c_info); $i++) {
                $x_id = substr($c_info[$i]['x_id'], 1);
                $type = substr($c_info[$i]['x_id'],0,1);
                if (M('x_e_customer')->where("id = {$x_id}")->select()[0] && $type == 2) {
                    $infoarray[] = array('x_e_name' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'id' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['id'],
                        'x_e_lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                        'b_id' => $c_info[$i]['Id'],
                        'zjkm' => $c_info[$i]['x_zjkm'],
                        'zjkmbz' => $c_info[$i]['x_zjkmbz']
                    );
                }
            }
            $count2 = count($c_info);
            $page2 = new Page($count2, 10);
            $this->assign("customertype", "e");
            $this->assign("fpage", $page2->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        }
//        var_dump($infoarray);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }


    public function customer_x_p_dbr_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function customer_x_p_dbr_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $id = I('id');
        $c_info = M('xd_dbr')->where("id = {$id}")->select();
        $this->assign("c_info", $c_info);

        $this->display();
    }

    public function do_add_dbr()
    {
        if (!IS_POST) _404('页面不存在', U('index'));

        $cardid = I('idcard');
        $data = array(
            'x_p_parentidcard' => $cardid,
            'x_p_name' => $_POST['x_p_name'],
            'x_p_idcard' => $_POST['x_p_idcard'],
            'x_p_sex' => $_POST['x_p_sex'],
            'x_p_mz' => $_POST['x_p_mz'],
            'x_p_jkzk' => $_POST['x_p_jkzk'],
            'x_p_gzdw' => $_POST['x_p_gzdw'],
            'x_p_zw' => $_POST['x_p_zw'],
            'x_p_hkzz' => $_POST['x_p_hkzz'],
            'x_p_sfzzz' => $_POST['x_p_sfzzz'],
            'x_p_sjzz' => $_POST['x_p_sjzz'],
            'x_p_lxfs' => $_POST['x_p_lxfs'],
            'x_p_hyzk' => $_POST['x_p_hyzk'],
            'x_p_poxm' => $_POST['x_p_poxm'],
            'x_p_mxzc' => $_POST['x_p_mxzc'],
            'x_p_posfzh' => $_POST['x_p_posfzh'],
            'x_p_polxfs' => $_POST['x_p_polxfs'],
            'x_p_posr' => $_POST['x_p_posr'],
            'x_p_pogzqk' => $_POST['x_p_pogzqk'],
            'x_p_pozw' => $_POST['x_p_pozw'],
            'x_p_jtzhnsr' => $_POST['x_p_jtzhnsr'],
            'x_p_yhck' => $_POST['x_p_yhck'],
            'x_p_fwxz' => $_POST['x_p_fwxz'],
            'x_p_fwxqjz' => $_POST['x_p_fwxqjz'],
            'x_p_clxhjz' => $_POST['x_p_clxhjz'],
            'x_p_jtqtsr' => $_POST['x_p_jtqtsr'],
            'x_p_jtqtsrbz' => $_POST['x_p_jtqtsrbz'],
            'x_p_xyked' => $_POST['x_p_xyked'],
            'x_p_xykfz' => $_POST['x_p_xykfz'],
            'x_p_yhajdk' => $_POST['x_p_yhajdk'],
            'x_p_mjjd' => $_POST['x_p_mjjd'],
            'x_p_dwdbqk' => $_POST['x_p_dwdbqk'],
            'x_p_time' => time(),
            'x_p_updatetime' => time(),
        );

        if (M('xd_dbr')->data($data)->add()) {
            $this->ajaxReturn(array('status' => 1, 'error' => '添加成功'), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '添加失败'), 'json');
        }

    }

    public function do_update_dbr()
    {
        if (!IS_POST) _404('页面不存在', U('index'));

        $id = I('id');
        $data = array(
            'x_p_name' => $_POST['x_p_name'],
            'x_p_idcard' => $_POST['x_p_idcard'],
            'x_p_sex' => $_POST['x_p_sex'],
            'x_p_mz' => $_POST['x_p_mz'],
            'x_p_jkzk' => $_POST['x_p_jkzk'],
            'x_p_gzdw' => $_POST['x_p_gzdw'],
            'x_p_zw' => $_POST['x_p_zw'],
            'x_p_hkzz' => $_POST['x_p_hkzz'],
            'x_p_sfzzz' => $_POST['x_p_sfzzz'],
            'x_p_sjzz' => $_POST['x_p_sjzz'],
            'x_p_lxfs' => $_POST['x_p_lxfs'],
            'x_p_hyzk' => $_POST['x_p_hyzk'],
            'x_p_poxm' => $_POST['x_p_poxm'],
            'x_p_posfzh' => $_POST['x_p_posfzh'],
            'x_p_polxfs' => $_POST['x_p_polxfs'],
            'x_p_posr' => $_POST['x_p_posr'],
            'x_p_pogzqk' => $_POST['x_p_pogzqk'],
            'x_p_pozw' => $_POST['x_p_pozw'],
            'x_p_jtzhnsr' => $_POST['x_p_jtzhnsr'],
            'x_p_yhck' => $_POST['x_p_yhck'],
            'x_p_mxzc' => $_POST['x_p_mxzc'],
            'x_p_fwxz' => $_POST['x_p_fwxz'],
            'x_p_fwxqjz' => $_POST['x_p_fwxqjz'],
            'x_p_clxhjz' => $_POST['x_p_clxhjz'],
            'x_p_jtqtsr' => $_POST['x_p_jtqtsr'],
            'x_p_jtqtsrbz' => $_POST['x_p_jtqtsrbz'],
            'x_p_xyked' => $_POST['x_p_xyked'],
            'x_p_xykfz' => $_POST['x_p_xykfz'],
            'x_p_yhajdk' => $_POST['x_p_yhajdk'],
            'x_p_mjjd' => $_POST['x_p_mjjd'],
            'x_p_dwdbqk' => $_POST['x_p_dwdbqk'],
            'x_p_updatetime' => time(),
        );

        if (M('xd_dbr')->where("id = {$id}")->save($data)) {
            $this->ajaxReturn(array('status' => 1, 'error' => '更新成功'), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '更新失败'), 'json');
        }

    }

    public function do_del_dbr()
    {
        $id = I('id');
        $cardid = I('cardid');
        if (M('xd_dbr')->where("id = {$id}")->delete()) {
            $data = M('xd_dbr')->where("x_p_parentidcard = {$cardid}")->select();
            $this->ajaxReturn(array('status' => 1, 'dbrinfo' => $data), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '更新失败'), 'json');
        }
    }

    public function getdbrinfo()
    {
        if (I('request')) {
            $cardid = I('cardid');
            $data = M('xd_dbr')->where("x_p_parentidcard = '{$cardid}'")->select();
            if (count($data) != 0) {
                $this->ajaxReturn(array('status' => 1, 'dbrinfo' => $data), 'json');
            } else {
                $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
            }
        } else {
            $this->ajaxReturn(array('status' => 0), 'json');
        }
    }

    public function hascustomer()
    {
        $sfzh = I('sfzh');
        $khlx = I('khlx');
        if ($khlx == 1) {
            $count = M('x_p_customer')->where("x_p_idcard = '{$sfzh}'")->count();
            $customer = M('x_p_customer')->where("x_p_idcard = '{$sfzh}' and x_p_del = 1")->select();
            $customer1 = M('x_p_customer')->where("x_p_idcard = '{$sfzh}'")->select();
        } else if ($khlx == 2) {
            $count = M('x_e_customer')->where("x_e_zzjgdmzh = '{$sfzh}'")->count();
            $customer = M('x_e_customer')->where("x_e_zzjgdmzh = '{$sfzh}' and x_e_del = 1")->select();
            $customer1 = M('x_e_customer')->where("x_e_zzjgdmzh = '{$sfzh}'")->select();
        }
        if ($count == 0) {
            if (count($customer) == 0 || !$customer) {
                $this->ajaxReturn(array('status' => 1),'json');
            } else {
                $this->ajaxReturn(array('status' => 3, 'c_id' => $customer[0]['id'], 'type' => 'xp'), 'json');
            }
        } else {
            $this->ajaxReturn(array('status' => 0,'id' => $customer1[0]['id'],'khlx'=>$khlx), 'json');
        }
    }

    public function del_yw()
    {
        $id = I('id');
        if (M('xdbusiness')->where("id = {$id}")->delete()) {
            $this->success("删除成功", U('customer'));
        } else {
            $this->error("删除出错", U('customer'),2);
        }
    }

    public function del_p_customer()
    {
        $Uid = $_SESSION['UserId'];
        $id = I('id');
        if(M('xdbusiness')->where("x_id = 1{$id} and x_status = 1")->count() == 0) {
            if (M('x_p_customer')->where("id = {$id}")->setField('x_p_del', 1)) {
                M('xdbusiness')->where("x_id = 1{$id} and x_status <> 1")->delete();
                M('x_p_customer')->where("id = {$id}")->setField('del_u_id', $Uid);
                $this->success("删除成功", U('customer'));
            } else {
                $this->error("删除出错", U('customer'));
            }
        }else {
            $this->error("该客户尚存在业务，无法删除", U('customer'));
        }
    }

    public function del_e_customer()
    {
        $Uid = $_SESSION['UserId'];
        $id = I('id');
        if(M('xdbusiness')->where("x_id = 2{$id} and x_status = 1")->count() == 0) {
            if (M('x_e_customer')->where("id = {$id}")->setField('x_e_del', 1)) {
                M('xdbusiness')->where("x_id = 2{$id} and x_status <> 1")->delete();
                M('x_e_customer')->where("id = {$id}")->setField('del_u_id', $Uid);
                $this->success("删除成功", U('customer'));
            } else {
                $this->error("删除出错", U('customer'));
            }
        }else {
            $this->error("该客户尚存在业务，无法删除", U('customer'));
        }
    }

    public function customer_x_adddhgzjc()
    {
        $this->display();
    }

    public function do_customer_dhgzjc()
    {
        $idcard = I('cardid');
        $time = I('time');
        $data = array(
            'idcard' => I('cardid'),
            'dhgzjc' => I('dhgzjc'),
            'time' => date('Y-m-d h:i:sa'),
            'type' => I('type')
        );

        if (M('dhgzjc')->where("idcard = '{$idcard}' AND time ={$time}")->select()[0]['Id'] != null) {
            $this->ajaxReturn(array('status' => 3, 'error' => '更新失败'), 'json');
        } else if (M('dhgzjc')->add($data)) {
            $this->ajaxReturn(array('status' => 1, 'error' => '更新成功'), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '更新失败'), 'json');
        }
    }

    public function getdhgzjcinfo()
    {
        if (I('request')) {
            $cardid = I('cardid');
            $data = M('dhgzjc')->where("idcard = '{$cardid}' AND type ='xd'")->select();
            if (count($data) != 0) {
                $this->ajaxReturn(array('status' => 1, 'dhgzjcinfo' => $data), 'json');
            } else {
                $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
            }
        } else {
            $this->ajaxReturn(array('status' => 0), 'json');
        }
    }

    public function createjj()
    {
        $jkrsfzh = I('jkrsfzh');
        $jkrxm = I('jkrxm');
        $jkyt = I('jkyt');
        $jkylv = I('jkylv');
        $jxfs = I('jxfs');
        $jkje = I('jkje');
        if ($jxfs == 1) {
            $jxfs = "等额本息";
        } elseif ($jxfs == 2) {
            $jxfs = "等额本金";
        } else {
            $jxfs = "按月还息，到期还本";
        }
        $jkqsrq = I('jkqsrq');
        $jkjsrq = I('jkjsrq');
        $khlx = I('customertype');
        vendor("PHPExcel.PHPExcel");
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("诚金办公管理系统")
            ->setLastModifiedBy("诚金办公管理系统")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        //set width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);

        //设置行高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(20);

        //set font size bold
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:D7')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A2:D7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:D7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //设置水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //合并cell
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

        if($khlx == 2){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '贷款借据  生成时间:' . date('Y-m-d H:i:s'))
                ->setCellValue('A2', '企业名称')
                ->setCellValue('B2', $jkrxm . " ")
                ->setCellValue('C2', '借款用途')
                ->setCellValue('D2', $jkyt . " ")
                ->setCellValue('A3', '组织机构代码证号')
                ->setCellValue('B3', $jkrsfzh . " ")
                ->setCellValue('C3', '借款月利率')
                ->setCellValue('D3', $jkylv . '‰')
                ->setCellValue('A4', '借款起止日期')
                ->setCellValue('B4', substr($jkqsrq, 0, 4) . '年' . substr($jkqsrq, 5, 2) . '月' . substr($jkqsrq, 8, 2) . '日至' . substr($jkjsrq, 0, 4) . '年' . substr($jkjsrq, 5, 2) . '月' . substr($jkjsrq, 8, 2) . '日')
                ->setCellValue('C4', '结息方式')
                ->setCellValue('D4', $jxfs)
                ->setCellValue('A5', '借款金额（大写）')
                ->setCellValue('B5', num2rmb($jkje))
                ->setCellValue('C5', '借款金额（小写）')
                ->setCellValue('D5', $jkje . '元')
                ->setCellValue('A6', '借款人签字')
                ->setCellValue('C6', '担保人签字')
                ->setCellValue('A7', '审批人签字')
                ->setCellValue('C7', '经办人签字');
        }else{
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '贷款借据  生成时间:' . date('Y-m-d H:i:s'))
            ->setCellValue('A2', '借款人名称')
            ->setCellValue('B2', $jkrxm . " ")
            ->setCellValue('C2', '借款用途')
            ->setCellValue('D2', $jkyt . " ")
            ->setCellValue('A3', '借款人身份号')
            ->setCellValue('B3', $jkrsfzh . " ")
            ->setCellValue('C3', '借款月利率')
            ->setCellValue('D3', $jkylv . '‰')
            ->setCellValue('A4', '借款起止日期')
            ->setCellValue('B4', substr($jkqsrq, 0, 4) . '年' . substr($jkqsrq, 5, 2) . '月' . substr($jkqsrq, 8, 2) . '日至' . substr($jkjsrq, 0, 4) . '年' . substr($jkjsrq, 5, 2) . '月' . substr($jkjsrq, 8, 2) . '日')
            ->setCellValue('C4', '结息方式')
            ->setCellValue('D4', $jxfs)
            ->setCellValue('A5', '借款金额（大写）')
            ->setCellValue('B5', num2rmb($jkje))
            ->setCellValue('C5', '借款金额（小写）')
            ->setCellValue('D5', $jkje . '元')
            ->setCellValue('A6', '借款人签字')
            ->setCellValue('C6', '担保人签字')
            ->setCellValue('A7', '审批人签字')
            ->setCellValue('C7', '经办人签字');
    }
        // set table header content



        //  sheet命名
        $objPHPExcel->getActiveSheet()->setTitle('借据');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // excel头参数
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="借据.xls"');  //日期为文件名后缀
        header('Cache-Control: max-age=0');

        $filename = "&#x8BDA;&#x91D1;&#x529E;&#x516C;&#x7CFB;&#x7EDF;&#x5BFC;&#x51FA;&#x6587;&#x4EF6;.xls";
        iconv('utf-8','gb2312',$filename);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式
        $objWriter->save("ChengJin Office Output File.xls");
        $this->ajaxReturn(array('status' => 1, 'xlsurl' => U('createjj')), 'json');
    }

    public function customer_dbw_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function customer_dbw_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $id = I('id');
        $c_info = M('dbw')->where("id = {$id}")->select();
        $this->assign("c_info", $c_info);

        $this->display();
    }

    public function do_add_dbw()
    {
        if (!IS_POST) _404('页面不存在', U('index'));

        $type = I('type');
        $parentid = I('parentid');
//        if ($type == '1') {
//            $parentid = M('x_p_customer')->query("select id from oa_x_p_customer WHERE x_p_idcard = '{$parentinfo}'");
//        } else if ($type == '2') {
//            $parentid = M('x_p_customer')->query("select id from oa_x_e_customer WHERE x_e_zzjgdmzh = '{$parentinfo}'");
//        }
        $data = array(
            'db_type' => $_POST['db_type'],
            'type' => $_POST['type'],
            'parentid' => $_POST['parentid'],
            'gjs_name' => $_POST['gjs_name'],
            'gjs_mc' => $_POST['gjs_mc'],
            'gjs_idcard' => $_POST['gjs_idcard'],
            'gjs_lxdh' => $_POST['gjs_lxdh'],
            'gjs_pgjg' => $_POST['gjs_pgjg'],
            'c_syqr' => $_POST['c_syqr'],
            'c_syqrsfzh' => $_POST['c_syqrsfzh'],
            'c_syqrlxdh' => $_POST['c_syqrlxdh'],
            'c_ph' => $_POST['c_ph'],
            'c_pp' => $_POST['c_pp'],
            'c_xh' => $_POST['c_xh'],
            'c_djh' => $_POST['c_djh'],
            'c_nx' => $_POST['c_nx'],
            'c_jz' => $_POST['c_jz'],
            'c_ywaj' => $_POST['c_ywaj'],
            'c_yhajje' => $_POST['c_yhajje'],
            'fw_syqr' => $_POST['fw_syqr'],
            'fw_syqrsfzh' => $_POST['fw_syqrsfzh'],
            'fw_syqrlxdh' => $_POST['fw_syqrlxdh'],
            'fw_fczh' => $_POST['fw_fczh'],
            'fw_tdzh' => $_POST['fw_tdzh'],
            'fw_mj' => $_POST['fw_mj'],
            'fw_dd' => $_POST['fw_dd'],
            'fw_pgjz' => $_POST['fw_pgjz'],
            'fw_ywaj' => $_POST['fw_ywaj'],
            'fw_yhajje' => $_POST['fw_yhajje'],
            'fw_ywgyr' => $_POST['fw_ywgyr'],
            'fw_gyrxm' => $_POST['fw_gyrxm'],
            'fw_gyrsfzh' => $_POST['fw_gyrsfzh'],
            'fw_gyrlxfs' => $_POST['fw_gyrlxfs'],
            'fw_fwsfcgdsr' => $_POST['fw_fwsfcgdsr'],
            'fw_zlqsrq' => $_POST['fw_zlqsrq'],
            'fw_zljsrq' => $_POST['fw_zljsrq'],
            'fw_zlrxm' => $_POST['fw_zlrxm'],
            'fw_zlrsfzh' => $_POST['fw_zlrsfzh'],
            'fw_zlrlxfs' => $_POST['fw_zlrlxfs'],
            'xy_name' => $_POST['xy_name'],
            'xy_idcard' => $_POST['xy_idcard'],
            'xy_lxdh' => $_POST['xy_lxdh'],
            'xy_sfzdz' => $_POST['xy_sfzdz'],
            'xy_sjzz' => $_POST['xy_sjzz'],
            'qt_mc' => $_POST['qt_mc'],
            'qt_name' => $_POST['qt_name'],
            'qt_idcard' => $_POST['qt_idcard'],
            'qt_lxdh' => $_POST['qt_lxdh'],
            'qt_pgjg' => $_POST['qt_pgjg'],
            'pz_name' => $_POST['pz_name'],
            'pz_idcard' => $_POST['pz_idcard'],
            'pz_lxdh' => $_POST['pz_lxdh'],
            'pz_hm' => $_POST['pz_hm'],
            'pz_mzje' => $_POST['pz_mzje'],
            'pz_kbxrq' => $_POST['pz_kbxrq'],
            'pz_pgjg' => $_POST['pz_pgjg']
        );

        if (M('dbw')->data($data)->add()) {
            $this->ajaxReturn(array('status' => 1, 'error' => '添加成功'), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '添加失败'), 'json');
        }
    }

    public function do_update_dbw()
    {
        if (!IS_POST) _404('页面不存在', U('index'));

        $id = I('id');
        $data = array(
            'db_type' => $_POST['db_type'],
            'type' => $_POST['type'],
            'parentid' => $_POST['parentid'],
            'gjs_name' => $_POST['gjs_name'],
            'gjs_mc' => $_POST['gjs_mc'],
            'gjs_idcard' => $_POST['gjs_idcard'],
            'gjs_lxdh' => $_POST['gjs_lxdh'],
            'gjs_pgjg' => $_POST['gjs_pgjg'],
            'c_syqr' => $_POST['c_syqr'],
            'c_syqrsfzh' => $_POST['c_syqrsfzh'],
            'c_syqrlxdh' => $_POST['c_syqrlxdh'],
            'c_ph' => $_POST['c_ph'],
            'c_pp' => $_POST['c_pp'],
            'c_xh' => $_POST['c_xh'],
            'c_nx' => $_POST['c_nx'],
            'c_djh' => $_POST['c_djh'],
            'c_jz' => $_POST['c_jz'],
            'c_ywaj' => $_POST['c_ywaj'],
            'c_yhajje' => $_POST['c_yhajje'],
            'fw_syqr' => $_POST['fw_syqr'],
            'fw_syqrsfzh' => $_POST['fw_syqrsfzh'],
            'fw_syqrlxdh' => $_POST['fw_syqrlxdh'],
            'fw_fczh' => $_POST['fw_fczh'],
            'fw_tdzh' => $_POST['fw_tdzh'],
            'fw_mj' => $_POST['fw_mj'],
            'fw_dd' => $_POST['fw_dd'],
            'fw_pgjz' => $_POST['fw_pgjz'],
            'fw_ywaj' => $_POST['fw_ywaj'],
            'fw_yhajje' => $_POST['fw_yhajje'],
            'fw_ywgyr' => $_POST['fw_ywgyr'],
            'fw_gyrxm' => $_POST['fw_gyrxm'],
            'fw_gyrsfzh' => $_POST['fw_gyrsfzh'],
            'fw_gyrlxfs' => $_POST['fw_gyrlxfs'],
            'fw_fwsfcgdsr' => $_POST['fw_fwsfcgdsr'],
            'fw_zlqsrq' => $_POST['fw_zlqsrq'],
            'fw_zljsrq' => $_POST['fw_zljsrq'],
            'fw_zlrxm' => $_POST['fw_zlrxm'],
            'fw_zlrsfzh' => $_POST['fw_zlrsfzh'],
            'fw_zlrlxfs' => $_POST['fw_zlrlxfs'],
            'xy_name' => $_POST['xy_name'],
            'xy_idcard' => $_POST['xy_idcard'],
            'xy_lxdh' => $_POST['xy_lxdh'],
            'xy_sfzdz' => $_POST['xy_sfzdz'],
            'xy_sjzz' => $_POST['xy_sjzz'],
            'qt_mc' => $_POST['qt_mc'],
            'qt_name' => $_POST['qt_name'],
            'qt_idcard' => $_POST['qt_idcard'],
            'qt_lxdh' => $_POST['qt_lxdh'],
            'qt_pgjg' => $_POST['qt_pgjg'],
            'pz_name' => $_POST['pz_name'],
            'pz_idcard' => $_POST['pz_idcard'],
            'pz_lxdh' => $_POST['pz_lxdh'],
            'pz_hm' => $_POST['pz_hm'],
            'pz_mzje' => $_POST['pz_mzje'],
            'pz_kbxrq' => $_POST['pz_kbxrq'],
            'pz_pgjg' => $_POST['pz_pgjg']
        );

        if (M('dbw')->where("id = {$id}")->save($data)) {
            $this->ajaxReturn(array('status' => 1, 'error' => '更新成功'), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '更新失败'), 'json');
        }

    }

    public function do_del_dbw()
    {
        $id = I('id');
        $cardid = I('cardid');
        if (M('dbw')->where("id = {$id}")->delete()) {
            $data = M('dbw')->where("parentid = '{$cardid}'")->select();
            $this->ajaxReturn(array('status' => 1, 'dbwinfo' => $data), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '删除失败'), 'json');
        }
    }

    public function getdbwinfo()
    {
        $parentinfo = I('cardid');
        $type = I('type');
        $data = M('dbw')->query("select * from oa_dbw WHERE parentid = '{$parentinfo}' and type = {$type}");
        if (count($data) != 0) {
            $this->ajaxReturn(array('status' => 1, 'dbwinfo' => $data), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
        }
    }

    public function recoverycustomer()
    {
        $c_id = I('c_id');
        $type = I('type');
        if ($type == 1) {
                if (M('x_p_customer')->where("id={$c_id}")->setField('x_p_del', '0')) {
                    $this->ajaxReturn(array('status' => 1, 'error' => '', 'id'=>$c_id, 'type'=>'xp'), 'json');
                } else {
                    $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
                }
        } else {
                if (M('x_e_customer')->where("id={$c_id}")->setField('x_e_del', '0')) {
                    $this->ajaxReturn(array('status' => 1, 'error' => ''), 'json');
                } else {
                    $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
                }
        }
    }

    public function customer_baseinfo(){
        $c_data = M('x_p_customer')->where('x_p_del = 0')->order('id desc')->select();
        $m_data = M('x_e_customer')->where('x_e_del = 0')->order('id desc')->select();
        $this->assign('c_data',$c_data);
        $this->assign('m_data',$m_data);
        $this->display();
    }

    public function customer_base_query(){
        $permissions_info = $this->pp;
        if ($permissions_info[3] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        $filed_name = $_GET['field_name'];

        $value = $_GET['value'];
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $new_filed = substr($filed_name, 0, 4);

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        $x_p_customer = M("x_p_customer");
        $x_e_customer = M("x_e_customer");
        if ($new_filed == "x_p_") {
            $sql = "select * from oa_x_p_customer as x where x." . $filed_name . " = '{$value}' and x.x_p_del <> 1";
            $c_info = $x_p_customer->query($sql);
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "p");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $c_info);
        } else {
            $sql = "select * from oa_x_e_customer as x where x." . $filed_name . " = '{$value}' and x.x_e_del <> 1";
            $c_info = $x_e_customer->query($sql);
            $count2 = count($c_info);
            $page2 = new Page($count2, 10);
            $this->assign("customertype", "e");
            $this->assign("fpage", $page2->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $c_info);
        }
//        var_dump($infoarray);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }


}


?>