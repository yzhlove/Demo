<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/25
 * Time: 上午10:02
 */

//clone不会调用构造函数

class HelloClone {

    private $instance_;

    public function __construct() {
        echo "Hello Clone\n";
        $this->instance_ = "construct create\n";
    }

    public function doSomeThing() {
        echo $this->instance_;
        echo " I am do something!!!\n";
    }
}

//启动构造函数
$hc = new HelloClone();
$hc->doSomeThing();

echo "\n-----------------------\n";

$thc = clone $hc;
$thc->doSomeThing();

