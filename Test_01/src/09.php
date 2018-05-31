<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/24
 * Time: 上午9:58
 */


//PHP中的代理
class Subject {
    protected function request($_str) {
        echo strtoupper($_str);
    }
}

class Proxy extends Subject {

    private $real_subject;

    protected function request($_str) {
        $this->real_subject = new Subject();
        $this->real_subject->request($_str);
    }

    public function login($_str) {
        if ($_str == "yurisa")
            $this->request("love ".$_str);
        else
            echo "no login.";
    }
}

$proxy = new Proxy();
$proxy->login("yurisa");