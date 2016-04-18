<?php

/**
 * Created by PhpStorm.
 * User: Dormon
 * Date: 2015/7/4
 * Time: 7:56
 */
class CustomercdAction extends CommonAction
{
    public $pp;
    public $shqx;

    function __construct()
    {
        if (!isset($_SESSION['Login']) && ($_SESSION['Login'] != true)) {
            $this->redirect('Login/login');
        }

        $Uid = $_SESSION['UserId'];
        $permissions = M("permissions");

        //获取到当前用户对OA管理模块的操作权限
        $pp = $permissions->where("p_column_id = 4 and p_uid = {$Uid}")->find();
        $p_column_sonName = $pp['p_column_sonName'];
        $p_column_son = $pp['p_column_son'];

        $p_column_son = explode(",", $p_column_son);
        $p_column_sonName = explode("|", $p_column_sonName);

        $shqx = $permissions->where("p_column_id = 6 and p_uid = {$Uid}")->find();
        $this->shqx = explode(",", $shqx['p_column_son']);
        $this->pp = $p_column_son;
    }

    public function customer()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $this->Online($_SESSION['UserId']);
            $cd_customer = M("cd_customer");
            $c_info_cd_customer = $cd_customer->where("cd_del = 0")->order("cd_updatetime desc")->select();
            $cd_data = array();
            for ($i = 0; $i < count($c_info_cd_customer); $i++) {
                $cd_business = M('cdbusiness')->where("cd_id = {$c_info_cd_customer[$i]['id']} and cd_del = 0")->order("cd_updatetime desc")->select();
                if (count($cd_business) == 0) {
//                    $cd_data[] = array(
//                        'c_id' => $c_info_cd_customer[$i]['id'],
//                        'xm' => $c_info_cd_customer[$i]['cd_name'],
//                        'clppxh' => 0,
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($cd_business); $j++) {
                        $cd_data[] = array(
                            'b_id' => $cd_business[$j]['id'],
                            'c_id' => $c_info_cd_customer[$i]['id'],
                            'xm' => $c_info_cd_customer[$i]['cd_name'],
                            'clppxh' => $cd_business[$j]['cd_clppxh']
                        );
                    }
                }
            }
            $this->assign("c_info_cd_customer", $cd_data);
            $this->display();
        } else {
            $this->Online($_SESSION['UserId']);
            $cd_customer = M("cd_customer");
            $c_info_cd_customer = $cd_customer->where("c_uid = {$Uid} AND cd_del = 0")->order("cd_updatetime desc")->select();
            $cd_data = array();
            for ($i = 0; $i < count($c_info_cd_customer); $i++) {
                $cd_business = M('cdbusiness')->where("cd_id = {$c_info_cd_customer[$i]['id']} and cd_del = 0")->order("cd_updatetime desc")->select();
                if (count($cd_business) == 0) {
//                    $cd_data[] = array(
//                        'c_id' => $c_info_cd_customer[$i]['id'],
//                        'xm' => $c_info_cd_customer[$i]['cd_name'],
//                        'clppxh' => 0,
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($cd_business); $j++) {
                        $cd_data[] = array(
                            'b_id' => $cd_business[$j]['id'],
                            'c_id' => $c_info_cd_customer[$i]['id'],
                            'xm' => $c_info_cd_customer[$i]['cd_name'],
                            'clppxh' => $cd_business[$j]['cd_clppxh']
                        );
                    }
                }
            }
            $this->assign("c_info_cd_customer", $cd_data);
            $this->display();
        }
    }

    public function customer_cd_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $this->display();
    }

    public function customer_cd_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->assign('enter', I('enter'));
        $id = I('id');
        //查询出客户的详细信息
        $cd_customer = M("cd_customer");
        $sql = "select * from oa_cd_customer as c where  c.id = {$id}";
        $c_info = $cd_customer->query($sql);
        $qpinfo = $cd_customer->query("select cd_qpinfo from oa_cd_customer where id = {$id}")[0]['cd_qpinfo'];
        $this->assign("qpinfo", json_decode($qpinfo));
        $this->assign("c_info", $c_info);
        $s_yywj = $cd_customer->query("select cd_yywj from oa_cd_customer where id = {$id}")[0]['cd_yywj'];
        $s_yywj = json_decode($s_yywj);
        $this->assign("yywj", $s_yywj);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function customer_cdyw()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function customer_cdyw_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $id = $_GET['id'];

        $baseinfo = M("cd_customer");
        $b_info = $baseinfo->query("select * from oa_cd_customer where id = {$id}");
        $this->assign("cd_name", $b_info[0]['cd_name']);
        $this->assign("cd_sfz", $b_info[0]['cd_idcard']);
        //查询出客户的业务信息
        $customer = M("cdbusiness");
        $sql = "select * from oa_cdbusiness as c where  c.cd_id = {$id}";
        $c_info = $customer->query($sql);
        $this->assign("c_info", $c_info);

        //查询出客户相关图片的地址
        $s_ht = json_decode($c_info[0]['cd_yywj']);
        $this->assign("yywj", $s_ht);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }


    public function customer_cdyw_update_by_b_id()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $id = $_GET['id'];


        //查询出客户的业务信息
        $customer = M("cdbusiness");
        $sql = "select * from oa_cdbusiness as c where  c.id = {$id}";
        $c_info = $customer->query($sql);
        $this->assign("c_info", $c_info);
        $baseinfo = M("cd_customer");
        $b_info = $baseinfo->query("select * from oa_cd_customer where id = {$c_info[0]['cd_id']}");
        $this->assign('cd_id', $b_info[0]['id']);
        $this->assign("cd_name", $b_info[0]['cd_name']);
        $this->assign("cd_sfz", $b_info[0]['cd_idcard']);
        //查询出客户相关图片的地址
        $s_ht = json_decode($c_info[0]['cd_yywj']);
        $this->assign("yywj", $s_ht);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function do_customer_cd_add()
    {
        //获取当前操作员的id
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));

        $data = array(
            'c_uid' => $Uid,
            'cd_name' => $_POST['cd_name'],
            'cd_idcard' => $_POST['cd_idcard'],
            'cd_sex' => $_POST['cd_sex'],
            'cd_mz' => $_POST['cd_mz'],
            'cd_fwxz' => $_POST['cd_fwxz'],
            'cd_gzdw' => $_POST['cd_gzdw'],
            'cd_zw' => $_POST['cd_zw'],
            'cd_hkszd' => $_POST['cd_hkszd'],
            'cd_sfzszd' => $_POST['cd_sfzszd'],
            'cd_sjzz' => $_POST['cd_sjzz'],
            'cd_lxfs' => $_POST['cd_lxfs'],
            'cd_hyzk' => $_POST['cd_hyzk'],
            'cd_poxm' => $_POST['cd_poxm'],
            'cd_posfzh' => $_POST['cd_posfzh'],
            'cd_polxfs' => $_POST['cd_polxfs'],
            'cd_ponsr' => $_POST['cd_ponsr'],
            'cd_pogzdw' => $_POST['cd_pogzdw'],
            'cd_pozw' => $_POST['cd_pozw'],
            'cd_bz' => $_POST['cd_bz'],
            'cd_qpinfo' => json_encode($_POST['cd_qpinfoarray']),
            'cd_updatetime' => time(),
            'cd_time' => time(),
            'cd_yywj' => json_encode($_POST['cd_yywj']),
        );
        $map['cd_idcard'] = $_POST['cd_idcard'];
        if (M('cd_customer')->where($map)->select() != "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '客户信息已存在'), 'json');
        } else if (M('cd_customer')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
    }


/////////////////////////////////////////////////////////
    public function do_edit_cd_customer()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_AJAX) _404('页面不存在', U('index'));
        $id = $_POST['id'];
        $customer = M("cd_customer");


        $data['cd_name'] = $_POST['cd_name'];
        $data['cd_idcard'] = $_POST['cd_idcard'];
        $data['cd_sex'] = $_POST['cd_sex'];
        $data['cd_mz'] = $_POST['cd_mz'];
        $data['cd_fwxz'] = $_POST['cd_fwxz'];
        $data['cd_gzdw'] = $_POST['cd_gzdw'];
        $data['cd_zw'] = $_POST['cd_zw'];
        $data['cd_hkszd'] = $_POST['cd_hkszd'];
        $data['cd_sfzszd'] = $_POST['cd_sfzszd'];
        $data['cd_sjzz'] = $_POST['cd_sjzz'];
        $data['cd_lxfs'] = $_POST['cd_lxfs'];
        $data['cd_hyzk'] = $_POST['cd_hyzk'];
        $data['cd_poxm'] = $_POST['cd_poxm'];
        $data['cd_posfzh'] = $_POST['cd_posfzh'];
        $data['cd_polxfs'] = $_POST['cd_polxfs'];
        $data['cd_ponsr'] = $_POST['cd_ponsr'];
        $data['cd_pogzdw'] = $_POST['cd_pogzdw'];
        $data['cd_pozw'] = $_POST['cd_pozw'];
        $data['cd_bz'] = $_POST['cd_bz'];
        $data['cd_qpinfo'] = json_encode($_POST['cd_qpinfoarray']);
        $data['cd_yywj'] = json_encode($_POST['cd_yywj']);
        $data['cd_updatetime'] = time();

        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }
    }

//////////////////////////////////////////////////////////////////////////////////
    public function do_cdyw()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        //获取当前操作员的id
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));

        //获取客户的id

        $customername = I('cd_name');
        $customersfzh = I('cd_cardid');
        $x_p_map['cd_name'] = $customername;
        $x_p_map['cd_idcard'] = $customersfzh;
        if (M('cd_customer')->where($x_p_map)->select()[0]['id'] != null) {//个人且存在记录
            $id = M('cd_customer')->where("cd_idcard = '{$customersfzh}'")->select()[0]['id'];
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '该客户尚未有客户基本信息'), 'json');
        }
        $data = array(
            'cd_id' => $id,
            'c_uid' => $Uid,
            'cd_updatetime' => time(),
            'cd_time' => time(),
            'cd_cardid' => $_POST['cd_cardid'],
            'cd_clppxh' => $_POST['cd_clppxh'],
            'cd_cph' => $_POST['cd_cph'],
            'cd_djh' => $_POST['cd_djh'],
            'cd_clys' => $_POST['cd_clys'],
            'cd_fjrq' => $_POST['cd_fjrq'],
            'cd_dkxx' => $_POST['cd_dkxx'],
            'cd_bxgsmc' => $_POST['cd_bxgsmc'],
            'cd_bxje' => $_POST['cd_bxje'],
            'cd_bdrq' => $_POST['cd_bdrq'],
            'cd_clssx' => $_POST['cd_clssx'],
            'cd_qcdqx' => $_POST['cd_qcdqx'],
            'cd_zrssx' => $_POST['cd_zrssx'],
            'cd_bjmptyx' => $_POST['cd_bjmptyx'],
            'cd_qtbxje' => $_POST['cd_qtbxje'],
            'cd_qtbxmc' => $_POST['cd_qtbxmc'],
            'cd_dkyh' => $_POST['cd_dkyh'],
            'cd_hkkh' => $_POST['cd_hkkh'],
            'cd_dkje' => $_POST['cd_dkje'],
            'cd_hfds' => $_POST['cd_hfds'],
            'cd_dkqx' => $_POST['cd_dkqx'],
            'cd_dkffr' => $_POST['cd_dkffr'],
            'cd_dkdqr' => $_POST['cd_dkdqr'],
            'cd_dkbl' => $_POST['cd_dkbl'],
            'cd_flbz' => $_POST['cd_flbz'],
            'cd_yywj' => json_encode($_POST['cd_yywj']),
        );
        $map['cd_id'] = $id;

        if (M('cdbusiness')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }

    }

    public function customer_query()
    {
        $Uid = $_SESSION['UserId'];
        $field_name = $_GET['field_name'];

        $value = $_GET['value'];
        $new_filed = substr($field_name, 0, 4);
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        $cd_customer = M("cd_customer");
        if ($field_name == "cd_dkffr" || $field_name == "cd_dkdqr") {
            $sql = "select * from oa_cdbusiness as x where x." . $field_name . " >= '{$startdate}' and x." . $field_name . " <= '{$enddate}' and x.cd_del <> 1";
            $c_info = M('cdbusiness')->query($sql);
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                if (M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0]) {
                    $infoarray[$i] = M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } elseif ($field_name == "cd_cph") {
            $sql = "select * from oa_cdbusiness WHERE {$field_name} = '{$value}' and cd_del = 0";
            $c_info = M('cdbusiness')->query($sql);
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                if (M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0]) {
                    $infoarray[$i] = M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } elseif ($field_name == "cd_dkyh") {
            preg_match_all("/./u", $value, $arr);
            $sql = "select * from oa_cdbusiness WHERE {$field_name} like '%" . $arr[0][0] . "%'";
            for ($i = 1; $i < count($arr[0]); $i++) {
                $sql = $sql . "AND cd_dkyh like '%" . $arr[0][$i] . "%' ";
            }
            $sql = $sql . " and cd_del = 0";
            $c_info = M('cdbusiness')->query($sql);
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                if (M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0]) {
                    $infoarray[$i] = M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } elseif ($field_name == 'cd_hmd') {
            $sql = "select * from oa_cdbusiness WHERE cd_jd = 2";
            $c_info = M('cdbusiness')->query($sql);
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                if (M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0]) {
                    $infoarray[$i] = M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } else {
//            $sql = "select * from oa_cd_customer as x where x." . $field_name . " = '{$value}' and x.c_uid = {$Uid} and x.cd_del <> 1";
//            $c_info1 = $cd_customer->query($sql);
//            $count = M('cdbusiness')->where("cd_id = '{$c_info1[0]['id']}' AND cd_del = 0")->count();
////            var_dump($count);
//            $infoarray = array();
//            if($count == 0){}
//            else {
//                for($i = 0;$i<=count($c_info1);$i++){
//                    if(M('cd_customer')->where("id = {$c_info1[$i]['cd_id']}")->select()[0]) {
//                        $infoarray[] = M('cd_customer')->where("id = {$c_info1[$i]['cd_id']}")->select()[0];
//                    }
//                }
//                $count1 = count($c_info1);
//                $page1 = new Page($count1, 10);
//                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
//                $this->assign("c_info", $infoarray);
//            }
            $sql = "select * from oa_cd_customer as x where x." . $field_name . " = '{$value}' and x.cd_del <> 1";
            $c_info = M('cd_customer')->query($sql);
            $c_info = M('cdbusiness')->where("cd_id = {$c_info[0]['id']}")->select();
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                if (M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0]) {
                    $infoarray[$i] = M('cd_customer')->where("id = {$c_info[$i]['cd_id']}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
//            var_dump($infoarray);
            $this->assign("c_info", $infoarray);
        }
//        var_dump($infoarray);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function do_cdyw_update()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_AJAX) _404('页面不存在', U('index'));
        $id = $_POST['id'];
        $cardid = $_POST['cd_cardid'];

        $customer = M("cdbusiness");

        $data = array(
            'cd_id' => M('cd_customer')->where("cd_idcard = {$cardid}")->select()[0]['id'],
            'c_uid' => $Uid,
            'cd_updatetime' => time(),
            'cd_clppxh' => $_POST['cd_clppxh'],
            'cd_cph' => $_POST['cd_cph'],
            'cd_djh' => $_POST['cd_djh'],
            'cd_clys' => $_POST['cd_clys'],
            'cd_fjrq' => $_POST['cd_fjrq'],
            'cd_dkxx' => $_POST['cd_dkxx'],
            'cd_bxgsmc' => $_POST['cd_bxgsmc'],
            'cd_bxje' => $_POST['cd_bxje'],
            'cd_bdrq' => $_POST['cd_bdrq'],
            'cd_clssx' => $_POST['cd_clssx'],
            'cd_qcdqx' => $_POST['cd_qcdqx'],
            'cd_zrssx' => $_POST['cd_zrssx'],
            'cd_bjmptyx' => $_POST['cd_bjmptyx'],
            'cd_qtbxje' => $_POST['cd_qtbxje'],
            'cd_qtbxmc' => $_POST['cd_qtbxmc'],
            'cd_dkyh' => $_POST['cd_dkyh'],
            'cd_hkkh' => $_POST['cd_hkkh'],
            'cd_dkje' => $_POST['cd_dkje'],
            'cd_dkqx' => $_POST['cd_dkqx'],
            'cd_dkffr' => $_POST['cd_dkffr'],
            'cd_dkdqr' => $_POST['cd_dkdqr'],
            'cd_dkbl' => $_POST['cd_dkbl'],
            'cd_hkfs' => $_POST['cd_hkfs'],
            'cd_flbz' => $_POST['cd_flbz'],
            'cd_jd' => $_POST['cd_jd'],
            'cd_yywj' => json_encode($_POST['cd_yywj']),
        );

        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }

    }

    public function hascustomer()
    {
        $sfzh = I('sfzh');
        $count = M('cd_customer')->where("cd_idcard = '{$sfzh}'")->count();
        $customer = M('cd_customer')->where("cd_idcard = '{$sfzh}' and cd_del = 1")->select();
        $customer1 = M('cd_customer')->where("cd_idcard = '{$sfzh}'")->select();
        if ($count == 0) {
            if (count($customer) == 0 || !$customer) {
                $this->ajaxReturn(array('status' => 1), 'json');
            } else {
                $this->ajaxReturn(array('status' => 3, 'c_id' => $customer[0]['id'], 'type' => 'cd'), 'json');
            }
        } else {
            $this->ajaxReturn(array('status' => 0, 'id' => $customer1[0]['id']), 'json');
        }
    }

    public function del_customer()
    {
        $Uid = $_SESSION['UserId'];
        $id = I('id');
        if (M('cdbusiness')->where("cd_id = {$id} and cd_status = 1")->count() == 0) {
            if (M('cd_customer')->where("id = {$id}")->setField('cd_del', 1)) {
                M('cdbusiness')->where("cd_id = {$id} and cd_status <> 1")->delete();
                M('cd_customer')->where("id = {$id}")->setField('del_u_id', $Uid);
                $this->success("删除成功", U('customer'));
            } else {
                $this->error("删除出错", U('customer'));
            }
        } else {
            $this->error("该客户尚存在业务，无法删除");
        }
    }

    public function del_yw()
    {
        $id = I('id');
        if (M('cdbusiness')->where("id = {$id}")->delete()) {
            $this->success("删除成功", U('customer'));
        } else {
            $this->error("删除出错", U('customer'));
        }
    }

    public function recoverycustomer()
    {
        $c_id = I('c_id');
        if (M('cd_customer')->where("id={$c_id}")->setField('cd_del', '0')) {
            $this->ajaxReturn(array('status' => 1, 'error' => ''), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
        }
    }

    public function customer_baseinfo()
    {
        $c_data = M('cd_customer')->where("cd_del = 0")->order("id desc")->select();
        $this->assign('c_data', $c_data);
        $this->display();
    }

    public function customer_base_query()
    {
        $Uid = $_SESSION['UserId'];
        $field_name = $_GET['field_name'];
        $value = $_GET['value'];
        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        $sql = "select * from oa_cd_customer as x where x." . $field_name . " = '{$value}' and x.cd_del <> 1";
        $c_info = M()->query($sql);
        $count1 = count($c_info);
        $page1 = new Page($count1, 10);
        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
        $this->assign("c_info", $c_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }
}