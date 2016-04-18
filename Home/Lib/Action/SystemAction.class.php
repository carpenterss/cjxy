<?php

class SystemAction extends CommonAction
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
        $pp = $permissions->where("p_column_id = 5 and p_uid = {$Uid}")->find();
        $p_column_sonName = $pp['p_column_sonName'];
        $p_column_son = $pp['p_column_son'];

        $p_column_son = explode(",", $p_column_son);
        $p_column_sonName = explode("|", $p_column_sonName);

        $this->pp = $p_column_son;
    }


    //OA平台管理
    public function OA_system_manage()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[0] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        //获取当前PHP版本
        $this->assign("PHPversion", phpversion());
        $url = M("url");
        //获取当前MYSQL版本
        $mysql_version = $url->query("select version()");
        $this->assign("MYSQLversion", $mysql_version[0]['version()']);

        //查询公司员工信息
        $employees = D("Employees");
        $e_info = $employees->relation(true)->select();
        $this->assign("e_info", $e_info);

        //获取到已有快速通讯簿
        $quickBooks = M("quickbooks");
        $q_info = $quickBooks->select();
        $this->assign("q_info", $q_info);

        //获取OA配置信息
        $config = M("config");
        $config_info = $config->find();
        $this->assign("config_info", $config_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //OA平台配置
    public function do_config()
    {
        $c_id = $_POST['c_id'];
        $data['c_switch'] = $_POST['c_switch'];
        $data['c_is_loginTime'] = $_POST['c_is_loginTime'];
        $data['c_logTime'] = str_replace("：", ":", $_POST['c_logTime']);
        $data['c_is_loginWarning'] = $_POST['c_is_loginWarning'];
        $data['c_warningNum'] = $_POST['c_warningNum'];
        $data['c_is_log'] = $_POST['c_is_log'];

        $config = M("config");
        if ($config->where("c_id = {$c_id}")->save($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新OA配置", 1);
            $this->success("配置更新成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新OA配置", 0);
            $this->error("配置更新失败");
        }
    }

    //添加快速通讯簿AJAX处理
    public function add_quickBooks()
    {
        $q_name = $_GET['q_name'];
        $q_department = $_GET['q_department'];
        $q_position = $_GET['q_position'];
        $q_phone = $_GET['q_phone'];

        $quickBooks = M("quickbooks");
        $data['q_name'] = $q_name;
        $data['q_department'] = $q_department;
        $data['q_position'] = $q_position;
        $data['q_phone'] = $q_phone;

        //判断是否已经添加
        $q_sum = $quickBooks->where("q_name = '{$q_name}'")->count();
        if ($q_sum > 0) {
            echo 3;
            exit();
        }

        if ($quickBooks->add($data)) {
            echo "<tr>";
            echo "<td align='right'>" . $q_name . "</td>";
            echo "<td align='right'>" . $q_department . "</td>";
            echo "<td align='right'>" . $q_position . "</td>";
            echo "<td align='right'>" . $q_phone . "</td>";
            echo "</tr>";
        } else {
            echo 2;
        }
    }

    //OA公司结构
    public function OA_structure()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //添加部门处理
    public function add_department()
    {
        $department = M("department");
        $data['d_name'] = $_POST['department'];
        $data['d_description'] = nl2br($_POST['department_info']);

        $d_sum = $department->where("d_name = '{$data['d_name']}'")->count();
        if ($d_sum > 0) {
            $this->error("对不起,部门已存在");
        }

        if ($department->add($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "添加部门", 1);
            $this->success("部门添加成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "添加部门", 0);
            $this->error("部门添加失败");
        }
    }

    //添加职位处理
    public function add_position()
    {
        $position = M("position");
        $data['p_name'] = $_POST['position'];
        $data['p_description'] = nl2br($_POST['position_info']);

        $p_sum = $position->where("p_name = '{$data['p_name']}'")->count();
        if ($p_sum > 0) {
            $this->error("对不起,职位已存在");
        }

        if ($position->add($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "添加职位", 1);
            $this->success("职位添加成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "添加职位", 0);
            $this->error("职位添加失败");
        }
    }

    //OA-用户管理
    public function OA_user_add()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        //调取部门列表
        $department = M("department");
        $d_info = $department->select();
        $this->assign("d_info", $d_info);
        //调取职位列表
        $position = M("position");
        $p_info = $position->select();
        $this->assign("p_info", $p_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //OA-创建用户处理
    public function do_addUser()
    {
        //获取提交的数据
        $data['u_username'] = $_POST['u_username'];
        $data['u_password'] = md5($_POST['u_password']);
        $u_password2 = md5($_POST['u_password2']);
        $data['u_name'] = $_POST['u_name'];
        $data['u_phone'] = $_POST['u_phone'];
        $data['u_sex'] = $_POST['u_sex'];
        $data['u_age'] = $_POST['u_age'];
        $data['u_enable'] = $_POST['u_enable'];
        $data['u_department'] = $_POST['u_department'];

        if ($data['u_password'] != $u_password2) {
            $this->error("对不起,两次密码输入不一致");
        }

        //处理数据
        $employees = M("employees");
        $space = M("space");
        $url = M("url");
        $online = M("online");

        $e_num = $employees->where("u_username = '{$data['u_username']}'")->count();
        if ($e_num > 0) {
            $this->error("对不起,该用户名已经被使用.");
        }
        $namecount = $employees->where("u_name = '{$data['u_name']}'")->count();
        if($namecount > 0){
            $this->error("对不起,该用户姓名已经被使用.");
        }

        if ($Uid = $employees->add($data)) {
            $this->success("恭喜您,用户创建成功");

        } else {
            $this->error("对不起,用户创建失败");
        }
    }

    //OA-用户管理
    public function OA_user_manage()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        //查询出用户基本信息
        $employees = M("employees");
        $emailconfig = M("emailconfig");
        $clockin = M("clockin");
        $permissions = M("permissions");
        $absolute = M("absolute");

        $e_info = $employees->field("u_id,u_name,u_enable")->select();

        //查询用户是否配置了外部邮件服务
        for ($i = 0; $i < count($e_info); $i++) {
            $email_sum = $emailconfig->where("ec_uid = {$e_info[$i]['u_id']}")->count();
            if ($email_sum > 0) {
                $e_info[$i]['email_config'] = 1;
            } else {
                $e_info[$i]['email_config'] = 0;
            }
        }

        $time_info = explode("-", date("Y-m", time()));
        //查询用户是否生成了考勤
        for ($i = 0; $i < count($e_info); $i++) {
            $c_sum = $clockin->where("c_uid = {$e_info[$i]['u_id']} and c_year = '{$time_info[0]}'")->count();
            if ($c_sum > 0) {
                $e_info[$i]['clockin'] = 1;
            } else {
                $e_info[$i]['clockin'] = 0;
            }
        }

        //查询用户是否生成权限控制
        for ($i = 0; $i < count($e_info); $i++) {
            $p_sum = $permissions->where("p_uid = {$e_info[$i]['u_id']}")->count();
            if ($p_sum > 0) {
                $e_info[$i]['permissions'] = 1;
            } else {
                $e_info[$i]['permissions'] = 0;
            }
        }

        //查询用户是否开启了自由办公桌
        for ($i = 0; $i < count($e_info); $i++) {
            $a_sum = $absolute->where("a_uid = {$e_info[$i]['u_id']}")->count();
            if ($a_sum > 0) {
                $e_info[$i]['absolute'] = 1;
            } else {
                $e_info[$i]['absolute'] = 0;
            }
        }

        $this->assign("e_info", $e_info);
        $this->display();
    }

    //配置外部邮件服务页面
    public function OA_config_mail()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[4] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //配置外部邮件服务处理
    public function do_configEmail()
    {
        $data['ec_uid'] = $_POST['ec_uid'];
        $data['ec_smtpserver'] = $_POST['ec_smtpserver'];
        $data['ec_smtppost'] = $_POST['ec_smtppost'];
        $data['ec_smtpuser'] = $_POST['ec_smtpuser'];
        $data['ec_smtppass'] = $_POST['ec_smtppass'];
        $data['ec_type'] = "HTML";

        $emailconfig = M("emailconfig");

        $e_sum = $emailconfig->where("ec_uid = {$data['ec_uid']}")->count();
        if ($e_sum > 0) {
            $this->error("对不起,该用户已经生成了外部邮件配置");
        }

        if ($emailconfig->add($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "配置外部邮件", 1);
            $this->success("外部邮件服务配置成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "配置外部邮件", 0);
            $this->error("对不起,邮件服务配置失败");
        }
    }

    //创建配置时测试邮件的处理
    public function do_ceshiEmail()
    {
        $uid = $_POST['uid'];
        $address = $_POST['address'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $emailconfig = M("emailconfig");
        $config = $emailconfig->where("ec_uid = {$uid}")->select();

        if (!$config) {
            $this->error("对不起,您还没有创建外部配置");
        }

        //导入邮件发送类
        import('ORG.Util.Phpmailer');

        //获取到测试的回复邮件地址和发送地址（使用公司邮箱进行测试）
        $employees = M("employees");
        $e_info = $employees->where("u_id = {$uid}")->select();
        if (!$e_info) {
            $this->error("对不起,请您补全公司信息,测试邮箱使用的为公司信息中的邮箱地址");
        }

        try {
            $mail = new PHPMailer(true);

            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8'; //设置邮件的字符编码这很重要不然中文乱
            $mail->SMTPAuth = true; //开启认证
            $mail->Port = $config[0]['ec_smtppost'];
            $mail->Host = $config[0]['ec_smtpserver'];
            $mail->Username = $config[0]['ec_smtpuser'];
            $mail->Password = $config[0]['ec_smtppass'];
            $mail->AddReplyTo($e_info[0]['u_email'], "AAA");//回复地址
            $mail->From = $e_info[0]['u_email'];
            $mail->AddAddress($address);
            $mail->Subject = $title;
            $mail->Body = $content;
            $mail->WordWrap = 80; // 设置每行字符串的长度
            //$mail->AddAttachment("./06114207.jpg"); //可以添加附件
            $mail->IsHTML(true);
            $mail->Send();
            $this->success("测试邮件发送成功");
        } catch (phpmailerException $e) {
            $this->error("测试邮件发送失败");
        }
    }

    //更改邮件配置
    public function OA_edit_emailconfig()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[4] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $u_id = $_GET['u_id'];
        $emailconfig = M("emailconfig");
        $e_info = $emailconfig->where("ec_uid = {$u_id}")->find();
        $this->assign("e_info", $e_info);
        $this->display();
    }

    //更改邮件配置处理
    public function do_edit_emailconfig()
    {
        $u_id = $_POST['uid'];
        $data['ec_smtpserver'] = $_POST['ec_smtpserver'];
        $data['ec_smtppost'] = $_POST['ec_smtppost'];
        $data['ec_smtpuser'] = $_POST['ec_smtpuser'];
        $data['ec_smtppass'] = $_POST['ec_smtppass'];

        $emailconfig = M("emailconfig");
        if ($emailconfig->where("ec_uid = {$u_id}")->save($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新外部邮件配置", 1);
            $this->success("外部邮件配置更新成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新外部邮件配置", 0);
            $this->success("对不起,外部邮件配置更新失败");
        }
    }


    //修改用户信息页面
    public function OA_edit_user()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[1] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }


        $uid = $_GET['uid'];
        //用户信息
        $employees = M("employees");
        $e_info = $employees->where("u_id = {$uid}")->find();
        $this->assign("e_info", $e_info);

        //部门信息
        $department = M("department");
        $d_info = $department->select();
        $this->assign("d_info", $d_info);

        //职位信息
        $position = M("position");
        $p_info = $position->select();
        $this->assign("p_info", $p_info);

        //个人文件信息
        $space = M("space");
        $s_info = $space->where("s_uid = {$uid}")->find();
        $this->assign("s_info", $s_info);
        $this->display();
    }

    //修改用户信息处理
    public function do_editUser()
    {
        //获取提交的数据
        $uid = $_POST['u_id'];
        $data['u_username'] = $_POST['u_username'];
        $data['u_name'] = $_POST['u_name'];
        $data['u_phone'] = $_POST['u_phone'];
        $data['u_email'] = $_POST['u_email'];
        $data['u_email_in'] = $_POST['u_email_in'];
        $data['u_sex'] = $_POST['u_sex'];
        $data['u_age'] = $_POST['u_age'];
        $data['u_position'] = $_POST['u_position'];
        $data['u_department'] = $_POST['u_department'];
        $data['u_enable'] = $_POST['u_enable'];

        $data2['s_space'] = $_POST['s_space'];
        $data2['s_upload_is'] = $_POST['s_upload_is'];

        $employees = M("employees");
        $space = M("space");

        $s = $space->where("s_uid = {$uid}")->save($data2);
        $e = $employees->where("u_id = {$uid}")->save($data);

        if ($e > 0 || $s > 0) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新员工信息", 1);
            $this->success("用户信息更新成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新员工信息", 0);
            $this->error("对不起,用户信息更新失败");
        }
    }

    //删除用户处理
    public function do_del_user()
    {
        $uid = $_GET['uid'];
        $employees = M("employees");
        $space = M("space");
        $emailconfig = M("emailconfig");
        $permissions = M("permissions");
        $absolute = M("absolute");
        $str = "";

        if ($employees->where("u_id = {$uid}")->delete()) {
            $str .= "<font color=green>已成功删除用户基本信息.</font><br/>";
        } else {
            $str .= "<font color=red>用户基本信息删除失败.</font><br/>";
        }

        if ($space->where("s_uid = {$uid}")->delete()) {
        }

        if ($emailconfig->where("ec_uid = {$uid}")->delete()) {
        }

        if ($permissions->where("p_uid = {$uid}")->delete()) {
            $str .= "<font color=green>已成功删用户权限控制信息.</font><br/>";
        } else {
            $str .= "<font color=red>用户权限控制信息删除失败.</font><br/>";
        }

        if ($absolute->where("a_uid = {$uid}")->delete()) {
        }

        $this->Online($_SESSION['UserId']);
        $this->Log($_SESSION['UserId'], "删除用户", 1);
        $this->success($str, U("System/OA_user_manage"), 5);
    }

    //管理数据库
    public function OA_database()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $url = M("url");
        $path = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . "/Public/Backup/";
        $t_info = $url->query("show tables");
        //循环查询表数据量
        for ($i = 0; $i < count($t_info); $i++) {
            $new_tables = substr($t_info[$i]['Tables_in_oa'], 3);

            $$new_tables = M("{$new_tables}");
            $sum = $$new_tables->count();
            $t_info[$i]['sum'] = $sum;

            if (file_exists($path . $t_info[$i]['Tables_in_oa'] . "_backup.txt")) {
                $t_info[$i]['is_backup'] = 1;
            } else {
                $t_info[$i]['is_backup'] = 0;
            }
        }
        $this->assign("t_info", $t_info);
        $this->display();
    }

    //OA-单表数据库备份处理
    public function do_backup_table()
    {
        $table_name = $_GET['tname'];
        $tname = substr($table_name, 3);
        $$tname = M("{$tname}");
        $createtable = $$tname->query("SHOW CREATE TABLE {$table_name}");
        $tabledump .= $createtable[0]['Create Table'] . ";";

        $field_show = "";
        $field = $$tname->getDbFields();
        for ($j = 0; $j < count($field); $j++) {
            $field_show .= $field[$j] . ",";
        }
        $field_show = trim($field_show, ",");

        $t_info = $$tname->select();

        for ($i = 0; $i < count($t_info); $i++) {
            $value = "";
            for ($j = 0; $j < count($field); $j++) {
                $value .= "'" . $t_info[$i][$field[$j]] . "',";
            }
            $new_v = trim($value, ",");
            $insert = "insert into {$table_name}({$field_show}) value({$new_v})";
            $tabledump .= $insert . ";";
        }

        //获取到导出的表结构和数据,并保存到文件
        $tabledump = $tabledump . "\n\n";
        //配置备份文件的路径

        $path = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . "/Public/Backup/";

        $fp = fopen($path . "{$table_name}_backup.txt", "w+");
        $status = fwrite($fp, $tabledump);
        if ($status) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "备份数据表", 1);
            $this->success("恭喜您,表{$table_name}备份成功");
        }
        fclose($fp);
    }

    //查看表结构处理
    public function OA_look_desc()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $table_name = $_GET['tname'];
        $tname = substr($table_name, 3);
        $$tname = M("{$tname}");
        $t_desc = $$tname->query("desc {$table_name}");
        $this->assign("t_desc", $t_desc);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //优化表（删除更新磁盘碎片）
    public function do_optimize()
    {
        $table_name = $_GET['tname'];
        $url = M("url");
        $sql = "optimize table {$table_name}";
        if ($url->query($sql)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "优化数据表", 1);
            $this->success("恭喜您,该表优化成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "优化数据表", 0);
            $this->error("对不起,优化失败,请重新尝试");
        }
    }

    //清空表数据处理-如有需要请直接打开注释，并删除前台的disabled=""属性即可使用
    /*public function do_del_tables(){
         $table_name = $_GET['tname'];
         $tname = substr($table_name,3);
         $$tname = M("{$tname}");
            $$tname->query("delete from {$table_name}");
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'],"清空数据表",1);
            $this->success("已成功清空表中数据");

    }*/

    //手动进行SQL操作页面
    public function OA_sql()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //手动进行SQL操作处理
    public function do_sql()
    {
        $url = M("url");
        $sql = $_POST['sql_v'];
        if ($result = $url->query($sql)) {
            echo "SQL语句执行成功...<a href='#' onclick='history.go(-1);'>[返回上一页]</a>";
            dump($result);
        } else {
            echo "对不起,SQL语句执行失败.....<a href='#' onclick='history.go(-1);'>[返回上一页]</a>";
        }
    }

    //公司相册管理
    public function OA_company_photo()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $photos = M("photos");

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)
        $count = $photos->count();//获取总数
        $page = new Page($count, 10);

        $p_info = $photos->limit($page->limit)->select();
        $this->assign("p_info", $p_info);
        $this->assign("fpage", $page->fpage(1, 4, 5, 6, 0, 3));
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //更新相片处理页面
    public function OA_update_photo()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $p_id = $_GET['p_id'];
        $photos = M("photos");

        $p_info = $photos->where("p_id = {$p_id}")->find();
        $this->assign("p_info", $p_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //更新相片处理程序
    public function do_updatePhoto()
    {
        $p_id = $_POST['p_id'];
        $p_title = $_POST['p_title'];
        $old_img = $_POST['p_img']; //原始文件名
        $photos = M("photos");

        $path_img = "./Public/Photos/";
        $path_thumbs = "./Public/Photos/thumbs/";

        import('ORG.Net.UploadFile');
        $upload = new UploadFile();// 实例化上传类
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath = $path_img;// 设置附件上传目录
        $upload->thumb = true;
        $upload->thumbMaxWidth = '125,125';
        $upload->thumbMaxHeight = '125,125';
        $upload->thumbPath = $path_thumbs;
        if (!$upload->upload()) {// 上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        } else {// 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
            $new_name = $info[0]['savename'];
        }


        if (file_exists("./Public/Photos/thumbs/thumb_" . $new_name)) {
            if (rename("./Public/Photos/thumbs/thumb_" . $new_name, "./Public/Photos/thumbs/" . $new_name)) {
                unlink("./Public/Photos/{$old_img}");
                unlink("./Public/Photos/thumbs/{$old_img}");


                $data['p_title'] = $p_title;
                $data['p_thumbs'] = "thumbs/" . $new_name;
                $data['p_img'] = $new_name;

                if ($photos->where("p_id = {$p_id}")->save($data)) {
                    $this->Online($_SESSION['UserId']);
                    $this->Log($_SESSION['UserId'], "更新公司相册", 1);
                    $this->success("相片更新成功");
                } else {
                    $this->Online($_SESSION['UserId']);
                    $this->Log($_SESSION['UserId'], "更新公司相册", 0);
                    $this->error("对不起,相片更新失败");
                }
            }
        }
    }

    //OA数据库表字段详细说明
    public function OA_DATABASES()
    {
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //录入公司基本信息页面
    public function OA_company_info()
    {
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //录入公司基本信息处理
    public function do_add_companyInfo()
    {
        if (empty($_POST['c_email']) || empty($_POST['c_city'])) {
            $this->error("对不起,邮箱地址和城市信息必须录入");
        }

        $company = M("company");

        if ($company->count() > 0) {
            $this->error("对不起,您已经创建了公司基本信息,如需更改请选择更改信息选项");
        }

        $company->create();
        if ($company->add()) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "录入公司信息", 1);
            $this->success("公司信息录入成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "录入公司信息", 0);
            $this->error("对不起,公司信息录入失败");
        }
    }

    //更改公司基本信息页面
    public function OA_edit_company()
    {
        $company = M("company");
        $c_info = $company->select();
        $this->assign("c_info", $c_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //更新公司基本页面处理
    public function do_edit_companyInfo()
    {
        $c_id = $_POST['c_id'];

        $data['c_cname'] = $_POST['c_cname'];
        $data['c_cphone'] = $_POST['c_cphone'];
        $data['c_telephone'] = $_POST['c_telephone'];
        $data['c_email'] = $_POST['c_email'];
        $data['c_fax'] = $_POST['c_fax'];
        $data['c_address'] = $_POST['c_address'];
        $data['c_city'] = $_POST['c_city'];
        $data['c_qq'] = $_POST['c_qq'];
        $data['c_site_url'] = $_POST['c_site_url'];

        $company = M("company");
        if ($company->where("c_id = {$c_id}")->save($data)) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新公司信息", 1);
            $this->success("公司基本信息更新成功");
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "更新公司信息", 0);
            $this->error("对不起,公司基本信息更新失败");
        }
    }

    //OA日志管理
    public function OA_log_manage()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }
        //获取公司人员名单
        $employees = M("employees");
        $e_info = $employees->field("u_id,u_name")->select();
        $this->assign("e_info", $e_info);

        $log = D("Log");

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)

        $count = $log->relation(true)->count();//获取总数
        $page = new Page($count, 10);

        $l_info = $log->relation(true)->limit($page->limit)->select();
        $this->assign("l_info", $l_info);
        $this->assign("fpage", $page->fpage(1, 4, 5, 6, 0, 3));
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //批量删除日志处理
    public function batch_del()
    {
        $arr = $_POST['check_is'];
        $log = M('log');
        if (!empty($arr)) {
            for ($i = 0; $i < count($arr); $i++) {
                $sql = "delete from oa_log where l_id = {$arr[$i]}";
                $log->query($sql);
            }
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "批量删除日志", 1);
            $this->success("批量删除日志已完成", U("System/OA_log_manage"));
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "批量删除日志", 0);
            $this->error('对不起,请选择要删除的记录');
        }
    }

    //单条删除日志记录处理
    public function del_log()
    {
        $l_id = $_GET['l_id'];
        $log = M('log');
        if ($log->where("l_id = {$l_id}")->delete()) {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "删除邮件", 1);
            $this->success("删除成功", U("System/OA_log_manage"));
        } else {
            $this->Online($_SESSION['UserId']);
            $this->Log($_SESSION['UserId'], "删除邮件", 0);
            $this->error("对不起,删除失败!!!");
        }
    }

    //根据姓名查询
    public function OA_query_uname()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }


        $u_id = $_POST['u_id'];
        //获取公司人员名单
        $employees = M("employees");
        $e_info = $employees->field("u_id,u_name")->select();
        $this->assign("e_info", $e_info);

        $log = D("Log");

        import('ORG.Util.page'); //导入分页类(非原TINKPHP分页类)

        $count = $log->relation(true)->where("l_uid = {$u_id}")->count();//获取总数
        $page = new Page($count, 10);

        $l_info = $log->relation(true)->limit($page->limit)->where("l_uid = {$u_id}")->order("l_time desc")->select();
        $this->assign("l_info", $l_info);
        $this->assign("fpage", $page->fpage(1, 4, 5, 6, 0, 3));

        $this->display();
    }

    //公司部门图形化页面
    public function OA_company_graphics()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $permissions_info = $this->pp;
        if ($permissions_info[7] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $department = M("department");
        $d_info = $department->select();
        $this->assign("d_info", $d_info);

        //获取页面元素
        $layout = D("Layout");
        $l_info = $layout->relation(true)->select();
        $this->assign("l_info", $l_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }

    //创建元素图形处理程序
    public function create_img()
    {
        $e_name = $_GET['e_name'];
        $num = $_GET['num'];

        $element = M("element");
        $element_info = $element->select();

        $element_arr = array();
        for ($i = 0; $i < count($element_info); $i++) {
            if ($element_info[$i]['e_name'] == $e_name) {
                $element_arr = $element_info[$i];
            }
        }

        $layout = M("layout");
        $data['cl_eid'] = $element_arr['e_id'];
        for ($i = 0; $i < $num; $i++) {
            if (!$layout->add($data)) {
                echo 2;
                exit();
            }
        }
        echo 1;
    }

    //拖动保存
    public function save_layout()
    {
        $data['cl_x'] = $_GET['x'];
        $data['cl_y'] = $_GET['y'];
        $data['cl_z'] = $_GET['z'];
        $cl_id = $_GET['cl_id'];

        $layout = M("layout");
        if ($layout->where("cl_id = {$cl_id}")->save($data)) {
            echo 1;
        } else {
            echo 2;
        }
    }

    //保存标题，部门
    public function save_layout2()
    {
        $data['cl_did'] = $_GET['e_did'];
        $data['cl_title'] = $_GET['e_title'];
        $cl_id = $_GET['clid'];
        $layout = M("layout");

        if ($layout->where("cl_id = {$cl_id}")->save($data)) {
            echo 1;
        } else {
            echo 2;
        }
    }

    //删除元素处理
    public function save_delete()
    {
        $cl_id = $_GET['clid'];
        $layout = M("layout");
        if ($layout->where("cl_id = {$cl_id}")->delete()) {
            echo 1;
        } else {
            echo 2;
        }
    }

    //查看部门详情
    public function OA_department_info()
    {
        $permissions_info = $this->pp;
        if ($permissions_info[5] != 1) {
            $this->error("对不起,您没有对本模块的操作权限");
        }

        $d_id = $_GET['d_id'];
        $employees = M("employees");

        $e_info = $employees->where("u_department = {$d_id}")->select();
        $this->assign("e_info", $e_info);
        $this->Online($_SESSION['UserId']);
        $this->display();
    }


    //为用户开启自由办公桌
    public function add_absolute()
    {
        $uid = $_GET['uid'];

        $section = M("section");
        $absolute = M("absolute");
        $s_info = $section->order("s_id asc")->select();

        for ($i = 0; $i < count($s_info); $i++) {
            $data['a_sid'] = $s_info[$i]['s_id'];
            $data['a_uid'] = $uid;

            if (!$absolute->add($data)) {
                $this->Online($_SESSION['UserId']);
                $this->Log($_SESSION['UserId'], "开启自由办公桌功能", 1);
                $this->error("对不起,自由办公桌功能开启失败");
            }
        }
        $this->Online($_SESSION['UserId']);
        $this->Log($_SESSION['UserId'], "开启自由办公桌功能", 0);
        $this->success("自由办公桌功能已开启");
    }

    //密码重置
    public function set_passwd(){
        $uid = $_GET['uid'];
        if($uid == null){
            $this->error('unknow error');
        }else{
            if(M('employees')->where("u_id = {$uid}")->setField("u_password",md5("0000"))){
                $this->success("密码成功重置为0000");
            }else{
                $this->error('密码重置时出现问题');
            }
        }
    }
}

?>