<?php

class YejiAction extends CommonAction
{
    public $pp;

    function __construct()
    {
        if (!isset($_SESSION['Login']) && ($_SESSION['Login'] != true)) {
            $this->redirect('Login/login');
        }

        $Uid = $_SESSION['UserId'];
        $permissions = M("permissions");

        //获取到当前用户对OA管理模块的操作权限
        $pp = $permissions->where("p_column_id = 7 and p_uid = {$Uid}")->find();
        $p_column_sonName = $pp['p_column_sonName'];
        $p_column_son = $pp['p_column_son'];

        $p_column_son = explode(",", $p_column_son);
        $p_column_sonName = explode("|", $p_column_sonName);

        $shqx = $permissions->where("p_column_id = 7 and p_uid = {$Uid}")->find();
        $this->shqx = explode(",", $shqx['p_column_son']);
        $this->pp = $p_column_son;
    }

    public function yeji()
    {

        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        $this->assign('dept', $department);
        if ($department) {
            $xdbusiness = M('xdbusiness')->where("x_del = 0 AND x_status = 1 and x_jd != 2")->select();
            $cdbusiness = M('cdbusiness')->where("cd_del = 0 and cd_jd != 2")->select();
            $dbgrbusiness = M('dbgrbusiness')->where("d_del = 0 AND d_status = 1 and d_jd != 2")->select();
            $dbqybusiness = M('dbqybusiness')->where("d_del = 0 AND d_status = 1 and d_jd != 2")->select();
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' => $cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('data', $data);
            $this->assign('zj', number_format($zj)."元");
            $this->display();
        } else {
            $xdbusiness = M('xdbusiness')->where("c_uid = {$Uid} AND x_del = 0 AND x_status = 1 and x_jd != 2")->select();
            $cdbusiness = M('cdbusiness')->where("c_uid = {$Uid} AND cd_del = 0 and cd_jd != 2")->select();
            $dbgrbusiness = M('dbgrbusiness')->where("c_uid = {$Uid} AND d_del = 0 AND d_status = 1 and d_jd != 2")->select();
            $dbqybusiness = M('dbqybusiness')->where("c_uid = {$Uid} AND d_del = 0 AND d_status = 1 and d_jd != 2")->select();
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' => $cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('data', $data);
            $this->assign('zj', number_format($zj)."元");
            $this->display();
        }
    }

    public function yeji_query()
    {

        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        $filed_name = $_GET['field_name'];
        $value = $_GET['value'];
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        if ($filed_name == "u_name") {
            $xdbusiness = M('xdbusiness')->query("select * from oa_xdbusiness where c_uid = (select u_id from oa_employees where u_name = '" . $value . "') and x_del = 0 and x_status = 1 and x_jd  != 2");
            $cdbusiness = M('cdbusiness')->query("select * from oa_cdbusiness where c_uid = (select u_id from oa_employees where u_name = '" . $value . "') and cd_del = 0 and cd_jd  != 2");
            $dbgrbusiness = M('dbgrbusiness')->query("select * from oa_dbgrbusiness where c_uid = (select u_id from oa_employees where u_name = '" . $value . "') and d_del = 0 and d_status = 1 and d_jd != 2");
            $dbqybusiness = M('dbqybusiness')->query("select * from oa_dbqybusiness where c_uid = (select u_id from oa_employees where u_name = '" . $value . "') and d_del = 0 and d_status = 1 and d_jd  != 2");
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' =>$cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('zj', number_format($zj)."元");
            $this->assign('data', $data);
        } else if ($filed_name == "fksj") {
            $xdbusiness = M('xdbusiness')->query("select * from oa_xdbusiness where x_dkqsrq>='{$startdate}' and x_dkqsrq<='{$enddate}' and x_del = 0 and x_jd != 2 and x_status = 1");
            $cdbusiness = M('cdbusiness')->query("select * from oa_cdbusiness where cd_dkffr>='{$startdate}' and cd_dkffr<='{$enddate}' and cd_del = 0 and cd_jd  != 2");
            $dbgrbusiness = M('dbgrbusiness')->query("select * from oa_dbgrbusiness where d_dkqsrq>='{$startdate}' and d_dkqsrq<='{$enddate}' and d_del =0 and d_jd != 2 and d_status = 1");
            $dbqybusiness = M('dbqybusiness')->query("select * from oa_dbqybusiness where d_dkqsrq>='{$startdate}' and d_dkqsrq<='{$enddate}' and d_del =0 and d_jd  != 2 and d_status = 1");
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' => $cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('zj', number_format($zj)."元");
            $this->assign('data', $data);
        } else if ($filed_name == "dqsj") {
            $xdbusiness = M('xdbusiness')->query("select * from oa_xdbusiness where x_dkjsrq>='{$startdate}' and x_dkjsrq<='{$enddate}' and x_del =0 and x_status = 1 and x_jd != 2");
            $cdbusiness = M('cdbusiness')->query("select * from oa_cdbusiness where cd_dkdqr>='{$startdate}' and cd_dkdqr<='{$enddate}' and cd_del = 0 and cd_jd != 2");
            $dbgrbusiness = M('dbgrbusiness')->query("select * from oa_dbgrbusiness where d_dkjsrq>='{$startdate}' and d_dkjsrq<='{$enddate}' and d_del =0 and d_status = 1 and d_jd != 2");
            $dbqybusiness = M('dbqybusiness')->query("select * from oa_dbqybusiness where d_dkjsrq>='{$startdate}' and d_dkjsrq<='{$enddate}' and d_del = 0 and d_status = 1 and d_jd != 2");
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' => $cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('zj', number_format($zj)."元");
            $this->assign('data', $data);
        }
        $this->display();
    }

    public function recoverycustomer()
    {
        $x_p_customer = M('x_p_customer')->where("x_p_del = 1")->select();
        $x_e_customer = M('x_e_customer')->where("x_e_del = 1")->select();
        $cd_customer = M('cd_customer')->where("cd_del = 1")->select();
        $d_p_customer = M('d_p_customer')->where("d_p_del = 1")->select();
        $d_e_customer = M('d_e_customer')->where("d_e_del = 1")->select();
        $data = array();

        for($i = 0;$i<count($x_p_customer);$i++){
            $data[] = array(
                'xm' => $x_p_customer[$i]['x_p_name'],
                'c_id' => $x_p_customer[$i]['id'],
                'sfzh' => $x_p_customer[$i]['x_p_idcard'],
                'u_id' => M('employees')->where("u_id = {$x_p_customer[$i]['c_uid']}")->select()[0]['u_name'],
                'del_u_id' => M('employees')->where("u_id = {$x_p_customer[$i]['del_u_id']}")->select()[0]['u_name'],
                'type' => 'xp'
            );
        }
        for($i = 0;$i<count($x_e_customer);$i++){
            $data[] = array(
                'xm' => $x_e_customer[$i]['x_e_name'],
                'c_id' => $x_e_customer[$i]['id'],
                'sfzh' => $x_e_customer[$i]['x_e_frsfzh'],
                'u_id' => M('employees')->where("u_id = {$x_e_customer[$i]['c_uid']}")->select()[0]['u_name'],
                'del_u_id' => M('employees')->where("u_id = {$x_e_customer[$i]['del_u_id']}")->select()[0]['u_name'],
                'type' => 'xe'
            );
        }
        for($i = 0;$i<count($cd_customer);$i++){
            $data[] = array(
                'xm' => $cd_customer[$i]['cd_name'],
                'c_id' => $cd_customer[$i]['id'],
                'sfzh' => $cd_customer[$i]['cd_idcard'],
                'u_id' => M('employees')->where("u_id = {$cd_customer[$i]['c_uid']}")->select()[0]['u_name'],
                'del_u_id' => M('employees')->where("u_id = {$cd_customer[$i]['del_u_id']}")->select()[0]['u_name'],
                'type' => 'cd'
            );
        }
        for($i = 0;$i<count($d_p_customer);$i++){
            $data[] = array(
                'xm' => $d_p_customer[$i]['d_p_name'],
                'c_id' => $d_p_customer[$i]['id'],
                'sfzh' => $d_p_customer[$i]['d_p_idcard'],
                'u_id' => M('employees')->where("u_id = {$d_p_customer[$i]['c_uid']}")->select()[0]['u_name'],
                'del_u_id' => M('employees')->where("u_id = {$d_p_customer[$i]['del_u_id']}")->select()[0]['u_name'],
                'type' => 'dp'
            );
        }
        for($i = 0;$i<count($d_e_customer);$i++){
            $data[] = array(
                'xm' => $d_e_customer[$i]['d_e_name'],
                'c_id' => $d_e_customer[$i]['id'],
                'sfzh' => $d_e_customer[$i]['d_e_frsfzh'],
                'u_id' => M('employees')->where("u_id = {$d_e_customer[$i]['c_uid']}")->select()[0]['u_name'],
                'del_u_id' => M('employees')->where("u_id = {$d_e_customer[$i]['del_u_id']}")->select()[0]['u_name'],
                'type' => 'de'
            );
        }



        $this->assign("data",$data);
        $this->display();

    }

    public function do_rec_customer(){
        $type = I('type');
        $id = I('id');
        if($type == 'xp'){
            if(M('x_p_customer')->where("id = {$id}")->setField("x_p_del",0)){
                $this->success("成功恢复已删除客户");
            }else{
                $this->error("恢复失败，请联系管理员");
            }
        } else if($type == 'xe'){
            if(M('x_e_customer')->where("id = {$id}")->setField("x_e_del",0)){
                $this->success("成功恢复已删除客户");
            }else{
                $this->error("恢复失败，请联系管理员");
            }
        }else if($type == 'cd'){
            if(M('cd_customer')->where("id = {$id}")->setField("cd_del",0)){
                $this->success("成功恢复已删除客户");
            }else{
                $this->error("恢复失败，请联系管理员");
            }
        }else if($type == 'dp'){
            if(M('d_p_customer')->where("id = {$id}")->setField("d_p_del",0)){
                $this->success("成功恢复已删除客户");
            }else{
                $this->error("恢复失败，请联系管理员");
            }
        }else if($type == 'de'){
            if(M('d_e_customer')->where("id = {$id}")->setField("d_e_del",0)){
                $this->success("成功恢复已删除客户");
            }else{
                $this->error("恢复失败，请联系管理员");
            }
        }


    }


    public function createyj()
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $list = M("Test");
        $rs = $list->select();
        $i = 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '姓名')
            ->setCellValue('B1', '年龄')
            ->setCellValue('C1', '性别')
            ->setCellValue('D1', '身份证号码')
            ->setCellValue('E1', '国籍')
            ->setCellValue('F1', '民族')
            ->setCellValue('G1', '详细地址');
        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($rs as $k => $v) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $v['name'])
                ->setCellValue('B' . $i, $v['old'])
                ->setCellValue('C' . $i, $v['sex'])
                ->setCellValue('D' . $i, $v['sid'])
                ->setCellValue('E' . $i, $v['guoji'])
                ->setCellValue('F' . $i, $v['minzu'])
                ->setCellValue('G' . $i, $v['address']);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('student');//设置sheet标签的名称
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();  //清空缓存
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename=11.xls');//设置文件的名称
        header("Content-Transfer-Encoding:binary");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function yeji_print()
    {

        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        $this->assign('dept', $department);
        if ($department) {
            $xdbusiness = M('xdbusiness')->where("x_del = 0 AND x_status = 1")->select();
            $cdbusiness = M('cdbusiness')->where("cd_del = 0")->select();
            $dbgrbusiness = M('dbgrbusiness')->where("d_del = 0 AND d_status = 1")->select();
            $dbqybusiness = M('dbqybusiness')->where("d_del = 0 AND d_status = 1")->select();
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' => $cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('data', $data);
            $this->assign('zj', number_format($zj)."元");
            $this->display();
        } else {
            $xdbusiness = M('xdbusiness')->where("c_uid = {$Uid} AND x_del = 0 AND x_status = 1")->select();
            $cdbusiness = M('cdbusiness')->where("c_uid = {$Uid} AND cd_del = 0")->select();
            $dbgrbusiness = M('dbgrbusiness')->where("c_uid = {$Uid} AND d_del = 0 AND d_status = 1")->select();
            $dbqybusiness = M('dbqybusiness')->where("c_uid = {$Uid} AND d_del = 0 AND d_status = 1")->select();
            $data = array();
            for ($i = 0; $i < count($xdbusiness); $i++) {
                $type = substr($xdbusiness[$i]['x_id'], 0, 1);
                $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
                if ($type == 1) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                } else if ($type == 2) {
                    $data[] = array('employeename' => M('employees')->where("u_id = {$xdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                        'customername' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                        'dkje' => $xdbusiness[$i]['x_dkje'],
                        'dkqx' => $xdbusiness[$i]['x_qx'],
                        'fkrq' => $xdbusiness[$i]['x_dkqsrq'],
                        'dqsj' => $xdbusiness[$i]['x_dkjsrq']);
                }
            }
            for ($i = 0; $i < count($cdbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$cdbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                    'dkje' => $cdbusiness[$i]['cd_dkje'],
                    'dkqx' => $cdbusiness[$i]['cd_qx'],
                    'fkrq' => $cdbusiness[$i]['cd_dkffr'],
                    'dqsj' => $cdbusiness[$i]['cd_dkdqr']);
            }
            for ($i = 0; $i < count($dbgrbusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbgrbusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                    'dkje' => $dbgrbusiness[$i]['d_dkje'],
                    'dkqx' => $dbgrbusiness[$i]['d_qx'],
                    'fkrq' => $dbgrbusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbgrbusiness[$i]['d_dkjsrq']);
            }
            for ($i = 0; $i < count($dbqybusiness); $i++) {
                $data[] = array('employeename' => M('employees')->where("u_id = {$dbqybusiness[$i]['c_uid']}")->select()[0]['u_name'],
                    'customername' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                    'dkje' => $dbqybusiness[$i]['d_dkje'],
                    'dkqx' => $dbqybusiness[$i]['d_qx'],
                    'fkrq' => $dbqybusiness[$i]['d_dkqsrq'],
                    'dqsj' => $dbqybusiness[$i]['d_dkjsrq']);
            }
            $zj = 0;
            for($i = 0;$i<count($data);$i++){
                $zj = $zj + $data[$i]['dkje'];
            }
            $this->assign('data', $data);
            $this->assign('zj', number_format($zj)."元");
            $this->display();
        }
    }

    function do_phy_del(){
        $id = I('id');
        $type = I('type');
        if($type == 'xp'){
            if(M('x_p_customer')->where("id = {$id}")->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }elseif($type == 'xe'){
            if(M('x_e_customer')->where("id = {$id}")->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }elseif($type == 'cd'){
            if(M('cd_customer')->where("id = {$id}")->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }elseif($type == 'dp'){
            if(M('d_p_customer')->where("id = {$id}")->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }elseif($type == 'de'){
            if(M('d_e_customer')->where("id = {$id}")->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }

    }

}