<?php

class CustomerdbAction extends CommonAction
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
        $pp = $permissions->where("p_column_id = 3 and p_uid = {$Uid}")->find();
        $p_column_sonName = $pp['p_column_sonName'];
        $p_column_son = $pp['p_column_son'];

        $p_column_son = explode(",", $p_column_son);
        $p_column_sonName = explode("|", $p_column_sonName);
        $shqx = $permissions->where("p_column_id = 6 and p_uid = {$Uid}")->find();
        $this->shqx = explode(",", $shqx['p_column_son']);
        $this->pp = $p_column_son;
    }

    public function customer_d_p_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function do_customer_d_p_add()
    {
        //获取当前操作员的id
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));

        $data = array(
            'c_uid' => $Uid,
            'd_p_name' => $_POST['d_p_name'],
            'd_p_idcard' => $_POST['d_p_idcard'],
            'd_p_sex' => $_POST['d_p_sex'],
            'd_p_mz' => $_POST['d_p_mz'],
            'd_p_jkzk' => $_POST['d_p_jkzk'],
            'd_p_gzdw' => $_POST['d_p_gzdw'],
            'd_p_zw' => $_POST['d_p_zw'],
            'd_p_hkzz' => $_POST['d_p_hkzz'],
            'd_p_sfzzz' => $_POST['d_p_sfzzz'],
            'd_p_sjzz' => $_POST['d_p_sjzz'],
            'd_p_lxfs' => $_POST['d_p_lxfs'],
            'd_p_hyzk' => $_POST['d_p_hyzk'],
            'd_p_poxm' => $_POST['d_p_poxm'],
            'd_p_posfzh' => $_POST['d_p_posfzh'],
            'd_p_polxfs' => $_POST['d_p_polxfs'],
            'd_p_posr' => $_POST['d_p_posr'],
            'd_p_pogzqk' => $_POST['d_p_pogzqk'],
            'd_p_pozw' => $_POST['d_p_pozw'],
            'd_p_bz' => $_POST['d_p_bz'],
            'd_p_jtzhnsr' => $_POST['d_p_jtzhnsr'],
            'd_p_mxzc' => $_POST['d_p_mxzc'],
            'd_p_yhck' => $_POST['d_p_yhck'],
            'd_p_fwxz' => $_POST['d_p_fwxz'],
            'd_p_fwxqjz' => $_POST['d_p_fwxqjz'],
            'd_p_clxhjz' => $_POST['d_p_clxhjz'],
            'd_p_jtqtsr' => $_POST['d_p_jtqtsr'],
            'd_p_jtqtsrbz' => $_POST['d_p_jtqtsrbz'],
            'd_p_xyked' => $_POST['d_p_xyked'],
            'd_p_xykfz' => $_POST['d_p_xykfz'],
            'd_p_yhajdk' => $_POST['d_p_yhajdk'],
            'd_p_mjjd' => $_POST['d_p_mjjd'],
            'd_p_dwdbqk' => $_POST['d_p_dwdbqk'],
            'd_p_qpinfo' => json_encode($_POST['d_p_qpinfoarray']),
            'd_p_clxx' => json_encode($_POST['d_p_clxx']),
            'd_p_fwxx' => json_encode($_POST['d_p_fwxx']),
            'd_p_yywj' => json_encode($_POST['d_p_yywj']),
            'd_p_updatetime' => time(),
            'd_p_time' => time(),
        );
        $map['d_p_idcard'] = $_POST['d_p_idcard'];
        if (M('d_p_customer')->where($map)->select() != "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '客户信息已存在'), 'json');
        } else if (M('d_p_customer')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
    }

    public function customer_d_p_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->assign('enter', I('enter'));

        $id = I('id');
        //查询出客户的详细信息
        $d_p_customer = M("d_p_customer");
        $sql = "select * from oa_d_p_customer as c where  c.id = {$id}";
        $c_info = $d_p_customer->query($sql);
        $qpinfo = $d_p_customer->query("select d_p_qpinfo from oa_d_p_customer where id = {$id}")[0]['d_p_qpinfo'];
        $clinfo = $d_p_customer->query("select d_p_clxx from oa_d_p_customer where id = {$id}")[0]['d_p_clxx'];
        $fwinfo = $d_p_customer->query("select d_p_fwxx from oa_d_p_customer where id = {$id}")[0]['d_p_fwxx'];
        $s_yywj = $d_p_customer->query("select d_p_yywj from oa_d_p_customer where id = {$id}")[0]['d_p_yywj'];
        $s_yywj = json_decode($s_yywj);
        $this->assign("yywj", $s_yywj);
        $this->assign("qpinfo", json_decode($qpinfo, true));
        $this->assign("fwxx", json_decode($fwinfo, true));
        $this->assign("clxx", json_decode($clinfo, true));
        $this->assign("c_info", $c_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function do_customer_d_p_update()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));

        $data = array(
            'c_uid' => $Uid,
            'd_p_name' => $_POST['d_p_name'],
            'd_p_idcard' => $_POST['d_p_idcard'],
            'd_p_sex' => $_POST['d_p_sex'],
            'd_p_mz' => $_POST['d_p_mz'],
            'd_p_jkzk' => $_POST['d_p_jkzk'],
            'd_p_gzdw' => $_POST['d_p_gzdw'],
            'd_p_zw' => $_POST['d_p_zw'],
            'd_p_hkzz' => $_POST['d_p_hkzz'],
            'd_p_sfzzz' => $_POST['d_p_sfzzz'],
            'd_p_sjzz' => $_POST['d_p_sjzz'],
            'd_p_lxfs' => $_POST['d_p_lxfs'],
            'd_p_hyzk' => $_POST['d_p_hyzk'],
            'd_p_poxm' => $_POST['d_p_poxm'],
            'd_p_posfzh' => $_POST['d_p_posfzh'],
            'd_p_polxfs' => $_POST['d_p_polxfs'],
            'd_p_posr' => $_POST['d_p_posr'],
            'd_p_pogzqk' => $_POST['d_p_pogzqk'],
            'd_p_pozw' => $_POST['d_p_pozw'],
            'd_p_bz' => $_POST['d_p_bz'],
            'd_p_jtzhnsr' => $_POST['d_p_jtzhnsr'],
            'd_p_mxzc' => $_POST['d_p_mxzc'],
            'd_p_yhck' => $_POST['d_p_yhck'],
            'd_p_fwxz' => $_POST['d_p_fwxz'],
            'd_p_fwxqjz' => $_POST['d_p_fwxqjz'],
            'd_p_clxhjz' => $_POST['d_p_clxhjz'],
            'd_p_jtqtsr' => $_POST['d_p_jtqtsr'],
            'd_p_jtqtsrbz' => $_POST['d_p_jtqtsrbz'],
            'd_p_xyked' => $_POST['d_p_xyked'],
            'd_p_xykfz' => $_POST['d_p_xykfz'],
            'd_p_yhajdk' => $_POST['d_p_yhajdk'],
            'd_p_mjjd' => $_POST['d_p_mjjd'],
            'd_p_dwdbqk' => $_POST['d_p_dwdbqk'],
            'd_p_qpinfo' => json_encode($_POST['d_p_qpinfoarray']),
            'd_p_yywj' => json_encode($_POST['d_p_yywj']),
            'd_p_updatetime' => time(),
        );
        $id = I('id');
        $customer = M('d_p_customer');
        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }
    }

    public function customer_d_e_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function do_customer_d_e_add()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');

        $data = array(
            'c_uid' => $Uid,
            'd_e_name' => $_POST['d_e_name'],
            'd_e_yyzzh' => $_POST['d_e_yyzzh'],
            'd_e_sudjzh' => $_POST['d_e_sudjzh'],
            'd_e_zzjgdmzh' => $_POST['d_e_zzjgdmzh'],
            'd_e_frxm' => $_POST['d_e_frxm'],
            'd_e_frsfzh' => $_POST['d_e_frsfzh'],
            'd_e_frsjzz' => $_POST['d_e_frsjzz'],
            'd_e_frhjzz' => $_POST['d_e_frhjzz'],
            'd_e_frlxfs' => $_POST['d_e_frlxfs'],
            'd_e_frhyzk' => $_POST['d_e_frhyzk'],
            'd_e_frpoxm' => $_POST['d_e_frpoxm'],
            'd_e_frposfzh' => $_POST['d_e_frposfzh'],
            'd_e_frpohjzz' => $_POST['d_e_frpohjzz'],
            'd_e_frpolxfs' => $_POST['d_e_frpolxfs'],
            'd_e_gdinfo' => json_encode($_POST['d_e_gdinfoarray']),
            'd_e_fwxx' => json_encode($_POST['d_e_fwxx']),
            'd_e_clxx' => json_encode($_POST['d_e_clxx']),
            'd_e_dkkh' => $_POST['d_e_dkkh'],
            'd_e_khxkzh' => $_POST['d_e_khxkzh'],
            'd_e_jgxydmzh' => $_POST['d_e_jgxydmzh'],
            'd_e_aqscxkzmc' => $_POST['d_e_aqscxkzmc'],
            'd_e_aqscxkzhm' => $_POST['d_e_aqscxkzhm'],
            'd_e_pwxkzmc' => $_POST['d_e_pwxkzmc'],
            'd_e_pwxkzhm' => $_POST['d_e_pwxkzhm'],
            'd_e_fczhm' => $_POST['d_e_fczhm'],
            'd_e_tdsyzhm' => $_POST['d_e_tdsyzhm'],
            'd_e_jycsszd' => $_POST['d_e_jycsszd'],
            'd_e_qysnzsr' => $_POST['d_e_qysnzsr'],
            'd_e_zczgm' => $_POST['d_e_zczgm'],
            'd_e_qtsrbz' => $_POST['d_e_qtsrbz'],
            'd_e_yhfzye' => $_POST['d_e_yhfzye'],
            'd_e_mjjdye' => $_POST['d_e_mjjdye'],
            'd_e_dwdbed' => $_POST['d_e_dwdbed'],
            'd_e_yyzz' => json_encode($_POST['d_e_yyzz']),
            'd_e_swdjz' => json_encode($_POST['d_e_swdjz']),
            'd_e_zzjgdmz' => json_encode($_POST['d_e_zzjgdmz']),
            'd_e_gszc' => json_encode($_POST['d_e_gszc']),
            'd_e_frzj' => json_encode($_POST['d_e_frzj']),
            'd_e_gdsfzfyj' => json_encode($_POST['d_e_gdsfzfyj']),
            'd_e_dkkfyj' => json_encode($_POST['d_e_dkkfyj']),
            'd_e_khxkz' => json_encode($_POST['d_e_khxkz']),
            'd_e_jgxydmz' => json_encode($_POST['d_e_jgxydmz']),
            'd_e_hyxkz' => json_encode($_POST['d_e_hyxkz']),
            'd_e_aqpwxkz' => json_encode($_POST['d_e_aqpwxkz']),
            'd_e_qyjbhyhls' => json_encode($_POST['d_e_qyjbhyhls']),
            'd_e_gxht' => json_encode($_POST['d_e_gxht']),
            'd_e_bb' => json_encode($_POST['d_e_bb']),
            'd_e_yywj' => json_encode($_POST['d_e_yywj']),
            'd_e_updatetime' => time(),
            'd_e_time' => time(),
        );
        $map['d_e_name'] = $_POST['d_e_name'];
        if (M('d_e_customer')->where($map)->select() != "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '公司已存在'), 'json');
        } else if (M('d_e_customer')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
    }

    public function customer_d_e_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->assign('enter', I('enter'));

        $id = $_GET['id'];

        //查询出客户的详细信息
        $d_e_customer = M("d_e_customer");
        $sql = "select * from oa_d_e_customer as c where  c.id = {$id}";
        $c_info = $d_e_customer->query($sql);
        $this->assign("c_info", $c_info);
        $gdinfo = $d_e_customer->query("select d_e_gdinfo from oa_d_e_customer where id = {$id}")[0]['d_e_gdinfo'];
        $this->assign('gdinfo', json_decode($gdinfo));
        $fwxx = $d_e_customer->query("select d_e_fwxx from oa_d_e_customer where id = {$id}")[0]['d_e_fwxx'];
        $this->assign('fwxx', json_decode($fwxx, true));
        $clxx = $d_e_customer->query("select d_e_clxx from oa_d_e_customer where id = {$id}")[0]['d_e_clxx'];
        $this->assign('clxx', json_decode($clxx, true));
        //查询出客户相关图片的地址
        $s_qyjbhyhls = $d_e_customer->query("select d_e_qyjbhyhls from oa_d_e_customer where id = {$id}")[0]['d_e_qyjbhyhls'];
        $s_gxht = $d_e_customer->query("select d_e_gxht from oa_d_e_customer where id = {$id}")[0]['d_e_gxht'];
        $s_bb = $d_e_customer->query("select d_e_bb from oa_d_e_customer where id = {$id}")[0]['d_e_bb'];
        $s_yyzz = $d_e_customer->query("select d_e_yyzz from oa_d_e_customer where id = {$id}")[0]['d_e_yyzz'];
        $s_swdjz = $d_e_customer->query("select d_e_swdjz from oa_d_e_customer where id = {$id}")[0]['d_e_swdjz'];
        $s_zzjgdmz = $d_e_customer->query("select d_e_zzjgdmz from oa_d_e_customer where id = {$id}")[0]['d_e_zzjgdmz'];
        $s_gszc = $d_e_customer->query("select d_e_gszc from oa_d_e_customer where id = {$id}")[0]['d_e_gszc'];
        $s_frzj = $d_e_customer->query("select d_e_frzj from oa_d_e_customer where id = {$id}")[0]['d_e_frzj'];
        $s_gdsfzfyj = $d_e_customer->query("select d_e_gdsfzfyj from oa_d_e_customer where id = {$id}")[0]['d_e_gdsfzfyj'];
        $s_dkkfyj = $d_e_customer->query("select d_e_dkkfyj from oa_d_e_customer where id = {$id}")[0]['d_e_dkkfyj'];
        $s_khxkz = $d_e_customer->query("select d_e_khxkz from oa_d_e_customer where id = {$id}")[0]['d_e_khxkz'];
        $s_jgxydmz = $d_e_customer->query("select d_e_jgxydmz from oa_d_e_customer where id = {$id}")[0]['d_e_jgxydmz'];
        $s_hyxkz = $d_e_customer->query("select d_e_hyxkz from oa_d_e_customer where id = {$id}")[0]['d_e_hyxkz'];
        $s_aqpwxkz = $d_e_customer->query("select d_e_aqpwxkz from oa_d_e_customer where id = {$id}")[0]['d_e_aqpwxkz'];
        $s_yywj = $d_e_customer->query("select d_e_yywj from oa_d_e_customer where id = {$id}")[0]['d_e_yywj'];
        $s_qyjbhyhls = json_decode($s_qyjbhyhls);
        $s_gxht = json_decode($s_gxht);
        $s_bb = json_decode($s_bb);
        $s_yyzz = json_decode($s_yyzz);
        $s_swdjz = json_decode($s_swdjz);
        $s_zzjgdmz = json_decode($s_zzjgdmz);
        $s_gszc = json_decode($s_gszc);
        $s_frzj = json_decode($s_frzj);
        $s_gdsfzfyj = json_decode($s_gdsfzfyj);
        $s_dkkfyj = json_decode($s_dkkfyj);
        $s_khxkz = json_decode($s_khxkz);
        $s_jgxydmz = json_decode($s_jgxydmz);
        $s_hyxkz = json_decode($s_hyxkz);
        $s_aqpwxkz = json_decode($s_aqpwxkz);
        $s_yywj = json_decode($s_yywj);

        $this->assign("qyjbhyhls", $s_qyjbhyhls);
        $this->assign("gxht", $s_gxht);
        $this->assign("bb", $s_bb);
        $this->assign("yyzz", $s_yyzz);
        $this->assign("swdjz", $s_swdjz);
        $this->assign("zzjgdmz", $s_zzjgdmz);
        $this->assign("gszc", $s_gszc);
        $this->assign("frzj", $s_frzj);
        $this->assign("gdsfzfyj", $s_gdsfzfyj);
        $this->assign("dkkfyj", $s_dkkfyj);
        $this->assign("khxkz", $s_khxkz);
        $this->assign("jgxydmz", $s_jgxydmz);
        $this->assign("hyxkz", $s_hyxkz);
        $this->assign("aqpwxkz", $s_aqpwxkz);
        $this->assign("yywj", $s_yywj);

        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function do_customer_d_e_update()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');

        $data = array(
            'c_uid' => $Uid,
            'd_e_name' => $_POST['d_e_name'],
            'd_e_yyzzh' => $_POST['d_e_yyzzh'],
            'd_e_sudjzh' => $_POST['d_e_sudjzh'],
            'd_e_zzjgdmzh' => $_POST['d_e_zzjgdmzh'],
            'd_e_frxm' => $_POST['d_e_frxm'],
            'd_e_frsfzh' => $_POST['d_e_frsfzh'],
            'd_e_frsjzz' => $_POST['d_e_frsjzz'],
            'd_e_frhjzz' => $_POST['d_e_frhjzz'],
            'd_e_frlxfs' => $_POST['d_e_frlxfs'],
            'd_e_frhyzk' => $_POST['d_e_frhyzk'],
            'd_e_frpoxm' => $_POST['d_e_frpoxm'],
            'd_e_frposfzh' => $_POST['d_e_frposfzh'],
            'd_e_frpohjzz' => $_POST['d_e_frpohjzz'],
            'd_e_frpolxfs' => $_POST['d_e_frpolxfs'],
            'd_e_gdinfo' => json_encode($_POST['d_e_gdinfoarray']),
            'd_e_fwxx' => json_encode($_POST['d_e_fwxx']),
            'd_e_clxx' => json_encode($_POST['d_e_clxx']),
            'd_e_dkkh' => $_POST['d_e_dkkh'],
            'd_e_khxkzh' => $_POST['d_e_khxkzh'],
            'd_e_jgxydmzh' => $_POST['d_e_jgxydmzh'],
            'd_e_aqscxkzmc' => $_POST['d_e_aqscxkzmc'],
            'd_e_aqscxkzhm' => $_POST['d_e_aqscxkzhm'],
            'd_e_pwxkzmc' => $_POST['d_e_pwxkzmc'],
            'd_e_pwxkzhm' => $_POST['d_e_pwxkzhm'],
            'd_e_fczhm' => $_POST['d_e_fczhm'],
            'd_e_tdsyzhm' => $_POST['d_e_tdsyzhm'],
            'd_e_jycsszd' => $_POST['d_e_jycsszd'],
            'd_e_qysnzsr' => $_POST['d_e_qysnzsr'],
            'd_e_zczgm' => $_POST['d_e_zczgm'],
            'd_e_qtsrbz' => $_POST['d_e_qtsrbz'],
            'd_e_yhfzye' => $_POST['d_e_yhfzye'],
            'd_e_mjjdye' => $_POST['d_e_mjjdye'],
            'd_e_dwdbed' => $_POST['d_e_dwdbed'],
            'd_e_yyzz' => json_encode($_POST['d_e_yyzz']),
            'd_e_swdjz' => json_encode($_POST['d_e_swdjz']),
            'd_e_zzjgdmz' => json_encode($_POST['d_e_zzjgdmz']),
            'd_e_gszc' => json_encode($_POST['d_e_gszc']),
            'd_e_frzj' => json_encode($_POST['d_e_frzj']),
            'd_e_gdsfzfyj' => json_encode($_POST['d_e_gdsfzfyj']),
            'd_e_dkkfyj' => json_encode($_POST['d_e_dkkfyj']),
            'd_e_khxkz' => json_encode($_POST['d_e_khxkz']),
            'd_e_jgxydmz' => json_encode($_POST['d_e_jgxydmz']),
            'd_e_hyxkz' => json_encode($_POST['d_e_hyxkz']),
            'd_e_aqpwxkz' => json_encode($_POST['d_e_aqpwxkz']),
            'd_e_qyjbhyhls' => json_encode($_POST['d_e_qyjbhyhls']),
            'd_e_gxht' => json_encode($_POST['d_e_gxht']),
            'd_e_bb' => json_encode($_POST['d_e_bb']),
            'd_e_yywj' => json_encode($_POST['d_e_yywj']),
            'd_e_updatetime' => time(),
        );

        $id = I('id');
        $customer = M('d_e_customer');
        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }

    }

    public function customer_dbywgr()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $shqx = 1;
        } else {
            $shqx = 0;
        }
        $this->assign('sh', $shqx);
        $this->display();
    }

    public function do_customer_dbywgr()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');


        $map['d_p_idcard'] = $_POST['d_cardid'];
        if (M('d_p_customer')->where($map)->select() == "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '该客户尚未添加基础信息'), 'json');
        } else {
            $id = M('d_p_customer')->where($map)->select()[0]['id'];
        }
        $data = array(
            'c_uid' => $Uid,
            'd_id' => $id,
            'Id' => get_AI_ID(),
            'd_name' => $_POST['d_name'],
            'd_cardid' => $_POST['d_cardid'],
            'd_khlx' => $_POST['d_khlx'],
            'd_sqzl' => $_POST['d_sqzl'],
            'd_fwpgbg' => $_POST['d_fwpgbg'],
            'd_fwdx' => $_POST['d_fwdx'],
            'd_fl' => $_POST['d_fl'],
            'd_zldd' => $_POST['d_zldd'],
            'd_sqrnl' => $_POST['d_sqrnl'],
            'd_sqrsr' => $_POST['d_sqrsr'],
            'd_sqrgzdd' => $_POST['d_sqrgzdd'],
            'd_dkzsyt' => $_POST['d_dkzsyt'],
            'd_gthkrnl' => $_POST['d_gthkrnl'],
            'd_gthkrsr' => $_POST['d_gthkrsr'],
            'd_gthkrgzdd' => $_POST['d_gthkrgzdd'],
            'd_dbf' => $_POST['d_dbf'],
            'd_bzj' => $_POST['d_bzj'],
            'd_fkrq' => $_POST['d_fkrq'],
            'd_hkgd' => $_POST['d_hkgd'],
            'd_sdkc' => $_POST['d_sdkc'],
            'd_xy_name' => $_POST['d_xy_name'],
            'd_xy_idcard' => $_POST['d_xy_idcard'],
            'd_xy_lxdh' => $_POST['d_xy_lxdh'],
            'd_xy_sfzdz' => $_POST['d_xy_sfzdz'],
            'd_dkje' => $_POST['d_dkje'],
            'd_dkyh' => $_POST['d_dkyh'],
            'd_hkfs' => $_POST['d_hkfs'],
            'd_dblv' => $_POST['d_dblv'],
            'd_pz_idcard' => $_POST['d_pz_idcard'],
            'd_pz_lxdh' => $_POST['d_pz_lxdh'],
            'd_pz_hm' => $_POST['d_pz_hm'],
            'd_pz_mzje' => $_POST['d_pz_mzje'],
            'd_pz_kbxrq' => $_POST['d_pz_kbxrq'],
            'd_pz_pgjg' => $_POST['d_pz_pgjg'],
            'd_gjs_name' => $_POST['d_gjs_name'],
            'd_gjs_idcard' => $_POST['d_gjs_idcard'],
            'd_gjs_lxdh' => $_POST['d_gjs_lxdh'],
            'd_gjs_pgjg' => $_POST['d_gjs_pgjg'],
            'd_qt_name' => $_POST['d_qt_name'],
            'd_qt_idcard' => $_POST['d_qt_idcard'],
            'd_qt_lxdh' => $_POST['d_qt_lxdh'],
            'd_qt_pgjg' => $_POST['d_qt_pgjg'],
            'd_c_syqr' => $_POST['d_c_syqr'],
            'd_c_syqrsfzh' => $_POST['d_c_syqrsfzh'],
            'd_c_syqrlxdh' => $_POST['d_c_syqrlxdh'],
            'd_c_ph' => $_POST['d_c_ph'],
            'd_c_pp' => $_POST['d_c_pp'],
            'd_c_xh' => $_POST['d_c_xh'],
            'd_c_nx' => $_POST['d_c_nx'],
            'd_c_jz' => $_POST['d_c_jz'],
            'd_c_ywaj' => $_POST['d_c_ywaj'],
            'd_c_yhajje' => $_POST['d_c_yhajje'],
            'd_fw_syqr' => $_POST['d_fw_syqr'],
            'd_fw_syqrsfzh' => $_POST['d_fw_syqrsfzh'],
            'd_fw_syqrlxdh' => $_POST['d_fw_syqrlxdh'],
            'd_fw_fczh' => $_POST['d_fw_fczh'],
            'd_fw_tdzh' => $_POST['d_fw_tdzh'],
            'd_fw_mj' => $_POST['d_fw_mj'],
            'd_fw_dd' => $_POST['d_fw_dd'],
            'd_fkyh' => $_POST['d_fkyh'],
            'd_fw_pgjz' => $_POST['d_fw_pgjz'],
            'd_fw_ywaj' => $_POST['d_fw_ywaj'],
            'd_fw_yhajje' => $_POST['d_fw_yhajje'],
            'd_fw_ywgyr' => $_POST['d_fw_ywgyr'],
            'd_fw_gyrxm' => $_POST['d_fw_gyrxm'],
            'd_fw_gyrsfzh' => $_POST['d_fw_gyrsfzh'],
            'd_fw_gyrlxfs' => $_POST['d_fw_gyrlxfs'],
            'd_fw_fwsfcgdsr' => $_POST['d_fw_fwsfcgdsr'],
            'd_fw_zlqsrq' => $_POST['d_fw_zlqsrq'],
            'd_fw_zlzzrq' => $_POST['d_fw_zlzzrq'],
            'd_fw_zlrxm' => $_POST['d_fw_zlrxm'],
            'd_fw_zlrsfzh' => $_POST['d_fw_zlrsfzh'],
            'd_fw_zlrlxfs' => $_POST['d_fw_zlrlxfs'],
            'd_ht' => json_encode($_POST['d_ht']),
            'd_lv' => $_POST['d_lv'],
            'd_dkqsrq' => $_POST['d_dkqsrq'],
            'd_dkjsrq' => $_POST['d_dkjsrq'],
            'd_yt' => $_POST['d_yt'],
            'd_hzyh' => $_POST['d_hzyh'],
            'uniquetag' => $_POST['uniquetag'],
            'd_hkdj' => 0,
            'd_updatetime' => time(),
            'd_time' => time(),
            'd_status' => '0',
        );
        $map['d_p_idcard'] = $_POST['d_cardid'];
        if (M('d_p_customer')->where($map)->select() == "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '该客户尚未添加基础信息'), 'json');
        } else if (M('dbgrbusiness')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
    }

    public function customer_dbywgr_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $shqx = 1;
        } else {
            $shqx = 0;
        }
        $this->assign('sh', $shqx);
        $id = I('id');
        $b_info = M('d_p_customer')->where("id = {$id}")->select();
        $c_info = M('dbgrbusiness')->where("d_id = {$id}")->select();
        $s_ht = M('dbgrbusiness')->query("select d_ht from oa_dbgrbusiness where d_id = {$id}")[0]['d_ht'];
        $s_ht = json_decode($s_ht);
        $this->assign('ht', $s_ht);
        $this->assign('b_info', $b_info);
        $this->assign('c_info', $c_info);
        $this->display();
    }

    public function customer_dbywgr_update_by_b_id()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $shqx = 1;
        } else {
            $shqx = 0;
        }
        $this->assign('enter', I('enter'));
        $this->assign('sh', $shqx);
        $id = I('id');
        $c_info = M('dbgrbusiness')->where("Id = {$id}")->select();
        $b_info = M('d_p_customer')->where("id = {$c_info[0]['d_id']}")->select();
        $s_ht = M('dbgrbusiness')->query("select d_ht from oa_dbgrbusiness where Id = {$id}")[0]['d_ht'];
        $s_ht = json_decode($s_ht);
        $this->assign('ht', $s_ht);
        $this->assign('b_info', $b_info);
        $this->assign('c_info', $c_info);
        $this->display();
    }

    public function customer_dbywqy_update_by_b_id()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[2] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $shqx = 1;
        } else {
            $shqx = 0;
        }
        $this->assign('enter', I('enter'));
        $this->assign('sh', $shqx);
        $id = I('id');
        $c_info = M('dbqybusiness')->where("Id = {$id}")->select();
        $b_info = M('d_e_customer')->where("id = {$c_info[0]['d_id']}")->select();
        $s_ht = M('dbgrbusiness')->query("select d_ht from oa_dbqybusiness where Id = {$id}")[0]['d_ht'];
        $s_ht = json_decode($s_ht);
        $this->assign('ht', $s_ht);
        $this->assign('b_info', $b_info);
        $this->assign('c_info', $c_info);
        $this->display();
    }

    public function do_customer_dbywgr_update()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');


        $data = array(
//            'c_uid' => $Uid,
            'd_id' => I('b_id'),
            'd_name' => $_POST['d_name'],
            'd_cardid' => $_POST['d_cardid'],
            'd_khlx' => $_POST['d_khlx'],
            'd_sqzl' => $_POST['d_sqzl'],
            'd_fwpgbg' => $_POST['d_fwpgbg'],
            'd_fwdx' => $_POST['d_fwdx'],
            'd_fl' => $_POST['d_fl'],
            'd_zldd' => $_POST['d_zldd'],
            'd_sqrnl' => $_POST['d_sqrnl'],
            'd_sqrsr' => $_POST['d_sqrsr'],
            'd_sqrgzdd' => $_POST['d_sqrgzdd'],
            'd_dkzsyt' => $_POST['d_dkzsyt'],
            'd_gthkrnl' => $_POST['d_gthkrnl'],
            'd_gthkrsr' => $_POST['d_gthkrsr'],
            'd_gthkrgzdd' => $_POST['d_gthkrgzdd'],
            'd_dbf' => $_POST['d_dbf'],
            'd_bzj' => $_POST['d_bzj'],
            'd_fkrq' => $_POST['d_fkrq'],
            'd_hkgd' => $_POST['d_hkgd'],
            'd_sdkc' => $_POST['d_sdkc'],
            'd_dblv' => $_POST['d_dblv'],
            'd_xy_name' => $_POST['d_xy_name'],
            'd_xy_idcard' => $_POST['d_xy_idcard'],
            'd_xy_lxdh' => $_POST['d_xy_lxdh'],
            'd_xy_sfzdz' => $_POST['d_xy_sfzdz'],
            'd_xy_sjzz' => $_POST['d_xy_sjzz'],
            'd_pz_name' => $_POST['d_pz_name'],
            'd_pz_idcard' => $_POST['d_pz_idcard'],
            'd_pz_lxdh' => $_POST['d_pz_lxdh'],
            'd_pz_hm' => $_POST['d_pz_hm'],
            'd_pz_mzje' => $_POST['d_pz_mzje'],
            'd_pz_kbxrq' => $_POST['d_pz_kbxrq'],
            'd_pz_pgjg' => $_POST['d_pz_pgjg'],
            'd_fkyh' => $_POST['d_fkyh'],
            'd_gjs_name' => $_POST['d_gjs_name'],
            'd_gjs_idcard' => $_POST['d_gjs_idcard'],
            'd_gjs_lxdh' => $_POST['d_gjs_lxdh'],
            'd_gjs_pgjg' => $_POST['d_gjs_pgjg'],
            'd_qt_name' => $_POST['d_qt_name'],
            'd_qt_idcard' => $_POST['d_qt_idcard'],
            'd_qt_lxdh' => $_POST['d_qt_lxdh'],
            'd_dkyh' => $_POST['d_dkyh'],
            'd_dkje' => $_POST['d_dkje'],
            'd_c_syqrsfzh' => $_POST['d_c_syqrsfzh'],
            'd_c_syqrlxdh' => $_POST['d_c_syqrlxdh'],
            'd_c_ph' => $_POST['d_c_ph'],
            'd_c_pp' => $_POST['d_c_pp'],
            'd_c_xh' => $_POST['d_c_xh'],
            'd_c_nx' => $_POST['d_c_nx'],
            'd_c_jz' => $_POST['d_c_jz'],
            'd_c_ywaj' => $_POST['d_c_ywaj'],
            'd_c_yhajje' => $_POST['d_c_yhajje'],
            'd_fw_syqr' => $_POST['d_fw_syqr'],
            'd_fw_syqrsfzh' => $_POST['d_fw_syqrsfzh'],
            'd_fw_syqrlxdh' => $_POST['d_fw_syqrlxdh'],
            'd_fw_fczh' => $_POST['d_fw_fczh'],
            'd_fw_tdzh' => $_POST['d_fw_tdzh'],
            'd_fw_mj' => $_POST['d_fw_mj'],
            'd_fw_dd' => $_POST['d_fw_dd'],
            'd_fw_pgjz' => $_POST['d_fw_pgjz'],
            'd_fw_ywaj' => $_POST['d_fw_ywaj'],
            'd_fw_yhajje' => $_POST['d_fw_yhajje'],
            'd_fw_ywgyr' => $_POST['d_fw_ywgyr'],
            'd_fw_gyrxm' => $_POST['d_fw_gyrxm'],
            'd_fw_gyrsfzh' => $_POST['d_fw_gyrsfzh'],
            'd_fw_gyrlxfs' => $_POST['d_fw_gyrlxfs'],
            'd_fw_fwsfcgdsr' => $_POST['d_fw_fwsfcgdsr'],
            'd_fw_zlqsrq' => $_POST['d_fw_zlqsrq'],
            'd_fw_zlzzrq' => $_POST['d_fw_zlzzrq'],
            'd_fw_zlrxm' => $_POST['d_fw_zlrxm'],
            'd_fw_zlrsfzh' => $_POST['d_fw_zlrsfzh'],
            'd_fw_zlrlxfs' => $_POST['d_fw_zlrlxfs'],
            'd_ht' => json_encode($_POST['d_ht']),
            'd_updatetime' => time(),
            'd_status' => $_POST['d_status'],
            'd_shxx' => $_POST['d_shxx'],
            'd_hkfs' => $_POST['d_hkfs'],
            'd_lv' => $_POST['d_lv'],
            'd_dkqsrq' => $_POST['d_dkqsrq'],
            'd_dkjsrq' => $_POST['d_dkjsrq'],
            'd_yt' => $_POST['d_yt'],
            'd_hzyh' => $_POST['d_hzyh'],
            'd_jd' => $_POST['d_jd'],
            'd_hkdj' => $_POST['d_hkdj']

        );

        $id = I('businessid');
        $customer = M('dbgrbusiness');
        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }
    }

    public function customer_dbywqy()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[3] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function do_customer_dbywqy()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');

        $map['d_e_zzjgdmzh'] = $_POST['d_cardid'];
        if (M('d_e_customer')->where($map)->select() == "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '该客户尚未添加基础信息'), 'json');
        } else {
            $id = M('d_e_customer')->where($map)->select()[0]['id'];
        }

        $data = array(
            'c_uid' => $Uid,
            'd_id' => $id,
            'Id' => get_AI_ID(),
            'd_sbgswj' => json_encode($_POST['d_sbgswj']),
            'd_dbf' => $_POST['d_dbf'],
            'd_bzj' => $_POST['d_bzj'],
            'd_fkrq' => $_POST['d_fkrq'],
            'd_hkgd' => $_POST['d_hkgd'],
            'd_ht' => json_encode($_POST['d_ht']),
            'd_sdkc' => $_POST['d_sdkc'],
            'd_xy_name' => $_POST['d_xy_name'],
            'd_xy_idcard' => $_POST['d_xy_idcard'],
            'd_xy_lxdh' => $_POST['d_xy_lxdh'],
            'd_xy_sfzdz' => $_POST['d_xy_sfzdz'],
            'd_xy_sjzz' => $_POST['d_xy_sjzz'],
            'd_pz_name' => $_POST['d_pz_name'],
            'd_pz_idcard' => $_POST['d_pz_idcard'],
            'd_pz_lxdh' => $_POST['d_pz_lxdh'],
            'd_pz_hm' => $_POST['d_pz_hm'],
            'd_pz_mzje' => $_POST['d_pz_mzje'],
            'd_pz_kbxrq' => $_POST['d_pz_kbxrq'],
            'd_pz_pgjg' => $_POST['d_pz_pgjg'],
            'd_gjs_name' => $_POST['d_gjs_name'],
            'd_gjs_idcard' => $_POST['d_gjs_idcard'],
            'd_gjs_lxdh' => $_POST['d_gjs_lxdh'],
            'd_dkyh' => $_POST['d_dkyh'],
            'd_dkje' => $_POST['d_dkje'],
            'd_qt_name' => $_POST['d_qt_name'],
            'd_dblv' => $_POST['d_dblv'],
            'd_qt_idcard' => $_POST['d_qt_idcard'],
            'd_fkyh' => $_POST['d_fkyh'],
            'd_qt_lxdh' => $_POST['d_qt_lxdh'],
            'd_qt_pgjg' => $_POST['d_qt_pgjg'],
            'd_c_syqr' => $_POST['d_c_syqr'],
            'd_c_syqrsfzh' => $_POST['d_c_syqrsfzh'],
            'd_c_syqrlxdh' => $_POST['d_c_syqrlxdh'],
            'd_c_ph' => $_POST['d_c_ph'],
            'd_c_pp' => $_POST['d_c_pp'],
            'd_c_xh' => $_POST['d_c_xh'],
            'd_c_nx' => $_POST['d_c_nx'],
            'd_c_jz' => $_POST['d_c_jz'],
            'd_c_ywaj' => $_POST['d_c_ywaj'],
            'd_c_yhajje' => $_POST['d_c_yhajje'],
            'd_fw_syqr' => $_POST['d_fw_syqr'],
            'd_fw_syqrsfzh' => $_POST['d_fw_syqrsfzh'],
            'd_fw_syqrlxdh' => $_POST['d_fw_syqrlxdh'],
            'd_fw_fczh' => $_POST['d_fw_fczh'],
            'd_fw_tdzh' => $_POST['d_fw_tdzh'],
            'd_fw_mj' => $_POST['d_fw_mj'],
            'd_fw_dd' => $_POST['d_fw_dd'],
            'd_fw_pgjz' => $_POST['d_fw_pgjz'],
            'd_fw_ywaj' => $_POST['d_fw_ywaj'],
            'd_fw_yhajje' => $_POST['d_fw_yhajje'],
            'd_fw_ywgyr' => $_POST['d_fw_ywgyr'],
            'd_fw_gyrxm' => $_POST['d_fw_gyrxm'],
            'd_fw_gyrsfzh' => $_POST['d_fw_gyrsfzh'],
            'd_fw_gyrlxfs' => $_POST['d_fw_gyrlxfs'],
            'd_fw_fwsfcgdsr' => $_POST['d_fw_fwsfcgdsr'],
            'd_fw_zlqsrq' => $_POST['d_fw_zlqsrq'],
            'd_fw_zlzzrq' => $_POST['d_fw_zlzzrq'],
            'd_fw_zlrxm' => $_POST['d_fw_zlrxm'],
            'd_fw_zlrsfzh' => $_POST['d_fw_zlrsfzh'],
            'd_fw_zlrlxfs' => $_POST['d_fw_zlrlxfs'],
            'd_updatetime' => time(),
            'd_time' => time(),
            'd_hkfs' => $_POST['d_hkfs'],
            'd_lv' => $_POST['d_lv'],
            'd_dkqsrq' => $_POST['d_dkqsrq'],
            'd_dkjsrq' => $_POST['d_dkjsrq'],
            'd_yt' => $_POST['d_yt'],
            'd_hzyh' => $_POST['d_hzyh'],
            'uniquetag' => $_POST['uniquetag'],
            'd_status' => '0',
            'd_hkdj' => 0
        );
        $map['d_e_zzjgdmzh'] = $_POST['d_cardid'];
        if (M('d_e_customer')->where($map)->select() == "") {
            $this->ajaxReturn(array('status' => 0, 'error' => '该客户尚未添加基础信息'), 'json');
        } else if (M('dbqybusiness')->data($data)->add()) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库添加失败'), 'json');
        }
    }

    public function customer_dbywqy_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[3] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $shqx = 1;
        } else {
            $shqx = 0;
        }
        $this->assign('sh', $shqx);
        $this->assign('sh', $shqx);
        $id = I('id');
        $b_info = M('d_e_customer')->where("id = {$id}")->select();
        $c_info = M('dbqybusiness')->where("d_id = {$id}")->select();
        $s_ht = M('dbqybusiness')->query("select d_ht from oa_dbqybusiness where d_id = {$id}")[0]['d_ht'];
        $d_sbgswj = M('dbqybusiness')->query("select d_sbgswj from oa_dbqybusiness where d_id = {$id}")[0]['d_sbgswj'];
        $s_ht = json_decode($s_ht);
        $d_sbgswj = json_decode($d_sbgswj);
        $this->assign('ht', $s_ht);
        $this->assign('sbgswj', $d_sbgswj);
        $this->assign('b_info', $b_info);
        $this->assign('c_info', $c_info);
        $this->display();
    }

    public function do_customer_dbywqy_update()
    {
        $Uid = $_SESSION['UserId'];
        if (!IS_POST) _404('页面不存在', U('index'));
        if (!IS_AJAX) halt('页面不存在');

        $data = array(
//            'c_uid' => $Uid,
            'd_id' => I('b_id'),
            'd_sbgswj' => json_encode($_POST['d_sbgswj']),
            'd_dbf' => $_POST['d_dbf'],
            'd_bzj' => $_POST['d_bzj'],
            'd_fkrq' => $_POST['d_fkrq'],
            'd_hkgd' => $_POST['d_hkgd'],
            'd_ht' => json_encode($_POST['d_ht']),
            'd_sdkc' => $_POST['d_sdkc'],
            'd_xy_name' => $_POST['d_xy_name'],
            'd_xy_idcard' => $_POST['d_xy_idcard'],
            'd_xy_lxdh' => $_POST['d_xy_lxdh'],
            'd_dblv' => $_POST['d_dblv'],
            'd_xy_sfzdz' => $_POST['d_xy_sfzdz'],
            'd_xy_sjzz' => $_POST['d_xy_sjzz'],
            'd_pz_name' => $_POST['d_pz_name'],
            'd_pz_idcard' => $_POST['d_pz_idcard'],
            'd_pz_lxdh' => $_POST['d_pz_lxdh'],
            'd_dkyh' => $_POST['d_dkyh'],
            'd_dkje' => $_POST['d_dkje'],
            'd_pz_kbxrq' => $_POST['d_pz_kbxrq'],
            'd_pz_pgjg' => $_POST['d_pz_pgjg'],
            'd_gjs_name' => $_POST['d_gjs_name'],
            'd_fkyh' => $_POST['d_fkyh'],
            'd_gjs_idcard' => $_POST['d_gjs_idcard'],
            'd_gjs_lxdh' => $_POST['d_gjs_lxdh'],
            'd_gjs_pgjg' => $_POST['d_gjs_pgjg'],
            'd_qt_name' => $_POST['d_qt_name'],
            'd_qt_idcard' => $_POST['d_qt_idcard'],
            'd_qt_lxdh' => $_POST['d_qt_lxdh'],
            'd_qt_pgjg' => $_POST['d_qt_pgjg'],
            'd_c_syqr' => $_POST['d_c_syqr'],
            'd_c_syqrsfzh' => $_POST['d_c_syqrsfzh'],
            'd_c_syqrlxdh' => $_POST['d_c_syqrlxdh'],
            'd_c_ph' => $_POST['d_c_ph'],
            'd_c_pp' => $_POST['d_c_pp'],
            'd_c_xh' => $_POST['d_c_xh'],
            'd_c_nx' => $_POST['d_c_nx'],
            'd_c_jz' => $_POST['d_c_jz'],
            'd_c_ywaj' => $_POST['d_c_ywaj'],
            'd_c_yhajje' => $_POST['d_c_yhajje'],
            'd_fw_syqr' => $_POST['d_fw_syqr'],
            'd_fw_syqrsfzh' => $_POST['d_fw_syqrsfzh'],
            'd_fw_syqrlxdh' => $_POST['d_fw_syqrlxdh'],
            'd_fw_fczh' => $_POST['d_fw_fczh'],
            'd_fw_tdzh' => $_POST['d_fw_tdzh'],
            'd_fw_mj' => $_POST['d_fw_mj'],
            'd_fw_dd' => $_POST['d_fw_dd'],
            'd_fw_pgjz' => $_POST['d_fw_pgjz'],
            'd_fw_ywaj' => $_POST['d_fw_ywaj'],
            'd_fw_yhajje' => $_POST['d_fw_yhajje'],
            'd_fw_ywgyr' => $_POST['d_fw_ywgyr'],
            'd_fw_gyrxm' => $_POST['d_fw_gyrxm'],
            'd_fw_gyrsfzh' => $_POST['d_fw_gyrsfzh'],
            'd_fw_gyrlxfs' => $_POST['d_fw_gyrlxfs'],
            'd_fw_fwsfcgdsr' => $_POST['d_fw_fwsfcgdsr'],
            'd_fw_zlqsrq' => $_POST['d_fw_zlqsrq'],
            'd_fw_zlzzrq' => $_POST['d_fw_zlzzrq'],
            'd_fw_zlrxm' => $_POST['d_fw_zlrxm'],
            'd_fw_zlrsfzh' => $_POST['d_fw_zlrsfzh'],
            'd_fw_zlrlxfs' => $_POST['d_fw_zlrlxfs'],
            'd_updatetime' => time(),
            'd_status' => $_POST['d_status'],
            'd_hkfs' => $_POST['d_hkfs'],
            'd_lv' => $_POST['d_lv'],
            'd_dkqsrq' => $_POST['d_dkqsrq'],
            'd_dkjsrq' => $_POST['d_dkjsrq'],
            'd_yt' => $_POST['d_yt'],
            'd_shxx' => $_POST['d_shxx'],
            'd_hzyh' => $_POST['d_hzyh'],
            'd_jd' => $_POST['d_jd'],
            'd_hkdj' => $_POST['d_hkdj'],

        );

        $id = I('businessid');
        $customer = M('dbqybusiness');
        if ($customer->where("id = {$id}")->save($data)) {
            $returndata['status'] = 1;
            $returndata['time'] = date('y-m-d H:i', time());
            $this->ajaxReturn($returndata, 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '数据库操作失败'), 'json');
        }

    }

    public function customer()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[4] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if ($department) {
            $this->Online($_SESSION['UserId']);
            $d_p_customer = M("d_p_customer");
            $c_info_d_p_customer = $d_p_customer->where("d_p_del = 0")->order("d_p_updatetime desc")->select();
            $d_p_data = array();
            for ($i = 0; $i < count($c_info_d_p_customer); $i++) {
                $d_p_business = M('dbgrbusiness')->where("d_id = {$c_info_d_p_customer[$i]['id']} and d_del = 0 AND d_status = 1")->order("d_updatetime desc")->select();
                if (count($d_p_business) == 0) {
//                    $d_p_data[] = array(
//                        'c_id' => $c_info_d_p_customer[$i]['id'],
//                        'xm' => $c_info_d_p_customer[$i]['d_p_name'],
//                        'lxfs' => $c_info_d_p_customer[$i]['d_p_lxfs'],
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($d_p_business); $j++) {
                        $d_p_data[] = array(
                            'b_id' => $d_p_business[$j]['Id'],
                            'c_id' => $c_info_d_p_customer[$i]['id'],
                            'xm' => $c_info_d_p_customer[$i]['d_p_name'],
                            'lxfs' => $c_info_d_p_customer[$i]['d_p_lxfs'],
                        );
                    }
                }
            }
            $d_e_customer = M("d_e_customer");
            $c_info_d_e_customer = $d_e_customer->where("d_e_del = 0")->order("d_e_updatetime desc")->select();
            $d_e_data = array();
            for ($i = 0; $i < count($c_info_d_e_customer); $i++) {
                $d_e_business = M('dbqybusiness')->where("d_id = {$c_info_d_e_customer[$i]['id']} and d_del = 0 AND d_status = 1")->order("d_updatetime desc")->select();
                if (count($d_e_business) == 0) {
//                    $d_e_data[] = array(
//                        'c_id' => $c_info_d_e_customer[$i]['id'],
//                        'xm' => $c_info_d_e_customer[$i]['d_e_name'],
//                        'lxfs' => $c_info_d_e_customer[$i]['d_e_frlxfs'],
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($d_e_business); $j++) {
                        $d_e_data[] = array(
                            'b_id' => $d_e_business[$j]['Id'],
                            'c_id' => $c_info_d_e_customer[$i]['id'],
                            'xm' => $c_info_d_e_customer[$i]['d_e_name'],
                            'lxfs' => $c_info_d_e_customer[$i]['d_e_frlxfs'],
                        );
                    }
                }
            }
            $this->assign("c_info_d_p_customer", $d_p_data);
            $this->assign("c_info_d_e_customer", $d_e_data);
            $this->display();
        } else {
            $this->Online($_SESSION['UserId']);
            $d_p_customer = M("d_p_customer");
            $c_info_d_p_customer = $d_p_customer->where("d_p_del = 0 and c_uid={$Uid}")->order("d_p_updatetime desc")->select();
            $d_p_data = array();
            for ($i = 0; $i < count($c_info_d_p_customer); $i++) {
                $d_p_business = M('dbgrbusiness')->where("d_id = {$c_info_d_p_customer[$i]['id']} and d_del = 0 AND d_status = 1")->order("d_updatetime desc")->select();
                if (count($d_p_business) == 0) {
//                    $d_p_data[] = array(
//                        'c_id' => $c_info_d_p_customer[$i]['id'],
//                        'xm' => $c_info_d_p_customer[$i]['d_p_name'],
//                        'lxfs' => $c_info_d_p_customer[$i]['d_p_lxfs'],
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($d_p_business); $j++) {
                        $d_p_data[] = array(
                            'b_id' => $d_p_business[$j]['Id'],
                            'c_id' => $c_info_d_p_customer[$i]['id'],
                            'xm' => $c_info_d_p_customer[$i]['d_p_name'],
                            'lxfs' => $c_info_d_p_customer[$i]['d_p_lxfs'],
                        );
                    }
                }
            }
            $d_e_customer = M("d_e_customer");
            $c_info_d_e_customer = $d_e_customer->where("d_e_del = 0 and c_uid={$Uid}")->order("d_e_updatetime desc")->select();
            $d_e_data = array();
            for ($i = 0; $i < count($c_info_d_e_customer); $i++) {
                $d_e_business = M('dbqybusiness')->where("d_id = {$c_info_d_e_customer[$i]['id']} and d_del = 0 AND d_status = 1")->order("d_updatetime desc")->select();
                if (count($d_e_business) == 0) {
//                    $d_e_data[] = array(
//                        'c_id' => $c_info_d_e_customer[$i]['id'],
//                        'xm' => $c_info_d_e_customer[$i]['d_e_name'],
//                        'lxfs' => $c_info_d_e_customer[$i]['d_e_frlxfs'],
//                        'b_id' => 0,
//                    );
                } else {
                    for ($j = 0; $j < count($d_e_business); $j++) {
                        $d_e_data[] = array(
                            'b_id' => $d_e_business[$j]['Id'],
                            'c_id' => $c_info_d_e_customer[$i]['id'],
                            'xm' => $c_info_d_e_customer[$i]['d_e_name'],
                            'lxfs' => $c_info_d_e_customer[$i]['d_e_frlxfs'],
                        );
                    }
                }
            }
            $this->assign("c_info_d_p_customer", $d_p_data);
            $this->assign("c_info_d_e_customer", $d_e_data);
            $this->display();
        }
    }

    //查询客户信息处理
    public function customer_query()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[4] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $Uid = $_SESSION['UserId'];
        $field_name = $_GET['field_name'];

        $value = $_GET['value'];
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
        $new_field = substr($field_name, 0, 4);

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        $d_p_customer = M("d_p_customer");
        $d_e_customer = M("d_e_customer");
        if ($new_field == "d_p_" || $new_field == "d_e_") {
            if ($field_name == 'd_p_dkqsrq' || $field_name == 'd_p_dkjsrq') {
                if ($field_name == 'd_p_dkqsrq') {
                    $field_name = 'd_dkqsrq';
                } elseif ($field_name == 'd_p_dkjsrq') {
                    $field_name = 'd_dkjsrq';
                }
                $sql = "select * from oa_dbgrbusiness as x where x." . $field_name . " >= '{$startdate}' and x." . $field_name . " <= '{$enddate}' and x.d_del = 0 and x.d_status = 1";
                $c_info = M('d_p_customer')->query($sql);
                $infoarray = array();
                for ($i = 0; $i <= count($c_info); $i++) {
                    $d_id = $c_info[$i]['d_id'];
                    if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                        $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                        $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                    }
                }
                $count1 = count($c_info);
                $page1 = new Page($count1, 10);
                $this->assign("customertype", "p");
                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                $this->assign("c_info", $infoarray);
            } elseif ($field_name == 'd_e_dkqsrq' || $field_name == 'd_e_dkjsrq') {
                if ($field_name == 'd_e_dkqsrq') {
                    $field_name = 'd_dkqsrq';
                } elseif ($field_name == 'd_e_dkjsrq') {
                    $field_name = 'd_dkjsrq';
                }
                $sql = "select * from oa_dbqybusiness as x where x." . $field_name . " >= '{$startdate}' and x." . $field_name . " <= '{$enddate}' and x.d_del = 0 and x.d_status = 1";
                $c_info = M('d_e_customer')->query($sql);
                $infoarray = array();
                for ($i = 0; $i <= count($c_info); $i++) {
                    $d_id = $c_info[$i]['d_id'];
                    if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                        $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                        $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                    }
                }
                $count1 = count($c_info);
                $page1 = new Page($count1, 10);
                $this->assign("customertype", "e");
                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                $this->assign("c_info", $infoarray);
            } elseif ($field_name == "d_p_dkzt" || $field_name == "d_e_dkzt") {
                if ($field_name == "d_p_dkzt") {
                    if ($value == 1) {
                        $sql = "select * from oa_dbgrbusiness where (d_hkdj = 1 or d_hkdj = 0) and d_del = 0 and d_status = 1";
                        $c_info = M('dbgrbusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "p");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    } elseif ($value == 2) {
                        $sql = "select * from oa_dbgrbusiness where d_jd = 1 and d_del = 0 and d_status = 1";
                        $c_info = M('dbgrbusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "p");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    } elseif ($value == 4) {
                        $sql = "select * from oa_dbgrbusiness where d_hkdj = 4 and d_del = 0 and d_status = 1";
                        $c_info = M('dbgrbusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "p");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    } elseif ($value == 5) {
                        $sql = "select * from oa_dbgrbusiness where d_jd = 2 and d_del = 0 and d_status = 1";
                        $c_info = M('dbgrbusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "p");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    }
                } else if ($field_name == "d_e_dkzt") {
                    if ($value == 1) {
                        $sql = "select * from oa_dbqybusiness where (d_hkdj = 1 or d_hkdj = 0) and d_del = 0 and d_status = 1";
                        $c_info = M('dbqybusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "e");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    } elseif ($value == 2) {
                        $sql = "select * from oa_dbqybusiness where d_jd = 1 and d_del = 0 and d_status = 1";
                        $c_info = M('dbqybusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "e");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    } elseif ($value == 4) {
                        $sql = "select * from oa_dbqybusiness where d_hkdj = 4 and d_del = 0 and d_status = 1";
                        $c_info = M('dbqybusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "e");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    } elseif ($value == 5) {
                        $sql = "select * from oa_dbqybusiness where d_jd = 2 and d_del = 0 and d_status = 1";
                        $c_info = M('dbqybusiness')->query($sql);
                        $infoarray = array();
                        for ($i = 0; $i <= count($c_info); $i++) {
                            $d_id = $c_info[$i]['d_id'];
                            if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                                $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                                $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                            }
                        }
                        $count1 = count($c_info);
                        $page1 = new Page($count1, 10);
                        $this->assign("customertype", "e");
                        $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                        $this->assign("c_info", $infoarray);
                    }
                }
            } elseif ($field_name == 'd_p_hzyh' || $field_name == 'd_e_hzyh') {
                if ($field_name == "d_p_hzyh") {
                    $field_name = "d_hzyh";
                    // $sql = "select * from oa_dbgrbusiness as x where x." . $field_name . " = '{$value}' and x.d_del <> 1";
                    // $c_info = M('d_p_customer')->query($sql);
                    // $infoarray = array();
                    // for ($i = 0; $i <= count($c_info); $i++) {
                    //     $d_id = $c_info[$i]['d_id'];
                    //     if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                    //         $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                    //         $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                    //     }
                    // }
                    // $count1 = count($c_info);
                    // $page1 = new Page($count1, 10);
                    // $this->assign("customertype", "p");
                    // $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    // $this->assign("c_info", $infoarray);

                    preg_match_all("/./u", $value, $arr);
                    $sql = "select * from oa_dbgrbusiness WHERE " . $field_name . " like '%" . $arr[0][0] . "%'";
                    for ($i = 1; $i < count($arr[0]); $i++) {
                        $sql = $sql . "AND " . $field_name . " like '%" . $arr[0][$i] . "%' ";
                    }
                    $sql = $sql . " and d_del = 0 and d_status = 1";
                    // var_dump($sql);
                    $c_info = M('dbgrbusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i <= count($c_info); $i++) {
                        if (M('d_p_customer')->where("id = {$c_info[$i]['d_id']}")->select()[0]) {
                            $infoarray[$i] = M('d_p_customer')->where("id = {$c_info[$i]['d_id']}")->select()[0];
                            $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "p");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                } else if ($field_name == "d_e_hzyh") {
                    $field_name = "d_hzyh";
                    preg_match_all("/./u", $value, $arr);
                    $sql = "select * from oa_dbqybusiness WHERE " . $field_name . " like '%" . $arr[0][0] . "%'";
                    for ($i = 1; $i < count($arr[0]); $i++) {
                        $sql = $sql . "AND " . $field_name . " like '%" . $arr[0][$i] . "%' ";
                    }
                    $sql = $sql . " and d_del = 0 and d_status = 1";
                    // var_dump($sql);
                    $c_info = M('dbqybusiness')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i <= count($c_info); $i++) {
                        if (M('d_e_customer')->where("id = {$c_info[$i]['d_id']}")->select()[0]) {
                            $infoarray[$i] = M('d_e_customer')->where("id = {$c_info[$i]['d_id']}")->select()[0];
                            $infoarray[$i]['b_id'] = $c_info[$i]['id'];
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "e");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
            } elseif ($field_name == 'd_p_hmd' || $field_name == 'd_e_hmd') {
                if ($field_name == 'd_p_hmd') {
                    $sql = "select * from oa_dbgrbusiness WHERE d_jd = 2 and d_status = 1";
                    $c_info = M('d_p_customer')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i <= count($c_info); $i++) {
                        $d_id = $c_info[$i]['d_id'];
                        if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                            $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                            $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "p");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                } else {
                    $sql = "select * from oa_dbqybusiness WHERE d_jd = 2 and d_status = 1";
                    $c_info = M('d_e_customer')->query($sql);
                    $infoarray = array();
                    for ($i = 0; $i <= count($c_info); $i++) {
                        $d_id = $c_info[$i]['d_id'];
                        if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                            $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                            $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                        }
                    }
                    $count1 = count($c_info);
                    $page1 = new Page($count1, 10);
                    $this->assign("customertype", "e");
                    $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
                    $this->assign("c_info", $infoarray);
                }
            }
        }
        if ($field_name == 'd_p_name' || $field_name == 'd_p_idcard') {
//            $sql = "select * from oa_d_p_customer as x where x." . $field_name . " = '{$value}' and x.d_p_del = 0";
//            $c_info = $d_p_customer->query($sql);
//            $count = M('dbgrbusiness')->where("d_id = '{$c_info[0]['id']}'")->count();
//            if($count == 0){}
//            else {
//                $count1 = count($c_info);
//                $page1 = new Page($count1, 10);
//                $this->assign("customertype", "p");
//                $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
//                $this->assign("c_info", $c_info);
//            }
            $sql = "select * from oa_d_p_customer as x where x." . $field_name . " = '{$value}' and x.d_p_del = 0";
            $c_info = M('d_p_customer')->query($sql);
            $c_info = M('dbgrbusiness')->where("d_id = {$c_info[0]['id']} and d_status = 1")->select();
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                $d_id = $c_info[$i]['d_id'];
                if (M('d_p_customer')->where("id = {$d_id}")->select()[0]) {
                    $infoarray[$i] = M('d_p_customer')->where("id = {$d_id}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "p");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        } elseif ($field_name == 'd_e_name' || $field_name == 'd_e_frsfzh') {
            $sql = "select * from oa_d_e_customer as x where x." . $field_name . " = '{$value}' and x.d_e_del = 0";
            $c_info = M('d_e_customer')->query($sql);
            $c_info = M('dbqybusiness')->where("d_id = {$c_info[0]['id']} and d_status = 1")->select();
            $infoarray = array();
            for ($i = 0; $i <= count($c_info); $i++) {
                $d_id = $c_info[$i]['d_id'];
                if (M('d_e_customer')->where("id = {$d_id}")->select()[0]) {
                    $infoarray[$i] = M('d_e_customer')->where("id = {$d_id}")->select()[0];
                    $infoarray[$i]['b_id'] = $c_info[$i]['Id'];
                }
            }
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "e");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $infoarray);
        }
//        var_dump($infoarray);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    public function hascustomer()
    {
        $sfzh = I('sfzh');
        $khlx = I('khlx');
        if ($khlx == 1) {
            $count = M('d_p_customer')->where("d_p_idcard = '{$sfzh}'")->count();
            $customer = M('d_p_customer')->where("d_p_idcard = '{$sfzh}' and d_p_del = 1")->select();
            $customer1 = M('d_p_customer')->where("d_p_idcard = '{$sfzh}'")->select();
        } else if ($khlx == 2) {
            $count = M('d_e_customer')->where("d_e_zzjgdmzh = '{$sfzh}'")->count();
            $customer = M('d_e_customer')->where("d_e_zzjgdmzh = '{$sfzh}' and d_e_del = 1")->select();
            $customer1 = M('d_e_customer')->where("d_e_zzjgdmzh = '{$sfzh}'")->select();
        }
        if ($count == 0) {
            if (count($customer) == 0 || !$customer) {
                $this->ajaxReturn(array('status' => 1), 'json');
            } else {
                $this->ajaxReturn(array('status' => 3, 'c_id' => $customer[0]['id'], 'type' => 'xp'), 'json');
            }
        } else {
            $this->ajaxReturn(array('status' => 0, 'id' => $customer1[0]['id'], 'khlx' => $khlx), 'json');
        }
    }

    public function del_p_customer()
    {
        $Uid = $_SESSION['UserId'];
        $id = I('id');
        if (M('dbgrbusiness')->where("d_id = {$id} and d_status = 1")->count() == 0) {
            if (M('d_p_customer')->where("id = {$id}")->setField('d_p_del', 1)) {
                M('dbgrbusiness')->where("d_id = {$id} and d_status <> 1")->delete();
                M('d_p_customer')->where("id = {$id}")->setField('del_u_id', $Uid);
                $this->success("删除成功", U('customer'));
            } else {
                $this->error("删除出错", U('customer'));
            }
        } else {
            $this->error("该用户尚存在业务，无法删除");
        }
    }

    public function del_e_customer()
    {
        $Uid = $_SESSION['UserId'];
        $id = I('id');
        if (M('dbqybusiness')->where("d_id = {$id} and d_status = 1")->count() == 0) {
            if (M('d_e_customer')->where("id = {$id}")->setField('d_e_del', 1)) {
                M('dbqybusiness')->where("d_id = {$id} and d_status <> 1")->delete();
                M('d_e_customer')->where("id = {$id}")->setField('del_u_id', $Uid);
                $this->success("删除成功", U('customer'));
            } else {
                $this->error("删除出错", U('customer'));
            }
        } else {
            $this->error("该用户尚存在业务，无法删除");
        }
    }

    public function del_p_yw()
    {
        $id = I('id');
        if (M('dbgrbusiness')->where("Id = {$id}")->delete()) {
            $this->success("删除成功", U('customer'));
        } else {
            $this->error("删除出错", U('customer'));
        }
    }

    public function del_e_yw()
    {
        $id = I('id');
        if (M('dbqybusiness')->where("Id = {$id}")->delete()) {
            $this->success("删除成功", U('customer'));
        } else {
            $this->error("删除出错", U('customer'));
        }
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
        $type = I('type');
        if (M('dbw')->where("id = {$id}")->delete()) {
            $data = M('dbw')->query("select * from oa_dbw WHERE parentid = '{$cardid}' and type = {$type}");
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
        if ($type == dp) {
            if (M('d_p_customer')->where("id={$c_id}")->setField('d_p_del', '0')) {
                $this->ajaxReturn(array('status' => 1, 'error' => ''), 'json');
            } else {
                $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
            }
        } else {
            if (M('d_e_customer')->where("id={$c_id}")->setField('d_e_del', '0')) {
                $this->ajaxReturn(array('status' => 1, 'error' => ''), 'json');
            } else {
                $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
            }
        }
    }

    public function customer_d_p_dbr_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->display();
    }

    public function customer_d_p_dbr_update()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $id = I('id');
        $c_info = M('db_dbr')->where("id = {$id}")->select();
        $this->assign("c_info", $c_info);

        $this->display();
    }

    public function do_add_dbr()
    {
        if (!IS_POST) _404('页面不存在', U('index'));

        $cardid = I('idcard');
        $data = array(
            'd_p_parentidcard' => $cardid,
            'd_p_name' => $_POST['d_p_name'],
            'd_p_idcard' => $_POST['d_p_idcard'],
            'd_p_sex' => $_POST['d_p_sex'],
            'd_p_mz' => $_POST['d_p_mz'],
            'd_p_jkzk' => $_POST['d_p_jkzk'],
            'd_p_gzdw' => $_POST['d_p_gzdw'],
            'd_p_zw' => $_POST['d_p_zw'],
            'd_p_hkzz' => $_POST['d_p_hkzz'],
            'd_p_sfzzz' => $_POST['d_p_sfzzz'],
            'd_p_sjzz' => $_POST['d_p_sjzz'],
            'd_p_lxfs' => $_POST['d_p_lxfs'],
            'd_p_hyzk' => $_POST['d_p_hyzk'],
            'd_p_poxm' => $_POST['d_p_poxm'],
            'd_p_mxzc' => $_POST['d_p_mxzc'],
            'd_p_posfzh' => $_POST['d_p_posfzh'],
            'd_p_polxfs' => $_POST['d_p_polxfs'],
            'd_p_posr' => $_POST['d_p_posr'],
            'd_p_pogzqk' => $_POST['d_p_pogzqk'],
            'd_p_pozw' => $_POST['d_p_pozw'],
            'd_p_jtzhnsr' => $_POST['d_p_jtzhnsr'],
            'd_p_yhck' => $_POST['d_p_yhck'],
            'd_p_fwxz' => $_POST['d_p_fwxz'],
            'd_p_fwxqjz' => $_POST['d_p_fwxqjz'],
            'd_p_clxhjz' => $_POST['d_p_clxhjz'],
            'd_p_jtqtsr' => $_POST['d_p_jtqtsr'],
            'd_p_jtqtsrbz' => $_POST['d_p_jtqtsrbz'],
            'd_p_xyked' => $_POST['d_p_xyked'],
            'd_p_xykfz' => $_POST['d_p_xykfz'],
            'd_p_yhajdk' => $_POST['d_p_yhajdk'],
            'd_p_mjjd' => $_POST['d_p_mjjd'],
            'd_p_dwdbqk' => $_POST['d_p_dwdbqk'],
            'd_p_time' => time(),
            'd_p_updatetime' => time(),
        );

        if (M('db_dbr')->data($data)->add()) {
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
            'd_p_name' => $_POST['d_p_name'],
            'd_p_idcard' => $_POST['d_p_idcard'],
            'd_p_sex' => $_POST['d_p_sex'],
            'd_p_mz' => $_POST['d_p_mz'],
            'd_p_jkzk' => $_POST['d_p_jkzk'],
            'd_p_gzdw' => $_POST['d_p_gzdw'],
            'd_p_zw' => $_POST['d_p_zw'],
            'd_p_hkzz' => $_POST['d_p_hkzz'],
            'd_p_sfzzz' => $_POST['d_p_sfzzz'],
            'd_p_sjzz' => $_POST['d_p_sjzz'],
            'd_p_lxfs' => $_POST['d_p_lxfs'],
            'd_p_hyzk' => $_POST['d_p_hyzk'],
            'd_p_poxm' => $_POST['d_p_poxm'],
            'd_p_mxzc' => $_POST['d_p_mxzc'],
            'd_p_posfzh' => $_POST['d_p_posfzh'],
            'd_p_polxfs' => $_POST['d_p_polxfs'],
            'd_p_posr' => $_POST['d_p_posr'],
            'd_p_pogzqk' => $_POST['d_p_pogzqk'],
            'd_p_pozw' => $_POST['d_p_pozw'],
            'd_p_jtzhnsr' => $_POST['d_p_jtzhnsr'],
            'd_p_yhck' => $_POST['d_p_yhck'],
            'd_p_fwxz' => $_POST['d_p_fwxz'],
            'd_p_fwxqjz' => $_POST['d_p_fwxqjz'],
            'd_p_clxhjz' => $_POST['d_p_clxhjz'],
            'd_p_jtqtsr' => $_POST['d_p_jtqtsr'],
            'd_p_jtqtsrbz' => $_POST['d_p_jtqtsrbz'],
            'd_p_xyked' => $_POST['d_p_xyked'],
            'd_p_xykfz' => $_POST['d_p_xykfz'],
            'd_p_yhajdk' => $_POST['d_p_yhajdk'],
            'd_p_mjjd' => $_POST['d_p_mjjd'],
            'd_p_dwdbqk' => $_POST['d_p_dwdbqk'],
            'd_p_updatetime' => time(),
        );

        if (M('db_dbr')->where("id = {$id}")->save($data)) {
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
            $data = M('xd_dbr')->where("x_p_parentidcard = '{$cardid}'")->select();
            $this->ajaxReturn(array('status' => 1, 'dbrinfo' => $data), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => '删除失败'), 'json');
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

    public function customer_baseinfo()
    {
        $c_data = M('d_p_customer')->where("d_p_del = 0")->order("id desc")->select();
        $m_data = M('d_e_customer')->where("d_e_del = 0")->order("id desc")->select();
        $this->assign('c_data', $c_data);
        $this->assign('m_data', $m_data);
        $this->display();
    }

    public function customer_base_query()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[4] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $Uid = $_SESSION['UserId'];
        $field_name = $_GET['field_name'];

        $value = $_GET['value'];
        $new_field = substr($field_name, 0, 4);
        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        if ($new_field == "d_p_") {
            $sql = "select * from oa_d_p_customer as x where x." . $field_name . " = '{$value}' and x.d_p_del = 0";
            $c_info = M('d_p_customer')->query($sql);
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "p");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $c_info);
        }elseif($new_field == "d_e_"){
            $sql = "select * from oa_d_e_customer as x where x." . $field_name . " = '{$value}' and x.d_e_del = 0";
            $c_info = M('d_e_customer')->query($sql);
            $count1 = count($c_info);
            $page1 = new Page($count1, 10);
            $this->assign("customertype", "e");
            $this->assign("fpage", $page1->fpage(1, 4, 5, 6, 0, 3));
            $this->assign("c_info", $c_info);
        }
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

}