<?php

class LoginAction extends Action
{
    /*
     * 用户登陆页面
     */
    public function login()
    {
        $this->display();
    }

    /*
     * 读条页面
     */
    public function dutiao()
    {
        $this->display();
    }

    /*
     * 用户登陆验证处理页面
     */
    public function doLogin()
    {
        //行验证码的验证
        $where['u_username'] = $_POST['u_username'];
        $where['u_password'] = md5($_POST['u_password']);
        $where['u_enable'] = 1;
        $verify = md5($_POST['verify']);
        $net = @fopen(C('AUTHSERVER'), "r");
        if ($net) {
            $auth=A("Auth");
            $result = $auth->do_auth();
            if($result != 1){
                $this->error($result);
            }
        }
        if (M('xz')->where("id = 0")->select()[0]['starttime'] == 0) {
            M('xz')->where("id = 0")->setField('starttime', $this->gettime("http://www.baidu.com"));
            M('xz')->where("id = 0")->setField('long', C('BETA_TIME'));
        }
        $starttime = M('xz')->where("id = 0")->select()[0]['starttime'];
        $starttime = $starttime + C('BETA_TIME') * 24 * 3600;
        $nowtime = $this->gettime("http://www.baidu.com");
        if ($starttime < $nowtime) {
            $this->error("对不起，使用已超过试用期，请联系0431-88448922");
        }
        if ($verify != (session('verify'))) {
            $this->error('对不起,验证码错误!!!');
        }
        //查看OA平台是否开启
        $config = M("config");
        $log_info = $config->find();
        if ($log_info['c_switch'] != 1) {
            $this->error("对不起,OA平台已关闭...");
        }

        //查看登陆时段是否限制,如限制根据限制时间进行处理
        if ($log_info['c_is_loginTime'] == 1) {
            $nowTime = time();
            $logTime = explode("-", $log_info['c_logTime']);
            $startTime = strtotime($logTime[0]) . "<hr/>";
            $endTime = strtotime($logTime[1]) . "<hr/>";
            if ($startTime > $endTime) {
                if (($nowTime < $startTime) && ($nowTime > $endTime)) {
                    //允许登陆向下执行
                } else {
                    $this->error("对不起,本时间段禁止登陆");
                }
            } else {
                if (($nowTime > $startTime) && ($nowTime < $endTime)) {
                    $this->error("对不起,本时间段禁止登陆");
                } else {
                    //允许登陆向下执行
                }
            }
        }

        if (!isset($_SESSION['NUM'])) {
            $_SESSION['NUM'] = $log_info['c_warningNum'];
        }
        //用户名和密码的验证
        $user = M('employees');
        $arr = $user->where($where)->find();

        $enable = $user->field("u_enable")->where("u_username = '{$_POST['u_username']}'")->find();
        if ($enable['u_enable'] != 1) {
            $this->error("对不起,您的账号已被锁定");
        }
        $log = M("log");
        if ($arr) {
            session('Login', true);
            session('UserName', $where['u_username']);
            session('UserId', $arr['u_id']);
            session('LoginTime', time());

            //如果成功创建一个文件
            touch("./Public/online_employees/" . $arr['u_id'] . ".txt");
            $online = M("online");
            $data['o_time'] = time();
            $online->where("o_uid = {$arr['u_id']}")->save($data);

            //判断是否开启日志记录
            if ($log_info['c_is_log'] == 1) {
                $data['l_uid'] = $arr['u_id'];
                $data['l_content'] = "登陆OA";
                $data['l_time'] = time();
                $data['l_status'] = 1;
                $log->add($data);
            }

            $this->redirect("Index/index");
        } else {

            if ($log_info['c_is_log'] == 1) {
                $data['l_uid'] = $arr['u_id'];
                $data['l_content'] = "登陆OA";
                $data['l_time'] = time();
                $data['l_status'] = 0;
                $log->add($data);
            }
            //查看是否开启了登陆报警
            if ($log_info['c_is_loginWarning'] == 1) {

                $_SESSION['NUM']--;
                if ($_SESSION['NUM'] == 0) {
                    $save['u_enable'] = 0;
                    $user->where("u_username = '{$_POST['u_username']}'")->save($save);
                    unset($_SESSION['NUM']);
                    $this->error("对不起,由于你尝试指定次数未登陆成功,触发警报,您的账号将被锁定,如需解锁请联系管理员");
                }
                $this->error("用户登陆失败,请重新尝试,剩余尝试次数:{$_SESSION['NUM']}次");
            } else {
                $this->error('用户登陆失败,请重新尝试!!!');
            }
        }
    }

    /*
     * 用户注销处理
     */
    public function doLogout()
    {
        $Time = $_SESSION['LoginTime'];
        $Uid = $_SESSION['UserId'];
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 1, '/');
        }
        session_destroy();
        unlink("./Public/online_employees/" . $Uid . ".txt");
        $log = M("log");

        $config = M("config");
        $log_info = $config->field("c_is_log")->find();

        if ($log_info['c_is_log'] == 1) {
            $data['l_uid'] = $Uid;
            $data['l_content'] = "退出OA";
            $data['l_time'] = time();
            $data['l_status'] = 1;
            $log->add($data);
        }
        $this->success('注销成功,谢谢', U('Login/login'), 3);
    }

    public function get_time($server)
    {
        $data = "HEAD / HTTP/1.1\r\n";
        $data .= "Host: $server\r\n";
        $data .= "Connection: Close\r\n\r\n";
        $fp = fsockopen($server, 80);
        fputs($fp, $data);
        $resp = '';
        while ($fp && !feof($fp))
            $resp .= fread($fp, 1024);
        preg_match('/^Date: (.*)$/mi', $resp, $matches);
        return strtotime($matches[1]);
    }

    public function gettime($url)
    {
        $check = @fopen($url, "r");
        if ($check) {
            $time = $this->get_time("www.baidu.com");
        } else {
            $time = time();
        }
        return $time;
    }

    function do_post_request($url, $data, $optional_headers = null)
    {
        $params = array('http' => array(
            'method' => 'POST',
            'content' => $data
        ));
        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        return $response;
    }


}

?>