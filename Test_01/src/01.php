<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/11/23
 * Time: 下午3:20
 */

//PHP设计模式初探

class TellAll {
    private $userAgent;
    public function __construct() {

        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        echo $this->userAgent;
    }
}

$tell = new TellAll();




?>