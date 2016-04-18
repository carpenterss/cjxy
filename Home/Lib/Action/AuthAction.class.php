<?php

class AuthAction extends Action
{
    //单例模式
    //保存类实例的静态成员变量
    private static $_instance;

    //private标记的构造方法
    public function __construct(){
    }

    //创建__clone方法防止对象被复制克隆
    public function __clone()
    {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }

    //单例方法,用于访问实例的公共的静态方法
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function do_auth(){
        $result = $this->send_post(C('AUTHSERVER'));
        return $result;
    }

    function check_encrypt($s_simnew1){
        $DevicePath = $s_simnew1->FindPort(0);
        if($s_simnew1->LastError != 0){
            $this->error('请在服务端插入加密狗');
        }else{
            return $DevicePath;
        }
    }

    function send_post($url)
    {
        $uuid = guid();
        $time = time();
        $post_data = array(
            'encryptID' => $this->getEncryptID(),
            'name' => $this->getString(),
            'uuid' => $uuid,
            'time' => $time,
//            'enstring' => $this->encrypt('123'.'123')
//            'enstring' => $this->encrypt($uuid)
        );
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 10 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    function encrypt($String){
        $s_simnew1=new \COM("Syunew3A.s_simnew3");
        $DevicePath = $this->check_encrypt($s_simnew1);
        $outstring = $s_simnew1->EncString($String, $DevicePath);
        If ($s_simnew1->LastError != 0)
            $this->error('加密时异常，请联系客服');
        else
            return $outstring;
    }

    function getEncryptID(){
        $s_simnew1=new \COM("Syunew3A.s_simnew3");
        $DevicePath = $this->check_encrypt($s_simnew1);
        $ID1 = $s_simnew1->GetID_1($DevicePath);
        If ($s_simnew1->LastError != 0 )
            $this->error('获取加密狗ID1异常，请联系客服');
        $ID2 = $s_simnew1->GetID_2($DevicePath);
        If ($s_simnew1->LastError != 0 )
            $this->error('获取加密狗ID2异常，请联系客服');
        return $this->Hex($ID1) . $this->Hex($ID2);
    }

    function getString(){
        $s_simnew1=new \COM("Syunew3A.s_simnew3");
        $DevicePath = $this->check_encrypt($s_simnew1);
        $mylen = 100;
        $outstring = $s_simnew1->YReadString(0, $mylen, "984B859C", "773F7E26", $DevicePath);
        If ($s_simnew1->LastError != 0 )
            $this->error('加密狗读取密匙错误，请联系客服');
        else{
            $c_name = explode(';',$outstring);
            return $c_name[1];
        }

    }

    function Hex($indata)
    {
        $lX8 = $indata & 0x80000000;
        if($lX8)
        {
            $indata=$indata & 0x7fffffff;
        }
        while ($indata>16)
        {
            $temp_1=$indata % 16;
            $indata=$indata /16 ;
            if($temp_1<10)
                $temp_1=$temp_1+0x30;
            else
                $temp_1=$temp_1+0x41-10;

            $outstring= chr($temp_1) . $outstring ;

        }
        $temp_1=$indata;
        if($lX8)$temp_1=$temp_1+8;
        if($temp_1<10)
            $temp_1=$temp_1+0x30;
        else
            $temp_1=$temp_1+0x41-10;

        $outstring= chr($temp_1) . $outstring ;

        return $outstring;

    }

}