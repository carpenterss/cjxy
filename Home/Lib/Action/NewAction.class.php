<?php

class NewAction extends Action{
    public function blacklist(){
        $this->display();
    }

    public function fundborrow(){
        $this->display();
    }

    public function xycx(){
        $this->display();
    }

    public function member_center(){
        header('Location: http://'.C('BASEPATH').'/zxcx/index.php/Home/Business/member_coin2.html');
    }
}