<?php

class JobLogAction extends CommonAction
{
    //默认工作日志显示页面
    public function jobLog()
    {
        //待审核
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];
        if($department) {
            $sh_xd = M('xdbusiness')->select();
            $xdqy = array();
            $xdgr = array();
            $sh_dbgr = M('dbgrbusiness')->select();
            $dbgr = array();
            $sh_dbqy = M('dbqybusiness')->select();
            $dbqy = array();
        }else{
            $sh_xd = M('xdbusiness')->where("c_uid = {$Uid}")->select();
            $xdqy = array();
            $xdgr = array();
            $sh_dbgr = M('dbgrbusiness')->where("c_uid = {$Uid}")->select();
            $dbgr = array();
            $sh_dbqy = M('dbqybusiness')->where("c_uid = {$Uid}")->select();
            $dbqy = array();
        }
        for($i = 0 ; $i < count($sh_xd); $i++){
            if(substr($sh_xd[$i]['x_id'],0,1) == 1){
                $id = substr($sh_xd[$i]['x_id'],1);
                if(M('x_p_customer')->where("id = {$id}")->select()[0]['x_p_del'] == 0) {
                    $xdgr[] = array(
                        'xm' => M('x_p_customer')->where("id = {$id}")->select()[0]['x_p_name'],
                        'sfzh' => M('x_p_customer')->where("id = {$id}")->select()[0]['x_p_idcard'],
                        'id' => M('x_p_customer')->where("id = {$id}")->select()[0]['id'],
                        'c_uid' => M('employees')->where("u_id = {$sh_xd[$i]['c_uid']}")->select()[0]['u_name'],
                        'b_id' => $sh_xd[$i]['Id'],
                        'shzt' => $sh_xd[$i]['x_status'],
                        'shxx' => $sh_xd[$i]['x_shxx']);
                }
            }elseif(substr($sh_xd[$i]['x_id'],0,1) == 2){
                $id = substr($sh_xd[$i]['x_id'],1);
                if(M('x_e_customer')->where("id = {$id}")->select()[0]['x_e_del'] == 0) {
                    $xdqy[] = array(
                        'xm' => M('x_e_customer')->where("id = {$id}")->select()[0]['x_e_name'],
                        'sfzh' => M('x_e_customer')->where("id = {$id}")->select()[0]['x_e_zzjgdmzh'],
                        'id' => M('x_e_customer')->where("id = {$id}")->select()[0]['id'],
                        'c_uid' => M('employees')->where("u_id = {$sh_xd[$i]['c_uid']}")->select()[0]['u_name'],
                        'b_id' => $sh_xd[$i]['Id'],
                        'shzt' => $sh_xd[$i]['x_status'],
                        'shxx' => $sh_xd[$i]['x_shxx']);
                }
            }
        }
        for($i = 0; $i < count($sh_dbgr); $i++){
            $id = $sh_dbgr[$i]['d_id'];
            if(M('d_p_customer')->where("id = {$id}")->select()[0]['d_p_del'] == 0) {
                $dbgr[] = array(
                    'xm' => M('d_p_customer')->where("id = {$id}")->select()[0]['d_p_name'],
                    'sfzh' => M('d_p_customer')->where("id = {$id}")->select()[0]['d_p_idcard'],
                    'b_id' => $sh_dbgr[$i]['Id'],
                    'id' => $sh_dbgr[$i]['d_id'],
                    'c_uid' => M('employees')->where("u_id = {$sh_dbgr[$i]['c_uid']}")->select()[0]['u_name'],
                    'shzt' => $sh_dbgr[$i]['d_status'],
                    'shxx' => $sh_dbgr[$i]['d_shxx']);
            }
        }
        for($i = 0; $i < count($sh_dbqy); $i++){
            $id = $sh_dbqy[$i]['d_id'];
            if(M('d_p_customer')->where("id = {$id}")->select()[0]['d_e_del'] == 0) {
                $dbqy[] = array(
                    'xm' => M('d_e_customer')->where("id = {$id}")->select()[0]['d_e_name'],
                    'sfzh' => M('d_e_customer')->where("id = {$id}")->select()[0]['d_e_zzjgdmzh'],
                    'b_id'=>$sh_dbqy[$i]['Id'],
                    'id' => $sh_dbqy[$i]['d_id'],
                    'c_uid' => M('employees')->where("u_id = {$sh_dbqy[$i]['c_uid']}")->select()[0]['u_name'],
                    'shzt' => $sh_dbqy[$i]['d_status'],
                    'shxx' => $sh_dbqy[$i]['d_shxx']);
            }
        }
//        var_dump($xdgr);
        $this->assign("xdgr",$xdgr);
        $this->assign("xdqy",$xdqy);
        $this->assign("dbgr",$dbgr);
        $this->assign("dbqy",$dbqy);
        $this->display();
    }

    //筛选数据
    public function getsortdata(){
        $fielddata = I('index');
        $fieldname = I('fieldname');
        $sh_xd = M('xdbusiness')->where("xd_{$fieldname} = {$fielddata}")->select();
        $data = array();
        $sh_cd = M('cdbusiness')->where("cd_{$fieldname} = {$fielddata}")->select();
        $sh_dbgr = M('dbgrbusiness')->where("d_{$fieldname} = {$fielddata}")->select();
        $sh_dbqy = M('dbqybusiness')->where("d_{$fieldname} = {$fielddata}")->select();
        for($i = 0 ; $i < count($sh_xd); $i++){
            if(substr($sh_xd[$i]['x_id'],0,1) == 1){
                $id = substr($sh_xd[$i]['x_id'],1);
                $data[] = array(
                    'xm' => M('x_p_customer')->where("id = {$id}")->select()[0]['x_p_name'],
                    'sfzh' => M('x_p_customer')->where("id = {$id}")->select()[0]['x_p_idcard'],
                    'id' => M('x_p_customer')->where("id = {$id}")->select()[0]['id'],
                    'shzt' => $sh_xd[$i]['x_status'],
                    'khtype' => 1,
                    'shxx' => $sh_xd[$i]['x_shxx']);
            }elseif(substr($sh_xd[$i]['x_id'],0,1) == 2){
                $id = substr($sh_xd[$i]['x_id'],1);
                $data[] = array(
                    'xm' => M('x_e_customer')->where("id = {$id}")->select()[0]['x_e_name'],
                    'sfzh' => M('x_e_customer')->where("id = {$id}")->select()[0]['x_e_zzjgdmzh'],
                    'id' => M('x_e_customer')->where("id = {$id}")->select()[0]['id'],
                    'shzt' => $sh_xd[$i]['x_status'],
                    'khtype' => 2,
                    'shxx' => $sh_xd[$i]['x_shxx']);
            }
        }
        for($i = 0; $i < count($sh_dbgr); $i++){
            $id = $sh_dbgr[$i]['d_id'];
            $data[] = array(
                'xm' => M('d_p_customer')->where("id = {$id}")->select()[0]['d_p_name'],
                'sfzh' => M('d_p_customer')->where("id = {$id}")->select()[0]['d_p_idcard'],
                'id' => $sh_dbgr[$i]['Id'],
                'shzt' => $sh_dbgr[$i]['d_status'],
                'khtype' => 4,
                'shxx' => $sh_dbgr[$i]['d_shxx']);
        }
        for($i = 0; $i < count($sh_dbqy); $i++){
            $id = $sh_dbqy[$i]['d_id'];
            $data[] = array(
                'xm' => M('d_e_customer')->where("id = {$id}")->select()[0]['d_e_name'],
                'sfzh' => M('d_e_customer')->where("id = {$id}")->select()[0]['d_e_zzjgdmzh'],
                'id' => $sh_dbqy[$i]['Id'],
                'shzt' => $sh_dbqy[$i]['d_status'],
                'khtype' => 5,
                'shxx' => $sh_dbqy[$i]['d_shxx']);
        }
        if (count($data) != 0) {
            $this->ajaxReturn(array('status' => 1, 'data' => $data), 'json');
        } else {
            $this->ajaxReturn(array('status' => 0, 'error' => ''), 'json');
        }
    }

    //添加今日工作日志页面
    public function add_jobLog()
    {
        $time = time();
        $this->assign("time", $time);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //添加今日工作日志处理
    public function do_add_jobLog()
    {
        $Uid = $_SESSION['UserId'];
        $jobLog = M("joblog");

        $time = time();
        $date_info = date("Y-m-d", $time);

        $j_date = $jobLog->field("j_date")->where("j_uid = {$Uid}")->select();

        for ($i = 0; $i < count($j_date); $i++) {
            $r_date_info = date("Y-m-d", $j_date[$i]['j_date']);
            if ($date_info == $r_date_info) {
                $this->error("对不起,今天你已经创建了日志");
            }
        }

        $data['j_uid'] = $Uid;
        $data['j_date'] = time();
        $data['j_content'] = nl2br($_POST['j_content']);
        $data['j_result'] = $_POST['j_result'];
        $data['j_note'] = nl2br($_POST['j_note']);

        if ($jobLog->add($data)) {
            $this->Online($Uid);
            $this->Log($Uid, "创建工作日志", 1);
            $this->success("日志添加成功", U("JobLog/jobLog"));
        } else {
            $this->Online($Uid);
            $this->Log($Uid, "创建工作日志", 0);
            $this->error("对不起,日志添加失败！！！");
        }
    }

    //查看工作日志
    public function look_jobLog()
    {
        $Uid = $_SESSION['UserId'];
        $j_id = $_GET['j_id'];

        $jobLog = M("joblog");
        $j_info = $jobLog->find($j_id);
        $this->assign("j_info", $j_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //对员工日志进行评价
    public function review_joblog()
    {
        $j_id = $_GET['j_id'];

        $jobLog = M("joblog");
        $j_info = $jobLog->find($j_id);
        if ($j_info['j_uid'] == $_SESSION['UserId']) {
            $this->error("对不起,不能对自身进行评价");
        }

        $this->assign("j_info", $j_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //评价处理
    public function do_review_joblog()
    {
        $Uid = $_SESSION['UserId'];

        //根据Uid获取到评论人的名字
        $user = M("employees");
        $name = $user->field("u_name")->find($Uid);

        $j_id = $_POST['j_id'];
        $data['j_boss_review'] = $_POST['j_boss_review'];
        $data['j_rname'] = $name['u_name'];

        $jobLog = M("joblog");
        if ($jobLog->where("j_id = {$j_id}")->save($data)) {
            $this->Online($Uid);
            $this->Log($Uid, "评价工作日志", 1);
            $this->success("评价提交成功!!!", U("JobLog/jobLog"));
        } else {
            $this->Online($Uid);
            $this->Log($Uid, "评价工作日志", 0);
            $this->error("评价失败,请重新尝试");
        }
    }

    //查看上司评价
    public function look_review()
    {
        $Uid = $_SESSION['UserId'];
        $j_id = $_GET['j_id'];
        $jobLog = M("joblog");
        $save['j_look_review'] = 1;
        $jobLog->where("j_id = {$j_id} and j_uid = {$Uid}")->save($save);
        $j_info = $jobLog->find($j_id);
        $this->assign("j_info", $j_info);

        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //修改日志
    public function edit_jobLog()
    {
        $Uid = $_SESSION['UserId'];
        $j_id = $_GET['j_id'];

        $jobLog = M("joblog");
        $j_info = $jobLog->find($j_id);
        $j_uid = $j_info['j_uid'];
        //得到日志的发布日期
        $j_date = $j_info['j_date'];
        $date_info = date("Y-m-d", $j_date);
        //获取今天的日期
        $time = time();
        $date_info2 = date("Y-m-d", $time);
        //判断是否是当天的日志
        if ($date_info != $date_info2) {
            $this->error("对不起,只能修改当天的日志");
        }

        //如果该条日志不是自己的就不允许修改（主要针对领导不能修改员工日志）
        if ($Uid != $j_uid) {
            $this->error("对不起,不能修改别人的工作日志");
        }

        $this->assign("j_info", $j_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //修改日志处理
    public function do_edit_jobLog()
    {
        $j_id = $_POST['j_id'];
        $jobLog = M("joblog");

        $data['j_content'] = $_POST['j_content'];
        $data['j_result'] = $_POST['j_result'];
        $data['j_note'] = $_POST['j_note'];

        if ($jobLog->where("j_id = {$j_id}")->save($data)) {
            $this->Online($Uid);
            $this->Log($Uid, "修改工作日志", 1);
            $this->success("日志修改成功", U("JobLog/jobLog"));
        } else {
            $this->Online($Uid);
            $this->Log($Uid, "修改工作日志", 0);
            $this->error("对不起,日志修改失败");
        }
    }
}

?>
