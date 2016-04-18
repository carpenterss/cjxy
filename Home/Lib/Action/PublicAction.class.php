<?php

class PublicAction extends CommonAction
{
    public $pp;
    public $shqx;

    function __construct()
    {
        $Uid = $_SESSION['UserId'];
        $permissions = M("permissions");

        //获取到当前用户对OA管理模块的操作权限
        $pp = $permissions->where("p_column_id = 6 and p_uid = {$Uid}")->find();
        $p_column_sonName = $pp['p_column_sonName'];
        $p_column_son = $pp['p_column_son'];

        $p_column_son = explode(",", $p_column_son);
        $p_column_sonName = explode("|", $p_column_sonName);

        $shqx = $permissions->where("p_column_id = 6 and p_uid = {$Uid}")->find();
        $this->shqx = explode(",", $shqx['p_column_son']);
        $this->pp = $p_column_son;
    }

    public function verify()
    {
        import('ORG.Util.Image');
        ob_end_clean();
        Image::buildImageVerify(4, 1, 'png', 70, 30);
    }

    //Email模块的公共头
    public function email_header()
    {
        $this->display();
    }

    //Email模块的公共尾
    public function email_footer()
    {
        $this->display();
    }

    //短信息模块公共头
    public function message_header()
    {
        $this->display();
    }

    //短信息模块公共尾
    public function message_footer()
    {
        $this->display();
    }

    //短信息模块公共头
    public function notice_header()
    {
        $this->display();
    }

    //短信息模块公共尾
    public function notice_footer()
    {
        $this->display();
    }

    //日常安排模块公共头
    public function schedule_header()
    {
        $this->display();
    }

    //日程安排模块公共尾
    public function schedule_footer()
    {
        $this->display();
    }

    //工作日志模块公共头
    public function jobLog_header()
    {
        $this->display();
    }

    //工作日志模块公共尾
    public function jobLog_footer()
    {
        $this->display();
    }

    //通讯录模块公共头
    public function addressBook_header()
    {
        $this->display();
    }

    //通讯录模块公共尾
    public function addressBook_footer()
    {
        $this->display();
    }

    //员工资料模块公共头
    public function employeesInfo_header()
    {
        $this->display();
    }

    //员工资料模块公共尾
    public function employeesInfo_footer()
    {
        $this->display();
    }

    //公共频道模块公共头
    public function chatChannel_header()
    {
        $this->display();
    }

    //公共频道模块公共尾
    public function chatChannel_footer()
    {
        $this->display();
    }

    //客户管理模块公共头
    public function customer_header()
    {
        $this->display();
    }

    //客户管理模块公共尾
    public function customer_footer()
    {
        $this->display();
    }

    //权限管理模块公共头
    public function permissions_header()
    {
        $this->display();
    }

    //权限管理模块公共尾
    public function permissions_footer()
    {
        $this->display();
    }

    //办公桌定时刷新局部
    public function main_info()
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
        $Uid = session('UserId');
        $user = M('employees');
        //多表查询，同时查询用户信息表，部门表，职位表
        $sql = "select * from oa_employees WHERE u_id = {$Uid}";
        $user_info = $user->query($sql);
        $this->assign("user_info", $user_info);

        /*未查看的短消息数量*/
        $message = M("message");
        $m_sum = $message->where("m_reUid = {$Uid} and m_looks_is = 0")->count();
        $this->assign("m_sum", $m_sum);

        /*调取出被评论的工作日志数量*/
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];

        /*未查看的短消息数量*/
        $message = M("message");
        $m_sum = $message->where("m_reUid = {$Uid} and m_looks_is = 0")->count();

        /*调取出待审核的数量*/
        $j_sum = 0;
        if($department == 1){
            $j_sum = M("xdbusiness")->where("x_status != 1")->count() 
            + M("dbgrbusiness")->where("d_status != 1")->count() +
            M("dbqybusiness")->where("d_status != 1")->count();
        }else{
            $j_sum = M("xdbusiness")->where("x_status <> 1 and c_uid = {$Uid}")->count() 
            + M("dbgrbusiness")->where("d_status <> 1 and c_uid = {$Uid}")->count() +
            M("dbqybusiness")->where("d_status <> 1 and c_uid = {$Uid}")->count();
        }
        $this->assign("j_sum", $j_sum);
        /*获取未完成的任务数量*/
        $tasks = M("tasks");
        $t_sum = $tasks->where("t_uid = {$Uid} and t_isOK = 0")->count();
        $this->assign("t_sum", $t_sum);
        $this->display();

    }

    //AJAX更新信息
    public function update_mainInfo()
    {
        $Uid = $_SESSION['UserId'];
        $department = M('employees')->where("u_id = {$Uid}")->select()[0]['u_department'];

        /*未查看的短消息数量*/
        $message = M("message");
        $m_sum = $message->where("m_reUid = {$Uid} and m_looks_is = 0")->count();
        $j_sum = 0;
        /*调取出待审核的数量*/
        if($department == 1){
            $j_sum = M("xdbusiness")->where("x_status <> 1")->count() 
            + M("dbgrbusiness")->where("d_status <> 1")->count() +
            M("dbqybusiness")->where("d_status <> 1")->count();
        }else{
            $j_sum = M("xdbusiness")->where("x_status <> 1 and c_uid = {$Uid}")->count() 
            + M("dbgrbusiness")->where("d_status <> 1 and c_uid = {$Uid}")->count() +
            M("dbqybusiness")->where("d_status <> 1 and c_uid = {$Uid}")->count();
        }

        /*获取未完成的任务数量*/
        $tasks = M("tasks");
        $t_sum = $tasks->where("t_uid = {$Uid} and t_isOK = 0")->count();

        echo $m_sum . "|" . $j_sum . "|" . $t_sum;
    }
}

?>