<?php

class IndexAction extends CommonAction
{

    /*
     * OA主框架页面
     */
    public function index()
    {

        $this->display();
    }
    //fdsfsd fsdf ds
    /*
     * OA顶部页面
     */
    public function top()
    {
//        $this->assign("now_time", time());  //获取当前时间从前台显示
//
//        $company = M("company");
//        $c_info = $company->field("c_site_url")->find();
//        $this->assign("site_url", $c_info['c_site_url']);
        $this->display();
    }

    /*
     * OA左侧导航页面
     */
    public function menu()
    {
        $Uid = $_SESSION['UserId'];
        $permissions = M("permissions");
        $p_info = $permissions->where("p_uid = {$Uid}")->order("p_column_id asc")->select();
        for ($i = 0; $i < count($p_info); $i++) {
            $column[$p_info[$i]['p_column_id']] = $p_info[$i]['p_column_enable'];
            $column_son[] = $p_info[$i]['p_column_son'];
        }
        $this->assign("xd_enable",C('XD_ENABLE'));
        $this->assign("cd_enable",C('CD_ENABLE'));
        $this->assign("db_enable",C('DB_ENABLE'));
        $this->assign("column", $column);
        $this->assign("son_1", explode(",", $column_son[0]));
        $this->assign("son_2", explode(",", $column_son[1]));
        $this->assign("son_3", explode(",", $column_son[2]));
        $this->assign("son_4", explode(",", $column_son[3]));
        $this->assign("son_5", explode(",", $column_son[4]));
        $this->assign("son_6", explode(",", $column_son[5]));
        $this->display();
    }

    /*
     * OA主内容页面
     */
    public function main()
    {
//        p($this->qixiancal('2015-07-15','2015-10-15'));
//        p($this->bqhkje('2015-07-15',10000,0.02,3,'2015-8-14'));
//        die;
        //登陆成功后根据ID获取相应的用户信息
        $Uid = session('UserId');
        $this->Online($_SESSION['UserId']);
        $user = M('employees');
        //多表查询，同时查询用户信息表，部门表，职位表
        $sql = "select * from oa_department as d,oa_employees as e,oa_position as p where (e.u_department = d.d_id or e.u_department = 0) and e.u_position = p.p_id and e.u_id = {$Uid}";
        $user_info = $user->query($sql);
        $this->assign("user_info", $user_info);
        /*查询所属该用户的公告通知*/
//		//查出用户所属部门ID
//			$user   = M("employees");
//			$u_info = $user->field("u_department")->find($Uid);
//
//			$notice = M("notice");
//			$department = M("department");
//
//			//分页处理部分
//			$count = $notice->where("(n_target = 2 or n_department = {$u_info['u_department']}) and n_rUid != {$Uid}")->count();
//
//			//查询出本部门所发公告或者所有员工接收的公告(排除自身所发公告)
//			$n_info = $notice->where("(n_target = 2 or n_department = {$u_info['u_department']}) and n_rUid != {$Uid}")->limit(7)->select();
//
//			//通过内部循环将部门ID换成部门名称
//			for($i=0;$i<count($n_info);$i++){
//				$d_info = $department->where("d_id = {$n_info[$i]['n_department']}")->select();
//				$n_info[$i]['n_department'] = $d_info[0]['d_name'];
//			}
//			if(empty($n_info)){
//			   $this->assign("n","2");
//			}else{
//			   $this->assign("n","1");
//			}
//			$this->assign("n_info",$n_info);
//
        /*查询出公共聊天室信息*/
        $chatroom = M("chatroom");
        $c_info = $chatroom->limit(8)->select();
        if (empty($c_info)) {
            $this->assign("c", "2");
        } else {
            $this->assign("c", "1");
        }
        $this->assign("c_info", $c_info);

        /*调取员工的工作日志*/
        $joblog = M("joblog");
        $j_info = $joblog->where("j_uid = {$Uid}")->select();
        $this->assign("j_info", $j_info);

        /*调取个人的办公桌布局*/
        if ($user_info[0]['u_window'] == 1) {
            $absolute = M("absolute");
            $ab_info = $absolute->where("a_uid = {$Uid}")->order("a_sid asc")->select();
            $this->assign("ab_info", $ab_info);
        }

        /*查询拖动的版块ID*/
        $section = M("section");
        $section_info = $section->select();
        $this->assign("section_info", $section_info);

        /*调取个人文件柜*/
        $filecabinet = M("filecabinet");
        $f_info = $filecabinet->where("f_uid = {$Uid}")->limit(5)->select();
        $this->assign("f_info", $f_info);

        /*获取系统当前时间*/
        $this->assign("now_time", time());
        //获取当天日期
        $this->assign("now_day", date("Y-m-d", time()));

        /*获取常用网址*/
        $url = M("url");
        $u_info = $url->where("u_uid = {$Uid}")->order("u_number asc")->select();
        $this->assign("u_info", $u_info);

        /*获取公司当天的紧急通知*/
//        $jinji = M("jinji");
//        $xd = M('xdbusiness')->where("x_jd == 0")->select();
//        $context = "";
//        $today = date('Ymd');
//
//        $year = substr($today, 0, 4);
//        $month = substr($today, 4, 2);
//        $nextmonthfirstday = date('Ymd', mktime(0, 0, 0, $month + 1, 1, $year));
//        for ($i = 0; $i < count($xd); $i++) {
//            if (substr($xd[$i]['x_id'], 0, 1) == 1) {
//                $time = date('Ymd', strtotime($xd[$i]['x_updatetime'] + '1 week'));
//                if ($time >= $nextmonthfirstday) {
//                    $id = substr($xd[$i]['x_id'], 0, 1);
//                    $context = M('x_p_customer')->where("id = {$id}")->select()[0]['x_p_name'] . "贷款即将超期";
//                }
//            }
//            if (substr($xd[$i]['x_id'], 0, 1) == 2) {
//                $time = date('Ymd', strtotime($xd[$i]['x_updatetime'] + '1 week'));
//                if ($time >= $nextmonthfirstday) {
//                    $id = substr($xd[$i]['x_id'], 0, 1);
//                    $context = M('x_e_customer')->where("id = {$id}")->select()[0]['x_e_name'] . "贷款即将超期";
//                }
//            }
//        }
//        $this->assign('jinji_context', $context);

//        p($this->bqhkje('2015-08-04',551.00,1.1,1,'2015-09-04'));
//        die;

        //预警服务
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        $today = date('Ymd');
        $year = substr($today, 0, 4);
        $month = substr($today, 4, 2);
        $day = substr($today, 6, 8);
        $data = array();
        if ($department) {
            $xdbusiness = M('xdbusiness')->where("x_del != 1 AND x_jd != 1 AND x_status = 1")->select();
            $cdbusiness = M('cdbusiness')->where("cd_del != 1 AND cd_jd != 1")->select();
            $dbgrbusiness = M('dbgrbusiness')->where("d_del != 1 AND d_jd != 1 AND d_status = 1")->select();
            $dbqybusiness = M('dbqybusiness')->where("d_del != 1 AND d_jd != 1 AND d_status = 1")->select();
        } else {
            $xdbusiness = M('xdbusiness')->where("x_del != 1 AND x_jd != 1 AND x_status = 1 AND c_uid={$Uid}")->select();
            $cdbusiness = M('cdbusiness')->where("cd_del != 1 AND cd_jd != 1 AND c_uid={$Uid}")->select();
            $dbgrbusiness = M('dbgrbusiness')->where("d_del != 1 AND d_jd != 1 AND d_status = 1 AND c_uid={$Uid}")->select();
            $dbqybusiness = M('dbqybusiness')->where("d_del != 1 AND d_jd != 1 AND d_status = 1 AND c_uid={$Uid}")->select();
        }
        for ($i = 0; $i < count($xdbusiness); $i++) {
            $type = substr($xdbusiness[$i]['x_id'], 0, 1);
            $x_id = substr($xdbusiness[$i]['x_id'], 1, strlen($xdbusiness[$i]['x_id']) - 1);
            if ($type == 1) {
                $data[] = array('xm' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_name'],
                    'b_id' => $xdbusiness[$i]['Id'],
                    'sfzh' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_idcard'],
                    'hkje' => $this->bqhkje($xdbusiness[$i]['x_dkqsrq'],$xdbusiness[$i]['x_dkje'],$xdbusiness[$i]['x_lv']/1000,$xdbusiness[$i]['x_hkfs'],$xdbusiness[$i]['x_dkjsrq']),
                    'dqr' => $xdbusiness[$i]['x_dkjsrq'],
                    'href' => U('Customer/ywlc_update_by_b_id?id='.$xdbusiness[$i]['Id']),
                    'syhkqs' => $xdbusiness[$i]['x_qx'],
                    'lxfs' => M('x_p_customer')->where("id = {$x_id}")->select()[0]['x_p_lxfs'],
                    'type' => "小贷个人",
                    'syhkts' => calsyhkts($xdbusiness[$i]['x_dkqsrq'],$xdbusiness[$i]['x_hkfs'],$xdbusiness[$i]['x_dkjsrq']));
            } else if ($type == 2) {
                $data[] = array('xm' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_name'],
                    'b_id' => $xdbusiness[$i]['Id'],
                    'sfzh' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_zzjgdmzh'],
                    'hkje' => $this->bqhkje($xdbusiness[$i]['x_dkqsrq'],$xdbusiness[$i]['x_dkje'],$xdbusiness[$i]['x_lv']/1000,$xdbusiness[$i]['x_hkfs'],$xdbusiness[$i]['x_dkjsrq']),
                    'dqr' => $xdbusiness[$i]['x_dkjsrq'],
                    'href' => U('Customer/ywlc_update_by_b_id?id=' . $xdbusiness[$i]['Id']),
                    'syhkqs' => $xdbusiness[$i]['x_qx'],
                    'lxfs' => M('x_e_customer')->where("id = {$x_id}")->select()[0]['x_e_frlxfs'],
                    'type' => "小贷企业",
                    'syhkts' => calsyhkts($xdbusiness[$i]['x_dkqsrq'],$xdbusiness[$i]['x_hkfs'],$xdbusiness[$i]['x_dkjsrq']));
            }
        }
        for ($i = 0; $i < count($cdbusiness); $i++) {
            $data[] = array('xm' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_name'],
                'b_id' => $cdbusiness[$i]['id'],
                'sfzh' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_idcard'],
                'hkje' => $this->bqhkje($cdbusiness[$i]['cd_dkffr'],$cdbusiness[$i]['cd_dkje'],$cdbusiness[$i]['cd_dkbl']/100,$cdbusiness[$i]['cd_hkfs'],$cdbusiness[$i]['cd_dkdqr']),
                'dqr' => $cdbusiness[$i]['cd_dkdqr'],
                'href' => U('Customercd/customer_cdyw_update_by_b_id?id=' .$cdbusiness[$i]['id']),
//                'syhkqs' => $cdbusiness[$i]['cd_qx'],
                'lxfs' => M('cd_customer')->where("id = {$cdbusiness[$i]['cd_id']}")->select()[0]['cd_lxfs'],
                'type' => "车贷",
                'syhkts' => calsyhkts($cdbusiness[$i]['cd_dkffr'],$cdbusiness[$i]['cd_hkfs'],$cdbusiness[$i]['cd_dkdqr']));
        }
        for ($i = 0; $i < count($dbgrbusiness); $i++) {
            $data[] = array('xm' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_name'],
                'b_id' => $dbgrbusiness[$i]['Id'],
                'sfzh' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_idcard'],
                'hkje' => $this->bqhkje($dbgrbusiness[$i]['d_dkqsrq'],$dbgrbusiness[$i]['d_dkje'],$dbgrbusiness[$i]['d_lv']/1000,$dbgrbusiness[$i]['d_hkfs'],$dbgrbusiness[$i]['d_dkjsrq']),
                'dqr' => $dbgrbusiness[$i]['d_dkjsrq'],
                'href' => U('Customerdb/customer_dbywgr_update_by_b_id?id=' . $dbgrbusiness[$i]['Id']),
//                'syhkqs' => $dbgrbusiness[$i]['d_qx'],
                'lxfs' => M('d_p_customer')->where("id = {$dbgrbusiness[$i]['d_id']}")->select()[0]['d_p_lxfs'],
                'type' => "担保个人",
                'syhkts' => calsyhkts($dbgrbusiness[$i]['d_dkqsrq'],$dbgrbusiness[$i]['d_hkfs'],$dbgrbusiness[$i]['d_dkjsrq']));
        }

        for ($i = 0; $i < count($dbqybusiness); $i++) {
            $data[] = array('xm' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_name'],
                'b_id' => $dbqybusiness[$i]['Id'],
                'sfzh' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_zzjgdmzh'],
                'hkje' => $this->bqhkje($dbqybusiness[$i]['d_dkqsrq'],$dbqybusiness[$i]['d_dkje'],$dbqybusiness[$i]['d_lv']/1000,$dbqybusiness[$i]['d_hkfs'],$dbqybusiness[$i]['d_dkjsrq']),
                'dqr' => $dbqybusiness[$i]['d_dkjsrq'],
                'href' => U('Customerdb/customer_dbywqy_update_by_b_id?id=' . $dbqybusiness[$i]['Id']),
                'syhkqs' => $dbqybusiness[$i]['d_qx'],
                'lxfs' => M('d_e_customer')->where("id = {$dbqybusiness[$i]['d_id']}")->select()[0]['d_e_frlxfs'],
                'type' => "担保企业",
                'syhkts' => calsyhkts($dbqybusiness[$i]['d_dkqsrq'],$dbqybusiness[$i]['d_hkfs'],$dbqybusiness[$i]['d_dkjsrq']));
        }
        $this->assign('data', $data);
        $this->display();
    }

    //主页面AJAX处理部分
    public function main_ajax()
    {
        $Uid = $_SESSION['UserId'];
        $nowTime = $_GET['nowTimes'];
        $memo = M("memo");
        $m_info = $memo->field("m_msg")->where("m_time = '{$nowTime}' and m_uid = {$Uid}")->find();
        if (empty($m_info)) {
            echo "当天没有设置备忘录信息...";
        } else {
            echo $m_info['m_msg'];
        }
    }

    //添加备忘按钮点击后处理
    public function add_memo()
    {
        $Uid = $_SESSION['UserId'];
        $m_time = $_GET['d_times'];
        $m_msg = $_GET['value'];
        $memo = M("memo");
        $data['m_uid'] = $Uid;
        $data['m_time'] = $m_time;
        $data['m_msg'] = $m_msg;
        $m_sum = $memo->where("m_time = '{$data['m_time']}'")->count();
        if ($m_sum > 0) {
            echo 3;
        }

        if ($memo->add($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "添加备忘录", 1);
            echo 1;
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "添加备忘录", 0);
            echo 2;
        }
    }

    //更新备忘录处理
    public function update_memo()
    {
        $Uid = $_SESSION['UserId'];
        $m_time = $_GET['d_times'];
        $m_msg = $_GET['value'];
        $memo = M("memo");

        $data['m_msg'] = $m_msg;
        if ($memo->where("m_time = '{$m_time}'")->save($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新备忘录", 1);
            echo 1;
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新备忘录", 0);
            echo 2;
        }
    }

    //增加常用网站地址处理
    public function add_url()
    {
        $u_url = $_GET['u_url'];
        $u_number = $_GET['u_number'];

        $url = M("url");
        $data['u_url'] = $u_url;
        if ($url->where("u_number = {$u_number}")->save($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "增加常用网站地址", 1);
            echo 1;
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "增加常用网站地址", 0);
            echo 2;
        }
    }

    //办公桌拖动位置保存处理程序
    public function save_absolute()
    {
        $Uid = $_SESSION['UserId'];
        $data['a_left'] = $_GET['x'];
        $data['a_top'] = $_GET['y'];
        $data['a_zIndex'] = $_GET['z'];
        $Sid = $_GET['sid'];

        $absolute = M("absolute");

        if ($absolute->where("a_uid = {$Uid} and a_sid = {$Sid}")->save($data)) {
            echo 1;
        } else {
            echo 2;
        }
    }

    //统计在线人数AJAX处理
    public function online_num()
    {
        $Uid = $_SESSION['UserId'];

        $now_time = time();
        $online = M("online");
        $o_info = $online->where("o_uid = {$Uid}")->find();

        $new_time = ($now_time - $o_info['o_time']);
        $minutes = intval($new_time / 60);

        //判断多久不在线将删除在线记录
        if ($minutes > 30) {
            if (file_exists("./Public/online_employees/{$Uid}.txt")) {
                unlink("./Public/online_employees/{$Uid}.txt");
            }
        } else {
            if (!file_exists("./Public/online_employees/{$Uid}.txt")) {
                touch("./Public/online_employees/{$Uid}.txt");
            }
        }

        //循环查询现在人数
        $num = array();
        $dir = dir("./Public/online_employees");
        while (false != ($file = $dir->read())) {
            if ($file != '.' && $file != '..') {
                $num[] = $file;
            }
        }
        $dir->close();
        echo count($num);
    }

    //更换个人照片
    public function img_head()
    {
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //TODO:剩余还款期数以及金额

    /**@author dormon
     * 计算当前期数
     * 注：假设8月15号贷款，则8月15日到9月15日为第一期，9月16日至10月16日为一期，一次类推
     * 只需判断当前日期与 贷款起始日期 的大小关系，若小于等于，则期数=两个时间之间的月份差
     * 若大于，则为小于等于情况算出的期数+1
     * @param $startdate 贷款起始日期
     * @return string
     */
    function dqqscal($startdate)
    {
        //计算月份差
        $startdate_unix = strtotime($startdate);
        $yuefencha = (date("Y", $startdate_unix) - date("Y")) * 12 + (date("m", $startdate_unix) - date("m"));
        //判断大小关系
        $startday = substr($startdate,8,2);
        $nowday = date("d");
        if(time() < $startdate_unix){
            return 0;
        }elseif($yuefencha == 0){
            return 1;
        }else{
            if ($startday >= $nowday) {
                if ($startdate == date('Y-m-d')) {
                    return 1;
                } else {
                    return abs($yuefencha);
                }
            } else {
                return abs($yuefencha - 1);
            }
        }
    }

    /**
     * @param $startdate
     * @param $enddate
     * @return bool|string
     * 计算两个两个月份差，即期数。
     */
    function qixiancal($startdate,$enddate)
    {
        $startdate_unix = strtotime($startdate);
        $enddate_unix = strtotime($enddate);
        $yuefencha = (date("Y", $startdate_unix) - date("Y",$enddate_unix)) * 12 + (date("m", $startdate_unix) - date("m",$enddate_unix));
        if($yuefencha == 0) {
            return 1;
        }else {
            return abs($yuefencha);
        }
    }

    /**@author dormon
     * @param $startdate 贷款起始日期
     * @param $money 贷款金额
     * @param $lv 贷款月利率
     * @param $type 贷款类型 等额本金=1 等额本息=2 按月结息=3
     * @param $enddate 贷款到期日
     *
     * 等额本金公式：每月应还款额=〔贷款本金×月利率×(1＋月利率)＾还款月数〕÷〔(1＋月利率)＾还款月数-1〕
     * @return float
     */
    function bqhkje($startdate, $money, $lv, $type, $enddate)
    {
        if ($type == 1) {//等额本金
            return number_format($this->debj($money,$lv,$this->qixiancal($startdate,$enddate),true)['xx'][$this->dqqscal($startdate)-1]['yueHuanKuan'],2)."(本月)";
        } elseif ($type == 2) {//等额本息
            return number_format($this->debx($money,$lv,$this->qixiancal($startdate,$enddate),true)['xx'][0]['yueHuanKuan'],2)."(本月)";
        } elseif ($type == 3) {//按月结息到期还款
            return number_format($this->ayjx($money,$lv,$startdate,$enddate)[$this->dqtianshu($startdate) -1]['yueHuanKuan'],2)."(本日)";
        } else {
            return -1;
        }
    }

    /**
     * @param $borrow_amount 贷款本金
     * @param $rate 贷款月利率
     * @param $drepay_time 期限
     * @param bool|false $showYue 计算出每个月的信息
     * @return array
     * 等额本金
     */
    function debj($borrow_amount, $rate, $drepay_time, $showYue = false)
    {

        //累计还款总额
        $HuanKuanZonge = 0;
        //月本金
        $yueBenJin = $borrow_amount / $drepay_time;
        $fh = array();
        $fh['yueBenJin'] = $yueBenJin;
        //余额
        $yue = $borrow_amount;
        $sz = array();
        for ($i = 1; $i <= $drepay_time; $i++) {
            $yueHuanKuan = $borrow_amount / $drepay_time + ($borrow_amount - $borrow_amount * ($i - 1) / $drepay_time) * $rate;//第i月还款额
            if ($i == 1) {
                //首月还款
                $fh['shouYueHuanKuan'] = $yueHuanKuan;
            }
            if ($i == 2) {
                //每月递减
                $fh['meiYuDiJian'] = $fh['shouYueHuanKuan'] - $yueHuanKuan;
            }
            $HuanKuanZonge = $HuanKuanZonge + $yueHuanKuan;
            $yueLiXi = $yueHuanKuan - $yueBenJin;
            $yue = $yue - $yueBenJin;
            $xj = array();
            $xj['bh'] = $i;
            $xj['yueLiXi'] = $yueLiXi;   //月利息
            $xj['yueBenJin'] = $yueBenJin; //月本金
            $xj['yueHuanKuan'] = $yueHuanKuan;   //月还款
            $xj['yue'] = $yue;     //余额
            $sz[$i - 1] = $xj;
        }
        $fh['zongLiXi'] = $HuanKuanZonge - $borrow_amount;
        $fh['huanKuanZongHe'] = $HuanKuanZonge;
        if ($showYue) {
            $fh['xx'] = $sz;
        }
        return $fh;
    }


    /**
     * @param $je 总额
     * @param $ylv 月利率
     * @param $qx 期限
     * @param bool|false $isshow 详细信息
     * @return array
     */
    function debx($je, $ylv, $qx, $isshow = false)
    {
        //每月还款
        $yhk = $je * $ylv * (pow(1 + $ylv, $qx) / (pow(1 + $ylv, $qx) - 1));;
        //累计还款总额
        $hkze = $yhk * $qx;
        //累计支付利息
        $zlx = $hkze - $je;
        $fh = array();
        $fh['zongLiXi'] = $zlx;
        $fh['huanKuanZongHe'] = $hkze;
        $fh['yueHuanKuan'] = $yhk;
        if ($isshow) {
            $ye = $je; //贷款余额
            $sz = array();
            for ($i = 1; $i <= $qx; $i++) {
                $ylx = $ye * $ylv;
                $ybj = $yhk - $ylx;
                $ye -= $ybj;
                $xj = array();
                $xj['bh'] = $i;
                $xj['yueLiXi'] = $ylx; //月利息
                $xj['yueBenJin'] = $ybj; //月本金
                $xj['yueHuanKuan'] = $ylx + $ybj;//月还款
                $xj['yue'] = $ye; //余额
                $sz[$i - 1] = $xj;
            }
            $fh['xx'] = $sz;
        }
        return $fh;
    }

    /**
     * @param $je 金额
     * @param $ylv 月利率
     * @param $startdate 贷款开始日期
     * @param $enddate 贷款结束日期
     * @return array
     * 按月结息，到期还本
     */
    function ayjx($je,$ylv,$startdate,$enddate){
        $rlv = $ylv/30;
        $sz = array();
        $startdate = strtotime($startdate);
        $enddate = strtotime($enddate);
        $qx = round(($enddate - $startdate)/86400)+1;
        for ($i = 0; $i < $qx-1; $i++) {
            $xj = array();
            $xj['yueHuanKuan'] = $je * $rlv;
            $xj['zongLiXi'] = $je * $qx * $ylv / 30;
            $xj['huanKuanZongHe'] = $je * $qx * $ylv / 30 + $je;
            $sz[$i] = $xj;
        }
        $sz[]['yueHuanKuan'] = $je * $rlv + $je;
        return $sz;
    }

    /**
     * @param $startdate
     * @return float
     * 计算出当前为按月结息的期数
     */
    function dqtianshu($startdate){
        $startdate = strtotime($startdate);
        $enddate = strtotime(date('Y-m-d',time()));
        $qs = round(($enddate - $startdate)/86400)+1;
        return $qs;
    }

    /**
     * 前台调用，ajax返回利息总额和累计还款总额
     * 传入参数：
     * startdate 贷款起始日期
     * money 贷款总金额
     * lv 贷款月利率
     * type 贷款类型
     * enddate 贷款结束日期
     */
    function remotecallx()
    {
        $startdate = I('startdate');
        $money = I('money');
        $lv = I('lv');
        $type = I('type');
        $enddate = I('enddate');
        if ($type == 1) {//等额本金
            $lxze = number_format($this->debj($money,$lv,$this->qixiancal($startdate,$enddate),true)['zongLiXi'],2);
            $ljhkze = number_format($this->debj($money,$lv,$this->qixiancal($startdate,$enddate),true)['huanKuanZongHe'],2);
        } elseif ($type == 2) {//等额本息
            $lxze =  number_format($this->debx($money,$lv,$this->qixiancal($startdate,$enddate),true)['zongLiXi'],2);
            $ljhkze =  number_format($this->debx($money,$lv,$this->qixiancal($startdate,$enddate),true)['huanKuanZongHe'],2);
        } elseif ($type == 3) {//按月结息到期还款
            $lxze =  number_format($this->ayjx($money,$lv,$startdate,$enddate)[0]['zongLiXi'],2);
            $ljhkze =  number_format($this->ayjx($money,$lv,$startdate,$enddate)[0]['huanKuanZongHe'],2);
        } else {
            $lxze =  -1;
            $ljhkze = -1;
            $this->ajaxReturn(array('status' => 0),'json');
        }
        $this->ajaxReturn(array('status' => 1, 'lxze' => $lxze, 'ljhkze'=>$ljhkze), 'json');
    }

}